<?php

use App\Models\User;
use App\Models\SiteSetting;
use App\Models\FeatureModule;
use App\Models\FaqItem;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sql = "-- =======================================================\n";
$sql .= "-- SmartEdu School Management System - MySQL Database Dump\n";
$sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
$sql .= "-- Compatible with MySQL 5.7+ / MySQL 8.0+ / MariaDB\n";
$sql .= "-- =======================================================\n\n";

$sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
$sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
$sql .= "START TRANSACTION;\n";
$sql .= "SET time_zone = \"+00:00\";\n\n";

// 1. Users Table
$sql .= "-- --------------------------------------------------------\n";
$sql .= "-- Table structure for `users`\n";
$sql .= "-- --------------------------------------------------------\n";
$sql .= "DROP TABLE IF EXISTS `users`;\n";
$sql .= "CREATE TABLE `users` (\n";
$sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
$sql .= "  `name` varchar(255) NOT NULL,\n";
$sql .= "  `email` varchar(255) NOT NULL,\n";
$sql .= "  `email_verified_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  `password` varchar(255) NOT NULL,\n";
$sql .= "  `remember_token` varchar(100) DEFAULT NULL,\n";
$sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  PRIMARY KEY (`id`),\n";
$sql .= "  UNIQUE KEY `users_email_unique` (`email`)\n";
$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

$users = DB::table('users')->get();
if ($users->count() > 0) {
    $sql .= "-- Dumping data for `users`\n";
    $sql .= "INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES\n";
    $userValues = [];
    foreach ($users as $u) {
        $name = addslashes($u->name);
        $email = addslashes($u->email);
        $pass = addslashes($u->password);
        $remember = $u->remember_token ? "'" . addslashes($u->remember_token) . "'" : "NULL";
        $created = $u->created_at ? "'{$u->created_at}'" : "NULL";
        $updated = $u->updated_at ? "'{$u->updated_at}'" : "NULL";
        $userValues[] = "({$u->id}, '{$name}', '{$email}', NULL, '{$pass}', {$remember}, {$created}, {$updated})";
    }
    $sql .= implode(",\n", $userValues) . ";\n\n";
}

// 2. Site Settings Table
$sql .= "-- --------------------------------------------------------\n";
$sql .= "-- Table structure for `site_settings`\n";
$sql .= "-- --------------------------------------------------------\n";
$sql .= "DROP TABLE IF EXISTS `site_settings`;\n";
$sql .= "CREATE TABLE `site_settings` (\n";
$sql .= "  `key` varchar(255) NOT NULL,\n";
$sql .= "  `value` longtext DEFAULT NULL,\n";
$sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  PRIMARY KEY (`key`)\n";
$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

$settings = DB::table('site_settings')->get();
if ($settings->count() > 0) {
    $sql .= "-- Dumping data for `site_settings`\n";
    $sql .= "INSERT INTO `site_settings` (`key`, `value`, `created_at`, `updated_at`) VALUES\n";
    $settingValues = [];
    foreach ($settings as $s) {
        $k = addslashes($s->key);
        $v = addslashes($s->value);
        $created = $s->created_at ? "'{$s->created_at}'" : "NULL";
        $updated = $s->updated_at ? "'{$s->updated_at}'" : "NULL";
        $settingValues[] = "('{$k}', '{$v}', {$created}, {$updated})";
    }
    $sql .= implode(",\n", $settingValues) . ";\n\n";
}

// 3. Feature Modules Table
$sql .= "-- --------------------------------------------------------\n";
$sql .= "-- Table structure for `feature_modules`\n";
$sql .= "-- --------------------------------------------------------\n";
$sql .= "DROP TABLE IF EXISTS `feature_modules`;\n";
$sql .= "CREATE TABLE `feature_modules` (\n";
$sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
$sql .= "  `title` varchar(255) NOT NULL,\n";
$sql .= "  `short_title` varchar(255) DEFAULT NULL,\n";
$sql .= "  `category` varchar(255) NOT NULL,\n";
$sql .= "  `category_name` varchar(255) NOT NULL,\n";
$sql .= "  `icon` varchar(255) NOT NULL DEFAULT '🏛️',\n";
$sql .= "  `badge_bg` varchar(255) NOT NULL DEFAULT 'bg-emerald-100 text-emerald-800',\n";
$sql .= "  `short_desc` text NOT NULL,\n";
$sql .= "  `full_desc` text NOT NULL,\n";
$sql .= "  `highlights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`highlights`)),\n";
$sql .= "  `is_active` tinyint(1) NOT NULL DEFAULT 1,\n";
$sql .= "  `sort_order` int(11) NOT NULL DEFAULT 0,\n";
$sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  PRIMARY KEY (`id`)\n";
$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

