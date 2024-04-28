<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceState extends Model
{
    protected $fillable = [
        'state',
    ];

    public static function getState($state,  $index)
    {
        return self::$device_states[$state][$index];
    }

    private static $device_states = [
        '利用中' => [
            'id'       => 1,
//            'state'    => '利用中',
        ],
        '利用停止' => [
            'id'       => 2,
//            'state'    => '利用停止',
        ],
        '休止' => [
            'id'       => 3,
//            'state'    => '利用停止',
        ]
    ];
}
