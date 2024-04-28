<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\DeviceReportPosition;
use App\DeviceAssignment;
use App\Company;

class DeviceReport extends DateModel
{
    /**
     * Constants for positioning
     */
    const POSITIONING_OFF = 0;
    const POSITIONING_ON = 1;
    
    protected $fillable = [
        'id',
        'device_assignment_id',
        'device_setting_id',
        'device_signal_id',
        'lat',
        'lng',
        'battery',
        'dealt_with_at',
        'supplement',
        'position_method',
        'positioning',
        'raw',
        'created_at',
        'rtc_time'
    ];

    protected $appends = ['dealt_with', 'received_messages', 'messages', 'created_at_date', 'created_at_time', 'rtc_time_date', 'rtc_time_time'];

    public function deviceSignal()
    {
        return $this->belongsTo(DeviceSignal::class);
    }

    public function deviceSetting() {

        return $this->belongsTo(DeviceSetting::class);
    }

    public function deviceAssignment()
    {
        return $this
            ->belongsTo(DeviceAssignment::class)
            ->withTrashed();
    }

    public function deviceReportPositions()
    {
        return $this->hasMany(DeviceReportPosition::class);
    }

    public function getCreatedAtAttribute() {
        return $this->attributes['created_at'] ? date('Y/m/d H:i:s', \strtotime($this->attributes['created_at'])) : null;
    }
    public function getCreatedAtDateAttribute(){
        return $this->attributes['created_at'] ? date('Y/m/d', \strtotime($this->attributes['created_at'])) : null;
    }

    public function getCreatedAtTimeAttribute(){
        return $this->attributes['created_at'] ? date('H:i:s', \strtotime($this->attributes['created_at'])) : null;
    }

    public function getRtcTimeAttribute() {
        return $this->attributes['rtc_time'] ? date('Y/m/d H:i:s', \strtotime($this->attributes['rtc_time'])) : null;
    }

    public function getRtcTimeDateAttribute(){
        return $this->attributes['rtc_time'] ? date('Y/m/d', \strtotime($this->attributes['rtc_time'])) : null;
    }

    public function getRtcTimeTimeAttribute(){
        return $this->attributes['rtc_time'] ? date('H:i:s', \strtotime($this->attributes['rtc_time'])) : null;
    }

    public function getReceivedMessagesAttribute(){
        return DeviceReportMessage::query()
            ->where('device_report_id', '=', $this->attributes['id'])
//            ->whereNotNull('device_report_id')
            ->where('received', '=', 1)
            ->get();
    }

    public function getMessagesAttribute(){
        return DeviceReportMessage::query()
            ->where('device_report_id', '=', $this->id)
            ->get();
    }

    public function getDealtWithAttribute(){
        return isset($this->attributes['dealt_with_at']);
    }

    public function scopeHasDeviceSignal(
        Builder $query,
        $signals
    ): Builder
    {
        $device_signal_ids =
            DeviceSignal::query()
                ->whereIn('signal_int', $signals)
                ->get()->getQueueableIds();

        return $query
            ->whereIn('device_signal_id',  $device_signal_ids);
    }

    public static function getDeviceAssignmentList(){
        $companyArray = Company::getCompanyList();
        $deviceAssignmentArray = DeviceAssignment::select('id')->whereIn('company_id', $companyArray)->get()->pluck('id')->all();
        return $deviceAssignmentArray;
    }
}
