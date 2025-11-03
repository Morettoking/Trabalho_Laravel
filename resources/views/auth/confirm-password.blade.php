@extends('layouts.site')

@section('title', 'Confirmar senha')

@section('content')
  <div class="max-w-md mx-auto card">
    <h1 class="text-2xl font-extrabold mb-4">Confirmar senha</h1>
    <p class="text-sm text-gray-600 mb-4">
      Por segurança, confirme sua senha para continuar.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
      @csrf

      <div>
        <label class="label" for="password">Senha</label>
        <input id="password" class="input" type="password" name="password" required autocomplete="current-password" />
        @error('password') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div class="flex items-center gap-2 pt-2">
        <button type="submit" class="btn btn-primary">Confirmar</button>
        <a class="btn btn-outline" href="{{ route('login') }}">Cancelar</a>
      </div>
    </form>
  </div>
@endsection
