@extends('layouts.site')

@section('title', 'Verificar e-mail')

@section('content')
  <div class="max-w-md mx-auto card">
    <h1 class="text-2xl font-extrabold mb-4">Verifique seu e-mail</h1>
    <p class="text-sm text-gray-600">
      Enviamos um link de verificação para <strong>{{ auth()->user()->email }}</strong>.
      Se você não recebeu, envie novamente.
    </p>

    @if (session('status') == 'verification-link-sent')
      <div class="my-4 rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-green-800">
        Um novo link de verificação foi enviado para seu e-mail.
      </div>
    @endif

    <div class="mt-4 flex items-center gap-2">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-primary" type="submit">Reenviar e-mail</button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline">Sair</button>
      </form>
    </div>
  </div>
@endsection
