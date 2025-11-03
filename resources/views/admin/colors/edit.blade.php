@extends('layouts.admin')
@section('title', 'Editar cor')

@section('admin-content')
  <div class="card max-w-lg">
    <form method="POST" action="{{ route('admin.colors.update', $color) }}" class="space-y-4">
      @csrf @method('PUT')
      <div>
        <label class="label">Nome</label>
        <input name="name" class="input" value="{{ old('name', $color->name) }}" required>
      </div>
      <div>
        <label class="label">Hex (#RRGGBB)</label>
        <input name="hex" class="input" value="{{ old('hex', $color->hex) }}" required>
      </div>
      <div class="flex gap-2">
        <button class="btn-primary">Salvar</button>
        <a href="{{ route('admin.colors.index') }}" class="btn-outline">Cancelar</a>
      </div>
    </form>
  </div>
@endsection
