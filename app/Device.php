<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'imei',
        'device_type_id',
        'version'
    ];

    // public function deviceSim()
    // {
    //     return $this->belongsTo(DeviceSim::class);
    // }

    public function fcmToken()
    {
        return $this->hasOne(FcmToken::class, "device_id");
    }

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }
}
