-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2020 年 7 月 30 日 05:12
-- サーバのバージョン： 8.0.18
-- PHP のバージョン: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+09:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `emerge`
--

drop database cspemerge;
create database cspemerge;
use cspemerge;
START TRANSACTION;


-- --------------------------------------------------------

--
-- テーブルの構造 `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会社情報';

--
-- テーブルのデータのダンプ `companies`
--

INSERT INTO `companies` (`id`, `name`, `phone`, `postcode`, `address`, `owner_name`, `owner_mail`, `sb_payment_no`, `message_enabled`, `created_at`, `updated_at`) VALUES
(1, 'ITZマーケティング株式会社', '0009991234', '1234567', '広島県安芸郡府中町青崎南6-24', '朴賢一', 'test@gmail.com', '1234567890', 1, '2020-07-21 16:11:46', '2020-07-21 16:11:46');

-- --------------------------------------------------------

--
-- テーブルの構造 `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `imei` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ハードウェア端末のIMEI',
  `device_type_id` int(10) UNSIGNED NOT NULL COMMENT 'ハードウェア端末の型番',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ハードウェア端末の情報';

--
-- テーブルのデータのダンプ `devices`
--

INSERT INTO `devices` (`id`, `imei`, `device_type_id`, `created_at`, `updated_at`) VALUES
(1, '863949040086260', 1, '2020-05-18 22:48:09', '2020-05-18 22:48:09'),
(2, '863949040226775', 1, '2020-05-18 22:48:14', '2020-05-18 22:48:14'),
(3, '863949040226791', 1, '2020-05-22 18:55:30', '2020-05-22 18:55:30'),
(4, '863949040225876', 1, '2020-07-12 14:05:51', '2020-07-12 14:05:58'),
(5, '863949040226792', 1, '2020-07-19 19:49:01', '2020-07-19 19:49:01');

-- --------------------------------------------------------

--
-- テーブルの構造 `device_assignments`
--

CREATE TABLE `device_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_sim_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末SIM',
  `device_group_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '端末グループ',
  `company_id` bigint(20) UNSIGNED NOT NULL COMMENT '会社情報',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '各端末の名前',
  `mount_no` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '架No（管理番号）',
  `rest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '休止状態（1休止、0稼働）',
  `applied_at` timestamp NULL DEFAULT NULL COMMENT '設定反映日時',
  `started_at` timestamp NULL DEFAULT NULL COMMENT '利用開始日時',
  `ended_at` timestamp NULL DEFAULT NULL COMMENT '利用停止日時',
  `restored_at` timestamp NULL DEFAULT NULL COMMENT '復元日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末設定';

--
-- テーブルのデータのダンプ `device_assignments`
--

-- INSERT INTO `device_assignments` (`id`, `device_sim_id`, `device_group_id`, `company_id`, `name`, `mount_no`, `rest`, `applied_at`, `started_at`, `ended_at`, `restored_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
-- (1, 1, 13, 1, 'A端末', '99999999', 0, '2020-07-28 10:30:46', '2020-06-11 00:00:00', NULL, NULL, NULL, '2020-07-28 10:30:46', '2020-07-28 10:30:46'),
-- (2, 2, 11, 16, 'B端末', '99999989', 0, '2020-07-28 10:37:01', '2020-06-08 03:04:15', NULL, NULL, NULL, '2020-07-28 10:30:46', '2020-07-28 10:37:01'),
-- (3, 3, 11, 16, 'C端末', '99999979', 0, '2020-07-28 10:31:13', '2020-06-08 00:00:00', NULL, NULL, NULL, '2020-07-28 10:30:46', '2020-07-28 10:31:13');

-- --------------------------------------------------------

--
-- テーブルの構造 `device_groups`
--

CREATE TABLE `device_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'グループの名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末グループ';

--
-- テーブルのデータのダンプ `device_groups`
--

INSERT INTO `device_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'テストグループ', '2020-07-12 14:14:04', '2020-07-12 14:14:06');
-- --------------------------------------------------------

--
-- テーブルの構造 `device_reports`
--

