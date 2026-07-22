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
            $table->dropColumn(['type', 'category', 'wordpress_version', 'screenshots', 'features']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('wordpress_version')->nullable();
            $table->json('screenshots')->nullable();
            $table->json('features')->nullable();
        });
    }
};
