@php
  function adminLink(string $label, string $routeName, string $svg) {
      $active = request()->routeIs($routeName . '*');
      $cls = 'admin-link' . ($active ? ' admin-link--active' : '');
      $url = route($routeName);
      return <<<HTML
        <a href="{$url}" class="{$cls}">
          <span class="admin-icon">{$svg}</span>
          <span>{$label}</span>
        </a>
      HTML;
  }

  $icDashboard = '<svg viewBox="0 0 24 24" fill="none" class="h-5 w-5"><path d="M3 12h18M3 12a9 9 0 1 1 18 0M7 12v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  $icCar       = '<svg viewBox="0 0 24 24" fill="none" class="h-5 w-5"><path d="M3 13l2-5a2 2 0 0 1 2-1h10a2 2 0 0 1 2 1l2 5M5 18h2m8 0h2M6 18a2 2 0 1 1 0-4 2 2 0 0 1 0 4Zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  $icTag       = '<svg viewBox="0 0 24 24" fill="none" class="h-5 w-5"><path d="M20 12l-8 8-8-8V4h8l8 8Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="9" r="1.5" fill="currentColor"/></svg>';
  $icPuzzle    = '<svg viewBox="0 0 24 24" fill="none" class="h-5 w-5"><path d="M11 3a2 2 0 1 1 2 2h3v3a2 2 0 1 1 0 4v3h-3a2 2 0 1 1-4 0H6v-3a2 2 0 1 1 0-4V5h3a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  $icPalette   = '<svg viewBox="0 0 24 24" fill="none" class="h-5 w-5"><path d="M12 3a9 9 0 0 0-9 9 6 6 0 0 0 6 6h2a2 2 0 0 1 2 2 3 3 0 0 0 3-3v-1a2 2 0 0 1 2-2h1a4 4 0 0 0 0-8A9 9 0 0 0 12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
@endphp

{{-- GRUPO: Início --}}
<div class="admin-group-title">Início</div>
{!! adminLink('Dashboard', 'admin.vehicles.index', $icDashboard) !!}

{{-- GRUPO: Cadastros --}}
<div class="admin-group-title">Cadastros</div>
{!! adminLink('Veículos',  'admin.vehicles.index', $icCar) !!}
{!! adminLink('Marcas',    'admin.brands.index',  $icTag) !!}
{!! adminLink('Modelos',   'admin.models.index',  $icPuzzle) !!}
{!! adminLink('Cores',     'admin.colors.index',  $icPalette) !!}