CREATE TABLE `device_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定への外部キー',
  `device_signal_id` int(10) UNSIGNED NOT NULL COMMENT '端末信号への外部キー',
  `lat` double DEFAULT NULL COMMENT '緯度',
  `lng` double DEFAULT NULL COMMENT '経度',
  `battery` int(10) UNSIGNED DEFAULT NULL COMMENT 'バッテリー残量',
  `dealt_with_at` timestamp NULL DEFAULT NULL COMMENT '対応日（管理画面で設定）',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supplement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '補足'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末レポート（端末からアップロードされたデータ）';

--
-- テーブルのデータのダンプ `device_reports`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `device_report_messages`
--

CREATE TABLE `device_report_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_report_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末レポートへの外部キー',
  `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定（メッセージの送信先）',
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'メッセージの文字列',
  `received` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末レポートに対応するメッセージ履歴';

--
-- テーブルのデータのダンプ `device_report_messages`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `device_settings`
--

CREATE TABLE `device_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ユーザー情報',
  `device_sim_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末SIM',
  `device_group_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '端末グループ',
  `company_id` bigint(20) UNSIGNED NOT NULL COMMENT '会社情報',
  `mount_no` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '架No',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '端末名称',
  `applied_at` timestamp NULL DEFAULT NULL COMMENT '設定適用の日時',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '休止状態',
  `started_at` timestamp NULL DEFAULT NULL COMMENT '利用開始日時',
  `ended_at` timestamp NULL DEFAULT NULL COMMENT '利用停止日時',
  `restored_at` timestamp NULL DEFAULT NULL COMMENT '復元日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の設定履歴';

--
-- テーブルのデータのダンプ `device_settings`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `device_setting_messages`
--

CREATE TABLE `device_setting_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_setting_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定履歴',
  `device_signal_id` int(10) UNSIGNED NOT NULL COMMENT '信号',
  `message` char(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'メッセージ文字列',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末設定履歴のメッセージ';

--
-- テーブルのデータのダンプ `device_setting_messages`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `device_setting_phones`
--

CREATE TABLE `device_setting_phones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_setting_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定履歴',
  `auth_no` int(10) UNSIGNED NOT NULL COMMENT '0から10の管理番号',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称（電話番号へラベル）',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話番号',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の設定履歴（電話番号）';

--
-- テーブルのデータのダンプ `device_setting_phones`
--

-- -- --------------------------------------------------------

-- --
-- -- テーブルの構造 `device_signals`
-- --

