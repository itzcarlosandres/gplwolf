<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class TrialMembershipPlanSeeder extends Seeder
{
    public function run(): void
    {
        MembershipPlan::updateOrCreate(
            ['slug' => 'prueba-7-dias'],
            [
                'name' => 'Prueba 7 Días',
                'slug' => 'prueba-7-dias',
                'description' => 'Prueba el catálogo completo durante 7 días sin compromisos.',
                'price' => 0.00,
                'duration' => 'trial',
                'duration_days' => 7,
                'daily_download_limit' => 3,
                'sites_limit' => 1,
                'reward_points' => 100,
                'benefits' => [
                    '3 descargas diarias por 7 días',
                    'Acceso a miles de temas y plugins GPL',
                    'Archivos 100% limpios y verificados',
                    'Conexión de 1 sitio web con el plugin oficial',
                    'Sin renovación automática forzada'
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
            ]
        );
    }
}
