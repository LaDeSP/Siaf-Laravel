
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
  <title>SIAF</title>
</head>

<body class='self_registration cn-site ' mobile=''>
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
          <div class='form-group no-error'>
            <label>
              Nome
              <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
              
              @if ($errors->has('name'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
              <i class='validate icon-check'></i>
            </label>
          </div>
          <div class='form-group no-error'>
            <label>
              Cpf
              <input id="cpf" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ old('cpf') }}" required autofocus>
              
              @if ($errors->has('cpf'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cpf') }}</strong>
              </span>
              @endif
            </label>
          </div>
          <div class='form-group no-error'>
            <label>
              Email
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
              
              @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
              <i class='validate icon-check'></i>
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
              <i class='validate'></i>
            </label>
          </div>
          
          <div class='form-group'>
            <label>
              Confirme a senha
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
              <i class='validate'></i>
            </label>
          </div>
          <div class='form-group'>
            <label>
              Telefone
              <input placeholder="Informe seu telefone" type="tel" />
              <i class='validate'></i>
            </label>
          </div>
          
          <!-- .title Vamos montar a estrutura ideal para sua empresa -->
          <div class='form-group'>
            <label>
              Nome da sua propriedade
              <input type='text' value=''>
              <i class='validate'></i>
            </label>
          </div>
          <div class='form-group'>
            <label>
              Localização da sua propriedade
              <input type='text' value=''>
              <i class='validate'></i>
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
              <i class='validate'></i>
            </label>
          </div>
          
          <div class='form-group'>
            <label>
              Cidade
              <select name="cidadess" id="cidade">
                <option value="">Escolha...</option>
              </select>
              <i class='validate'></i>
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
  
  