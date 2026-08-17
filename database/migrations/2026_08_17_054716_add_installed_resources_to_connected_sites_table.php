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
            $table->longText('installed_resources')->nullable()->after('plugin_version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('connected_sites', function (Blueprint $table) {
            $table->dropColumn('installed_resources');
        });
    }
};