CREATE TABLE `device_signals` (
  `id` int(10) UNSIGNED NOT NULL,
  `response` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '端末レポートの対応文字列',
  `signal_int` int(10) UNSIGNED NOT NULL COMMENT '信号',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '信号の補足説明',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の信号';

-- --
-- -- テーブルのデータのダンプ `device_signals`
-- --

INSERT INTO `device_signals` (`id`, `response`, `signal_int`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SOS OR MD Cancelled', 1, '緊急ブザー', NULL, NULL),
(2, 'Making a call', 2, '緊急通報', '2020-05-18 22:17:15', '2020-05-18 22:17:15'),
(3, 'BATTERY LOW', 3, 'バッテリー低下', '2020-05-18 22:17:15', '2020-05-18 22:17:15'),
(4, 'POWER OFF NOW', 4, '電源OFF', '2020-05-18 22:17:15', '2020-05-18 22:17:15'),
(5, 'POWER ON NOW', 5, '電源ON', '2020-05-18 22:17:15', '2020-05-18 22:17:15'),
(6, 'Calling', 6, '電話着信', '2020-05-18 22:17:15', '2020-05-18 22:17:15'),
(7, 'CMD-F', 7, '位置情報問い合わせ', '2020-05-18 22:17:15', '2020-05-18 22:17:15'),
(8, 'CMD-A', 8, '電話番号の設定', '2020-05-18 22:17:15', '2020-05-18 22:17:15'),
(9, 'ALM-A', 2, '緊急通報', '2020-07-15 16:45:11', '2020-07-15 16:45:11');

-- -- --------------------------------------------------------

-- --
-- -- テーブルの構造 `device_sims`
-- --

CREATE TABLE `device_sims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_imei` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IMEI番号',
  `sim_iccid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ICCID番号（SIM固有）',
  `active` tinyint(1) DEFAULT '0' COMMENT '稼働状況（１電源ON、０電源OFF）',
  `battery` int(11) DEFAULT '0' COMMENT 'バッテリー残量',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ハードウェア端末とSIMの対応';

-- --
-- -- テーブルのデータのダンプ `device_sims`
-- --

INSERT INTO `device_sims` (`id`, `device_imei`, `sim_iccid`, `active`, `battery`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '863949040226791', '8981200290670154960', 0, 50, NULL, '2020-05-22 18:55:30', '2020-05-22 18:55:30'),
(2, '863949040226775', '8981200290670155017', 0, 60, NULL, '2020-05-18 22:48:10', '2020-05-18 22:48:10'),
(3, '863949040225876', '8981200290670154952', 0, 40, NULL, '2020-05-18 22:48:14', '2020-05-18 22:48:14');

-- -- --------------------------------------------------------

-- --
-- -- テーブルの構造 `device_types`
-- --

CREATE TABLE `device_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '型番',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末の型番';

-- --
-- -- テーブルのデータのダンプ `device_types`
-- --

INSERT INTO `device_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'JPTL-401', '2020-05-18 22:48:09', '2020-05-18 22:48:09');

-- -- --------------------------------------------------------

-- --
-- -- テーブルの構造 `jobs`
-- --

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `payload` text COLLATE utf8mb4_general_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ジョブキュー';

-- -- --------------------------------------------------------

-- --
-- -- テーブルの構造 `messages`
-- --

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定',
  `device_signal_id` int(10) UNSIGNED NOT NULL COMMENT '信号',
  `message` char(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'メッセージ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末設定に対応したメッセージ';

-- --
-- -- テーブルのデータのダンプ `messages`
-- --

-- -- --------------------------------------------------------

-- --
-- -- テーブルの構造 `phones`
-- --

CREATE TABLE `phones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末設定',
  `auth_no` int(10) UNSIGNED NOT NULL COMMENT '0から10の管理番号',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称（電話番号のラベル）',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話番号',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='端末設定に対応する電話番号';

-- --
-- -- テーブルのデータのダンプ `phones`
-- --

-- --------------------------------------------------------

--
-- テーブルの構造 `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) NOT NULL COMMENT 'requestNoと併用',
  `device_sim_id` bigint(20) UNSIGNED NOT NULL COMMENT '端末SIM',
  `device_report_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '端末レポート',
  `requested_at` datetime DEFAULT NULL COMMENT '位置情報のリクエスト日時',
  `resulted_at` datetime DEFAULT NULL COMMENT '位置情報のアップロード日時',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='位置情報';

--
-- テーブルのデータのダンプ `positions`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `sims`
--

CREATE TABLE `sims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `iccid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ICCID番号',
  `msn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話番号',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='SIM情報';

--
-- テーブルのデータのダンプ `sims`
--

INSERT INTO `sims` (`id`, `iccid`, `msn`, `created_at`, `updated_at`) VALUES
(1, '8981200290670155058', '08048300028', '2020-05-18 22:17:14', '2020-05-18 22:17:14'),
(2, '8981200290670155033', '08044618109', '2020-05-18 22:17:14', '2020-05-18 22:17:14'),
(3, '8981200290670154952', '08091534966', '2020-07-02 21:36:49', '2020-07-02 21:36:49'),
(4, '8981200290670155017', '08091701642', '2020-07-02 21:36:49', '2020-07-02 21:36:49'),
(5, '8981200290670154960', '08091784196', '2020-07-02 21:36:49', '2020-07-02 21:36:49'),
(6, '8981200290670154929', '08035173420', '2020-07-28 10:46:02', '2020-07-28 10:46:02'),
(7, '8981200290670154986', '08034697117', '2020-07-28 10:47:19', '2020-07-28 10:47:19');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ログインID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ユーザー名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'パスワード',
  `company_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '会社情報',
  `user_role_id` int(10) UNSIGNED NOT NULL COMMENT 'ユーザーロール',
  `enabled` tinyint(1) NOT NULL COMMENT '利用可否（１可０不可）',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザー情報';

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `login_id`, `name`, `password`, `company_id`, `user_role_id`, `enabled`, `deleted_at`, `remember_token`, `login_verified_at`, `created_at`, `updated_at`) VALUES
(1, 'system', 'システム開発者', '$2y$10$J0BMooPbW3tE6PU/TNt5/e5iCceM9UHUkLa2nKOKyb7gm1RJfxa7W', NULL, 1, 1, NULL, NULL, NULL, '2020-05-18 22:17:14', '2020-05-20 13:30:12'),
(2, 'admin', '管理者', '$2y$10$GsN4YCxUZbPxP0PILkfase.LjrJJxcLIWLAy6Uf2yGLHFRSxcfYM6', NULL, 2, 1, NULL, NULL, NULL, '2020-05-18 22:17:14', '2020-06-19 17:24:51'),
(3, 'user', 'ITZマーケティング株式会社', '$2y$10$GsN4YCxUZbPxP0PILkfase.LjrJJxcLIWLAy6Uf2yGLHFRSxcfYM6', 1, 2, 1, NULL, NULL, NULL, '2020-05-18 22:17:14', '2020-06-19 17:24:51');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '役割名称',
  `auth` int(10) UNSIGNED NOT NULL COMMENT '権限レベル',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザーの役割';

--
-- テーブルのデータのダンプ `user_roles`
--

INSERT INTO `user_roles` (`id`, `role`, `auth`, `created_at`, `updated_at`) VALUES
(1, 'system', 10, NULL, NULL),
(2, 'admin', 5, NULL, NULL),
(3, 'user', 1, NULL, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devices_imei_unique` (`imei`),
  ADD KEY `devices_device_type_id_foreign` (`device_type_id`);

--
-- テーブルのインデックス `device_assignments`
--
ALTER TABLE `device_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_assignments_company_id_foreign` (`company_id`),
  ADD KEY `device_assignments_device_group_id_foreign` (`device_group_id`),
  ADD KEY `device_assignments_device_sim_id_foreign` (`device_sim_id`);

--
-- テーブルのインデックス `device_groups`
--
ALTER TABLE `device_groups`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `device_reports`
--
ALTER TABLE `device_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_reports_device_assignments_id_fk` (`device_assignment_id`),
  ADD KEY `device_reports_device_signals_id_fk` (`device_signal_id`);

--
-- テーブルのインデックス `device_report_messages`
--
ALTER TABLE `device_report_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_report_messages_device_report_id_foreign` (`device_report_id`);

--
-- テーブルのインデックス `device_settings`
--
ALTER TABLE `device_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_settings_company_id_foreign` (`company_id`),
  ADD KEY `device_settings_device_assignment_id_foreign` (`device_assignment_id`),
  ADD KEY `device_settings_device_group_id_foreign` (`device_group_id`),
  ADD KEY `device_settings_device_sim_id_foreign` (`device_sim_id`),
  ADD KEY `device_settings_user_id_foreign` (`user_id`);

--
-- テーブルのインデックス `device_setting_messages`
--
ALTER TABLE `device_setting_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_setting_messages_device_setting_id_foreign` (`device_setting_id`),
  ADD KEY `device_setting_messages_device_signal_id_foreign` (`device_signal_id`);

--
-- テーブルのインデックス `device_setting_phones`
--
ALTER TABLE `device_setting_phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_setting_id` (`device_setting_id`);

--
-- テーブルのインデックス `device_signals`
--
ALTER TABLE `device_signals`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `device_sims`
--
ALTER TABLE `device_sims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_sims_device_imei_foreign` (`device_imei`),
  ADD KEY `device_sims_sim_iccid_foreign` (`sim_iccid`);

--
-- テーブルのインデックス `device_types`
--
ALTER TABLE `device_types`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue` (`queue`);

--
-- テーブルのインデックス `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_device_assignment_id_foreign` (`device_assignment_id`),
  ADD KEY `messages_device_signal_id_foreign` (`device_signal_id`);

--
-- テーブルのインデックス `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_assignment_id` (`device_assignment_id`);

--
-- テーブルのインデックス `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `positions_device_reports_id_fk` (`device_report_id`),
  ADD KEY `positions_device_sims_id_fk` (`device_sim_id`);

--
-- テーブルのインデックス `sims`
--
ALTER TABLE `sims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sims_iccid_unique` (`iccid`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_id_unique` (`login_id`),
  ADD UNIQUE KEY `users_name_uindex` (`name`),
  ADD KEY `users_company_id_foreign` (`company_id`),
  ADD KEY `users_user_role_id_foreign` (`user_role_id`);

--
-- テーブルのインデックス `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- テーブルのAUTO_INCREMENT `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルのAUTO_INCREMENT `device_assignments`
--
ALTER TABLE `device_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルのAUTO_INCREMENT `device_groups`
--
ALTER TABLE `device_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- テーブルのAUTO_INCREMENT `device_reports`
--
ALTER TABLE `device_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1195;

--
-- テーブルのAUTO_INCREMENT `device_report_messages`
--
ALTER TABLE `device_report_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- テーブルのAUTO_INCREMENT `device_settings`
--
ALTER TABLE `device_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;

--
-- テーブルのAUTO_INCREMENT `device_setting_messages`
--
ALTER TABLE `device_setting_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- テーブルのAUTO_INCREMENT `device_setting_phones`
--
ALTER TABLE `device_setting_phones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1856;

--
-- テーブルのAUTO_INCREMENT `device_signals`
--
ALTER TABLE `device_signals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルのAUTO_INCREMENT `device_sims`
--
ALTER TABLE `device_sims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルのAUTO_INCREMENT `device_types`
--
ALTER TABLE `device_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルのAUTO_INCREMENT `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- テーブルのAUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- テーブルのAUTO_INCREMENT `phones`
--
ALTER TABLE `phones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- テーブルのAUTO_INCREMENT `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'requestNoと併用', AUTO_INCREMENT=15;

--
-- テーブルのAUTO_INCREMENT `sims`
--
ALTER TABLE `sims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- テーブルのAUTO_INCREMENT `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_device_type_id_foreign` FOREIGN KEY (`device_type_id`) REFERENCES `device_types` (`id`);

--
-- テーブルの制約 `device_assignments`
--
ALTER TABLE `device_assignments`
  ADD CONSTRAINT `device_assignments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `device_assignments_device_group_id_foreign` FOREIGN KEY (`device_group_id`) REFERENCES `device_groups` (`id`),
  ADD CONSTRAINT `device_assignments_device_sim_id_foreign` FOREIGN KEY (`device_sim_id`) REFERENCES `device_sims` (`id`);

--
-- テーブルの制約 `device_reports`
--
ALTER TABLE `device_reports`
  ADD CONSTRAINT `device_reports_device_assignments_id_fk` FOREIGN KEY (`device_assignment_id`) REFERENCES `device_assignments` (`id`),
  ADD CONSTRAINT `device_reports_device_signals_id_fk` FOREIGN KEY (`device_signal_id`) REFERENCES `device_signals` (`id`);

--
-- テーブルの制約 `device_report_messages`
--
ALTER TABLE `device_report_messages`
  ADD CONSTRAINT `device_report_messages_device_report_id_foreign` FOREIGN KEY (`device_report_id`) REFERENCES `device_reports` (`id`);

--
-- テーブルの制約 `device_settings`
--
ALTER TABLE `device_settings`
  ADD CONSTRAINT `device_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `device_settings_device_assignment_id_foreign` FOREIGN KEY (`device_assignment_id`) REFERENCES `device_assignments` (`id`),
  ADD CONSTRAINT `device_settings_device_group_id_foreign` FOREIGN KEY (`device_group_id`) REFERENCES `device_groups` (`id`),
  ADD CONSTRAINT `device_settings_device_sim_id_foreign` FOREIGN KEY (`device_sim_id`) REFERENCES `device_sims` (`id`),
  ADD CONSTRAINT `device_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- テーブルの制約 `device_setting_messages`
--
ALTER TABLE `device_setting_messages`
  ADD CONSTRAINT `device_setting_messages_device_setting_id_foreign` FOREIGN KEY (`device_setting_id`) REFERENCES `device_settings` (`id`),
  ADD CONSTRAINT `device_setting_messages_device_signal_id_foreign` FOREIGN KEY (`device_signal_id`) REFERENCES `device_signals` (`id`);

--
-- テーブルの制約 `device_setting_phones`
--
ALTER TABLE `device_setting_phones`
  ADD CONSTRAINT `device_setting_phones_device_setting_id_foreign` FOREIGN KEY (`device_setting_id`) REFERENCES `device_settings` (`id`);

--
-- テーブルの制約 `device_sims`
--
ALTER TABLE `device_sims`
  ADD CONSTRAINT `device_sims_devices_imei_fk` FOREIGN KEY (`device_imei`) REFERENCES `devices` (`imei`),
  ADD CONSTRAINT `device_sims_sims_iccid_fk` FOREIGN KEY (`sim_iccid`) REFERENCES `sims` (`iccid`);

--
-- テーブルの制約 `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_device_assignment_id_foreign` FOREIGN KEY (`device_assignment_id`) REFERENCES `device_assignments` (`id`),
  ADD CONSTRAINT `messages_device_signal_id_foreign` FOREIGN KEY (`device_signal_id`) REFERENCES `device_signals` (`id`);

--
-- テーブルの制約 `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_device_assignment_id_foreign` FOREIGN KEY (`device_assignment_id`) REFERENCES `device_assignments` (`id`);

--
-- テーブルの制約 `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_device_reports_id_fk` FOREIGN KEY (`device_report_id`) REFERENCES `device_reports` (`id`),
  ADD CONSTRAINT `positions_device_sims_id_fk` FOREIGN KEY (`device_sim_id`) REFERENCES `device_sims` (`id`);

--
-- テーブルの制約 `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `users_user_role_id_foreign` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

COMMIT;