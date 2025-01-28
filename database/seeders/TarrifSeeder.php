<?php

namespace Database\Seeders;

use App\Models\Tarrif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarrifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tarrif::query()->insert([
            [
                'ration_name' => 'Vegetarian Daily Meal',
                'cooking_day_before' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ration_name' => 'Keto High-Protein Plan',
                'cooking_day_before' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ration_name' => 'Family Dinner Pack',
                'cooking_day_before' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ration_name' => 'Athlete Energy Booster',
                'cooking_day_before' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ration_name' => 'Balanced Nutrition Combo',
                'cooking_day_before' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
