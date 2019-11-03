@extends('layouts.auth-master')

@section('content')
<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
<div class="card card-success">
    <div class="card-header"><h4>Login</h4></div>
    
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block browser_alert_login">
                <strong>{{$message}}</strong>
            </div>
            @endif
            <div class="form-group">
                <label for="email">CPF</label>
                <input aria-describedby="emailHelpBlock" id="cpf" type="cpf" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" placeholder="Informe seu CPF(Somente números)" tabindex="1" value="{{ old('cpf') }}" autofocus>
                <div class="invalid-feedback">
                    {{ $errors->first('cpf') }}
                </div>
                @if(App::environment('demo'))
                <small id="emailHelpBlock" class="form-text text-muted">
                    Demo Email: admin@example.com
                </small>
                @endif
            </div>
            
            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">Senha</label>
                    <div class="float-right">
                        <a href="{{ route('password.request') }}" class="text-small">
                            Esqueceu sua Senha?
                        </a>
                    </div>
                </div>
                <input aria-describedby="passwordHelpBlock" id="password" type="password" placeholder="Insira sua senha(Mínimo 6 caracteres)" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password" tabindex="2">
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
                @if(App::environment('demo'))
                <small id="passwordHelpBlock" class="form-text text-muted">
                    Demo Password: 1234
                </small>
                @endif
            </div>
            
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember"{{ old('remember') ? ' checked': '' }}>
                    <label class="custom-control-label" for="remember">Continuar conectado</label>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
                    Login
                </button>
            </div>
            <div>
                Ainda não tem conta? <a href="{{ route('register') }}">Você pode se cadastrar!</a>
            </div>
        </form>
    </div>
</div>
<div class="simple-footer">
        Copyright &copy; {{ env('APP_NAME') }} {{ date('Y') }}
    </div>
</div>
@endsection
