<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ログイン
Route::get('/', 'HomeController@index')->name('home');
Route::get('login', 'Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 管理者
//Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');

// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    // 管理者情報を表示する
    Route::get('admin', 'AdminController@index')->name('admin');
    Route::get('admin/{id}/detail', 'AdminController@detail')->name('admin.detail');
    Route::post('admin/getbyid', 'AdminController@getOne')->name('admin.getbyid');
    Route::post('admin/register', 'AdminController@register')->name('admin.register');
    Route::post('admin/update', 'AdminController@update')->name('admin.update');
    Route::post('admin/delete', 'AdminController@delete')->name('admin.delete');

    // 会社
    Route::get('company', 'CompanyController@index')->name('company');
    Route::get('company/search', 'CompanyController@searchCompany')->name('company.register');
    Route::post('company/register', 'CompanyController@register')->name('company.register');
    Route::post('company/update', 'CompanyController@update')->name('company.update');
    Route::post('company/delete', 'CompanyController@delete')->name('company.delete');
    Route::get('company/{id}/detail', 'CompanyController@detail')->name('company.detail');

    Route::get('company/{id}/history', 'HistoryController@listByCompany')->name('company.history');
    Route::get('company/{id}/history/search', 'HistoryController@searchHistory')->name('company.history.search');
    Route::get('company/{company_id}/history/{history_id}/detail', 'HistoryController@detailForCompany')->name('company.history.detail');

    Route::get('company/{id}/device', 'DeviceController@listByCompany')->name('company.device');
    Route::get('company/{id}/device/search', 'DeviceController@searchDevice')->name('company.device.search');
    Route::get('company/{company_id}/device/{device_id}/detail', 'DeviceController@detailForCompany')->name('company.device.detail');

    // 端末
    Route::post('device/update', 'DeviceController@update')->name('device.update');
    Route::post('device/delete', 'DeviceController@delete')->name('device.delete');
    Route::post('device/restore', 'DeviceController@restore')->name('device.restore');
    Route::post('device/clone', 'DeviceController@clone')->name('device.clone');

    // エクセルインポート
    Route::post('device/import', 'DeviceController@import')->name('device.import');
    Route::get('device/export', 'DeviceController@export')->name('device.export');

    // 履歴
    Route::post('history/update', 'HistoryController@update')->name('history.update');
    Route::post('history/delete', 'HistoryController@delete')->name('history.delete');
    Route::get('history/monitor', 'HistoryController@monitor')->name('history.monitor');

//    Route::get('geo', 'GeolocationController@index')->name('home');

});

Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
// 登録
// 端末情報を表示する
    Route::get('device', 'DeviceController@index')->name('device');
    Route::get('device/garbage', 'DeviceController@garbage')->name('device.garbage');
    Route::get('device/search', 'DeviceController@searchDevice')->name('device.search');
    Route::get('device/searchCompanyName', 'DeviceController@searchCompanyName')->name('device.search');
    Route::get('device/{id}/detail', 'DeviceController@detail')->name('device.detail');
    Route::get('device/searchforclone', 'DeviceController@searchDeviceAssignmentForClone')->name('company.device.searchforclone');
    Route::get('device/{id}/detail/garbage', 'DeviceController@garbageDetail')->name('device.detail.garbage');

// お知らせを表示する
    Route::get('notice', 'NoticeController@index')->name('notice');
    Route::get('notice/search', 'NoticeController@searchNotice')->name('notice.search');
    Route::post('notice/check', 'NoticeController@check')->name('notice.check');
    Route::post('notice/update', 'HistoryController@updateNotice')->name('notice.update');
    Route::get('notice/{id}/detail', 'NoticeController@detail')->name('notice.detail');

// 履歴を表示する
    Route::get('history', 'HistoryController@index')->name('history');
    Route::get('history/search', 'HistoryController@searchHistory')->name('history.search');
    Route::get('history/{id}/detail', 'HistoryController@detail')->name('history.detail');
    Route::get('history/{id}/message', 'HistoryController@message')->name('history.message');
    Route::get('history/setting', 'SettingHistoryController@index')->name('history.setting');
    Route::get('history/setting/search', 'SettingHistoryController@searchHistory')->name('history.setting.search');
    Route::get('history/monitor', 'HistoryController@monitor')->name('history.monitor');
});

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {
});

Route::group(['middleware' => ['auth', 'can:branch-higher']], function () {
    Route::get('company', 'CompanyController@index')->name('company');
    Route::get('company/search', 'CompanyController@searchCompany')->name('company.register');
    Route::post('company/register', 'CompanyController@register')->name('company.register');
    Route::post('company/update', 'CompanyController@update')->name('company.update');
    Route::post('company/delete', 'CompanyController@delete')->name('company.delete');
    Route::get('company/{id}/detail', 'CompanyController@detail')->name('company.detail');

    Route::get('company/{id}/history', 'HistoryController@listByCompany')->name('company.history');
    Route::get('company/{id}/history/search', 'HistoryController@searchHistory')->name('company.history.search');
    Route::get('company/{company_id}/history/{history_id}/detail', 'HistoryController@detailForCompany')->name('company.history.detail');

    Route::get('company/{id}/device', 'DeviceController@listByCompany')->name('company.device');
    Route::get('company/{id}/device/search', 'DeviceController@searchDevice')->name('company.device.search');
    Route::get('company/{company_id}/device/{device_id}/detail', 'DeviceController@detailForCompany')->name('company.device.detail');

    // 端末
    Route::post('device/update', 'DeviceController@update')->name('device.update');
    Route::post('device/delete', 'DeviceController@delete')->name('device.delete');
    Route::post('device/restore', 'DeviceController@restore')->name('device.restore');
    Route::post('device/clone', 'DeviceController@clone')->name('device.clone');

    // エクセルインポート
    Route::post('device/import', 'DeviceController@import')->name('device.import');
    Route::get('device/export', 'DeviceController@export')->name('device.export');

    // 履歴
    Route::post('history/update', 'HistoryController@update')->name('history.update');
    Route::post('history/delete', 'HistoryController@delete')->name('history.delete');
    Route::get('history/monitor', 'HistoryController@monitor')->name('history.monitor');
});
