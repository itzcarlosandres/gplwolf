<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@marketplace.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Create Sample Customers
        User::updateOrCreate(
            ['email' => 'juan@example.com'],
            [
                'name' => 'Juan Pérez',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // 3. Create Membership Plans
        $plans = [
            [
                'name' => 'Básico',
                'slug' => 'basico',
                'description' => 'Ideal para empezar',
                'price' => 29.00,
                'duration' => 'monthly',
                'duration_days' => 30,
                'benefits' => ['5 descargas', 'Soporte email', 'Actualizaciones'],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'El más popular',
                'price' => 79.00,
                'duration' => 'monthly',
                'duration_days' => 30,
                'benefits' => ['Descargas ilimitadas', 'Soporte 24/7', 'Acceso prioritario'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2
            ]
        ];

        foreach ($plans as $plan) {
            MembershipPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }

        // 4. Create Sample Products
        $products = [
            [
                'name' => 'Astra Pro Theme',
                'slug' => 'astra-pro-theme',
                'description' => 'The most popular theme for WordPress.',
                'type' => 'theme',
                'category' => 'Multi-purpose',
                'price' => 59.00,
                'version' => '4.2.0',
                'is_active' => true,
                'downloads_count' => 1500
            ],
            [
                'name' => 'Elementor Pro',
                'slug' => 'elementor-pro',
                'description' => 'The world\'s leading WordPress website builder.',
                'type' => 'plugin',
                'category' => 'Page Builder',
                'price' => 49.00,
                'version' => '3.15.0',
                'is_active' => true,
                'downloads_count' => 5000
            ],
            [
                'name' => 'WP Rocket',
                'slug' => 'wp-rocket',
                'description' => 'The best WordPress caching plugin.',
                'type' => 'plugin',
                'category' => 'Optimization',
                'price' => 39.00,
                'version' => '3.14.0',
                'is_active' => true,
                'downloads_count' => 3200
            ]
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
