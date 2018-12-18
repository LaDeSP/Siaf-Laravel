<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="/images/favicon.png">
        <title>SIAF</title>
        <!-- Scripts -->
        <script src="/js/JQuery/jquery-2.2.4.min.js"></script>
        <script src="/js/validator/jQuery.mask1.14.11.min.js"></script>
        <!-- Styles -->
        <link href="/css/login.css" rel="stylesheet">
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: blue;
   color: white;
   text-align: center;
}
</style>
        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                ]) !!};
        </script> 
        <script type="text/javascript">
            $("#telefone, #celular").mask("(00)00000-0000");
            $('#cpf').mask('000.000.000-00');
        </script>
    </head>
    <body class='new cn-sessions ' mobile=''>
    <div class='box-left'>
         <a class='logo_sign' href='/'>
         <img height="40" src="/images/log.png" alt="Logo" />
         </a>
         <div class='testimonials'>
            <ul></ul>
         </div>
      </div>
        
        <div class='box-right'>
            <div class='bar'>
                <!--<div class='switcher'>
                    @if(Request::segment(1) == 'login')
                    <a class='btn btn-success' href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a class="active btn btn-light" href="{{ route('register') }}">{{ __('Cadastro') }}</a>
                    @elseif(Request::segment(1) == 'register')
                    <a class="active btn btn-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a class='btn btn-success' href="{{ route('register') }}">{{ __('Cadastro') }}</a>
                    @endif
                </div>
            -->
            </div>
            @yield('content')
            <div class="push"></div>
        </div>
        <div class="footer">
                <p>Footer</p>
              </div>
    </body>
</html>