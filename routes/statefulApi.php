<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    Route::get('admin/list', 'AdminController@list');
    Route::get('company/single/{id}', 'CompanyController@single');
    Route::get('company/list', 'Api\CompanyController@list');

    Route::get('device/list/garbage', 'Api\DeviceController@garbageList');
    Route::get('device/search', 'Api\DeviceController@search');
//    Route::post('device/position/single', 'Api\DeviceController@singlePosition');
//    Route::post('device/position/start', 'Api\DeviceController@startContinuousPosition');
//    Route::post('device/position/stop', 'Api\DeviceController@endContinuousPosition');
//    Route::get('command/{msn}/test', 'Api\DeviceController@testCommand');
//    Route::get('command/{msn}/update/dev', 'Api\DeviceController@updateDevCommand');
//    Route::get('command/{msn}/update/test', 'Api\DeviceController@updateTestCommand');
//    Route::get('command/{msn}/update/prod', 'Api\DeviceController@updateProdCommand');
//    Route::get('command/{msn}/reset/test', 'Api\DeviceController@resetTestCommand');
//    Route::get('command/{msn}/reset/dev', 'Api\DeviceController@resetDevCommand');
//    Route::get('command/{msn}/reset/prod', 'Api\DeviceController@resetProdCommand');

});

Route::group(['middleware' => ['auth', 'can:branch-higher']], function () {
//    Route::get('device/list/garbage', 'Api\DeviceController@garbageList');
//    Route::get('device/search', 'Api\DeviceController@search');
    Route::get('command/{msn}/test', 'Api\DeviceController@testCommand');
    Route::get('command/{msn}/update/dev', 'Api\DeviceController@updateDevCommand');
    Route::get('command/{msn}/update/test', 'Api\DeviceController@updateTestCommand');
    Route::get('command/{msn}/update/prod', 'Api\DeviceController@updateProdCommand');
    Route::get('command/{msn}/reset/test', 'Api\DeviceController@resetTestCommand');
    Route::get('command/{msn}/reset/dev', 'Api\DeviceController@resetDevCommand');
    Route::get('command/{msn}/reset/prod', 'Api\DeviceController@resetProdCommand');
});

Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    // Route::get('notice/list', 'Api\NoticeController@list');
    Route::get('history/list', 'HistoryController@list');
    Route::get('history/setting/list', 'SettingHistoryController@list');
    Route::get('device/list', 'Api\DeviceController@list');

    Route::post('/history/tracklist', 'Api\TrackingController@list')->name('history_list_track');
    Route::get('/track/{history}/positions', 'Api\TrackingController@polling')->name('position_polling');
    Route::get('/track/{history}/position_request', 'Api\TrackingController@initPositionRequest')->name('position_request');
    Route::get('/track/{history}/request_status/{request_no}', 'Api\TrackingController@checkPositionResult')->name('position_request');
    Route::post('history/update', 'Api\HistoryController@update');
});
