<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Vehicle, Brand, CarModel, Color, VehiclePhoto};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string) $request->get('q'));
        $brandId  = $request->integer('brand_id');
        $modelId  = $request->integer('car_model_id');
        $colorId  = $request->integer('color_id');
        $yearMin  = $request->integer('year_min');
        $yearMax  = $request->integer('year_max');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');

        $vehicles = Vehicle::with(['brand','carModel','color'])
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($q2) use ($q) {
                    $q2->where('title', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->when($brandId, fn ($qb) => $qb->where('brand_id', $brandId))
            ->when($modelId, fn ($qb) => $qb->where('car_model_id', $modelId))
            ->when($colorId, fn ($qb) => $qb->where('color_id', $colorId))
            ->when($yearMin, fn ($qb) => $qb->where('year', '>=', $yearMin))
            ->when($yearMax, fn ($qb) => $qb->where('year', '<=', $yearMax))
            ->when(strlen((string)$priceMin) > 0, fn ($qb) => $qb->where('price', '>=', (float)$priceMin))
            ->when(strlen((string)$priceMax) > 0, fn ($qb) => $qb->where('price', '<=', (float)$priceMax))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $brands = Brand::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $models = CarModel::with('brand')->orderBy('name')->get();

        return view('admin.vehicles.index', compact(
            'vehicles','brands','colors','models',
            'q','brandId','modelId','colorId','yearMin','yearMax','priceMin','priceMax'
        ));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $models = CarModel::with('brand')->orderBy('name')->get();

        return view('admin.vehicles.create', compact('brands','colors','models'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($data) {
            $vehicle = Vehicle::create([
                'brand_id'       => $data['brand_id'],
                'car_model_id'   => $data['car_model_id'],
                'color_id'       => $data['color_id'],
                'title'          => $data['title'] ?? null,
                'year'           => $data['year'],
                'mileage_km'     => $data['mileage_km'],
                'price'          => $data['price'],
                'main_photo_url' => $data['main_photo_url'] ?? null,
                'description'    => $data['description'] ?? null,
            ]);

            $position = 1;
            foreach ($data['photo_urls'] as $url) {
                VehiclePhoto::create([
                    'vehicle_id' => $vehicle->id,
                    'url'        => $url,
                    'position'   => $position++,
                ]);
            }
        });

        return redirect()->route('admin.vehicles.index')->with('success', 'Veículo criado com sucesso!');
    }

    public function edit(Vehicle $vehicle)
    {
        $vehicle->load('photos','brand','carModel','color');

        $brands = Brand::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $models = CarModel::with('brand')->orderBy('name')->get();

        return view('admin.vehicles.edit', compact('vehicle','brands','colors','models'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($vehicle, $data) {
            $vehicle->update([
                'brand_id'       => $data['brand_id'],
                'car_model_id'   => $data['car_model_id'],
                'color_id'       => $data['color_id'],
                'title'          => $data['title'] ?? null,
                'year'           => $data['year'],
                'mileage_km'     => $data['mileage_km'],
                'price'          => $data['price'],
                'main_photo_url' => $data['main_photo_url'] ?? null,
                'description'    => $data['description'] ?? null,
            ]);

            // Sincroniza fotos: simples e efetivo
            $vehicle->photos()->delete();
            $position = 1;
            foreach ($data['photo_urls'] as $url) {
                VehiclePhoto::create([
                    'vehicle_id' => $vehicle->id,
                    'url'        => $url,
                    'position'   => $position++,
                ]);
            }
        });

        return redirect()->route('admin.vehicles.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Veículo excluído com sucesso!');
    }

    private function validatedData(Request $request): array
    {
        $currentYear = (int) now()->year + 1;

        $data = $request->validate([
            'brand_id'       => 'required|exists:brands,id',
            'car_model_id'   => 'required|exists:car_models,id',
            'color_id'       => 'required|exists:colors,id',
            'title'          => 'nullable|string|max:120',
            'year'           => "required|integer|min:1950|max:$currentYear",
            'mileage_km'     => 'required|integer|min:0',
            'price'          => 'required|numeric|min:0',
            'main_photo_url' => 'nullable|url|max:500',
            'description'    => 'nullable|string',
            'photo_urls'     => 'required|array|min:3',
            'photo_urls.*'   => 'required|url|max:500',
        ]);

        // modelo deve pertencer à marca
        $belongs = CarModel::where('id', $data['car_model_id'])
            ->where('brand_id', $data['brand_id'])
            ->exists();

        if (!$belongs) {
            back()->withErrors(['car_model_id' => 'O modelo selecionado não pertence à marca escolhida.'])->throwResponse();
        }

        return $data;
    }
}
