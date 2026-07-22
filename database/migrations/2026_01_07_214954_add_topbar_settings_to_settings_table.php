<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insertar configuraciones del top bar
        DB::table('settings')->insert([
            [
                'key' => 'topbar_enabled',
                'value' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'topbar_text',
                'value' => '🎉 Usa el cupón WELCOME20 y obtén 20% de descuento en tu primera compra',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'topbar_link',
                'value' => '/checkout',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'topbar_link_text',
                'value' => 'Comprar Ahora',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'topbar_bg_color',
                'value' => '#FF2121',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'topbar_enabled',
            'topbar_text',
            'topbar_link',
            'topbar_link_text',
            'topbar_bg_color',
        ])->delete();
    }
};
