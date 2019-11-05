@extends('layouts.admin-master')

@section('title')
Editar Perfil ({{ $user->name }})
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Editar Perfil</h1>
    </div>
    <div class="section-body">
        <div class="row d-flex justify-content-center">
            @if(session()->has('info'))
            <div class="alert alert-info alert-dismissible show fade col-10">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session('info') }}
                </div>
            </div>
            @elseif(session()->has('danger'))
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="section-lead m-0">Campos marcados com (<b><span class="text-danger">*</span></b>) são obrigatórios!</p>
                        <form method="POST" action="{{ route('painel.perfil', ['user'=>$user]) }}" accept-charset="UTF-8" class="needs-validation" novalidate="">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-divider">
                                Suas Informações
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-sm-6">
                                    <label for="nome">Nome <span style="color: red">*</span></label>
                                    <input id="name" placeholder="Informe seu nome" type="text" value="{{$user->name}}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
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
                                    <input id="cpf" placeholder="Informe seu CPF (somente numeros)" type="text" value="{{$user->cpf}}" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ old('cpf') }}" required autofocus readonly>
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
                                    <input id="email" placeholder="Informe seu email" type="email" value="{{$user->email}}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>
                                    @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group col-12 col-sm-6">
                                    <label for="telefone">Telefone</label>
                                    <input id="telefone" placeholder="Informe seu telefone" type="text" value="{{$user->telefone}}" class="form-control {{ $errors->has('telefone') ? ' is-invalid' : '' }}" name="telefone" value="{{ old('telefone') }}">
                                    @if ($errors->has('telefone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('telefone') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-sm-6">
                                    <label for="password" class="d-block">Nova Senha</label>
                                    <input id="password" placeholder="Senha com no (mínimo 6 caracteres)"  type="password" class="form-control pwstrength {{ $errors->has('senha') ? ' is-invalid' : '' }}" data-indicator="pwindicator" name="senha"> 
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
                                    <label for="confirme_senha" class="d-block">Confirme a senha</label>
                                    <input id="confirme_senha" placeholder="Confirme a senha fornecida" type="password" class="form-control {{ $errors->has('confirme_senha') ? ' is-invalid' : '' }}" name="confirme_senha">
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
                                    <label for="nome">Nome <span style="color: red">*</span></label>
                                    <input placeholder="Informe o nome da sua propriedade" type="text" value="{{$propriedade->nome}}" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') }}" required autofocus>
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
                                    <input class="form-control {{ $errors->has('localizacao') ? ' is-invalid' : '' }}" value="{{$propriedade->localizacao}}" placeholder="Localização da sua propriedade" name="localizacao" type='text' value="{{ old('localizacao') }}" required>
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
                                        <option value={{$estado->id}} {{ ($estado->id==$propriedade->cidade()->first()->estado_id) ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Estado é obrigatório!
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Cidade <span style="color: red">*</span></label>
                                    <select class="custom-select {{ $errors->has('cidade') ? ' is-invalid' : '' }}" name="cidade" id="cidade" required>
                                        <option value="{{$propriedade->cidade()->first()->id}}">{{$propriedade->cidade()->first()->nome}}</option>
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
                                <div class="card-footer form-group text-center">
                                    <button class="btn btn-success btn-lg col-md-2">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/modules/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js')}}"></script>
<script type="text/javascript">
    $("#telefone, #celular").mask("(00)00000-0000");
    $('#cpf').mask('000.000.000-00');
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
