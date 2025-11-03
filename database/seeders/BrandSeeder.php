<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Ferrari',
            'Lamborghini',
            'Porsche',
            'McLaren',
            'Bugatti',
            'Aston Martin',
            'Rolls-Royce',
            'Bentley',
        ];

        foreach ($brands as $name) {
            Brand::firstOrCreate(['name' => $name]);
        }
    }
}
