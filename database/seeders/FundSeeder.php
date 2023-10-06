<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Fund;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Fund::factory(100)
            ->state(new Sequence(
                fn (Sequence $sequence) => ['manager_id' => Manager::all()->random()->id],
            ))
            ->hasAliases(rand(1, 3))
            ->create();
        // Attach companies to funds
        Fund::all()->each(function (Fund $fund) {
            $fund->companies()->attach(Company::all()->random(rand(1, 3)));
        });
    }
}
