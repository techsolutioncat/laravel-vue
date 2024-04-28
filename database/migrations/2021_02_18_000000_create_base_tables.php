<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        // 元となる全テーブルを作成
        // クエリ発行のためselectを使用
        DB::select(
        "CREATE TABLE `companies` (
          `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '会社 名前',
              `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '会社 電話番号',
              `postcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '会社 郵便番号',
              `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '会社 住所',
              `owner_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '責任者 氏名',
              `owner_mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '責任者 メールアドレス',
              `sb_payment_no` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '架No（管理番号）',
              `message_enabled` tinyint(1) NOT NULL COMMENT 'メッセージ機能の利用可否',
              `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会社情報'");

        DB::select(
        "CREATE TABLE `devices` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `imei` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ハードウェア端末のIMEI',
              `device_type_id` int(10) UNSIGNED NOT NULL COMMENT 'ハードウェア端末の型番',
              `version` int(6) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000' COMMENT '端末バージョン',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ハードウェア端末の情報';");

        DB::select(
            "CREATE TABLE `device_assignments` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_sim_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末SIMのID',
              `device_group_id` bigint(20) UNSIGNED NULL DEFAULT NULL  COMMENT '端末グループ',
              `company_id` bigint(20) UNSIGNED NOT NULL COMMENT '所有会社',
              `mount_no` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '架No（一意）',
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '端末名称',
              `rest` tinyint(1) DEFAULT '0' NOT NULL COMMENT '1:休止 0:休止でない',
              `active` tinyint(1) DEFAULT '0' NOT NULL COMMENT '1:電源オン 0:電源オフ',
              `applied_at` datetime DEFAULT NULL COMMENT '読み込み 日時',
              `started_at` datetime DEFAULT NULL COMMENT '利用開始 日時',
              `ended_at` datetime DEFAULT NULL COMMENT '利用停止 日時',
              `restored_at` datetime DEFAULT NULL COMMENT '復旧 日時',
              `deleted_at` datetime DEFAULT NULL COMMENT '削除 日時',
              `updated_at` timestamp NULL DEFAULT NULL,
              `created_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='端末設定';");


        DB::select(
        "CREATE TABLE `device_groups` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'グループの名称',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末グループ';");


        DB::select(
        "CREATE TABLE `device_reports` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定への外部キー',
              `device_signal_id` int(10) UNSIGNED NOT NULL COMMENT '端末信号への外部キー',
              `lat` double DEFAULT NULL COMMENT 'GPS緯度',
              `lng` double DEFAULT NULL COMMENT 'GPS経度',
              `battery` int(10) UNSIGNED DEFAULT NULL COMMENT 'バッテリー残量',
              `dealt_with_at` timestamp NULL DEFAULT NULL COMMENT '対応日（管理画面で設定）',
              `supplement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '補足',
              `position_method` int(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '測位の方法(0:gps, 1:wifi, 2:lbs)',
              `rtc_time` timestamp NULL DEFAULT NULL COMMENT '操作日時',
              `position_time` timestamp NULL DEFAULT NULL COMMENT '測位日時',
              `raw` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '生データ',
              `positioning` tinyint(1) NOT NULL DEFAULT '0' COMMENT '測位中',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末レポート（端末からアップロードされたデータ）';");

        DB::select(
        "CREATE TABLE `device_report_messages` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_report_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末レポートへの外部キー',
              `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定（メッセージの送信先）',
              `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'メッセージの文字列',
              `received` tinyint(1) NOT NULL DEFAULT '0',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末レポートに対応するメッセージ履歴';");

        DB::select(
        "CREATE TABLE `device_report_positions` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_report_id` bigint(20) UNSIGNED  NULL COMMENT '端末レポート',
              `lat` double NULL COMMENT '緯度',
              `lot` double NULL COMMENT '経度',
              `position_time` timestamp NULL DEFAULT NULL COMMENT '測位日時',
              `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='端末の連続測位位置';");


        DB::select(
        "CREATE TABLE `device_settings` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定',
              `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ユーザー情報',
              `sim_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'SIM',
              `device_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末',
              `device_group_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '端末グループ',
              `company_id` bigint(20) UNSIGNED NOT NULL COMMENT '会社情報',
              `mount_no` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '架No',
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '端末名称',
              `rest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '休止状態',
              `started_at` timestamp NULL DEFAULT NULL COMMENT '利用開始日時',
              `ended_at` timestamp NULL DEFAULT NULL COMMENT '利用停止日時',
              `applied_at` timestamp NULL DEFAULT NULL COMMENT '設定適用の日時',
              `restored_at` timestamp NULL DEFAULT NULL COMMENT '復元日時',
              `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の設定履歴';");

        DB::select(
        "CREATE TABLE `device_setting_messages` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_setting_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定履歴',
              `device_signal_id` int(10) UNSIGNED NOT NULL COMMENT '信号',
              `message` char(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'メッセージ文字列',
              `updated_at` timestamp NULL DEFAULT NULL,
              `created_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末設定履歴のメッセージ';");

        DB::select(
        "CREATE TABLE `device_setting_phones` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_setting_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定履歴',
              `auth_no` int(10) UNSIGNED NOT NULL COMMENT '0から10の管理番号',
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称（電話番号へラベル）',
              `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話番号',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の設定履歴（電話番号）';");

        DB::select(
        "CREATE TABLE `device_signals` (
              `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `response` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '端末レポートの対応文字列',
              `signal_int` int(10) UNSIGNED NOT NULL COMMENT '信号',
              `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '信号の補足説明',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の信号';");

        DB::select(
        "CREATE TABLE `device_sims` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_imei` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IMEI番号',
              `sim_iccid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ICCID番号（SIM固有）',
              `active` tinyint(1) DEFAULT '0' COMMENT '稼働状況（１電源ON、０電源OFF）',
              `battery` int(10) UNSIGNED DEFAULT '0' COMMENT 'バッテリー残量',
              `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ハードウェア端末とSIMの対応';");

        DB::select(
        "CREATE TABLE `device_types` (
              `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '型番',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の型番';");


        DB::select(
        "CREATE TABLE `messages` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定',
              `device_signal_id` int(10) UNSIGNED NOT NULL COMMENT '信号',
              `message` char(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'メッセージ',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末設定に対応したメッセージ';");

        DB::select(
        "CREATE TABLE `phones` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定',
              `auth_no` int(10) UNSIGNED NOT NULL COMMENT '0から10の管理番号',
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称（電話番号のラベル）',
              `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話番号',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末設定に対応する電話番号';");

        DB::select(
        "CREATE TABLE `sims` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `iccid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ICCID番号',
              `msn` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話番号',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='SIM情報';
            ");

        DB::select(
        "CREATE TABLE `users` (
              `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `login_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ログインID',
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ユーザー名',
              `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'パスワード',
              `company_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '会社情報',
              `user_role_id` int(10) UNSIGNED NOT NULL COMMENT 'ユーザーロール',
              `enabled` tinyint(1) NOT NULL COMMENT '利用可否（１可０不可）',
              `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
              `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `login_verified_at` timestamp NULL DEFAULT NULL,
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザー情報';");

        DB::select(
        "CREATE TABLE `user_roles` (
              `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '役割名称',
              `auth` int(10) UNSIGNED NOT NULL COMMENT '権限レベル',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザーの役割';");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
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
            'device_sims',
            'device_types',
            'messages',
            'phones',
            'sims',
            'users',
            'user_roles',
        ];
        foreach($tables as $table)
           Schema::dropIfExists($table);

        Schema::enableForeignKeyConstraints();
    }
}
