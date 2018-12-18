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
            background-color: #4c4c4c;
            color: white;
            text-align: center;
            height: 40px;
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
    <body class='new cn-sessions'>
            <div class='box-left'>
                    <div style="font:20px; height: 450px;">
                        <p class="text-center">Lorem Ipsum isdcd,,,,,,,,,,,,,,,,,,,, simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
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
        <p>Todos os direitos reservados. Universidade Federal de Mato Grosso do Sul. Copyright © 2018 - Corumbá/MS <img class="col-1" src="images/Logo_menor.png"></p>
    </div>
</body>
</html>