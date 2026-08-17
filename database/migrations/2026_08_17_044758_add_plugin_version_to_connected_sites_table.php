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
        Schema::table('connected_sites', function (Blueprint $table) {
            $table->string('plugin_version')->nullable()->after('domain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('connected_sites', function (Blueprint $table) {
            $table->dropColumn('plugin_version');
        });
    }
};
