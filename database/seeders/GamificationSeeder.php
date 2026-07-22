<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rank;
use App\Models\User;
use App\Models\Setting;

class GamificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Ranks
        $ranks = [
            [
                'name' => 'Bronce', 
                'threshold_points' => 0, 
                'discount_percent' => 0,
                'color' => '#CD7F32',
                'icon' => 'fa-medal'
            ],
            [
                'name' => 'Plata', 
                'threshold_points' => 1000, 
                'discount_percent' => 5,
                'color' => '#C0C0C0',
                'icon' => 'fa-medal'
            ],
            [
                'name' => 'Oro', 
                'threshold_points' => 5000, 
                'discount_percent' => 10,
                'color' => '#FFD700',
                'icon' => 'fa-crown'
            ],
            [
                'name' => 'Diamante', 
                'threshold_points' => 15000, 
                'discount_percent' => 15,
                'color' => '#b9f2ff',
                'icon' => 'fa-gem'
            ],
        ];

        foreach ($ranks as $rank) {
            Rank::updateOrCreate(['name' => $rank['name']], $rank);
        }

        // 2. Setup Default Daily Rewards Config
        $config = [
            'active' => true,
            'rewards' => [
                1 => 10,
                2 => 20,
                3 => 30,
                4 => 40,
                5 => 50,
                6 => 100,
                7 => 250 // Cofre Final
            ]
        ];

        Setting::updateOrCreate(
            ['key' => 'gamification_rewards'],
            ['value' => json_encode($config)]
        );

        // 3. Update Existing Admin to Diamond (for testing)
        $admin = User::where('email', 'admin@admin.com')->first();
        if ($admin) {
            $diamond = Rank::where('name', 'Diamante')->first();
            $admin->update([
                'points' => 20000,
                'current_rank_id' => $diamond->id
            ]);
        }
    }
}
