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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'update_package_file')) {
                $table->string('update_package_file')->nullable()->after('product_file');
            }
            if (!Schema::hasColumn('products', 'extra_file_name')) {
                $table->string('extra_file_name')->nullable()->after('update_package_file');
            }
        });

        Schema::table('product_versions', function (Blueprint $table) {
            if (!Schema::hasColumn('product_versions', 'update_package_file')) {
                $table->string('update_package_file')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('product_versions', 'extra_file_name')) {
                $table->string('extra_file_name')->nullable()->after('update_package_file');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['update_package_file', 'extra_file_name']);
        });

        Schema::table('product_versions', function (Blueprint $table) {
            $table->dropColumn(['update_package_file', 'extra_file_name']);
        });
    }
};
