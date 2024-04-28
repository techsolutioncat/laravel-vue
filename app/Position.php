<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DeviceSim;
use App\DeviceReport;

class Position extends Model
{


    protected $fillable = [
        'requested_at',
        'resulted_at',
    ];

    protected $hidden = [];

    public function device(){
      return $this->belongsTo(Device::class);
    }
    public function deviceSim(){
      return $this->belongsTo(DeviceSim::class);
    }
    public function deviceReport() {
      return $this->belongsTo(DeviceReport::class);
    }

    public function getResultedAtAttribute(){
      return ( new Carbon( $this->attributes['resulted_at'] ) )->format( 'Y/m/d H:i:s' );
  }
}
