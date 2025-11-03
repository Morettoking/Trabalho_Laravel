@extends('layouts.admin')

@section('title', 'Editar Veículo')

@section('admin-content')
  <form method="POST" action="{{ route('admin.vehicles.update', $vehicle) }}"" class="card">
    @csrf @method('PUT')

    <div class="grid gap-4 md:grid-cols-3">
      <div>
        <label class="label">Marca</label>
        <select name="brand_id" id="brand_id" class="select" required>
          @foreach ($brands as $b)
            <option value="{{ $b->id }}" @selected(old('brand_id', $vehicle->brand_id)==$b->id)>{{ $b->name }}</option>
          @endforeach
        </select>
        @error('brand_id') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="label">Modelo</label>
        <select name="car_model_id" id="car_model_id" class="select" required>
          @foreach ($models as $m)
            <option value="{{ $m->id }}" data-brand="{{ $m->brand_id }}" @selected(old('car_model_id', $vehicle->car_model_id)==$m->id)>
              {{ $m->brand->name }} - {{ $m->name }}
            </option>
          @endforeach
        </select>
        @error('car_model_id') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="label">Cor</label>
        <select name="color_id" class="select" required>
          @foreach ($colors as $c)
            <option value="{{ $c->id }}" @selected(old('color_id', $vehicle->color_id)==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
        @error('color_id') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3 mt-4">
      <div>
        <label class="label">Título (opcional)</label>
        <input name="title" value="{{ old('title', $vehicle->title) }}" class="input">
        @error('title') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="label">Ano</label>
        <input type="number" name="year" value="{{ old('year', $vehicle->year) }}" class="input" required>
        @error('year') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="label">Quilometragem (km)</label>
        <input type="number" name="mileage_km" value="{{ old('mileage_km', $vehicle->mileage_km) }}" class="input" required>
        @error('mileage_km') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 mt-4">
      <div>
        <label class="label">Preço (R$)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $vehicle->price) }}" class="input" required>
        @error('price') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="label">Foto Principal (URL)</label>
        <input name="main_photo_url" value="{{ old('main_photo_url', $vehicle->main_photo_url) }}" class="input" placeholder="https://...">
        @error('main_photo_url') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="mt-4">
      <label class="label">Descrição (detalhes)</label>
      <textarea name="description" rows="4" class="textarea">{{ old('description', $vehicle->description) }}</textarea>
      @error('description') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="mt-6">
      <div class="flex items-center justify-between">
        <label class="label !mb-0 font-semibold">Fotos (mínimo 3 URLs)</label>
        <button type="button" id="add-photo" class="text-sm underline">+ adicionar foto</button>
      </div>

      <div id="photos" class="mt-2 space-y-2">
        @php
          $oldPhotos = old('photo_urls', $vehicle->photos->pluck('url')->toArray());
          if (count($oldPhotos) < 3) $oldPhotos = array_pad($oldPhotos, 3, '');
        @endphp
        @foreach ($oldPhotos as $p)
          <div class="flex gap-2">
            <input name="photo_urls[]" value="{{ $p }}" class="input flex-1" placeholder="https://...">
            <button type="button" class="btn btn-outline remove-photo">Remover</button>
          </div>
        @endforeach
      </div>

      @error('photo_urls') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      @error('photo_urls.*') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="mt-6 flex gap-2">
      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline">Cancelar</a>
    </div>
  </form>

  <script>
    // filtra modelos por marca
    const brandSelect = document.getElementById('brand_id');
    const modelSelect = document.getElementById('car_model_id');
    function filterModels() {
      const brandId = brandSelect.value;
      [...modelSelect.options].forEach(opt => {
        if (!opt.value) return;
        opt.hidden = (opt.dataset.brand !== brandId);
      });
      if (modelSelect.selectedOptions[0] && modelSelect.selectedOptions[0].hidden) {
        modelSelect.value = '';
      }
    }
    brandSelect.addEventListener('change', filterModels);
    filterModels();

    // adicionar/remover campos de fotos
    document.getElementById('add-photo').addEventListener('click', function() {
      const div = document.getElementById('photos');
      const row = document.createElement('div');
      row.className = 'flex gap-2';
      row.innerHTML = `
        <input name="photo_urls[]" class="input flex-1" placeholder="https://...">
        <button type="button" class="btn btn-outline remove-photo">Remover</button>
      `;
      div.appendChild(row);
    });
    document.getElementById('photos').addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-photo')) {
        const row = e.target.closest('div.flex');
        row.parentNode.removeChild(row);
      }
    });
  </script>
@endsection
