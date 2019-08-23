@extends('layouts.auth-master')

@section('content')
<head>
  <style>
  body  {
    background-image: url('assets/img/fundo.jpg');
  }
  </style>
</head>

<div class="card">
  <div class="card-header"><h4>Resetar Senha</h4></div>

  <div class="card-body">
    <form method="POST" action="{{ route('password.email') }}">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" tabindex="1" value="{{ old('email') }}" autofocus>
        <div class="invalid-feedback">
          {{ $errors->first('email') }}
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
          Enviar pedido
        </button>
      </div>
    </form>
  </div>
</div>
<div class="mt-5 text-muted text-center">
  Relembrou sua senha? <a href="{{ route('login') }}">Entre aqui!</a>
</div>
@endsection
