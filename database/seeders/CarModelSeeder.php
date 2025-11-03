<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        $byBrand = [
            'Ferrari'      => ['488 GTB', 'F8 Tributo', '812 Superfast', 'Roma'],
            'Lamborghini'  => ['Huracán EVO', 'Aventador SVJ', 'Urus'],
            'Porsche'      => ['911 Turbo S', 'Cayman GT4', 'Panamera Turbo S', 'Taycan Turbo S'],
            'McLaren'      => ['720S', 'Artura', '765LT'],
            'Bugatti'      => ['Chiron', 'Veyron Super Sport'],
            'Aston Martin' => ['DB11', 'Vantage', 'DBS Superleggera'],
            'Rolls-Royce'  => ['Phantom', 'Ghost', 'Cullinan'],
            'Bentley'      => ['Continental GT', 'Flying Spur', 'Bentayga'],
        ];

        foreach ($byBrand as $brandName => $models) {
            $brand = Brand::where('name', $brandName)->first();
            if (!$brand) continue;

            foreach ($models as $m) {
                CarModel::firstOrCreate([
                    'brand_id' => $brand->id,
                    'name'     => $m,
                ]);
            }
        }
    }
}
