@extends('layouts.auth-master')

@section('content')
<head>
  <style>
  body  {
    background-image: url('assets/img/fundo.jpg');
    background-color: #cccccc;
  }
  </style>
  </head>
  
<div class="card">
  <div class="card-header"><h4>Registre-se</h4></div>
  <div class="card-body">
    <form method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}
        <div class="form-group">
          <label for="name">Nome</label>
          <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" tabindex="1" placeholder="Nome Completo" value="{{ old('name') }}" autofocus>
          <div class="invalid-feedback">
            {{ $errors->first('name') }}
          </div>
        </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email address" name="email" tabindex="1" value="{{ old('email') }}" autofocus>
        <div class="invalid-feedback">
          {{ $errors->first('email') }}
        </div>
      </div>

      <div class="form-group">
        <label for="password" class="control-label">Senha</label>
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" placeholder="Set account password" name="password" tabindex="2">
        <div class="invalid-feedback">
          {{ $errors->first('password') }}
        </div>
      </div>

      <div class="form-group">
        <label for="password_confirmation" class="control-label">Confirmar Senha</label>
        <input id="password_confirmation" type="password" placeholder="Confirmar senha" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}" name="password_confirmation" tabindex="2">
        <div class="invalid-feedback">
          {{ $errors->first('password_confirmation') }}
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
          Salvar
        </button>
      </div>
      Já tem conta no SIAF? <a href="{{ route('login') }}">Você pode fazer login!</a>
    </div>
  </form>
</div>
@endsection
