@extends('layouts.site')

@section('title', $vehicle->title ?? ($vehicle->brand->name.' '.$vehicle->carModel->name.' '.$vehicle->year))

{{-- HERO (mesma coloração da sidebar) --}}
@section('hero')
  {{-- BREADCRUMB ANIMADO --}}
  <div class="breadcrumb mb-3">
    <span class="crumb" style="animation-delay: 0ms;">
      <a href="{{ route('home') }}">Catálogo</a>
    </span>
    <span class="crumb-sep" style="animation-delay: 90ms;"></span>
    <span class="crumb" style="animation-delay: 120ms;">
      <a href="{{ route('home', ['brand_id' => $vehicle->brand_id]) }}">{{ $vehicle->brand->name }}</a>
    </span>
    <span class="crumb-sep" style="animation-delay: 210ms;"></span>
    <span class="crumb" style="animation-delay: 240ms;">
      <a href="{{ route('home', ['car_model_id' => $vehicle->car_model_id]) }}">{{ $vehicle->carModel->name }}</a>
    </span>
    <span class="crumb-sep" style="animation-delay: 330ms;"></span>
    <span class="crumb crumb--muted" style="animation-delay: 360ms;">
      {{ $vehicle->year }}
    </span>
  </div>

  <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between text-white">
    <div class="crumb" style="animation-delay: 420ms;">
      <h1 class="text-2xl md:text-3xl font-extrabold">
        {{ $vehicle->title ?? ($vehicle->brand->name.' '.$vehicle->carModel->name.' '.$vehicle->year) }}
      </h1>
      <div class="mt-2 flex flex-wrap items-center gap-2">
        <span class="pill bg-white/20 text-white">{{ $vehicle->brand->name }}</span>
        <span class="pill bg-white/20 text-white">{{ $vehicle->carModel->name }}</span>
        <span class="pill bg-white/20 text-white">Ano {{ $vehicle->year }}</span>
        <span class="pill bg-white/20 text-white">{{ number_format($vehicle->mileage_km, 0, ',', '.') }} km</span>
      </div>
    </div>

    <div class="text-right crumb" style="animation-delay: 480ms;">
      <div class="text-xs uppercase tracking-wider text-white/80">Preço</div>
      <div class="text-2xl md:text-3xl font-extrabold">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</div>
      <div class="mt-2 flex gap-2 justify-end">
        <a href="https://api.whatsapp.com/send?text={{ urlencode(($vehicle->title ?? ($vehicle->brand->name.' '.$vehicle->carModel->name.' '.$vehicle->year)).' - '.route('vehicles.show', $vehicle)) }}"
           target="_blank"
           class="btn-white-outline">
          WhatsApp
        </a>
        <a href="{{ route('home') }}" class="btn-white">Voltar</a>
      </div>
    </div>
  </div>
@endsection

{{-- SIDEBAR (ficha rápida + ações) --}}
@section('sidebar')
  <div class="sidebar page-enter" style="animation-delay:.05s">
    <div class="sidebar-title">Ficha rápida</div>
    <div class="sidebar-sub">Principais informações deste veículo.</div>

    <div class="mt-4 space-y-3 text-white/90">
      <div class="flex items-center justify-between">
        <span class="text-white/70">Marca</span>
        <span class="font-semibold">{{ $vehicle->brand->name }}</span>
      </div>
      <div class="flex items-center justify-between">
        <span class="text-white/70">Modelo</span>
        <span class="font-semibold">{{ $vehicle->carModel->name }}</span>
      </div>
      <div class="flex items-center justify-between">
        <span class="text-white/70">Cor</span>
        <span class="font-semibold">{{ $vehicle->color->name }}</span>
      </div>
      <div class="flex items-center justify-between">
        <span class="text-white/70">Ano</span>
        <span class="font-semibold">{{ $vehicle->year }}</span>
      </div>
      <div class="flex items-center justify-between">
        <span class="text-white/70">Quilometragem</span>
        <span class="font-semibold">{{ number_format($vehicle->mileage_km, 0, ',', '.') }} km</span>
      </div>
      <div class="pt-2 border-t border-white/10"></div>
      <div class="flex items-center justify-between">
        <span class="text-white/70">Preço</span>
        <span class="text-lg font-extrabold">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</span>
      </div>
    </div>

    <div class="mt-5 grid grid-cols-1 gap-2">
      <a href="https://api.whatsapp.com/send?text={{ urlencode(($vehicle->title ?? ($vehicle->brand->name.' '.$vehicle->carModel->name.' '.$vehicle->year)).' - '.route('vehicles.show', $vehicle)) }}"
         target="_blank" class="btn-white">Falar no WhatsApp</a>
      <a href="{{ route('home') }}" class="btn-white-outline">Voltar ao Catálogo</a>
    </div>
  </div>

  @if(isset($related) && $related->count())
    <div class="mt-6 sidebar page-enter" style="animation-delay:.15s">
      <div class="sidebar-title">Você também pode gostar</div>
      <div class="mt-3 space-y-3">
        @foreach($related as $r)
          <a href="{{ route('vehicles.show', $r) }}" class="side-link">
            <span class="truncate">{{ $r->brand->name }} {{ $r->carModel->name }} {{ $r->year }}</span>
          </a>
        @endforeach
      </div>
    </div>
  @endif
