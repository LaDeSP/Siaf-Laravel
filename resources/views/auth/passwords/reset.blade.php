<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <link rel="icon" href="/images/favicon.png">
      <meta charset='UTF-8'>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link href="/css/login.css" rel="stylesheet">
      <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <title>SIAF</title>
   </head>
   <body class='self_registration cn-site'>
      <div class='box-left'>
      <div class="banner-sec img-fluid" alt="Responsive image">
      </div>
      <div class='box-right'>
         <form class="" id="" action="{{ route('password.update') }}" accept-charset="UTF-8" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class='step step1 current-step' data-step='1'>
               <div class='title'>
                  Redefinição de senha
               </div>
               <div class='form-group'>
                  <label>
                  Email
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  Senha
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                  @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  Confirme a senha
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                  </label>
               </div>
               <button class='active btn btn-success' id='submit-form' type='submit'>
               Redefinir Senha
               </button>
            </div>
         </form>
      </div>
   </body>
</html>