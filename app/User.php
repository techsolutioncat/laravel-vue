<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'login_id',
        'name',
        'password',
        'company_id',
        'user_role_id',
        'enabled',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'login_verified_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function isAdmin()
    {
        return $this->userRole->auth >= 5;
    }

    public function isBranchAdmin()
    {
        return $this->userRole->auth >= 3;
    }

    public function isBranch()
    {
        return $this->userRole->auth == 3;
    }

    public function isAvailable(){
        return $this->enabled == 1;
    }

    # getting branch lists
    public static function getBranchList()
    {
        $branchArray = User::select('login_id', 'id', 'user_role_id')->whereHas('userRole', function ($q){$q->where('role', 'branch');})->orderBy('login_id', 'DESC')->get();
        return $branchArray;
    }
}
