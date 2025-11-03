<?php

namespace Database\Seeders;

use App\Models\{Vehicle, VehiclePhoto, Brand, CarModel, Color};
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $create = function (string $brandName, string $modelName, string $colorName, array $attrs = [], array $photos = []) {
            $brand = Brand::where('name', $brandName)->first();
            $model = CarModel::where('name', $modelName)->where('brand_id', optional($brand)->id)->first();
            $color = Color::where('name', $colorName)->first();

            if (!$brand || !$model || !$color) return;

            $vehicle = Vehicle::create([
                'brand_id'       => $brand->id,
                'car_model_id'   => $model->id,
                'color_id'       => $color->id,
                'title'          => $attrs['title'] ?? "{$brandName} {$modelName}",
                'year'           => $attrs['year'] ?? 2023,
                'mileage_km'     => $attrs['mileage_km'] ?? 8000,
                'price'          => $attrs['price'] ?? 2999000.00,
                'main_photo_url' => $attrs['main_photo_url'] ?? ($photos[0] ?? null),
                'description'    => $attrs['description'] ?? 'Superesportivo de luxo com altíssimo desempenho e design exclusivo. Revisado e em perfeito estado.',
            ]);

            $pos = 1;
            foreach ($photos as $url) {
                VehiclePhoto::create([
                    'vehicle_id' => $vehicle->id,
                    'url'        => $url,
                    'position'   => $pos++,
                ]);
            }
        };

        $p = fn($term) => [
            "https://source.unsplash.com/1200x700/?{$term}-car,supercar",
            "https://source.unsplash.com/1200x700/?{$term}-interior",
            "https://source.unsplash.com/1200x700/?{$term}-detail",
        ];

        $create('Ferrari', 'F8 Tributo', 'Vermelho Racing', [
            'year' => 2022, 'mileage_km' => 4000, 'price' => 3890000.00,
        ], $p('ferrari'));

        $create('Lamborghini', 'Huracán EVO', 'Amarelo Solar', [
            'year' => 2021, 'mileage_km' => 6500, 'price' => 3490000.00,
        ], $p('lamborghini'));

        $create('Porsche', '911 Turbo S', 'Branco Pérola', [
            'year' => 2023, 'mileage_km' => 1500, 'price' => 1890000.00,
        ], $p('porsche'));

        $create('McLaren', '720S', 'Laranja', [
            'year' => 2020, 'mileage_km' => 9000, 'price' => 2690000.00,
        ], $p('mclaren'));

        $create('Bugatti', 'Chiron', 'Azul Royal', [
            'year' => 2019, 'mileage_km' => 3000, 'price' => 15500000.00,
        ], $p('bugatti'));

        $create('Aston Martin', 'DBS Superleggera', 'Cinza Titanium', [
            'year' => 2021, 'mileage_km' => 5000, 'price' => 2890000.00,
        ], $p('aston-martin'));

        $create('Rolls-Royce', 'Ghost', 'Branco Pérola', [
            'year' => 2022, 'mileage_km' => 7000, 'price' => 4190000.00,
        ], $p('rolls-royce'));

        $create('Bentley', 'Continental GT', 'Verde Esmeralda', [
            'year' => 2020, 'mileage_km' => 8000, 'price' => 2590000.00,
        ], $p('bentley'));
    }
}
