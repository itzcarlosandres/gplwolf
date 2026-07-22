<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('role');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('exclude_from_membership')->default(false)->after('is_active');
        });

        Schema::table('membership_plans', function (Blueprint $table) {
            $table->integer('daily_download_limit')->default(0)->after('duration_days'); // 0 = unlimited
            $table->integer('reward_points')->default(0)->after('daily_download_limit');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('reward_points')->default(0)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('points');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('exclude_from_membership');
        });

        Schema::table('membership_plans', function (Blueprint $table) {
            $table->dropColumn(['daily_download_limit', 'reward_points']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('reward_points');
        });
    }
};
