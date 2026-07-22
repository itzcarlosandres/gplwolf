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
        Schema::table('memberships', function (Blueprint $table) {
            $table->integer('extra_daily_downloads')->default(0)->after('expires_at');
            $table->text('admin_notes')->nullable()->after('extra_daily_downloads');
            // Update status enum to include suspended/banned if needed, 
            // but for now we can use 'cancelled' or just effectively ban them.
            // Let's add 'suspended' to be explicit.
            $table->string('status')->default('pending')->change(); // Change to string to be more flexible than enum if needed, or just update enum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn(['extra_daily_downloads', 'admin_notes']);
        });
    }
};
