<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cambiar el tipo de columna de ENUM a VARCHAR para permitir más estados
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(50) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a ENUM original
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending'");
    }
};
