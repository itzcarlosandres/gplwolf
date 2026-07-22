<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        $ranks = [
            [
                'name' => 'Bronce',
                'min_points' => 0,
                'discount_percentage' => 0,
                'icon' => 'fas fa-shield-alt',
                'color' => '#fb923c', // Orange-400
            ],
            [
                'name' => 'Plata',
                'min_points' => 500,
                'discount_percentage' => 5.00,
                'icon' => 'fas fa-shield-alt',
                'color' => '#9ca3af', // Gray-400
            ],
            [
                'name' => 'Oro',
                'min_points' => 1000,
                'discount_percentage' => 10.00,
                'icon' => 'fas fa-crown',
                'color' => '#fbbf24', // Amber-400
            ],
            [
                'name' => 'Diamante',
                'min_points' => 2500,
                'discount_percentage' => 15.00,
                'icon' => 'fas fa-gem',
                'color' => '#22d3ee', // Cyan-400
            ],
        ];

        foreach ($ranks as $rank) {
            Rank::updateOrCreate(
                ['min_points' => $rank['min_points']], // Unique key
                $rank
            );
        }
    }
}