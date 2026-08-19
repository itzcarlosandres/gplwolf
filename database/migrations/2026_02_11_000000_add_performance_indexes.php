<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'products' => ['category_id', 'is_active', 'created_at', 'updated_at', 'downloads_count'],
            'orders' => ['user_id', 'coupon_id', 'status', 'created_at'],
            'order_items' => ['order_id', 'product_id', 'membership_plan_id'],
            'downloads' => [['user_id', 'downloaded_at'], 'product_id'],
            'product_versions' => ['product_id', 'released_at'],
            'notifications' => [['user_id', 'is_read']],
            'connected_sites' => ['user_id', 'domain'],
            'update_requests' => [['user_id', 'product_id', 'status'], 'status'],
            'memberships' => [['user_id', 'status'], 'membership_plan_id'],
        ];

        foreach ($tables as $tableName => $indexes) {
            if (Schema::hasTable($tableName)) {
                foreach ($indexes as $index) {
                    try {
                        Schema::table($tableName, function (Blueprint $table) use ($index) {
                            $table->index($index);
                        });
                    } catch (\Throwable $e) {
                        // Index already exists, ignore
                    }
                }
            }
        }
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
