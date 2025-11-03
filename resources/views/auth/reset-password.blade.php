@extends('layouts.site')

@section('title', 'Redefinir senha')

@section('content')
  <div class="max-w-md mx-auto card">
    <h1 class="text-2xl font-extrabold mb-4">Redefinir senha</h1>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
      @csrf

      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <div>
        <label class="label" for="email">E-mail</label>
        <input id="email" class="input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus />
        @error('email') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="label" for="password">Nova senha</label>
        <input id="password" class="input" type="password" name="password" required />
        @error('password') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="label" for="password_confirmation">Confirmar senha</label>
        <input id="password_confirmation" class="input" type="password" name="password_confirmation" required />
      </div>

      <div class="flex items-center gap-2 pt-2">
        <button type="submit" class="btn btn-primary">Redefinir</button>
        <a class="btn btn-outline" href="{{ route('login') }}">Cancelar</a>
      </div>
    </form>
  </div>
@endsection
