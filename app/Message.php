<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'device_assignment_id',
        'device_signal_id',
        'message'
    ];

    protected $hidden = [];

    public function deviceAssignment()
    {
        return $this->belongsTo(DeviceAssignment::class)->withDefault();
    }

    public function deviceSignal()
    {
        return $this->belongsTo(DeviceSignal::class)->withDefault();
    }
}
