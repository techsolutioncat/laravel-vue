<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    protected $fillable = [
        'device_assignment_id',
        'auth_no',
        'name',
        'phone',
    ];

    protected $hidden = [];

    protected $attributes = [
      'name' => '',
      'phone' => '',
    ];

}
