@extends('layouts.app')
@section('content')
<form action="{{ route('password.email') }}" method="POST">
    {{ csrf_field() }}
    <div class='step login-step'>
        <div class='title title2'>
            Recuperação de senha
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
        </div>
        <div class='form-group'>
            <label>
            Email
            <input placeholder="Informe seu email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
            <small id="emailHelp" class="form-text text-muted">Você receberá um link de recuperação de senha. Clique e siga as intruções para cadastro de nova senha.</small>
            </label>
        </div>
        <button class='btn btn-success' type='submit' name="login" value="Login">
        {{ __('Enviar o link') }}
        </button>
        <a class="text-center signup-link" href="{{ route('login') }}">Se preferir você pode voltar para a tela de login!</a>
    </div>
</form>
@endsection