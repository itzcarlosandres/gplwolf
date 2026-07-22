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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'max_rank_id')) {
                $table->foreignId('max_rank_id')->nullable()->after('current_rank_id')->constrained('ranks')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'max_rank_id')) {
                $table->dropForeign(['max_rank_id']);
                $table->dropColumn('max_rank_id');
            }
        });
    }
};
