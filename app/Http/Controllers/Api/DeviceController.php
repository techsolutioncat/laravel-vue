<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Device;
use App\DeviceAssignment;
use App\DeviceGroup;
use App\DeviceReport;
use App\DeviceSignal;
use App\DeviceSim;
use App\DeviceType;
use App\Http\Controllers\Controller;
use App\Http\Services\GpsService;
use App\Jobs\CommandApi;
use App\Sim;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    const DEVICE_STATUS_FIXED = 'f'; // ???
    const DEVICE_STATUS_MOVABLE = 'm'; // ???

    public static function list(Request $request)
    {
        $query = DeviceAssignment::query();

        $perPage = $request->input('per_page', 10);
        $started_at = $request->get('started_at', null);

        $device_type_name = $request->get('device_type_name', '%');
        $imei = $request->get('imei', '%');
        $group_name = $request->get('group_name', '%');
        $sb_payment_no = $request->get('sb_payment_no', '%');
        $company_name = $request->get('company_name','%');
        $mount_no = $request->get('mount_no', '%');
        $msn = $request->get('msn','%');
        $auth_phone = $request->get('auth_phone','%');
        $operator_phone = $request->get('operator_phone','%');
        $company_id = $request->get('company_id',null);

        if ($started_at != null) {
            $start = (new CarbonImmutable())->setDateFrom($started_at)->startOfDay();
            $end = $start->endOfDay();
            $query->whereBetween('updated_at', [$start, $end]);
        }

        $query->where('mount_no', 'LIKE', $mount_no);

        $device_type_ids = DeviceType::query()
            ->where('type', 'LIKE', $device_type_name)->get()->getQueueableIds();
        $device_imeis = Device::query()->whereIn('device_type_id', $device_type_ids)->get('imei')->toArray();
        $device_sim_ids = DeviceSim::query()->whereIn('device_imei', $device_imeis)->get()->getQueueableIds();
        $query->whereIn('device_sim_id', $device_sim_ids);

        $company_ids = Company::query()
            ->where('sb_payment_no', 'LIKE', $sb_payment_no)
            ->where('name', 'LIKE', $company_name)->get()->getQueueableIds();

        $query->whereIn('company_id', $company_ids);

        if ($company_id != null)
            $query->where('company_id', '=', $company_id);

        $group_ids = DeviceGroup::query()->where('group', 'LIKE', $group_name)->get()->getQueueableIds();
        $query->whereIn('device_group_id', $group_ids);

        $query->hasDeviceSim(
            $imei,
            $msn);

        $query->hasPhone($auth_phone);
        $query->hasOperatorPhone($operator_phone);

        if(Auth::user()->userRole->role == 'user')
        {
            $query->where('company_id', '=', Auth::user()->company_id);
        }

        $device_assignments = $query->paginate($perPage);

        $device_assignments->data = $device_assignments->map(function ($device_assignment) {
            return $device_assignment->data();
        });

        return response()->json($device_assignments);
    }

    public function garbageList(Request $request)
    {
        $query = DeviceAssignment::onlyTrashed();

        $perPage = $request->input('per_page', 10);
        $started_at = $request->get('started_at', null);

        $device_type_name = $request->get('device_type_name', '%');
        $imei = $request->get('imei', '%');
        $group_name = $request->get('group_name', '%');
        $sb_payment_no = $request->get('sb_payment_no', '%');
        $company_name = $request->get('company_name','%');
        $mount_no = $request->get('mount_no', '%');
        $msn = $request->get('msn','%');
        $auth_phone = $request->get('auth_phone','%');

        $company_id = $request->get('company_id',null);

        if ($started_at != null) {
            $start = (new CarbonImmutable())->setDateFrom($started_at)->startOfDay();
            $end = $start->endOfDay();
            $query->whereBetween('updated_at', [$start, $end]);
        }

        $query->where('mount_no', 'LIKE', $mount_no);
        if ($company_id != null)
            $query->where('company_id', '=', $company_id);

        $query->hasDeviceSim(
            $imei,
            $msn);

        $query->hasPhone($auth_phone);

        $device_assignments = $query->paginate($perPage);

        $device_assignments->data = $device_assignments->map(function ($device_assignment) {
            return $device_assignment->data();
        });

        return response()->json($device_assignments);
    }

    public function search(Request $request)
    {
        $msn = $request->get('msn', null);
        $mount_no = $request->get('mount_no', null);

        $sim_ids = Sim::query()->where('msn', 'LIKE', $msn)->get()->getQueueableIds();
        $device_sim_ids = DeviceSim::query()->whereIn('sim_id', $sim_ids)->get()->getQueueableIds();

        $device_assignment = DeviceAssignment::query()->whereIn('device_sim_id', $device_sim_ids)->where('mount_no', 'LIKE', $mount_no)->first();
        $data = $device_assignment->data();

        return response()->json($data);
    }

    public function singlePosition(Request $request)
    {
        $msn = $request->post('msn');

        if (isset($msn)) {
            $sim = Sim::query()->where('msn', $msn)->firstOrFail();
            CommandApi::dispatch($msn, '123456F');
//            CommandApi::dispatch($msn, '123456T');
        }

        return response()->json([
            'success'   =>  true,
        ]);
    }

    public function testCommand($msn, GpsService $gps_service)
    {
        $result = false;
        $command = 'test';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success'   =>  $result,
        ]);
    }

    // ???? ??????
    public function updateProdCommand($msn, $type, GpsService $gps_service)
    {
        $result = false;
        $command = $type == $this::DEVICE_STATUS_MOVABLE ? '123456UVP' : '123456UVPS';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success'   =>  $result,
        ]);
    }

    // ????? ??????
    public function updateTestCommand($msn, $type, GpsService $gps_service)
    {
        $result = false;
        $command = $type == $this::DEVICE_STATUS_MOVABLE ? '123456UVD' : '123456UVDS';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success'   =>  $result,
        ]);
    }

    public function updateDevCommand($msn, GpsService $gps_service)
    {
        $result = false;
        $command = '123456UVD';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success'   =>  $result,
        ]);
    }

    public function kittingTestCommand($msn, GpsService $gps_service)
    {
        $result = false;
        $command = '123456UVD0823';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success'   =>  $result,
        ]);
    }

    public function kittingProdCommand($msn, GpsService $gps_service)
    {
        $result = false;
        $command = '123456UVP0823';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success'   =>  $result,
        ]);
    }

    // ????? ???
    public function resetTestCommand($msn, $type, GpsService $gps_service)
    {
        $result = false;
        $command = $type == $this::DEVICE_STATUS_MOVABLE ? 'RESET!D' : 'RESET!DS';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success'   =>  $result,
        ]);
    }

    public function resetDevCommand($msn, GpsService $gps_service)
    {
        $result = false;
        $command = 'RESET!D';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success' => $result,
        ]);
    }

    // ???? ???
    public function resetProdCommand($msn, $type, GpsService $gps_service)
    {
        $result = false;
        $command = $type == $this::DEVICE_STATUS_MOVABLE ? 'RESET!P' : 'RESET!PS';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success' => $result,
        ]);
    }

    public function buzzerStartCommand($msn, GpsService $gps_service)
    {
        $result = false;
        $command = '123456BZ1';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success' => $result,
        ]);        
    }

    public function buzzerStopCommand($msn, GpsService $gps_service)
    {
        $result = false;
        $command = '123456BZ0';

        if (isset($msn)) {
            $result = $gps_service->commandRequest($msn, $command);
        }

        return response()->json([
            'success' => $result,
        ]);        
    }

//    public function startContinuousPosition(Request $request)
//    {
//        $msn = $request->post('msn');
//
//        if (isset($msn)) {
//            $sim = Sim::query()->where('msn', $msn)->firstOrFail();
//            CommandApi::dispatch($msn, '123456M1,005M');
//        }
//
//        return [
//            'success' => true
//        ];
//    }

//    public function endContinuousPosition(Request $request)
//    {
//        $msn = $request->post('msn');
//
//        if (isset($msn)) {
//            $sim = Sim::query()->where('msn', $msn)->firstOrFail();
//            CommandApi::dispatch($msn, '123456M0,005M');
//        }
//
//        return [
//            'success' => true
//        ];
//    }

//    public function command(Request $request)
//    {
//        $msn = $request->post('msn');
//        $text = $request->post('commandText');
//
//        if (isset($msn)) {
//            $sim = Sim::query()->where('msn', $msn)->firstOrFail();
//            CommandApi::dispatch($msn, $text);
//        }
//
//        return [
//            'success' => true
//        ];
//    }

}
