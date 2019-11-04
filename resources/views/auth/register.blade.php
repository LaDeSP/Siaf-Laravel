@extends('layouts.auth-master')
@section('content')
<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
    <div class="card card-success">
        <div class="card-body">
            <div class="text-center">
                <h4>Cadastro</h4>
                @if(session()->has('danger'))
                <div class="alert alert-danger alert-dismissible show fade col-10">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ session('danger') }}
                    </div>
                </div>
                @endif
            </div>
            <p class="section-lead m-0">Campos marcados com (<b><span class="text-danger">*</span></b>) são obrigatórios!</p>
            <form method="POST" action="{{ route('register') }}" accept-charset="UTF-8" class="needs-validation" novalidate="">
                {{ csrf_field() }}
                <div class="form-divider">
                    Suas Informações
                </div>
                <div class="row">
                    <div class="form-group col-12 col-sm-6">
                        <label for="nome">Nome <span style="color: red">*</span></label>
                        <input id="name" placeholder="Informe seu nome" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        <div class="invalid-feedback">
                            Nome é obrigatório!
                        </div>
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group col-12 col-sm-6">
                        <label for="cpf">CPF <span style="color: red">*</span></label>
                        <input id="cpf" placeholder="Informe seu CPF (somente numeros)" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ old('cpf') }}" required autofocus>
                        <div class="invalid-feedback">
                            CPF é obrigatório!
                        </div>
                        @if ($errors->has('cpf'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cpf') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-sm-6">
                        <label for="email">Email</label>
                        <input id="email" placeholder="Informe seu email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>
                        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group col-12 col-sm-6">
                        <label for="telefone">Telefone</label>
                        <input id="telefone" placeholder="Informe seu telefone" type="text" class="form-control {{ $errors->has('telefone') ? ' is-invalid' : '' }}" name="telefone" value="{{ old('telefone') }}">
                        @if ($errors->has('telefone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('telefone') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-sm-6">
                        <label for="password" class="d-block">Senha <span style="color: red">*</span></label>
                        <input id="password" placeholder="Senha com no (mínimo 6 caracteres)"  type="password" class="form-control pwstrength {{ $errors->has('senha') ? ' is-invalid' : '' }}" data-indicator="pwindicator" name="senha" required> 
                        <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                        <div class="invalid-feedback">
                            Senha é obrigatório!
                        </div>
                        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group col-12 col-sm-6">
                        <label for="confirme_senha" class="d-block">Confirme a senha <span style="color: red">*</span></label>
                        <input id="confirme_senha" placeholder="Confirme a senha fornecida" type="password" class="form-control {{ $errors->has('confirme_senha') ? ' is-invalid' : '' }}" name="confirme_senha" required>
                        <div class="invalid-feedback">
                            Confirmar a senha é obrigatório!
                        </div>
                        @if ($errors->has('confirme_senha'))
                        <div class="invalid-feedback">
                            {{ $errors->first('confirme_senha') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-divider">
                    Informações da Propriedade
                </div>
                <div class="row">
                    <div class="form-group col-12 col-sm-6">
                        <label for="propriedade_nome">Nome da propriedade <span style="color: red">*</span></label>
                        <input class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" type='text' value="{{ old('nome') }}" name="nome" placeholder="Informe o nome da sua propriedade" required>
                        <div class="invalid-feedback">
                            Nome da propriedade é obrigatório!
                        </div>
                        @if ($errors->has('nome'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nome') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group col-12 col-sm-6">
                        <label for="last_name">Endereço <span style="color: red">*</span></label>
                        <input class="form-control {{ $errors->has('localizacao') ? ' is-invalid' : '' }}" placeholder="Localização da sua propriedade" name="localizacao" type='text' value="{{ old('localizacao') }}" required>
                        <div class="invalid-feedback">
                            Endereço da propriedade é obrigatório!
                        </div>
                        @if ($errors->has('localizacao'))
                        <div class="invalid-feedback">
                            {{ $errors->first('localizacao') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label>Estado <span style="color: red">*</span></label>
                        <select class="custom-select" name="estados" id="uf" required>
                            <option value="">Selecione o Estado...</option>
                            @foreach ($estados as $estado)
                            <option value={{$estado->id}}>{{ $estado->nome }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Estado é obrigatório!
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label>Cidade <span style="color: red">*</span></label>
                        <select class="custom-select {{ $errors->has('cidade') ? ' is-invalid' : '' }}" name="cidade" id="cidade" required>
                            <option value="">Selecione a cidade...</option>
                        </select>
                        <div class="invalid-feedback">
                            Cidade é obrigatório!
                        </div>
                        @if ($errors->has('cidade'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('cidade') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block">
                        Cadastrar
                    </button>
                </div>
            </form>
            <div class="text-center">
                Já tem conta no SIAF? <a href="{{ route('login') }}">Você pode fazer login!</a>
            </div>
        </div>
    </div>
    <div class="simple-footer">
        Copyright &copy; {{ env('APP_NAME') }} {{ date('Y') }}
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('select[name=estados]').change(function () {
        var idEstado = $(this).val();
        $.get('/cidades/' + idEstado, function (cidades) {
            $('select[name=cidade]').empty();
            $.each(cidades, function (key, value) {
                $('select[name=cidade]').append('<option value=' + value.id + '>' + value.nome + '</option>');
            });
        });
    });
</script>
@endpush
