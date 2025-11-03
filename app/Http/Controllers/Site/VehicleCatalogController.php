<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\{Vehicle, Brand, CarModel, Color};
use Illuminate\Http\Request;

class VehicleCatalogController extends Controller
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
            ->paginate(12)
            ->withQueryString();

        $brands = Brand::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $models = CarModel::with('brand')->orderBy('name')->get();

        return view('site.vehicles.index', compact(
            'vehicles','brands','colors','models',
            'q','brandId','modelId','colorId','yearMin','yearMax','priceMin','priceMax'
        ));
    }
}
