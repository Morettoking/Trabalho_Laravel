@extends('layouts.site')

@section('title', 'Recuperar senha')

@section('content')
  <div class="max-w-md mx-auto card">
    <h1 class="text-2xl font-extrabold mb-4">Esqueceu sua senha?</h1>
    <p class="text-sm text-gray-600 mb-4">
      Informe seu e-mail e enviaremos um link para redefinição de senha.
    </p>

    @if (session('status'))
      <div class="mb-4 rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-green-800">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
      @csrf
      <div>
        <label class="label" for="email">E-mail</label>
        <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus />
        @error('email') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div class="flex items-center gap-2 pt-2">
        <button type="submit" class="btn btn-primary">Enviar link</button>
        <a class="btn btn-outline" href="{{ route('login') }}">Voltar</a>
      </div>
    </form>
  </div>
@endsection
