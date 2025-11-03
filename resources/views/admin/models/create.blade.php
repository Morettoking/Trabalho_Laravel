@extends('layouts.admin')
@section('title', 'Novo modelo')

@section('admin-content')
  <div class="card max-w-xl">
    <form method="POST" action="{{ route('admin.models.store') }}" class="space-y-4">
      @csrf
      <div>
        <label class="label">Marca</label>
        <select name="brand_id" class="select" required>
          <option value="">Selecione...</option>
          @foreach($brands as $b)
            <option value="{{ $b->id }}" @selected(old('brand_id')==$b->id)>{{ $b->name }}</option>
          @endforeach
        </select>
        @error('brand_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="label">Nome do modelo</label>
        <input name="name" class="input" value="{{ old('name') }}" required>
        @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="flex gap-2">
        <button class="btn-primary">Salvar</button>
        <a href="{{ route('admin.models.index') }}" class="btn-outline">Cancelar</a>
      </div>
    </form>
  </div>
@endsection
