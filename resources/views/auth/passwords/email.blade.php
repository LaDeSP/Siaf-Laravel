@extends('layouts.auth-master')

@section('content')
<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
    <div class="card card-success">
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
        <div class="mt-2 text-muted text-center">
            Relembrou sua senha? <a href="{{ route('login') }}">Entre aqui!</a>
        </div>
    </div>
</div>
@endsection
