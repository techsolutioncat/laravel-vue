<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DeviceSetting extends Model
{
    protected $fillable = [
        'id',
        'device_assignment_id',
        'user_id',
        'sim_id',
        'device_id',
        'device_group_id',
        'company_id',
        'mount_no',
        'name',
        'rest',
        'started_at',
        'ended_at',
        'restored_at',
        'deleted_at',
        'applied_at',
    ];

    protected $hidden = [];
    protected $appends = ['created_at_date', 'created_at_time'];

    public function deviceAssignment(){
        return $this->belongsTo(DeviceAssignment::class)->withTrashed();
    }

    public function Sim(){
        return $this->belongsTo(Sim::class)->withDefault();
    }

    public function device() {
        return $this->belongsTo(Device::class)->withDefault();
    }

    // public function deviceSim() {
    //     return $this->belongsTo(DeviceSim::class)->withDefault();
    // }
    
    public function deviceGroup() {
        return $this->belongsTo(DeviceGroup::class)->withDefault();
    }

    public function company() {
        return $this->belongsTo(Company::class)->withDefault();
    }

    public function phones() {
        return $this->hasMany(DeviceSettingPhone::class,'device_setting_id');
    }

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getCreatedAtDateAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('Y/m/d') : null;
    }
    public function getCreatedAtTimeAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('H:i:s') : null;
    }
    public function getStartedAtAttribute(){
        return $this->attributes['started_at'] ? Carbon::parse($this->attributes['started_at'])->format('Y/m/d') : null;
    }
    public function getEndedAtAttribute(){
        return $this->attributes['ended_at'] ? Carbon::parse($this->attributes['ended_at'])->format('Y/m/d') : null;
    }
    public function getRestoredAtAttribute(){
        return $this->attributes['restored_at'] ? Carbon::parse($this->attributes['restored_at'])->format('Y/m/d') : null;
    }
    public function getDeletedAtAttribute(){
        return $this->attributes['deleted_at'] ? Carbon::parse($this->attributes['deleted_at'])->format('Y/m/d') : null;
    }
    public function getAppliedAttribute(){
        return $this->attributes['applied_at'] ? Carbon::parse($this->attributes['applied_at'])->format('Y/m/d') : null;
    }

    public function scopeHasDeviceSim(
        Builder $query,
        $imei,
        $msn
    ): Builder
    {
        $device =
            Device::query()
                ->where('imei', 'LIKE', $imei)
                ->get()->getQueueableIds();

        $sim =
            Sim::query()
                ->where('msn', 'LIKE', $msn)
                ->get('iccid')->toArray();

        // $device_sim =
        //     DeviceSim::query()
        //         ->where('device_imei', 'LIKE', $imei)
        //         ->whereIn('sim_iccid', $sim)
        //         ->get()->getQueueableIds();

        return $query
            ->whereIn('sim_id',  $sim);
    }

    public function data()
    {
        $this['created_at_date']
            = (new Carbon($this->created_at))->format('Y/m/d');
        $this['created_at_time']
            = (new Carbon($this->created_at))->format('H:i:s');
        $this['started_at']
            = (new Carbon($this->started_at))->format('Y/m/d');
        if($this->ended_at !== null)
            $this['ended_at']
            = (new Carbon($this->ended_at))->format('Y/m/d');
        if($this->restored_at == null)
            $this['restored_at']
            = (new Carbon($this->restored_at))->format('Y/m/d');
        if($this->deleted_at !== null)
            $this['deleted_at']
            = (new Carbon($this->deleted_at))->format('Y/m/d');

        $this['device_type'] = $this->device->deviceType;
        $this['device'] = $this->device;
        $this['device_msn'] = $this->Sim->msn;
        $this['device_group'] = $this->deviceGroup;
        $this['device_company'] = $this->company;
        $this['using'] = $this->ended_at == null;
        $this['user'] = $this->ended_at == $this->user;

        $devicePhones = $this->phones;

        $phones = [];

        for($i=0; $i<11; $i++){
            $phones[] = $devicePhones->get(
                $i,
                ['phone' => '', 'name' => '']
            );
        }

        $this['device_phones'] = $phones;

        return $this;
    }
}
