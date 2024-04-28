<?php

namespace App\Http\Services;

use App\DeviceReport;
use App\Jobs\CommandApi;
use GuzzleHttp\Client;
use App\DeviceReportPosition;

class GpsService{

    private $error;
    private $http_client;

    public function __construct(){
        $url = config('services.setting.url');
        $port = config('services.setting.port');
        
        $this->http_client = new Client([
            'base_uri' => $url.':'.$port,
        ]);

    }
    public function getError(){
        return $this->error;
    }

    /**
     * position api request to gateway
     * @param DeviceReport $report
     * @return integer $request_no
     * if error return false
     */
    public function initPositionRequest( $report ){
        // request position request
        $response = null;
        $deviceAssignment = $report->deviceAssignment;
        if($deviceAssignment->device->deviceType->type == 'S10')
        {
            $response = $this->http_client->request('post', 'position',
                [
                    'json'  =>  [
                        'device_assignment_id'   =>  $deviceAssignment->id
                    ]
                ]);
        } else {
            $msn = $report->deviceAssignment->sim->msn;
            $response = $this->http_client->request('post', 'sms/position',
                [
                    'json'  =>  [
                        'msn'   =>  $msn
                    ]
                ]);
        }

        if ($response->getStatusCode() == 200) {
            $res_body = json_decode($response->getBody());
            if ($res_body->status === "ok" && isset($res_body->requestId)) {
                return $res_body->requestId;
            }
            $this->error = "Gps command response format error";
            return false;
        }
        $this->error = "Gps Command Error";
        return false;
    }

    /**
     * get position request result periodically
     * @param integer $request_no
     * @return Object result
     * 
     * response example
     *  - position not ready
     *  {
     *      positionStatus: false
     *  }
     *  - position is ready
     *  {
     *      positionStatus  :   true,
     *      lat             :   35.688271,
     *      lng             :   139.693222
     *  }
     */
    public function getManualPositionResult( $request_id ){
        $position = DeviceReportPosition::where(['request_id' => $request_id])->first();
        if (!$position) {
            return false;
        }
        if (empty($position->lat) || empty($position->lot)) {
            return false;
        }
        return $position;
    }

    /**
     * finish the continuous geolocation tracking
     * @param integer 
     */
    public function finishLocationTracking(DeviceReport $report){
        // finish tracking command
        $response = null;
        $deviceAssignment = $report->deviceAssignment;
        if($deviceAssignment->device->deviceType->type == 'S10')
        {
            return $this->http_client->request('post', 'position/stop',
                [
                    'json'  =>  [
                        'device_assignment_id'   =>  $deviceAssignment->id
                    ]
                ]);
        } else {
            $msn = $report->deviceAssignment->sim->msn;
            $command = "123456M0,005M";
            return $this->http_client->request('post', 'sms/command',
                [
                    'json' => [
                        'msn' => $msn,
                        'command' => $command,
                    ]
                ]);
        }
    }

    public function commandRequest( $msn, $command )
    {
        $response = $this->sendCommand($msn, $command);
        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            $this->error = "Gps Command Error";
            return false;
        }
    }

    private function sendCommand($msn, $command){
        return $this->http_client->request('post', 'sms/command',
        [
            'json' => [
                'msn' => $msn,
                'command' => $command,
            ]
        ]);
    }


}