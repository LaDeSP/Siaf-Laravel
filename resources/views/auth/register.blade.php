@extends('layouts.app')
@section('content')
<form class="" id="" action="{{ route('register') }}" accept-charset="UTF-8" method="post">
    {{ csrf_field() }}
    <div class='step'>
        <div class='title1'>
            Cadastro
        </div>
        <!-- .title Vamos criar sua conta -->
        <div class='form-group'>
            <label>
            Nome
            <span style="color: red">*</span>
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
            <span style="color: red">*</span>
            <input id="cpf" placeholder="Informe seu CPF (somente numeros)" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ old('cpf') }}" required autofocus>
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
            <input id="email" placeholder="Informe seu email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>
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
            <span style="color: red">*</span>
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
            <span style="color: red">*</span>
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
            <input id="telefone" placeholder="Informe seu telefone" type="text" class="form-control {{ $errors->has('telefone') ? ' is-invalid' : '' }}" name="telefone" value="{{ old('telefone') }}">
            @if ($errors->has('telefone'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('telefone') }}</strong>
            </span>
            @endif
            </label>
        </div>
        <!-- .title Vamos montar a estrutura ideal para sua propriedade -->
        <div class='form-group'>
            <label>
            Nome da sua propriedade
            <span style="color: red">*</span>
            <input class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" type='text' value="{{ old('nome') }}" name="nome" placeholder="Informe o nome da sua propriedade" required>
            @if ($errors->has('nome'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('nome') }}</strong>
            </span>
            @endif
            </label>
        </div>
        <div class='form-group'>
            <label>
            Localização da sua propriedade
            <span style="color: red">*</span>
            <input class="form-control {{ $errors->has('localizacao') ? ' is-invalid' : '' }}" placeholder="Informe a localização da sua propriedade"  name="localizacao" type='text' value="{{ old('localizacao') }}" required>
            @if ($errors->has('localizacao'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('localizacao') }}</strong>
            </span>
            @endif
            </label>
        </div>
        <div class='form-group'>
            <label>
                Estado
                <span style="color: red">*</span>
                <select class="custom-select" name="estados" id="uf" required>
                    <option value="">Selecione o Estado...</option>
                    @foreach ($estados as $estado)
                    <option value={{$estado->id}}>{{ $estado->nome }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        <div class='form-group'>
            <label>
                Cidade
                <span style="color: red">*</span>
                <select class="custom-select {{ $errors->has('cidade') ? ' is-invalid' : '' }}" name="cidade" id="cidade" required>
                    <option value="">Selecione a cidade...</option>
                </select>
                @if ($errors->has('cidade'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cidade') }}</strong>
                </span>
                @endif
            </label>
        </div>
        <button class=' btn btn-success' id='submit-form' type='submit'>
        Salvar
        </button>
        <a class="text-center signup-link" href="{{ route('login') }}">Já tem conta no SIAF? Você pode fazer login!</a>
    </div>
</form>
<script type="text/javascript">
    $('select[name=estados]').change(function () {
        var idEstado = $(this).val();
        $.get('/siaf/public/cidades/' + idEstado, function (cidades) {
            $('select[name=cidade]').empty();
            $.each(cidades, function (key, value) {
                $('select[name=cidade]').append('<option value=' + value.id + '>' + value.nome + '</option>');
            });
        });
    });
</script>
@endsection
