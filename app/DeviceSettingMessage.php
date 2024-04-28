<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceSettingMessage extends Model
{
    protected $fillable = [
        'device_setting_id',
        'device_signal_id',
        'message'
    ];

    protected $hidden = [];

    public function deviceSetting()
    {
        return $this->belongsTo(DeviceSetting::class)->withDefault();
    }

    public function deviceSignal()
    {
        return $this->belongsTo(DeviceSignal::class)->withDefault();
    }
}
