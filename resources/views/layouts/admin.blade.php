<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin • CarStore')</title>
  <meta name="color-scheme" content="light only">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen text-gray-900 font-sans">
  {{-- Topbar --}}
  <header class="border-b bg-white/70 backdrop-blur">
    <div class="container flex items-center justify-between py-4">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
        {{-- LOGO (mesma do site) --}}
        <div class="h-10 w-10 rounded-xl grid place-content-center bg-brand-700 shadow-soft">
          <svg viewBox="0 0 64 32" class="h-7 w-7" aria-label="CarStore">
            <linearGradient id="lg-admin" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#ffffff"/>
              <stop offset="100%" stop-color="#e5ecff"/>
            </linearGradient>
            <path fill="url(#lg-admin)" d="M6 21c5-6 16-10 28-10 8 0 15 2 20 5 3 2 5 4 6 5 1 1 0 2-1 2h-5a5 5 0 0 0-10 0H22a5 5 0 0 0-10 0H7c-2 0-3-1-1-2zM12 23a3 3 0 1 1 0 .01V23zm32 0a3 3 0 1 1 0 .01V23z"/>
            <path fill="#c7d2ff" d="M12 16c6-4 17-7 28-7 3 0 7 .3 10 1-7-4-15-6-23-5C20 6 14 10 12 16z" opacity=".7"/>
          </svg>
        </div>
        <span class="font-extrabold text-lg tracking-tight text-brand-800 group-hover:text-brand-700 transition">
          CarStore <span class="text-gray-400">•</span> <span class="text-gray-700">Admin</span>
        </span>
      </a>

      <nav class="flex items-center gap-2">
        <a href="{{ route('home') }}" class="btn-ghost">Ver Catálogo</a>
        <a href="{{ route('admin.vehicles.index') }}" class="btn-primary">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button class="btn-outline">Sair</button>
        </form>
      </nav>
    </div>
  </header>

  <main class="container py-6">
    @if (session('success'))
      <div class="mb-4 rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-green-800">
        {{ session('success') }}
      </div>
    @endif

    {{-- título da página (opcional) --}}
    @hasSection('title')
      <div class="mb-4">
        <h1 class="text-2xl font-extrabold text-brand-900">@yield('title')</h1>
      </div>
    @endif

    {{-- SHELL FLEX: sidebar fixa + conteúdo --}}
    <div class="admin-shell">
      <aside class="admin-sidebar">
        <div class="admin-sidebar__header">
          <div class="admin-sidebar__title">Administração</div>
          <div class="admin-sidebar__sub">Gerencie marcas, modelos, cores e veículos.</div>
        </div>

        <div class="admin-sidebar__scroll">
          @include('partials.admin.sidebar')
        </div>

        <div class="admin-quick">
          <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('admin.vehicles.create') }}" class="btn-white">Novo veículo</a>
            <a href="{{ route('admin.brands.create') }}" class="btn-white-outline">Nova marca</a>
          </div>
        </div>
      </aside>

      <section class="flex-1 min-w-0">
        @yield('admin-content')
      </section>
    </div>
  </main>

  <footer class="border-t">
    <div class="container py-6 text-center text-sm text-gray-600">
      &copy; {{ date('Y') }} CarStore — Painel Administrativo
    </div>
  </footer>
</body>
</html>
