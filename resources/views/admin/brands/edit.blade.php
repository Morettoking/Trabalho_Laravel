@extends('layouts.admin')
@section('title', 'Editar marca')

@section('admin-content')
  <div class="card max-w-lg">
    <form method="POST" action="{{ route('admin.brands.update', $brand) }}" class="space-y-4">
      @csrf @method('PUT')
      <div>
        <label class="label">Nome</label>
        <input name="name" class="input" value="{{ old('name', $brand->name) }}" required>
        @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="flex gap-2">
        <button class="btn-primary">Salvar</button>
        <a href="{{ route('admin.brands.index') }}" class="btn-outline">Cancelar</a>
      </div>
    </form>
  </div>
@endsection
