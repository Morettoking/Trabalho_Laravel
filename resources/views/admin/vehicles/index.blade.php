@extends('layouts.admin')
@section('title', 'Veículos')

@section('admin-content')
  <div class="toolbar">
    <form method="GET" class="searchbox">
      <svg viewBox="0 0 24 24" class="h-5 w-5 text-gray-400"><path d="M21 21l-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/></svg>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar veículo (título, marca, modelo)...">
      @if(request('q')) <a href="{{ route('admin.vehicles.index') }}" class="text-xs text-gray-500 underline">limpar</a> @endif
    </form>

    <a href="{{ route('admin.vehicles.create') }}" class="btn-new">
      <svg viewBox="0 0 24 24" class="h-4 w-4"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      Novo veículo
    </a>
  </div>

  <div class="table-card">
    <table class="table">
      <thead>
        <tr>
          <th class="th">Carro</th>
          <th class="th">Ano</th>
          <th class="th">KM</th>
          <th class="th">Preço</th>
          <th class="th-right w-56">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($vehicles as $v)
          <tr>
            <td class="td">
              <div class="flex items-center gap-3">
                <img src="{{ $v->main_photo_url ?? 'https://placehold.co/120x80?text=Foto' }}" class="h-14 w-20 object-cover rounded-md border" alt="">
                <div>
                  <div class="font-semibold">{{ $v->title ?? ($v->brand->name.' '.$v->carModel->name) }}</div>
                  <div class="text-xs text-gray-500">{{ $v->brand->name }} • {{ $v->carModel->name }} • {{ $v->color->name }}</div>
                </div>
              </div>
            </td>
            <td class="td">{{ $v->year }}</td>
            <td class="td">{{ number_format($v->mileage_km, 0, ',', '.') }} km</td>
            <td class="td">R$ {{ number_format($v->price, 2, ',', '.') }}</td>
            <td class="td-right">
              <div class="inline-flex gap-2">
                <a href="{{ route('vehicles.show', $v) }}" target="_blank" class="btn-outline" title="Ver na loja">
                  <svg viewBox="0 0 24 24" class="h-4 w-4"><path d="M14 3h7v7M10 14L21 3M21 13v7H3V3h7" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  Loja
                </a>
                <a href="{{ route('admin.vehicles.edit', $v) }}" class="btn-edit">
                  <svg viewBox="0 0 24 24" class="h-4 w-4"><path d="M4 21h4l11-11a2.8 2.8 0 1 0-4-4L4 17v4Z" fill="currentColor"/></svg>
                  Editar
                </a>
                <form action="{{ route('admin.vehicles.destroy', $v) }}" method="POST" onsubmit="return confirm('Excluir este veículo?');">
                  @csrf @method('DELETE')
                  <button class="btn-danger">
                    <svg viewBox="0 0 24 24" class="h-4 w-4"><path d="M3 6h18M8 6l1-2h6l1 2m-1 0-1 14H9L8 6Z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Excluir
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td class="td" colspan="5">Nenhum veículo cadastrado.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $vehicles->links() }}</div>
@endsection
