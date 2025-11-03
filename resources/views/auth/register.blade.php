@extends('layouts.auth')
@section('title', 'Criar conta • CarStore')

{{-- HERO --}}
@section('hero')
  <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between text-white">
    <div>
      <h1 class="text-2xl md:text-3xl font-extrabold">Crie sua conta</h1>
      <p class="text-white/80 text-sm md:text-base">Cadastre-se para gerenciar anúncios e acessar o painel.</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('home') }}" class="btn-white">Voltar ao Catálogo</a>
      <a href="{{ route('login') }}" class="btn-white-outline">Já tenho conta</a>
    </div>
  </div>
@endsection

@section('content')
  <div class="mx-auto max-w-md">
    {{-- Erros/Status --}}
    @if ($errors->any())
      <div class="mb-4 rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-red-800">
        <div class="font-semibold mb-1">Ops! Revise os campos:</div>
        <ul class="list-disc ml-5 text-sm">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="glass-card">
      <div class="mb-5 flex items-center gap-3">
        <div class="h-10 w-10 rounded-xl grid place-content-center bg-brand-700 shadow-soft">
          <svg viewBox="0 0 64 32" class="h-7 w-7" aria-label="CarStore">
            <linearGradient id="lg-register" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#ffffff"/>
              <stop offset="100%" stop-color="#e5ecff"/>
            </linearGradient>
            <path fill="url(#lg-register)" d="M6 21c5-6 16-10 28-10 8 0 15 2 20 5 3 2 5 4 6 5 1 1 0 2-1 2h-5a5 5 0 0 0-10 0H22a5 5 0 0 0-10 0H7c-2 0-3-1-1-2zM12 23a3 3 0 1 1 0 .01V23zm32 0a3 3 0 1 1 0 .01V23z"/>
            <path fill="#c7d2ff" d="M12 16c6-4 17-7 28-7 3 0 7 .3 10 1-7-4-15-6-23-5C20 6 14 10 12 16z" opacity=".7"/>
          </svg>
        </div>
        <div>
          <div class="text-sm text-gray-600">Cadastro</div>
          <div class="text-lg font-extrabold text-brand-900">Criar conta</div>
        </div>
      </div>

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
          <label for="name" class="label">Nome completo</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="input">
        </div>

        <div>
          <label for="email" class="label">E-mail</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="input">
        </div>

        <div>
          <label for="password" class="label">Senha</label>
          <div class="relative">
            <input id="password" type="password" name="password" required autocomplete="new-password" class="input pr-10">
            <button type="button" id="togglePass" class="absolute inset-y-0 right-2 my-auto text-gray-500 hover:text-gray-700" aria-label="Mostrar senha">
              👁️
            </button>
          </div>
          {{-- Barra de força da senha --}}
          <div class="mt-2 h-2 w-full rounded-full bg-gray-200 overflow-hidden">
            <div id="pwdStrength" class="h-full w-0 bg-red-500 transition-all"></div>
          </div>
          <div id="pwdHint" class="mt-1 text-xs text-gray-500">Use ao menos 8 caracteres, incluindo letra e número.</div>
        </div>

        <div>
          <label for="password_confirmation" class="label">Confirmar senha</label>
          <div class="relative">
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="input pr-10">
            <button type="button" id="togglePass2" class="absolute inset-y-0 right-2 my-auto text-gray-500 hover:text-gray-700" aria-label="Mostrar senha">
              👁️
            </button>
          </div>
        </div>

        {{-- Caso use Terms do Breeze/Jetstream, descomente abaixo e ajuste a rota/política
        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
          <input type="checkbox" name="terms" required class="rounded border-gray-300">
          Aceito os <a href="#" class="text-brand-700 hover:underline">termos de uso</a>
        </label>
        --}}

        <button class="btn-primary w-full">Criar conta</button>

        <div class="text-center text-sm text-gray-600">
          Já tem conta?
          <a href="{{ route('login') }}" class="text-brand-700 font-semibold hover:underline">Entrar</a>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  // Mostrar/ocultar senhas
  function bindToggle(btnId, inputId) {
    const btn = document.getElementById(btnId);
    const input = document.getElementById(inputId);
    if (!btn || !input) return;
    btn.addEventListener('click', () => {
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  }
  bindToggle('togglePass', 'password');
  bindToggle('togglePass2', 'password_confirmation');

  // Força da senha (muito simples, só para feedback visual)
  const pwd = document.getElementById('password');
  const bar = document.getElementById('pwdStrength');
  const hint = document.getElementById('pwdHint');
  if (pwd && bar) {
    pwd.addEventListener('input', () => {
      const val = pwd.value || '';
      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[a-z]/.test(val)) score++;
      if (/\d/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;

      const map = [
        { w: '10%',  c: '#ef4444', t: 'Senha muito fraca' },
        { w: '30%',  c: '#f97316', t: 'Senha fraca' },
        { w: '55%',  c: '#f59e0b', t: 'Senha razoável' },
        { w: '80%',  c: '#22c55e', t: 'Senha boa' },
        { w: '100%', c: '#16a34a', t: 'Senha forte' },
      ];
      const level = map[Math.max(0, Math.min(score-1, map.length-1))];
      bar.style.width = level.w;
      bar.style.backgroundColor = level.c;
      if (hint) hint.textContent = level.t;
    });
  }
</script>
@endpush
