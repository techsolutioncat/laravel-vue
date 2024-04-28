<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    protected $fillable = [
        'iccid',
        'msn'
    ];

//    public function deviceSim()
//    {
//        return $this->belongsTo(DeviceSim::class);
//    }
}
