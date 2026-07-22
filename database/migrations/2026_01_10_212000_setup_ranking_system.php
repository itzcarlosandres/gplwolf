<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Force Reset Ranks Table
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ranks');
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_points')->unique();
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        // 2. Update Users Table
        Schema::table('users', function (Blueprint $table) {
            // Try to clean up
            try {
                if (Schema::hasColumn('users', 'rank_id')) {
                    $table->dropForeign(['rank_id']);
                    $table->dropColumn('rank_id');
                }
            } catch (\Exception $e) {}

            try {
                if (Schema::hasColumn('users', 'current_rank_id')) {
                    $table->dropForeign(['current_rank_id']);
                    $table->dropColumn('current_rank_id');
                }
            } catch (\Exception $e) {}

            $table->foreignId('current_rank_id')->nullable()->constrained('ranks')->nullOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'current_rank_id')) {
                $table->dropForeign(['current_rank_id']);
                $table->dropColumn('current_rank_id');
            }
        });
        Schema::dropIfExists('ranks');
    }
};
