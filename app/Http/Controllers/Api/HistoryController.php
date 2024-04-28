<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Device;
use App\DeviceAssignment;
use App\DeviceReportMessage;
use App\DeviceSignal;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DeviceReport;
use App\Http\Services\GpsService;
use App\Http\Services\HistoryQueryService;

class HistoryController extends Controller
{
    public function update(Request $request, GpsService $gps_service, HistoryQueryService $history_query_service)
    {
        $id = $request->post('id', null);
        $dealt_with = $request->post('dealt_with');
        $supplement = $request->post('supplement', '');

        $data = [
            'supplement' => $supplement
        ];
        
        if( $dealt_with ) {
            $data['dealt_with_at'] = $dealt_with ? Carbon::now() : null;
//            $data['positioning'] = 0;
        } else {
            $data['dealt_with_at'] = null;
        }
        $report = DeviceReport::find($id);

        // Authorization check
        $this->authorize('update', $report);
        
        // test part
        if($report && !empty($data['dealt_with_at'])) {
            $data['positioning'] = 0;
            $history_query_service->linkedReportsDealt( $report, ['positioning' => 0, 'dealt_with_at' => $data['dealt_with_at']] );
        }
        DeviceReport::where('id', $id)
            ->update($data);
        
        
        if( $dealt_with && $report->positioning) {
            $gps_service->finishLocationTracking( $report );
        }

        $report = DeviceReport::where('id', $id)->with([
            'deviceAssignment.sim',
            'deviceAssignment.device.deviceType',
            'deviceAssignment.deviceGroup',
            'deviceAssignment.company',
            'deviceAssignment.phones',
            'deviceSetting.sim',
            'deviceSetting.device.deviceType',
            'deviceSignal',
            'deviceSetting.deviceGroup',
            'deviceSetting.company',
            'deviceSetting.phones'
        ])->firstOrFail();

        return response()->json( [
            'success'   =>  true,
            'data'      =>  $report
         ] );
    }

    public function list(Request $request)
    {
        $query = DeviceReport::query();

        $per_page = $request->input('per_page', 10);

        $registered_at = $request->input('registered_at');
        if (!empty($registered_at)) {
            $query->whereDate(
                'created_at',
                '=',
                $registered_at);
        }

        $signals = array();
        $emergency_buzzer = $request->boolean('emergency_buzzer', false);
        if ($emergency_buzzer)
            $signals[] = DeviceSignal::$emergency_buzzer;

        $emergency_call = $request->boolean('emergency_call', false);
        if ($emergency_call)
            $signals[] = DeviceSignal::$emergency_call;

        $battery_low = $request->boolean('battery_low', false);
        if ($battery_low)
            $signals[] = DeviceSignal::$battery_low;

        $power_off = $request->boolean('power_off', false);
        if ($power_off)
            $signals[] = DeviceSignal::$power_off;

        $power_on = $request->boolean('power_on', false);
        if ($power_on)
            $signals[] = DeviceSignal::$power_on;

        $location_inquiry = $request->boolean('location_inquiry', false);
        if ($location_inquiry)
            $signals[] = DeviceSignal::$location_inquiry;

        $connection_error = $request->boolean('connection_error', false);
        if ($connection_error)
            $signals[] = DeviceSignal::$connection_error;

        $connection_restore = $request->boolean('connection_restore', false);
        if ($connection_restore)
            $signals[] = DeviceSignal::$connection_restore;

        $device_type_name = $request->input('device_type_name', '%');

        $imei = $request->input('imei', '%');

        $group_name = $request->input('group_name', '%');

        $sb_payment_no = $request->input('sb_payment_no', '%');

        $company_name = $request->input('company_name', '%');

        $msn = $request->input('msn', '%');

        $auth_phone = $request->input('auth_phone', '%');

        $company_id = $request->get('company_id',null);

        if ($company_id != null)
        {
            $device_assignment =
                DeviceAssignment::query()
                    ->whereIn('company_id',  $company_id)
                    ->get()->getQueueableIds();

            $query
                ->whereIn('device_assignment_id', $device_assignment);
        }

        $dealt_with_at_true = $request->boolean('dealt_with_at_true', false);
        $dealt_with_at_false = $request->boolean('dealt_with_at_false', false);
        if ($dealt_with_at_true && $dealt_with_at_false){}
        else if ($dealt_with_at_true)
            $query->whereNotNull('dealt_with_at');
        else if ($dealt_with_at_false)
            $query->whereNull('dealt_with_at');

        $query->hasDeviceSignal($signals);

        $query->hasDeviceAssignment(
            $device_type_name,
            $imei,
            $msn,
            $group_name,
            $company_name,
            $sb_payment_no);

        $query->hasPhone($auth_phone);

        $histories = $query->paginate($per_page);

        $histories->data = $histories->map(function ($history) {
            return $history->data();
        });

        return response()->json($histories);
    }
}
