<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HistoryListTrackRequest;
use App\DeviceReport;
use App\Http\Services\GpsService;

class TrackingController extends Controller {

    public function list(HistoryListTrackRequest $request){
        $ids = $request->input('ids');
        $history_list = DeviceReport::whereIn('id', $ids)->with([
            'deviceAssignment.sim',
            'deviceAssignment.device.deviceType',
            'deviceSignal',
            'deviceAssignment.deviceGroup',
            'deviceAssignment.company',
            'deviceAssignment.phones'])->orderBy('created_at', 'desc')->get();
        
        // TODO have to filter items for authorized user

        return response()->json($history_list);
    }

    public function polling(DeviceReport $history){
        // TODO check if a current user has the authority to deal with this record

        // Authorization check
        $this->authorize('polling', $history);

        $res = [];
        if( !$history->positioning ){
            $res['stop'] = true;
        }
        $positions = $history->deviceReportPositions()->where( 'created_at', '>=', $history->created_at )->orderBy('created_at', 'desc')->get();
        $res['positions'] = $positions;
        return response()->json( $res );
    }

    public function initPositionRequest(DeviceReport $history, GpsService $gps_service){
        // Authorization check

        $this->authorize('initPositionRequest', $history);

        $result = $gps_service->initPositionRequest( $history );
        if ( $result === false ){
            return response()->json([
                'success'   =>  false,
                'msg'       =>  $gps_service->getError(),
            ]);
        }
        return response()->json([
            'success'   =>  true,
            'request_id'=>  $result
        ]);
    }

    public function checkPositionResult(DeviceReport $history, $request_no, GpsService $gps_service){
        // Authorization check
        $this->authorize('checkPositionResult', $history);

        $result = $gps_service->getManualPositionResult( $request_no );
        if($result === false){
            return response()->json([
                'success'   =>  false,
            ]);
        }
        return response()->json([
            'success'   =>  true,
            'data'      =>  $result
        ]);
    }

}