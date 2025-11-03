<div class="sidebar">
  <div class="mb-3">
    <div class="sidebar-title">Explore</div>
    <div class="sidebar-sub">Refine sua busca por marca, modelo, cor, ano e preço.</div>
  </div>

  <div>
    <div class="side-title">Atalhos</div>
    <div class="flex flex-col">
      <a href="{{ route('home') }}" class="side-link">Catálogo</a>
      @auth
        <a href="{{ route('admin.dashboard') }}" class="side-link">Painel Admin</a>
      @else
        <a href="{{ route('login') }}" class="side-link">Entrar</a>
      @endauth
    </div>
  </div>

  {{-- filtros (conteúdo injetado pela página) --}}
  @isset($filterForm)
    {!! $filterForm !!}
  @endisset

  <div class="mt-4 grid grid-cols-2 gap-2">
    <a href="{{ route('home') }}" class="btn-white-outline">Limpar</a>
    <a href="{{ route('home') }}" class="btn-white">Ver todos</a>
  </div>
</div>
