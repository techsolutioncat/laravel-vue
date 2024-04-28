<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceGroup extends Model
{
    protected $fillable = [
        'company_id',
        'name',
    ];

//    public function deviceAssignments()
//    {
//        return $this->belongsToMany(DeviceAssignment::class);
//    }
    public function company() {
        return $this->belongsTo(Company::class)->withDefault();
    }
}
