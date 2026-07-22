<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('is_active');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('downloads_count');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('coupon_id');
            $table->index('status');
            $table->index('created_at');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
            $table->index('membership_plan_id');
        });

        Schema::table('downloads', function (Blueprint $table) {
            $table->index(['user_id', 'downloaded_at']);
            $table->index('product_id');
        });

        Schema::table('product_versions', function (Blueprint $table) {
            $table->index('product_id');
            $table->index('released_at');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['user_id', 'is_read']);
        });

        Schema::table('connected_sites', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('domain');
        });

        Schema::table('update_requests', function (Blueprint $table) {
            $table->index(['user_id', 'product_id', 'status']);
            $table->index('status');
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->index(['user_id', 'status']);
            $table->index('membership_plan_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['downloads_count']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['coupon_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['product_id']);
            $table->dropIndex(['membership_plan_id']);
        });

        Schema::table('downloads', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'downloaded_at']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('product_versions', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['released_at']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'is_read']);
        });

        Schema::table('connected_sites', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['domain']);
        });

        Schema::table('update_requests', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'product_id', 'status']);
            $table->dropIndex(['status']);
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['membership_plan_id']);
        });
    }
};
