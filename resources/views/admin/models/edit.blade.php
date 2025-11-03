@extends('layouts.admin')
@section('title', 'Editar modelo')

@section('admin-content')
  <div class="card max-w-xl">
    <form method="POST" action="{{ route('admin.models.update', $model) }}" class="space-y-4">
      @csrf @method('PUT')
      <div>
        <label class="label">Marca</label>
        <select name="brand_id" class="select" required>
          @foreach($brands as $b)
            <option value="{{ $b->id }}" @selected(old('brand_id', $model->brand_id)==$b->id)>{{ $b->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="label">Nome do modelo</label>
        <input name="name" class="input" value="{{ old('name', $model->name) }}" required>
      </div>

      <div class="flex gap-2">
        <button class="btn-primary">Salvar</button>
        <a href="{{ route('admin.models.index') }}" class="btn-outline">Cancelar</a>
      </div>
    </form>
  </div>
@endsection
