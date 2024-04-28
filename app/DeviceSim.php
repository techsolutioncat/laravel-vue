<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceSim extends Model
{
    protected $fillable = [
        'id',
        'device_imei',
        'sim_iccid',
        'active',
        'battery',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_imei', 'imei');
    }

    public function sim()
    {
        return $this->belongsTo(Sim::class, 'sim_iccid', 'iccid');
    }

//    public function deviceAssignments()
//    {
//        return $this->belongsToMany(DeviceAssignment::class);
//    }
}
