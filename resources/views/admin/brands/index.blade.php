@extends('layouts.admin')
@section('title', 'Marcas')

@section('admin-content')
  <div class="toolbar">
    <form method="GET" class="searchbox">
      <svg viewBox="0 0 24 24" class="h-5 w-5 text-gray-400"><path d="M21 21l-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/></svg>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar marca...">
      @if(request('q')) <a href="{{ route('admin.brands.index') }}" class="text-xs text-gray-500 underline">limpar</a> @endif
    </form>

    <a href="{{ route('admin.brands.create') }}" class="btn-new">
      <svg viewBox="0 0 24 24" class="h-4 w-4"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      Nova marca
    </a>
  </div>

  <div class="table-card">
    <table class="table">
      <thead>
        <tr>
          <th class="th w-24">ID</th>
          <th class="th">Nome</th>
          <th class="th-right w-48">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($brands as $brand)
          <tr>
            <td class="td">{{ $brand->id }}</td>
            <td class="td font-medium">{{ $brand->name }}</td>
            <td class="td-right">
              <div class="inline-flex gap-2">
                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn-edit" title="Editar">
                  <svg viewBox="0 0 24 24" class="h-4 w-4"><path d="M4 21h4l11-11a2.8 2.8 0 1 0-4-4L4 17v4Z" fill="currentColor"/></svg>
                  Editar
                </a>
                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Excluir esta marca?');">
                  @csrf @method('DELETE')
                  <button class="btn-danger" title="Excluir">
                    <svg viewBox="0 0 24 24" class="h-4 w-4"><path d="M3 6h18M8 6l1-2h6l1 2m-1 0-1 14H9L8 6Z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Excluir
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td class="td" colspan="3">Nenhuma marca cadastrada.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $brands->links() }}</div>
@endsection
