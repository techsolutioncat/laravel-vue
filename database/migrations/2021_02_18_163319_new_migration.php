<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // companies table 1 col added by bunny
        
        if (!Schema::hasColumn('companies', 'user_id')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->default(null)->after('name')->comment('支社権限のユーザー、この会社を担当');
            });
        }

        // device_sims table droped by admin

        if (Schema::hasTable('device_sims')) {
            Schema::disableForeignKeyConstraints();
            Schema::drop('device_sims');
            Schema::enableForeignKeyConstraints();
        }

        // device_assignments table 4 col added, 1 col deled by admin

        if (!Schema::hasColumn('device_assignments', 'sim_id')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('sim_id')->nullable()->default(null)
                    ->after('company_id')->comment('SIM');
            });
        }

        if (!Schema::hasColumn('device_assignments', 'device_id')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('device_id')->nullable(false)
                    ->after('sim_id')->comment('端末');
            });
        }

        if (!Schema::hasColumn('device_assignments', 'active')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->boolean('active')->nullable()->default(null)
                    ->after('rest')->comment('1:電源オン 0:電源オフ');
            });
        }

        if (!Schema::hasColumn('device_assignments', 'battery')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->unsignedSmallInteger('battery')->default(0)
                    ->after('active')->comment('バッテリー残量');
            });
        }

        if (Schema::hasColumn('device_assignments', 'device_sim_id')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                Schema::disableForeignKeyConstraints();
                // if (Schema::hasForeign($table, 'device_sim_id')) {
                //     $table->dropForeign('device_sim_id');
                // }
                $table->dropColumn('device_sim_id');
                Schema::enableForeignKeyConstraints();                
            });
        }
        
        // device_settings table 2 col added by admin
        if (!Schema::hasColumn('device_settings', 'sim_id')) {
            Schema::table('device_settings', function (Blueprint $table) {
                $table->unsignedBigInteger('sim_id')->nullable()->default(null)
                    ->after('user_id')->comment('SIM');
            });
        }

        if (!Schema::hasColumn('device_settings', 'device_id')) {
            Schema::table('device_settings', function (Blueprint $table) {
                $table->unsignedBigInteger('device_id')->nullable(false)->default(null)
                    ->after('sim_id')->comment('端末');
            });
        }

        // device_groups table 1 col added by admin
        
        if (!Schema::hasColumn('device_groups', 'company_id')) {
            Schema::table('device_groups', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable(false)->default(null)
                    ->after('id')->comment('会社');
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
        // companies table
        
        if (Schema::hasColumn('companies', 'user_id')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->dropColumn(['user_id']);
            });
        }

        // device_assignments table 4 col added, 1 col deled by admin

        if (Schema::hasColumn('device_assignments', 'sim_id')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->dropColumn(['sim_id', 'device_id', 'active', 'battery']);
            });
        }

        if (!Schema::hasColumn('device_assignments', 'device_sim_id')) {
            Schema::table('device_assignments', function (Blueprint $table) {
                $table->bigInteger('device_sim_id')->nullable();
            });
        }
        
        // device_settings table 2 col added by admin
        if (Schema::hasColumn('device_settings', 'sim_id')) {
            Schema::table('device_settings', function (Blueprint $table) {
                $table->dropColumn(['sim_id', 'device_id']);
            });
        }

        // device_groups table 1 col added by admin
        
        if (!Schema::hasColumn('device_groups', 'company_id')) {
            Schema::table('device_groups', function (Blueprint $table) {
                $table->dropColumn(['company_id']);
            });
        }

    }
}
