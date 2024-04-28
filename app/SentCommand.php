<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SentCommand extends Model
{
    protected $fillable = [
        'device_assignment_id',
        'command',
        'result',
        'sent_at',
        'applied_at',
    ];

    protected $hidden = [];

    public function deviceAssignment()
    {
        return $this->belongsTo(DeviceAssignment::class)->withDefault();
    }
}
