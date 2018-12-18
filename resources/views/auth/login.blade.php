@extends('layouts.app')
@section('content')
<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class='step login-step'>
        <div class='title title2'>
            Digite seu CPF e sua senha
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block browser_alert_login">
                <strong>{{$message}}</strong>
            </div>
            @endif
        </div>
        <div class='form-group'>
            <label>
                CPF
                <input id="cpf" placeholder="Informe seu CPF (somente numeros)" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ old('cpf') }}" required autofocus>
                @if ($errors->has('cpf'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('cpf') }}</strong>
                </span>
                @endif
            </label>    
        </div>
        <div class='form-group'>
            <label>
                Senha
                <input id="senha" placeholder="Informe sua senha com no (mínimo 6 caracteres)" type="password" class="form-control{{ $errors->has('senha') ? ' is-invalid' : '' }}" name="senha" required>
                @if ($errors->has('senha'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('senha') }}</strong>
                </span>
                @endif
            </label>
        </div>
        <div class='form-group'>
            <label>
                <input class="" type="checkbox" name="remember_me" id="remember" {{ old('remember') ? 'checked' : '' }}>
                Continuar conectado
            </label>
            <label>
                <a class="forgot" href="{{ route('password.request') }}">Esqueci minha senha</a>
            </label>
        </div>
        <button class="btn btn-success" type='submit' name="login" value="Login">
            {{ __('Entrar') }}
        </button>
        <a class="text-center signup-link" href="{{ route('register') }}">Ainda não tem uma conta? <span>Você pode se cadastrar!</span></a>
    </div>
</form>
@endsection         