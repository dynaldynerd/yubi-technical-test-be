<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Style;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Style::create([
            'style_name' => 'Hair Punk',
            'desc' => 'Week Style Kekinian'
        ]);
        Style::create([
            'style_name' => 'Yellow Rainbow',
            'desc' => 'Week Style Kidz Zaman Now'
        ]);
        Style::create([
            'style_name' => 'Hair Punk',
            'desc' => 'Week Style Clasic'
        ]);
    }
}
