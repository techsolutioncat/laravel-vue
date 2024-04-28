<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\DeviceReport;

class DeviceReportPosition extends Model
{
    protected $fillable = [
        'lat',
        'lot',
        'position_time'
    ];

    protected $casts = [
        'position_time' =>  'date:Y/m/d H:i:s',
        'created_at'    =>  'date:Y/m/d H:i:s'
    ];
    protected $appends = ['lng'];

    
    public function device_report(){
        return $this->belongsTo(DeviceReport::class);
    }
    public function getPositionTimeAttribute(){
        return ( new Carbon( $this->attributes['position_time'] ) )->format( 'Y/m/d H:i:s' );
    }
    public function getCreatedAtAttribute(){
        return ( new Carbon( $this->attributes['created_at'] ) )->format( 'Y/m/d H:i:s' );
    }

    public function getLngAttribute(){
        return $this->attributes['lot'];
    }
    
}
