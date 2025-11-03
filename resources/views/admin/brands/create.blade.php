@extends('layouts.admin')
@section('title', 'Nova marca')

@section('admin-content')
  <div class="card max-w-lg">
    <form method="POST" action="{{ route('admin.brands.store') }}" class="space-y-4">
      @csrf
      <div>
        <label class="label">Nome</label>
        <input name="name" class="input" value="{{ old('name') }}" required>
        @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="flex gap-2">
        <button class="btn-primary">Salvar</button>
        <a href="{{ route('admin.brands.index') }}" class="btn-outline">Cancelar</a>
      </div>
    </form>
  </div>
@endsection
