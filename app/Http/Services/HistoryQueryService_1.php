<?php
namespace App\Http\Services;

use App\DeviceReport;
use App\DeviceSignal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Company;
class HistoryQueryService {

    public function search(Request $request){       
        $date = $request->input('date');
        $rtc_time = $request->input('rtc_time');
        $emergency_buzzer = $request->boolean('emergency_buzzer');
        $emergency_call = $request->boolean('emergency_call');
        $call_received = $request->boolean('call_received');
        $battery_low = $request->boolean('battery_low');
        $power_off = $request->boolean('power_off');
        $power_on = $request->boolean('power_on');
        $location_inquiry = $request->boolean('location_inquiry');
        $group_name = $request->input('group_name');
        $sb_billing_number = $request->input('sb_billing_number');
        $device_model = $request->input('device_model');
        $company_name = $request->input('company_name');
        $imei_number = $request->input('imei_number');
        $command_center = $request->input('command_center');
        $msn = $request->input('msn');
        $receiver_number = $request->input('receiver_number');
        $dealt_with_at_true = $request->boolean('dealt_with_at_true');
        $dealt_with_at_false = $request->boolean('dealt_with_at_false');
        $company_id = $request->input('company_id');
        $mount_no = $request->input('mount_no');
        $query = DeviceReport::query();

        if (!empty($date)) {
            $query->whereDate('created_at', $date);
            // $query->whereDate('rtc_time', $date);
        }
        if (!empty($rtc_time)) {
            $query->whereDate('rtc_time', $rtc_time);
        }
        $signal_int = [];
        if ($emergency_buzzer == "true" ){
            $signal_int[] = DeviceSignal::$emergency_buzzer;
        }
        if ($emergency_call )
            $signal_int[] = DeviceSignal::$emergency_call;

        if ($battery_low )
            $signal_int[] = DeviceSignal::$battery_low;

        if ($power_off )
            $signal_int[] = DeviceSignal::$power_off;

        if($call_received ){
            $signal_int[] = DeviceSignal::$call_received;
        }
        if ($power_on )
            $signal_int[] = DeviceSignal::$power_on;

        if ($location_inquiry )
        $signal_int[] = DeviceSignal::$location_inquiry;
        
        
        if ( count( $signal_int ) ) {
            $query->whereHas('deviceSignal', function ($q) use ($signal_int){
                $q->whereIn('signal_int', $signal_int);
                // if($signal_int){
                //     foreach ($signal_int as $id => $value) {
                //         $q->orWhere('signal_int', $value);
                //     }
                // }
            });
        }

        $dealt = [];
        if ($dealt_with_at_true == 1) {
            $dealt['dealt_with_true'] = $dealt_with_at_true;
        }

        if ($dealt_with_at_false == 1) {
            $dealt['dealt_with_false'] = $dealt_with_at_false;
        }

        $query->where(function ($q) use ($dealt) {
            if (isset($dealt['dealt_with_false']) && isset($dealt['dealt_with_true'])) {

            } else if (isset($dealt['dealt_with_true'])) {
                $q->whereNotNull('dealt_with_at');
            } else if (isset($dealt['dealt_with_false'])) {
                $q->whereNull('dealt_with_at');
            } else {
                $q->whereNotNull('dealt_with_at')->whereNull('dealt_with_at');
            }
        });
        
        ///when company page
        if ( $company_id ) {

            $query->doesntHave('deviceSetting')->whereHas('deviceAssignment', function ($q) use ($company_id){
                $q->where('company_id', $company_id);
            })
            ->orWhereHas('deviceSetting', function ($q) use ($company_id) {
                $q->where('company_id', $company_id);
            });
        } 

        $companyArray = Company::getCompanyList();
        
        // if (isset($companyArray)) {
        //
        //     ->orWhereHas('deviceSetting', function ($q) use ($companyArray) {
        //         $q->whereIn('company_id', $companyArray);
        //     });
        // }
        
        // if ( $company_name ) {

        //     $query->doesntHave('deviceSetting.company')->whereHas('deviceAssignment.company', function ($q) use ($company_name, $companyArray){
        //         $q->where('name', $company_name)->whereIn('id', $companyArray);
        //     })
        //     ->orWhereHas('deviceSetting.company', function ($q) use ($company_name, $companyArray) {
        //         $q->where('name', $company_name)->whereIn('id', $companyArray);
        //     }); 
        // } elseif (!isset($company_id)) {

        //     $query->doesntHave('deviceSetting.company')->whereHas('deviceAssignment.company', function ($q) use ($company_name, $companyArray){
        //         $q->whereIn('id', $companyArray);
        //     })
        //     ->orWhereHas('deviceSetting.company', function ($q) use ($company_name, $companyArray) {
        //         $q->whereIn('id', $companyArray);
        //     });
        // }
        if ( $company_name ) {
            $query->doesntHave('deviceSetting.company')->whereHas('deviceAssignment.company', function ($q) use ($company_name){
                $q->where('name', $company_name);
            })
            ->orWhereHas('deviceSetting.company', function ($q) use ($company_name) {
                $q->where('name', $company_name);
            });      
        } 

        if ($mount_no) {
            $query->doesntHave('deviceSetting')->whereHas('deviceAssignment', function ($q) use ($mount_no){
                $q->where('mount_no', $mount_no);
            })
            ->orWhereHas('deviceSetting', function ($q) use ($mount_no) {
                $q->where('mount_no', $mount_no);
            });
        }

        if ( $device_model ) {
            $query->doesntHave('deviceSetting.device.deviceType')->whereHas('deviceAssignment.device.deviceType', function ($q) use ($device_model){
                $q->where('type', $device_model);
            })
            ->orWhereHas('deviceSetting.device.deviceType', function ($q) use ($device_model) {
                $q->where('type', $device_model);
            });
        }

        if ( $sb_billing_number ) {
            $query->doesntHave('deviceSetting.company')->whereHas('deviceAssignment.company', function ($q) use ($sb_billing_number){
                $q->where('sb_payment_no', $sb_billing_number);
            })
            ->orWhereHas('deviceSetting.company', function ($q) use ($sb_billing_number) {
                $q->where('sb_payment_no', $sb_billing_number);
            });
        }

        if ( $group_name ) {
            $query->doesntHave('deviceSetting.deviceGroup')->whereHas('deviceAssignment.deviceGroup', function ($q) use ($group_name){
                $q->where('name', $group_name);
            })
            ->orWhereHas('deviceSetting.deviceGroup', function ($q) use ($group_name) {
                $q->where('name', $group_name);
            });
        }



        if ( $imei_number ) {
            $query->doesntHave('deviceSetting.device')->whereHas('deviceAssignment.device', function ($q) use ($imei_number){
                $q->where('imei', $imei_number);
            })
            ->orWhereHas('deviceSetting.device', function ($q) use ($imei_number) {
                $q->where('imei', $imei_number);
            });
        }

        if ( $msn ) {
            $query->doesntHave('deviceSetting.sim')->whereHas('deviceAssignment.sim', function ($q) use ($msn){
                $q->where('msn', $msn);
            })
            ->orWhereHas('deviceSetting.sim', function ($q) use ($msn) {
                $q->where('msn', $msn);
            });
        }

        if ( $command_center ) {
            $query->doesntHave('deviceSetting.phones')->whereHas('deviceAssignment.phones', function ($q) use ($command_center){
                $q->where('phone', $command_center);
            })
            ->orWhereHas('deviceSetting.phones', function ($q) use ($command_center) {
                $q->where('phone', $command_center);
            });
        }

        if ( $receiver_number ) {
            $query->doesntHave('deviceSetting.phones')->whereHas('deviceAssignment.phones', function ($q) use ($receiver_number){
                $q->where(['phone' => $receiver_number, 'auth_no' => 0]);
            })
            ->orWhereHas('deviceSetting.phones', function ($q) use ($receiver_number) {
                $q->where(['phone' => $receiver_number, 'auth_no' => 0]);
            });
        }

        // if(Auth::user()->userRole->role == 'user')
        // {
        //     $company_id = Auth::user()->company_id;
        //     $query->doesntHave('deviceSetting')->whereHas('deviceAssignment', function ($q) use ($company_id){
        //         $q->where('company_id', $company_id);
        //     })
        //     ->orWhereHas('deviceSetting', function ($q) use ($company_id) {
        //         $q->where('company_id', $company_id);
        //     });
        // }
        
        //$query_not_null->merge($query_setting_null);
        session(['company_device_history_history' =>
            [
                'date' => $date,
                'rtc_time' => $rtc_time,
                'emergency_buzzer' => $emergency_buzzer,
                'emergency_call' => $emergency_call,
                'call_received' => $call_received,
                'power_off' => $power_off,
                'power_on' => $power_on,
                'battery_low' => $battery_low,
                'location_inquiry' => $location_inquiry,
                'device_model' => $device_model,
                'sb_billing_number' => $sb_billing_number,
                'group_name' => $group_name,
                'imei_number' => $imei_number,
                'command_center' => $command_center,
                'msn' => $msn,
                'receiver_number' => $receiver_number,
                'dealt_with_at_true' => $dealt_with_at_true,
                'dealt_with_at_false' => $dealt_with_at_false,
                'mount_no'  => $mount_no,
                'company_name' => $company_name
            ]
        ]);
        session(['company_device_history_history_page' => $request->get('page')]);
        return $query;
    }

    public function linkedReportsDealt(DeviceReport $device_report, $data){
        $device_sim_id = $device_report->deviceAssignment->sim->id;
        
        DeviceReport::whereHas('deviceAssignment', function($q) use( $device_sim_id ) {
            $q->where('sim_id', $device_sim_id);
        })
        // ->where('positioning', '>=', 1)
        // ->get();
        ->update( $data );
        
    }

}