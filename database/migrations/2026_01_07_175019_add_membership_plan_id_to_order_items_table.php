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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('membership_plan_id')->nullable()->constrained()->nullOnDelete()->after('product_id');
            $table->renameColumn('product_id', 'product_id')->nullable(true)->change(); // Ensure product_id is nullable now
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('membership_plan_id');
        });
    }
};
