<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta content='width=device-width, initial-scale=1' name='viewport'>
      <link rel="icon" href="/images/favicon.png">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link href="/css/login.css" rel="stylesheet">
      <script src="/js/JQuery/jquery-2.2.4.min.js"></script>
      <script src="/js/validator/jQuery.mask1.14.11.min.js"></script>
      <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <title>SIAF</title>
      <script type="text/javascript">
         //$('#cpf').mask('000.000.000-00');
      </script>
   </head>
   <body class="cn-site">
      <div class="banner-sec img-fluid" alt="Responsive image">
      </div>
      <div class='box-right'>
         <div class='bar'>
            <div class='switcher'>
               <a class='active' href="{{ route('login') }}">{{ __('Login') }}</a>
               <a href="{{ route('register') }}">{{ __('Cadastro') }}</a>
            </div>
         </div>
         <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class='step login-step'>
               <div class='title'>
                  Digite seu cpf e sua senha
                  @if ($message = Session::get('error'))
                  <div class="alert alert-danger alert-block browser_alert_login">
                     <strong>{{$message}}</strong>
                  </div>
                  @endif
               </div>
               <div class='form-group'>
                  <label>
                  CPF
                  <input class="form-control" id="cpf" type="text" name="cpf" value="{{ old('cpf') }}" required autofocus>
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  Senha
                  <input class="form-control" id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                  </label>
               </div>
               <div class='form-group'>
                  <label class='pull-left'>
                  <input class="form-check-input" type="checkbox" name="remember_me" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  Continuar conectado
                  </label>
                  <label class='pull-right'>
                  <a class="forgot" href="{{ route('password.request') }}">Esqueci minha senha</a>
                  </label>
               </div>
               <button type='submit' name="login" value="Login">
               {{ __('Entrar') }}
               </button>
               <a class="text-center signup-link" href="{{ route('register') }}">Ainda não tem uma conta? <span>Você pode se cadastrar!</span></a>
         </form>
         </div>
      </div>
   </body>
</html>