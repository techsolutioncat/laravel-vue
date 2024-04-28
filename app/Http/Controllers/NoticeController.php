<?php

namespace App\Http\Controllers;

use App\DeviceSignal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DeviceReport;
use Illuminate\Support\Facades\Auth;
use JavaScript;
use Emerge;

class NoticeController extends Controller
{
    public function index()
    {
        // $companyArray = Company::getCompanyList();
        $deviceAssignmentArray = DeviceReport::getDeviceAssignmentList();
        $data = $this->get_data_for_table($deviceAssignmentArray);

        $admin = Auth::user()->userRole->role == 'admin';
        // $page = session('notice_history_page');
        
        //dd($page);
        JavaScript::put([
            'notices' => $data['notices_pagination'],
            'filter' =>  $data['filter'],
            'isAdmin' => $admin,
            // 'current_page' => $page
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
            ]]);
        }

        if(session('history_setting_history')){
            session(['history_setting_history' => [
            'report_date_start' => null,
            'report_date_end' => null,
            'mount_no' => null,
            'imei' => null,
            'msn' => null
            ]]);
        }

        return view('notice.index');
    }

    public function searchNotice(Request $request){
        $emergency_buzzer = $request->boolean('emergency_buzzer');
        $emergency_call = $request->boolean('emergency_call');
        $battery_low = $request->boolean('battery_low');
        $power_off = $request->boolean('power_off');

        $deviceAssignmentArray = DeviceReport::getDeviceAssignmentList();
        $searched_data = $this->search($emergency_buzzer, $emergency_call, $battery_low, $power_off, $deviceAssignmentArray);
        $searched_data = Emerge::customPaginate($searched_data, 20);

        return [
            'success' => true,
            'data' => $searched_data,
        ];
    }

    public function check(Request $request){
        $id = $request->post('id', null);
        $dealt_with = $request->post('dealt_with', false);

        $data = [
            'dealt_with_at' => $dealt_with ? Carbon::now(): null,
        ];

        DeviceReport::query()->find($id)->fill($data)->save();

        return [
            'success' => true,
        ];
    }

    public function detail($id)
    {
        $isBranchAdmin = Auth::user()->isBranchAdmin();
        $history_detail = DeviceReport::query()->where('id', $id)->with([
            'deviceAssignment.sim',
            'deviceAssignment.device',
            'deviceSignal',
            'deviceAssignment.deviceGroup',
            'deviceAssignment.company',
            'deviceAssignment.phones',
            'deviceReportPositions'
        ])->first();
        $page = session('notice_history_page', 1);
        JavaScript::put([
            'history_detail' => $history_detail,
            'isAdmin' => $isBranchAdmin,
            'google_api_key'    =>  config('services.google.key'),
            'current_page' => $page,
            'isProduction' => view()->shared('is_production')
        ]);

        return view('notice.detail');
    }

    private function get_data_for_table($deviceAssignmentArray = null){
        $emergency_buzzer = $emergency_call = $battery_low = $power_off = true;
            

        if(session('notice_history')){
            $emergency_buzzer = session('notice_history')['emergency_buzzer'];
            $emergency_call = session('notice_history')['emergency_call'];
            $battery_low = session('notice_history')['battery_low'];
            $power_off = session('notice_history')['power_off'];
        }

        $notices = $this->search($emergency_buzzer, $emergency_call, $battery_low, $power_off, $deviceAssignmentArray);

        $notices_pagination = Emerge::customPaginate($notices, 20);
        
        $page = $notices_pagination->currentPage();
        session(['notice_history_page' => $page]);

        return [
            'notices_pagination' => $notices_pagination,
            'filter' => [
                'emergency_buzzer' => $emergency_buzzer,
                'emergency_call' => $emergency_call,
                'battery_low' => $battery_low,
                'power_off' => $power_off,
            ],
        ];
    }

    public function search($emergency_buzzer, $emergency_call, $battery_low, $power_off, $deviceAssignmentArray){

        $query = DeviceReport::query();

        $signal_int = [];
        if ($emergency_buzzer)
            $signal_int[] = DeviceSignal::$emergency_buzzer;

        if ($emergency_call)
            $signal_int[] = DeviceSignal::$emergency_call;

        if ($power_off)
            $signal_int[] = DeviceSignal::$power_off;

        if($battery_low){
            $signal_int[] = DeviceSignal::$battery_low;
        }

        $query->whereHas('deviceSignal', function ($q)use($signal_int){
            $q->where('signal_int', null);
            if($signal_int){
                foreach ($signal_int as $id => $value) {
                    $q->orWhere('signal_int', $value);
                }
            }
        });

        $query->whereHas('deviceSignal', function ($q){$q->whereIn('signal_int', [
                DeviceSignal::$emergency_buzzer,
                DeviceSignal::$emergency_call,
                DeviceSignal::$battery_low,
                DeviceSignal::$power_off]);
        });

        if (!is_null($deviceAssignmentArray)) {
            $query->whereIn('device_assignment_id', $deviceAssignmentArray);
        } elseif (Auth::user()->userRole->role == 'user') {
            $company_id = Auth::user()->company_id;
            $query->whereHas('deviceAssignment', function($q)use($company_id){$q->where('company_id', $company_id);});
        }

        session(['notice_history' =>
            [
                'emergency_buzzer' => $emergency_buzzer,
                'emergency_call' => $emergency_call,
                'battery_low' => $battery_low,
                'power_off' => $power_off,
            ]
        ]);
        
        return $query->with([
            'deviceAssignment.sim',
            'deviceSignal',
            'deviceAssignment.deviceGroup',
            'deviceAssignment.company',
            'deviceAssignment.phones'
        ])->orderBy('created_at', 'desc')->get();

    }

    function send()
    {
        $key = config('services.google.key');
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=130,40&key='.$key;

        if ( !function_exists( 'curl_version' ) ) {
            return false;
        }

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $data = curl_exec( $ch );

        $response = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

        curl_close( $ch );

        if ( $response === 200 ) {
            return true;
        } else {
//            $this->output->writeln($response);
            return false;
        };
    }

}
