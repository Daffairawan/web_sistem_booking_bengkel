<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'phone_number' => '08123456789',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Customer Satu',
            'email' => 'customer@bengkel.com',
            'role' => 'customer',
            'password' => bcrypt('password'),
            'phone_number' => '08987654321',
        ]);

        $services = [
            ['service_name' => 'Servis Rutin / Tune Up', 'description' => 'Pengecekan dan pembersihan komponen mesin berkala', 'price' => 250000],
            ['service_name' => 'Ganti Oli & Filter', 'description' => 'Penggantian oli mesin dan filter oli', 'price' => 150000],
            ['service_name' => 'Servis Rem', 'description' => 'Pengecekan, pembersihan, dan penggantian kampas rem', 'price' => 300000],
            ['service_name' => 'Spooring & Balancing', 'description' => 'Penyelarasan roda dan ban agar stabil', 'price' => 200000],
            ['service_name' => 'Turun Mesin (Overhaul)', 'description' => 'Perbaikan berat pada komponen mesin internal', 'price' => 2500000],
        ];

        foreach ($services as $service) {
            \App\Models\Service::create($service);
        }
    }
}
