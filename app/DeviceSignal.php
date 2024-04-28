<?php

namespace App;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DeviceSignal extends Model
{
    protected $fillable = [
        'response',
        'signal_int',
        'description',
    ];

//    public static $emergency_buzzer = 'SOS OR MD Cancelled';
//    public static $emergency_call = 'ALM-A';
//    public static $battery_low = 'BATTERY LOW';
//    public static $power_off = 'POWER OFF NOW';
//    public static $power_on = 'POWER ON NOW';
//    public static $location_inquiry = 'CMD-F';
//    public static $setting = 'Setting';
    public static $emergency_buzzer = 1;
    public static $emergency_call = 2;
    public static $battery_low = 3;
    public static $power_off = 4;
    public static $power_on = 5;
    public static $call_received = 6;
    public static $location_inquiry = 7;
    public static $call_setting = 8;
    public static $connection_error = 100;
    public static $connection_restore = 101;

}
