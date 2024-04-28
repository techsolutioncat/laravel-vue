<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Modify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tcp_queue');
        Schema::dropIfExists('tcp_failed_queue');
        Schema::dropIfExists('http_queue');
        Schema::dropIfExists('http_failed_queue');

        // todo lat lotをnull許容に
//        if (Schema::hasColumn('device_report_positions', 'lat')) {
//            Schema::table('device_report_positions', function (Blueprint $table) {
//                // lat lotの変更
//                $table->uuid('request_id')->nullable(true)->default(null)
//                    ->after('id')->comment('測位リクエストID、uuid');
//                $table->double('lat')->nullable(true)->default(null)
//                    ->after('request_id')->comment('緯度');
//                $table->double('lot')->nullable(true)->default(null)
//                    ->after('lat')->comment('経度');
//            });
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
