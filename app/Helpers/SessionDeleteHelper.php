<?php

namespace App\Helpers;

class SessionDeleteHelper
{
    /**
     * Delete Session;
     *
     * @param $items
     * @return void
     */
    public static function sessionDelete()
    {
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
    }
}
