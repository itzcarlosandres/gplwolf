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
        Schema::table('coupons', function (Blueprint $table) {
            // 'none', 'products', 'categories', 'membership_plans'
            $table->string('restriction_type')->default('none')->after('is_active');
            
            // Stores IDs as JSON array: [1, 2, 3]
            $table->json('restriction_ids')->nullable()->after('restriction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['restriction_type', 'restriction_ids']);
        });
    }
};
