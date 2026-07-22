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
        // Add points balance to users if not exists
        if (!Schema::hasColumn('users', 'points')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('points')->default(0)->after('email');
            });
        }

        // Daily Logins Table (Streaks)
        Schema::create('daily_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('logged_at'); // The date of the login activity
            $table->integer('current_streak')->default(0);
            $table->integer('max_streak')->default(0);
            $table->timestamps();

            // Ensure one record per user
            $table->unique('user_id'); 
        });

        // Point Transactions History
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('amount'); // +/- amount
            $table->string('type', 50); // daily_login, purchase, refund, manual_adjustment
            $table->string('description')->nullable();
            $table->json('metadata')->nullable(); // Flexible field for references (order_id, etc)
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('type');
        });
        
        // Ranks Table
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('threshold_points')->default(0); // Points required to reach this rank
            $table->integer('discount_percent')->default(0); // Benefits
            $table->string('icon')->nullable(); // FontAwesome class
            $table->string('color')->nullable(); // Hex color
            $table->timestamps();
        });

        // User Current Rank
        if (!Schema::hasColumn('users', 'current_rank_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('current_rank_id')->nullable()->after('points')->constrained('ranks')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_transactions');
        Schema::dropIfExists('daily_logins');
        
        if (Schema::hasColumn('users', 'current_rank_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['current_rank_id']);
                $table->dropColumn('current_rank_id');
            });
        }
        
        Schema::dropIfExists('ranks');

        if (Schema::hasColumn('users', 'points')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('points');
            });
        }
    }
};
