<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ColorMethod;


class ColorMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ColorMethod::create([
            'name' => 'Roasted',
            'desc' => 'Pengolahan Warna dengan di bakar'
        ]);
        ColorMethod::create([
            'name' => 'Boiled',
            'desc' => 'Pengolahan Warna dengan di rebus'
        ]);
        ColorMethod::create([
            'name' => 'Printed',
            'desc' => 'Pengolahan Warna dengan di print'
        ]);
    }
}
