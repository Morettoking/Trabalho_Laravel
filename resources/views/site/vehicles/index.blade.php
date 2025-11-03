@extends('layouts.site')

@section('title', 'Catálogo de veículos')

{{-- HERO (mesma coloração da sidebar) --}}
@section('hero')
  <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <div>
      <h1 class="text-2xl md:text-3xl font-extrabold text-white">Exclusivos & Superesportivos</h1>
      <p class="text-white/80 text-sm md:text-base">
        Explore nosso acervo de luxo com filtros avançados de marca, modelo, cor, ano e preço.
      </p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('home') }}" class="btn-white">Ver todos</a>
      @auth
        <a href="{{ route('admin.dashboard') }}" class="btn-white-outline">Painel Admin</a>
      @else
        <a href="{{ route('login') }}" class="btn-white-outline">Entrar</a>
      @endauth
    </div>
  </div>
@endsection

{{-- SIDEBAR (filtros) --}}
@section('sidebar')
  @php ob_start(); @endphp
    <form method="GET" class="mt-4">
      <label class="label-invert">Busca (título/descrição)</label>
      <input type="text" name="q" value="{{ $q ?? '' }}" class="input-invert mb-3" placeholder="Ex.: V12, fibra de carbono">

      <label class="label-invert">Marca</label>
      <select name="brand_id" id="brand_id" class="select-invert mb-3">
        <option value="">Todas</option>
        @foreach($brands as $b)
          <option value="{{ $b->id }}" @selected(($brandId ?? null) == $b->id)>{{ $b->name }}</option>
        @endforeach
      </select>

      <label class="label-invert">Modelo</label>
      <select name="car_model_id" id="car_model_id" class="select-invert mb-3">
        <option value="">Todos</option>
        @foreach($models as $m)
          <option value="{{ $m->id }}" data-brand="{{ $m->brand_id }}" @selected(($modelId ?? null) == $m->id)>
            {{ $m->brand->name }} - {{ $m->name }}
          </option>
        @endforeach
      </select>

      <label class="label-invert">Cor</label>
      <select name="color_id" class="select-invert mb-3">
        <option value="">Todas</option>
        @foreach($colors as $c)
          <option value="{{ $c->id }}" @selected(($colorId ?? null) == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>

      <div class="grid grid-cols-2 gap-2 mb-3">
        <div>
          <label class="label-invert">Ano mín.</label>
          <input type="number" name="year_min" value="{{ $yearMin ?? '' }}" class="input-invert">
        </div>
        <div>
          <label class="label-invert">Ano máx.</label>
          <input type="number" name="year_max" value="{{ $yearMax ?? '' }}" class="input-invert">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <label class="label-invert">Preço mín. (R$)</label>
          <input type="number" step="0.01" name="price_min" value="{{ $priceMin ?? '' }}" class="input-invert">
        </div>
        <div>
          <label class="label-invert">Preço máx. (R$)</label>
          <input type="number" step="0.01" name="price_max" value="{{ $priceMax ?? '' }}" class="input-invert">
        </div>
      </div>

      <button class="btn-white w-full mt-4">Filtrar</button>
    </form>

    <script>
      // filtra modelos por marca (sidebar)
      const brandSelect = document.getElementById('brand_id');
      const modelSelect = document.getElementById('car_model_id');
      function filterModels() {
        const brandId = brandSelect.value;
        [...modelSelect.options].forEach(opt => {
          if (!opt.value) return;
          opt.hidden = (brandId && opt.dataset.brand !== brandId);
        });
        if (modelSelect.selectedOptions[0] && modelSelect.selectedOptions[0].hidden) {
          modelSelect.value = '';
        }
      }
      brandSelect.addEventListener('change', filterModels);
      filterModels();
    </script>
  @php $filterForm = ob_get_clean(); @endphp

  @include('partials.site.sidebar', ['filterForm' => $filterForm])
@endsection

{{-- CONTEÚDO --}}
@section('content')
  <div class="mb-4 flex items-center justify-between">
    <h2 class="text-xl font-extrabold text-brand-900">Catálogo</h2>
    <div class="flex items-center gap-2">
      <span class="badge-brand">{{ $vehicles->total() }} resultado(s)</span>
    </div>
  </div>

  @if($vehicles->count() === 0)
    <div class="card">Nenhum veículo encontrado com os filtros informados.</div>
  @else
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
      @foreach ($vehicles as $v)
        <a href="{{ route('vehicles.show', $v) }}" class="card-hover">
          <div class="relative aspect-video overflow-hidden rounded-xl">
            <img src="{{ $v->main_photo_url ?? 'https://placehold.co/1200x700?text=Sem+Foto' }}"
                 alt=""
                 class="h-full w-full object-cover">
            <div class="absolute left-3 top-3">
              <span class="badge-brand">{{ $v->brand->name }}</span>
            </div>
            <div class="absolute right-3 bottom-3">
              <span class="badge-red">R$ {{ number_format($v->price, 2, ',', '.') }}</span>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
          </div>

          <div class="mt-3">
            <div class="text-xs text-gray-600">
              {{ $v->carModel->name }} • {{ $v->color->name }}
            </div>
            <div class="mt-1 text-lg font-extrabold text-brand-800">
              {{ $v->title ?? ($v->brand->name.' '.$v->carModel->name.' '.$v->year) }}
            </div>

            <div class="mt-2 flex items-center justify-between">
              <span class="pill">Ano {{ $v->year }}</span>
              <span class="pill">{{ number_format($v->mileage_km, 0, ',', '.') }} km</span>
              <span class="pill">Ver detalhes</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $vehicles->links() }}
    </div>
  @endif
@endsection
