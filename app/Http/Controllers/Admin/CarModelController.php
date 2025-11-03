<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\Brand;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $models = CarModel::with('brand')
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhereHas('brand', fn ($qb) => $qb->where('name', 'like', "%{$q}%"));
            })
            ->orderBy(Brand::select('name')->whereColumn('brands.id', 'car_models.brand_id'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.models.index', compact('models', 'q'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name'     => 'required|string|max:100',
        ]);

        $exists = CarModel::where('brand_id', $data['brand_id'])
            ->where('name', $data['name'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Já existe um modelo com esse nome para esta marca.'])->withInput();
        }

        CarModel::create($data);
        return redirect()->route('admin.models.index')->with('success', 'Modelo criado com sucesso!');
    }

    public function edit(CarModel $model)
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.models.edit', compact('model', 'brands'));
    }

    public function update(Request $request, CarModel $model)
    {
        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name'     => 'required|string|max:100',
        ]);

        $exists = CarModel::where('brand_id', $data['brand_id'])
            ->where('name', $data['name'])
            ->where('id', '<>', $model->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Já existe um modelo com esse nome para esta marca.'])->withInput();
        }

        $model->update($data);
        return redirect()->route('admin.models.index')->with('success', 'Modelo atualizado com sucesso!');
    }

    public function destroy(CarModel $model)
    {
        $model->delete();
        return redirect()->route('admin.models.index')->with('success', 'Modelo excluído com sucesso!');
    }
}
