<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $fillable = [
        'device_id',
        'token',
    ];


    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
