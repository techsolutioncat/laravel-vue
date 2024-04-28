<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $isProduction = config('app.env') == 'production';
        // マスター情報の登録
        DB::select(
            "INSERT INTO `user_roles` (`id`, `role`, `auth`, `created_at`, `updated_at`) VALUES
            (1, 'system', 10, NULL, NULL),
            (2, 'admin', 5, NULL, NULL),
            (3, 'user', 1, NULL, NULL),
            (4, 'branch', 3, NULL, NULL);");

        DB::select(
            "INSERT INTO `device_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
            (1, 'JPTL-401', '2021-02-19 03:55:14', '2021-02-19 03:55:14');");

        DB::select(
            "INSERT INTO `device_signals` (`id`, `response`, `signal_int`, `description`, `created_at`, `updated_at`) VALUES
            (1, 'SOS OR MD Cancelled', 1, '緊急ブザー', NULL, NULL),
            (2, 'Making a call,ALM-A', 2, '緊急通報', NULL, NULL),
            (3, 'BATTERY LOW', 3, 'バッテリー低下', NULL, NULL),
            (4, 'POWER OFF NOW', 4, '電源OFF', NULL, NULL),
            (5, 'POWER ON NOW', 5, '電源ON', NULL, NULL),
            (6, 'Calling', 6, '電話着信', NULL, NULL),
            (7, 'CMD-F', 7, '位置情報問い合わせ', NULL, NULL),
            (8, 'CMD-A', 0, '電話番号の設定', NULL, NULL),
            (9, 'Making a call', 0, '通話発信 サブ画面から', NULL, NULL),
            (10, 'CMD-T', 8, '連続測位', NULL, NULL),
            (11, 'ALM-A5', 11, '緊急ブザー詳細', NULL, NULL),
            (12, 'CMD-M0', 18, '連続測位停止', NULL, NULL);");

        if ($isProduction) {
            DB::select(
                "INSERT INTO `users` (`id`, `login_id`, `name`, `password`, `company_id`, `user_role_id`, `enabled`, `deleted_at`, `remember_token`, `login_verified_at`, `created_at`, `updated_at`) VALUES
            (1, 'system', 'システム開発者', '$2y$10\$vxecu5n2dY.kvXLvtWvmc.t14sPBraOLZlKgmblHtQqhskv9rVCOe', NULL, 1, 1, NULL, NULL, NULL, current_timestamp, current_timestamp),
            (2, 'admin', '管理者', '$2y$10\$Nx.eOdu/.cowrcgSdxuZput1hQZ4m/LkJmm7msiJjWeh7aNFsk2Fm', NULL, 2, 1, NULL, NULL, NULL, current_timestamp , current_timestamp )");

        } else {
            DB::select(
                "INSERT INTO `users` (`id`, `login_id`, `name`, `password`, `company_id`, `user_role_id`, `enabled`, `deleted_at`, `remember_token`, `login_verified_at`, `created_at`, `updated_at`) VALUES
            (1, 'system', 'システム開発者', '$2y$10\$vxecu5n2dY.kvXLvtWvmc.t14sPBraOLZlKgmblHtQqhskv9rVCOe', NULL, 1, 1, NULL, NULL, NULL, '2020-05-18 13:17:14', '2020-05-20 04:30:12'),
            (2, 'admin', '管理者', '$2y$10\$Nx.eOdu/.cowrcgSdxuZput1hQZ4m/LkJmm7msiJjWeh7aNFsk2Fm', NULL, 2, 1, NULL, NULL, NULL, '2020-05-18 13:17:14', '2021-02-19 06:42:20'),
            (3, 'itzmkt', 'ITZ', '$2y$10\$ii8/4l7HLEKZY61sf/Swh.j755DYSpfkUBoBr3l51MxFyJz8sknHy', 1, 3, 1, NULL, NULL, NULL, '2020-05-18 13:17:14', '2021-02-19 06:42:20'),
            (4, 'itztest', 'ITZテスト', '$2y$10\$ii8/4l7HLEKZY61sf/Swh.j755DYSpfkUBoBr3l51MxFyJz8sknHy', 2, 3, 1, NULL, NULL, NULL, '2020-05-18 13:17:14', '2021-02-19 06:42:20');");
//

            // 開発からテスト環境への移行用
            DB::select(
                "INSERT INTO `sims` (`id`, `iccid`, `msn`, `created_at`, `updated_at`) VALUES
            (1, '8981200290670154978', '07032460269', '2020-09-24 01:47:19', '2021-02-15 03:40:44'),
            (2, '8981200290670155082', '08049026552', '2020-10-27 22:00:00', '2021-02-20 05:00:43');");

            DB::select(
                "INSERT INTO `devices` (`id`, `imei`, `device_type_id`, `version`, `created_at`, `updated_at`) VALUES
            (1, '863949040207544', 22, 210204, '2020-10-27 14:46:00', '2020-10-27 14:46:00'),
            (2, '863949040207411', 22, 210219, '2020-10-28 15:36:52', '2020-10-28 15:36:52');");

            DB::select(
                "INSERT INTO `companies` (`id`, `name`, `user_id`, `phone`, `postcode`, `address`, `owner_name`, `owner_mail`, `sb_payment_no`, `message_enabled`, `created_at`, `updated_at`) VALUES
            (1, 'ITZ', 2, '0822582988', '7350017', '安芸郡府中町青崎南6-24 向洋ビル3Ｆ', '朴賢一', 'itz@it-z.biz', '0000000000', 1, '2021-02-22 00:00:00', '2021-02-22 00:00:00'),
            (2, 'ITZテスト', 3, '0822582988', '7350017', '安芸郡府中町青崎南6-24 向洋ビル3Ｆ', '朴賢一', 'itz@it-z.biz', '0000000000', 1, '2021-02-22 00:00:00', '2021-02-22 00:00:00');
            ");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'companies',
            'device_assignments',
            'devices',
            'device_groups'	,
            'device_reports',
            'device_report_messages',
            'device_report_positions',
            'device_settings',
            'device_setting_messages',
            'device_setting_phones',
            'device_signals',
            'device_types',
            'messages',
            'phones',
            'sims',
            'users',
            'user_roles',
        ];
        foreach($tables as $table)
        {
            $drop = 'DELETE FROM `'.$table.'` WHERE 1';
            DB::select($drop);
        }
    }
}
