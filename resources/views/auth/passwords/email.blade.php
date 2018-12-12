<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta content='width=device-width, initial-scale=1' name='viewport'>
      <link rel="icon" href="/images/favicon.png">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link href="/css/login.css" rel="stylesheet">
      <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <title>SIAF</title>
   </head>
   <body class="cn-site">
      <div class="banner-sec img-fluid" alt="Responsive image">
      </div>
      <div class='box-right'>
         <div class='bar'>
            <div class='switcher'>
               <a class="active btn btn-light" href="{{ route('login') }}">{{ __('Login') }}</a>
               <a class="active btn btn-light" href="{{ route('register') }}">{{ __('Cadastro') }}</a>
            </div>
         </div>
         <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class='step login-step'>
               <div class='title'>
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
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                  @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
                  </label>
               </div>
               <button class='btn btn-success' type='submit' name="login" value="Login">
               {{ __('Enviar o link') }}
               </button>
         </form>
         </div>
      </div>
   </body>
</html>