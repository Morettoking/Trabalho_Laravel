<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $colors = Color::when($q !== '', fn ($qb) => $qb->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.colors.index', compact('colors', 'q'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:colors,name',
            'hex'  => ['nullable','regex:/^#([A-Fa-f0-9]{6})$/'],
        ]);

        Color::create($data);
        return redirect()->route('admin.colors.index')->with('success', 'Cor criada com sucesso!');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:colors,name,' . $color->id,
            'hex'  => ['nullable','regex:/^#([A-Fa-f0-9]{6})$/'],
        ]);

        $color->update($data);
        return redirect()->route('admin.colors.index')->with('success', 'Cor atualizada com sucesso!');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Cor excluída com sucesso!');
    }
}
