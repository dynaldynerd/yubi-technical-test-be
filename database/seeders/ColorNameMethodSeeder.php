<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ColorNameMethod;

class ColorNameMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ColorNameMethod::create([
            'color_method_id' => 1,
            'name' => 'Red Classic',
        ]);
        ColorNameMethod::create([
            'color_method_id' => 1,
            'name' => 'Blue Marin',
        ]);
        ColorNameMethod::create([
            'color_method_id' => 2,
            'name' => 'Dark Morron',
        ]);
        ColorNameMethod::create([
            'color_method_id' => 3,
            'name' => 'Grey Water',
        ]);
    }
}
