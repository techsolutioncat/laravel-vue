<?php

namespace App\Http\Controllers;

use App\DeviceSetting;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JavaScript;
use Emerge;

class SettingHistoryController extends Controller
{
    public function index(Request $request)
    {


        $data = $this->get_data_for_table();
        JavaScript::put([
            'histories' => $data['settings_pagination'],
            'roles' => $data['roles'],
            'filter' => $data['filter']
        ]);

        ///delete other page's session for search;
        if (session('company_device_history_history')) {
            session(['company_device_history_history' =>
                [
                    'date' => '',
                    'rtc_time' => '',
                    'emergency_buzzer' => true,
                    'emergency_call' => true,
                    'call_received' => true,
                    'power_off' => true,
                    'power_on' => true,
                    'battery_low' => true,
                    'location_inquiry' => true,
                    'connection_error' => true,
                    'connection_restore' => true,
                    'device_model' => '',
                    'sb_billing_number' => '',
                    'group_name' => '',
                    'imei_number' => '',
                    'command_center' => '',
                    'msn' => '',
                    'receiver_number' => '',
                    'positioning_with_at_true' => true,
                    'positioning_with_at_false' => true,
                ]
            ]);
        }

        if (session("company_device_history_history_page")){
            session(['company_device_history_history_page' => 1]);
        }

        if(session('company_history')){
            session(['company_history' => [
                'registered_at' => '',
                'sb_payment_no' => '',
                'company_name' => '',
                'phone_number' => ''
            ]]);
        }

        if (session('company_device_assignment_history')) {
            session(['company_device_assignment_history' => [
                'started_at' => null,
                'mount_no' => null,
                'device_model' => null,
                'sb_billing_number' => null,
                'group_name' => null,
                'imei_number' => null,
                'command_center' => null,
                'msn' => null,
                'receiver_number' => null,
                'name' => null,
                'company_name' => null,
                'version' => null
            ]]);
        }

        if(session('notice_history')){
            session(['notice_history' => [
                'emergency_buzzer' => true,
                'emergency_call' => true,
                'battery_low' => true,
                'power_off' => true
            ]]);
        }

        return view('history.setting');
    }

    public function searchHistory(Request $request){
        $report_date_start = $request->get('report_date_start');
        $report_date_end = $request->get('report_date_end');
        $imei = $request->get('imei');
        $msn = $request->get('msn');
        $mount_no = $request->get('mount_no');

        $data = $this->search($report_date_start, $report_date_end, $mount_no, $imei, $msn);
        $roles =  UserRole::select('user_roles.*', 'users.id as user_id')
           ->leftJoin('users', 'user_roles.id', '=', 'users.user_role_id')
           ->get();
        //$data = Emerge::customPaginate($data, 20);
        return [
            'success' => true,
            'data' => $data,
            'roles' => $roles
        ];
    }

    private function get_data_for_table(){
        $report_date_start = $report_date_end = $imei = $msn = $mount_no = null;

        if(session('history_setting_history')){
            $report_date_start = session('history_setting_history')['report_date_start'];
            $report_date_end = session('history_setting_history')['report_date_end'];
            $imei = session('history_setting_history')['imei'];
            $msn = session('history_setting_history')['msn'];
            $mount_no = session('history_setting_history')['mount_no'];
        }
        
        $settings_pagination = $this->search($report_date_start, $report_date_end, $mount_no, $imei, $msn);
        $roles =  UserRole::select('user_roles.*', 'users.id as user_id')
        ->leftJoin('users', 'user_roles.id', '=', 'users.user_role_id')
        ->get();
        // $settings_pagination = Emerge::customPaginate($settings_pagination, 20);
        return [
            'settings_pagination' => $settings_pagination,
            'roles' => $roles,
            'filter' => [
                'report_date_start' => $report_date_start,
                'report_date_end' => $report_date_end,
                'mount_no' => $mount_no,
                'imei' => $imei,
                'msn' => $msn,
            ],
        ];
    }

    public function search($report_date_start, $report_date_end, $mount_no, $imei, $msn, $perPage = 20){

        $query = DeviceSetting::query();

        if (isset($report_date_start))
            $query->whereDate('created_at', '>=', $report_date_start);

        if (isset($report_date_end))
            $query->whereDate('created_at', '<=', $report_date_end);

        if (isset($mount_no))
            $query->whereHas('deviceAssignment', function ($q)use($mount_no){$q->where('mount_no', $mount_no);});

        if (isset($imei))
            $query->whereHas('device', function ($q)use($imei){$q->where('imei', $imei);});

        if (isset($msn))
            $query->whereHas('sim', function ($q)use($msn){$q->where('msn', $msn);});

        if (Auth::user()->isBranch()) {
            $user_id = Auth::user()->id;
            $query->where('user_id', $user_id);
        }

        session([
            'history_setting_history' => [
                'report_date_start' => $report_date_start,
                'report_date_end' => $report_date_end,
                'mount_no' => $mount_no,
                'imei' => $imei,
                'msn' => $msn,
            ]
        ]);
        return $query->with(['user', 'deviceAssignment', 'company', 'sim', 'device.deviceType', 'deviceGroup', 'phones'])
            ->orderBy('created_at', 'desc')->paginate($perPage);

    }
}
