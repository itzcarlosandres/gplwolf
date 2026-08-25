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
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('is_promo')->default(false)->after('icon');
            $table->string('link_url')->nullable()->after('is_promo');
            $table->string('badge_text', 100)->nullable()->after('link_url');
            $table->string('highlight_color', 50)->default('amber')->after('badge_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['is_promo', 'link_url', 'badge_text', 'highlight_color']);
        });
    }
};
