<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceReportMessage extends Model
{
    protected $fillable = [
        'device_report_id',
        'device_assignment_id'
    ];

    protected $hidden = [];

    public function deviceReport()
    {
        return $this->belongsTo(DeviceReport::class)->withDefault();
    }

    public function deviceAssignment()
    {
        return $this->belongsTo(DeviceAssignment::class)->withTrashed();
    }
}