$modules = DB::table('feature_modules')->get();
if ($modules->count() > 0) {
    $sql .= "-- Dumping data for `feature_modules`\n";
    $sql .= "INSERT INTO `feature_modules` (`id`, `title`, `short_title`, `category`, `category_name`, `icon`, `badge_bg`, `short_desc`, `full_desc`, `highlights`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES\n";
    $moduleValues = [];
    foreach ($modules as $m) {
        $title = addslashes($m->title);
        $stitle = $m->short_title ? "'" . addslashes($m->short_title) . "'" : "NULL";
        $cat = addslashes($m->category);
        $catName = addslashes($m->category_name);
        $icon = addslashes($m->icon);
        $badge = addslashes($m->badge_bg);
        $sdesc = addslashes($m->short_desc);
        $fdesc = addslashes($m->full_desc);
        $high = addslashes($m->highlights);
        $active = $m->is_active ? 1 : 0;
        $order = (int)$m->sort_order;
        $created = $m->created_at ? "'{$m->created_at}'" : "NULL";
        $updated = $m->updated_at ? "'{$m->updated_at}'" : "NULL";
        $moduleValues[] = "({$m->id}, '{$title}', {$stitle}, '{$cat}', '{$catName}', '{$icon}', '{$badge}', '{$sdesc}', '{$fdesc}', '{$high}', {$active}, {$order}, {$created}, {$updated})";
    }
    $sql .= implode(",\n", $moduleValues) . ";\n\n";
}

// 4. FAQ Items Table
$sql .= "-- --------------------------------------------------------\n";
$sql .= "-- Table structure for `faq_items`\n";
$sql .= "-- --------------------------------------------------------\n";
$sql .= "DROP TABLE IF EXISTS `faq_items`;\n";
$sql .= "CREATE TABLE `faq_items` (\n";
$sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
$sql .= "  `question` text NOT NULL,\n";
$sql .= "  `answer` text NOT NULL,\n";
$sql .= "  `sort_order` int(11) NOT NULL DEFAULT 0,\n";
$sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  PRIMARY KEY (`id`)\n";
$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

$faqs = DB::table('faq_items')->get();
if ($faqs->count() > 0) {
    $sql .= "-- Dumping data for `faq_items`\n";
    $sql .= "INSERT INTO `faq_items` (`id`, `question`, `answer`, `sort_order`, `created_at`, `updated_at`) VALUES\n";
    $faqValues = [];
    foreach ($faqs as $f) {
        $q = addslashes($f->question);
        $a = addslashes($f->answer);
        $order = (int)$f->sort_order;
        $created = $f->created_at ? "'{$f->created_at}'" : "NULL";
        $updated = $f->updated_at ? "'{$f->updated_at}'" : "NULL";
        $faqValues[] = "({$f->id}, '{$q}', '{$a}', {$order}, {$created}, {$updated})";
    }
    $sql .= implode(",\n", $faqValues) . ";\n\n";
}

// 5. Password Reset Tokens Table
$sql .= "-- --------------------------------------------------------\n";
$sql .= "-- Table structure for `password_reset_tokens`\n";
$sql .= "-- --------------------------------------------------------\n";
$sql .= "DROP TABLE IF EXISTS `password_reset_tokens`;\n";
$sql .= "CREATE TABLE `password_reset_tokens` (\n";
$sql .= "  `email` varchar(255) NOT NULL,\n";
$sql .= "  `token` varchar(255) NOT NULL,\n";
$sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
$sql .= "  PRIMARY KEY (`email`)\n";
$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

// 6. Sessions Table
$sql .= "-- --------------------------------------------------------\n";
$sql .= "-- Table structure for `sessions`\n";
$sql .= "-- --------------------------------------------------------\n";
$sql .= "DROP TABLE IF EXISTS `sessions`;\n";
$sql .= "CREATE TABLE `sessions` (\n";
$sql .= "  `id` varchar(255) NOT NULL,\n";
$sql .= "  `user_id` bigint(20) UNSIGNED DEFAULT NULL,\n";
$sql .= "  `ip_address` varchar(45) DEFAULT NULL,\n";
$sql .= "  `user_agent` text DEFAULT NULL,\n";
$sql .= "  `payload` longtext NOT NULL,\n";
$sql .= "  `last_activity` int(11) NOT NULL,\n";
$sql .= "  PRIMARY KEY (`id`),\n";
$sql .= "  KEY `sessions_user_id_index` (`user_id`),\n";
$sql .= "  KEY `sessions_last_activity_index` (`last_activity`)\n";
$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

// 7. Migrations Table
$sql .= "-- --------------------------------------------------------\n";
$sql .= "-- Table structure for `migrations`\n";
$sql .= "-- --------------------------------------------------------\n";
$sql .= "DROP TABLE IF EXISTS `migrations`;\n";
$sql .= "CREATE TABLE `migrations` (\n";
$sql .= "  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
$sql .= "  `migration` varchar(255) NOT NULL,\n";
$sql .= "  `batch` int(11) NOT NULL,\n";
$sql .= "  PRIMARY KEY (`id`)\n";
$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

$migrations = DB::table('migrations')->get();
if ($migrations->count() > 0) {
    $sql .= "-- Dumping data for `migrations`\n";
    $sql .= "INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES\n";
    $mValues = [];
    foreach ($migrations as $m) {
        $mValues[] = "({$m->id}, '" . addslashes($m->migration) . "', {$m->batch})";
    }
    $sql .= implode(",\n", $mValues) . ";\n\n";
}

$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
$sql .= "COMMIT;\n";

file_put_contents(__DIR__ . '/../smartedu_database.sql', $sql);
file_put_contents(__DIR__ . '/../database/smartedu_database.sql', $sql);
echo "SUCCESS: MySQL Database dump exported to smartedu_database.sql and database/smartedu_database.sql\n";
