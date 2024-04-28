<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsIntoDeviceReportPositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('device_report_positions', 'request_id')) {
            Schema::table('device_report_positions', function (Blueprint $table) {
                $table->uuid('request_id')->nullable(true)->default(null)
                    ->after('id')->comment('測位リクエストID、uuid');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('device_report_positions', 'request_id')) {
            Schema::table('device_report_positions', function (Blueprint $table) {
                $table->dropColumn(['request_id']);
            });
        }
    }
}
