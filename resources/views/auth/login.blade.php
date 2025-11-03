@extends('layouts.auth')
@section('title', 'Entrar • CarStore')

{{-- hero curto com mensagem de boas-vindas --}}
@section('hero')
  <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between text-white">
    <div>
      <h1 class="text-2xl md:text-3xl font-extrabold">Bem-vindo ao painel</h1>
      <p class="text-white/80 text-sm md:text-base">Faça login para gerenciar veículos, marcas, modelos e cores.</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('home') }}" class="btn-white">Ver Catálogo</a>
    </div>
  </div>
@endsection

@section('content')
  <div class="mx-auto max-w-md">
    {{-- Mensagens de status/erro --}}
    @if (session('status'))
      <div class="mb-4 rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-green-800">
        {{ session('status') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="mb-4 rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-red-800">
        <div class="font-semibold mb-1">Ops! Verifique os campos:</div>
        <ul class="list-disc ml-5 text-sm">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Card do formulário --}}
    <div class="glass-card">
      <div class="mb-5 flex items-center gap-3">
        <div class="h-10 w-10 rounded-xl grid place-content-center bg-brand-700 shadow-soft">
          <svg viewBox="0 0 64 32" class="h-7 w-7" aria-label="CarStore">
            <linearGradient id="lg-login" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#ffffff"/>
              <stop offset="100%" stop-color="#e5ecff"/>
            </linearGradient>
            <path fill="url(#lg-login)" d="M6 21c5-6 16-10 28-10 8 0 15 2 20 5 3 2 5 4 6 5 1 1 0 2-1 2h-5a5 5 0 0 0-10 0H22a5 5 0 0 0-10 0H7c-2 0-3-1-1-2zM12 23a3 3 0 1 1 0 .01V23zm32 0a3 3 0 1 1 0 .01V23z"/>
            <path fill="#c7d2ff" d="M12 16c6-4 17-7 28-7 3 0 7 .3 10 1-7-4-15-6-23-5C20 6 14 10 12 16z" opacity=".7"/>
          </svg>
        </div>
        <div>
          <div class="text-sm text-gray-600">Acesso administrativo</div>
          <div class="text-lg font-extrabold text-brand-900">Entrar</div>
        </div>
      </div>

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label for="email" class="label">E-mail</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="input">
        </div>

        <div>
          <label for="password" class="label">Senha</label>
          <input id="password" type="password" name="password" required autocomplete="current-password" class="input">
        </div>

        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="remember" class="rounded border-gray-300">
            Lembrar-me
          </label>

          @if (Route::has('password.request'))
            <a class="text-sm text-brand-700 hover:underline" href="{{ route('password.request') }}">
              Esqueci minha senha
            </a>
          @endif
        </div>

        <button class="btn-primary w-full">Entrar</button>
      </form>

      @if (Route::has('register'))
        <div class="mt-4 text-center text-sm text-gray-600">
          Não tem conta?
          <a href="{{ route('register') }}" class="text-brand-700 font-semibold hover:underline">Criar agora</a>
        </div>
      @endif
    </div>

    {{-- Dica de acesso para o professor/correção --}}
    <div class="mt-4 text-center text-xs text-gray-600">
      Acesso demo: <span class="font-semibold">admin@carstore.test</span> / <span class="font-semibold">password</span>
    </div>
  </div>
@endsection
