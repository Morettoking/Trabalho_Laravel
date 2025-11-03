<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Vermelho Racing', 'hex' => '#C00000'],
            ['name' => 'Amarelo Solar',  'hex' => '#FFD000'],
            ['name' => 'Preto Piano',    'hex' => '#000000'],
            ['name' => 'Branco Pérola',  'hex' => '#F9F9F9'],
            ['name' => 'Cinza Titanium', 'hex' => '#8A8A8A'],
            ['name' => 'Azul Royal',     'hex' => '#0033CC'],
            ['name' => 'Verde Esmeralda','hex' => '#007F5C'],
        ];

        foreach ($colors as $c) {
            Color::firstOrCreate(['name' => $c['name']], ['hex' => $c['hex']]);
        }
    }
}
