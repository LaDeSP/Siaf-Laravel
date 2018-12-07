<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <link rel="icon" href="/images/favicon.png">
      <meta charset='UTF-8'>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link href="/css/login.css" rel="stylesheet">
      <script src="/js/JQuery/jquery-2.2.4.min.js"></script>
      <script src="/js/validator/jQuery.mask1.14.11.min.js"></script>
      <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <title>SIAF</title>
      <script type="text/javascript">
         $("#telefone, #celular").mask("(00) 00000-0000");
         //$('#cpf').mask('000.000.000-00');
      </script>
   </head>
   <body class='self_registration cn-site'>
      <div class='box-left'>
      <div class="banner-sec img-fluid" alt="Responsive image">
      </div>
      <div class='box-right'>
         <div class='bar'>
            <div class='switcher'>
               <a  href="{{ route('login') }}">{{ __('Login') }}</a>
               <a class='active' href="{{ route('register') }}">{{ __('Cadastro') }}</a>
            </div>
         </div>
         <form class="" id="" action="{{ route('register') }}" accept-charset="UTF-8" method="post">
            @csrf
            <div class='step step1 current-step' data-step='1'>
               <!-- .title Vamos criar sua conta -->        
               <div class='form-group'>
                  <label>
                  Nome
                  <input id="name" placeholder="Informe seu nome" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                  @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  CPF
                  <input id="cpf" placeholder="Informe seu CPF no formato xxx.xxx.xxx-xx" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ old('cpf') }}" required autofocus>
                  @if ($errors->has('cpf'))
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('cpf') }}</strong>
                  </span>
                  @endif
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  Email
                  <input id="email" placeholder="Informe seu email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
                  <input id="senha" placeholder="Informe sua senha com no (mínimo 6 caracteres)" type="password" class="form-control{{ $errors->has('senha') ? ' is-invalid' : '' }}" name="senha" required>
                  @if ($errors->has('senha'))
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('senha') }}</strong>
                  </span>
                  @endif
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  Confirme a senha
                  <input id="confirme_senha" placeholder="Confirme a senha fornecida" type="password" class="form-control {{ $errors->has('confirme_senha') ? ' is-invalid' : '' }}" name="confirme_senha" required>
                  @if ($errors->has('confirme_senha'))
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('confirme_senha') }}</strong>
                  </span>
                  @endif
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  Telefone
                  <input placeholder="Informe seu telefone" type="tel" id="telefone" name="telefone"/>
                  </label>
               </div>
               <!-- .title Vamos montar a estrutura ideal para sua propriedade -->
               <div class='form-group'>
                  <label>
                  Nome da sua propriedade
                  <input type='text' value=''>
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                  Localização da sua propriedade
                  <input type='text' value=''>
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                     Estado
                     <select name="estados" id="uf">
                        <option value="">Escolha...</option>
                        @foreach ($estados as $estado)
                        <option value={{$estado->id}}>{{ $estado->nome }}</option>
                        @endforeach
                     </select>
                  </label>
               </div>
               <div class='form-group'>
                  <label>
                     Cidade
                     <select name="cidadess" id="cidade">
                        <option value="">Escolha...</option>
                     </select>
                  </label>
               </div>
               <button id='submit-form' type='submit'>
               Crie meu usuário
               </button>
               <a class="text-center signup-link" href="{{ route('login') }}">Já tem conta no Siaf? <span>Você pode fazer login!</span></a>
            </div>
         </form>
         <script type="text/javascript">
            $('select[name=estados]').change(function () {
              var idEstado = $(this).val();
              $.get('/cidades/' + idEstado, function (cidades) {
                $('select[name=cidadess]').empty();
                $.each(cidades, function (key, value) {
                  $('select[name=cidadess]').append('<option value=' + value.id + '>' + value.nome + '</option>');
                });
              });
            });
         </script>
      </div>
   </body>
</html>