@endsection

@section('content')
  <div class="page-enter">
    {{-- GALERIA PRINCIPAL --}}
    <div class="card">
      <div class="grid gap-4 lg:grid-cols-12">
        <div class="lg:col-span-8">
          <div class="relative aspect-video overflow-hidden rounded-xl bg-gray-100">
            <img id="mainPhoto"
                src="{{ $vehicle->main_photo_url ?? ($vehicle->photos->first()->url ?? 'https://placehold.co/1200x700?text=Sem+Foto') }}"
                alt="{{ $vehicle->title ?? $vehicle->carModel->name }}"
                class="h-full w-full object-cover transition">
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
          </div>

          {{-- Thumbs --}}
          @php
            $thumbs = collect([$vehicle->main_photo_url])->filter()->values();
            $photoUrls = $vehicle->photos->pluck('url')->toArray();
            foreach ($photoUrls as $u) { if (!$thumbs->contains($u)) $thumbs->push($u); }
          @endphp

          @if($thumbs->count())
            <div class="mt-3 flex gap-3 overflow-x-auto pb-1">
              @foreach($thumbs as $idx => $url)
                <button type="button"
                        data-photo="{{ $url }}"
                        class="thumb-btn relative h-20 w-32 shrink-0 overflow-hidden rounded-lg border {{ $idx === 0 ? 'ring-2 ring-brand-500' : 'border-gray-300' }}">
                  <img src="{{ $url }}" class="h-full w-full object-cover" alt="thumb">
                </button>
              @endforeach
            </div>
          @endif
        </div>

        {{-- ESPECIFICAÇÕES RÁPIDAS --}}
        <div class="lg:col-span-4">
          <div class="card">
            <div class="text-lg font-extrabold text-brand-900">Especificações</div>
            <div class="mt-3 space-y-2 text-sm">
              <div class="flex items-center justify-between">
                <span class="text-gray-500">Marca</span>
                <span class="font-semibold">{{ $vehicle->brand->name }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-500">Modelo</span>
                <span class="font-semibold">{{ $vehicle->carModel->name }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-500">Cor</span>
                <span class="font-semibold">{{ $vehicle->color->name }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-500">Ano</span>
                <span class="font-semibold">{{ $vehicle->year }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-500">Quilometragem</span>
                <span class="font-semibold">{{ number_format($vehicle->mileage_km, 0, ',', '.') }} km</span>
              </div>
              <div class="flex items-center justify-between pt-2 mt-2 border-t">
                <span class="text-gray-500">Preço</span>
                <span class="text-lg font-extrabold">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</span>
              </div>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-2">
              <a href="https://api.whatsapp.com/send?text={{ urlencode(($vehicle->title ?? ($vehicle->brand->name.' '.$vehicle->carModel->name.' '.$vehicle->year)).' - '.route('vehicles.show', $vehicle)) }}"
                target="_blank" class="btn-primary">Tenho interesse</a>
              <a href="{{ route('home') }}" class="btn-outline">Voltar ao catálogo</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- DESCRIÇÃO --}}
    <div class="mt-6 card">
      <div class="text-lg font-extrabold text-brand-900">Descrição</div>
      <div class="mt-2 text-gray-700 leading-relaxed">
        {!! nl2br(e($vehicle->description ?? 'Veículo em excelente estado, revisões em dia, manual e chave reserva. Pronto para surpreender em desempenho e design.')) !!}
      </div>
    </div>

    {{-- GALERIA COMPLETA --}}
    @if($vehicle->photos->count() > 0)
      <div class="mt-6">
        <div class="text-lg font-extrabold text-brand-900 mb-3">Galeria</div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          @foreach($vehicle->photos as $p)
            <div class="card overflow-hidden p-0">
              <img src="{{ $p->url }}" alt="foto" class="h-56 w-full object-cover">
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
@endsection

@push('scripts')
<script>
  // troca da foto principal ao clicar nas thumbs
  document.querySelectorAll('.thumb-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const url = btn.getAttribute('data-photo');
      const main = document.getElementById('mainPhoto');
      if (url && main) {
        main.src = url;
        document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('ring-2','ring-brand-500'));
        btn.classList.add('ring-2','ring-brand-500');
      }
    });
  });
</script>
@endpush
