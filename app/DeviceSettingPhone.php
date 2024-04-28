<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceSettingPhone extends Model
{

    protected $fillable = [
        'device_setting_id',
        'auth_no',
        'name',
        'phone'
    ];

    protected $hidden = [];

    protected $attributes = [
      'name' => '',
      'phone' => '',
    ];

//    public function deviceAssignment()
//    {
//        return $this->belongsTo(DeviceAssignment::class);
//    }
}
