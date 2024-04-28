<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('device_assignments', 'device_setting_id')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('device_setting_id')->nullable(true)->default(null)
                    ->after('device_id')->comment('設定履歴の外部キー');
            });
        }
        if (!Schema::hasColumn('device_reports', 'device_setting_id')) {
            Schema::table('device_reports', function (Blueprint $table) {
                $table->unsignedBigInteger('device_setting_id')->nullable(true)->default(null)
                    ->after('device_assignment_id')->comment('設定履歴の外部キー');
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
        //
        if (Schema::hasColumn('device_assignments', 'device_setting_id')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->dropColumn(['device_setting_id']);
            });
        }

        if (Schema::hasColumn('device_reports', 'device_setting_id')) {
            Schema::table('device_reports', function (Blueprint $table) {
                $table->dropColumn(['device_setting_id']);
            });
        }
    }
}
