<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Canoe Admin',
            'email' => 'admin@canoe-test.test',
            'password' => Hash::make('qg8MQzP@cN'),
        ]);

        $this->call([
            ManagerSeeder::class,
            CompanySeeder::class,
            FundSeeder::class,
        ]);
    }
}
