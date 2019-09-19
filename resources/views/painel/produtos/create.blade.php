@extends('layouts.admin-master')

@section('title')
Adicionar Produto
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar Produto</h1>
    </div>
    <div class="section-body">
        <div class="row d-flex justify-content-center">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible show fade col-10">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session('success') }}
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
            <div class="col-12">
                <div class="card">
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form  method="POST" name="addproduto" action="{{ route('painel.produto.store') }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome do produto <span class="text-danger">*</span></label>
                                <input name="nome_produto" type="text" class="form-control {{ $errors->has('nome_produto') ? ' is-invalid' : '' }}" required placeholder="Ex: Tomate" value="{{ old('nome_produto') }}">
                                <div class="invalid-feedback">
                                    Nome do produto é obrigatório!
                                </div>
                                @if ($errors->has('nome_produto'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nome_produto') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Unidade do produto <span class="text-danger">*</span></label>
                                <select name="unidade" class="custom-select form-control {{ $errors->has('unidade') ? ' is-invalid' : '' }}" required value="{{ old('unidade') }}">
                                    <option selected="" value="">Selecione a unidade do seu produto</option>
                                    @foreach ($unidades as $unidade)
                                    <option value="{{$unidade->id}}">{{$unidade->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Unidade do produto é obrigatório!
                                </div>
                                @if ($errors->has('unidade'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('unidade') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Categoria do produto <span class="text-danger">*</span></label>
                                <select name="categoria" class="custom-select form-control {{ $errors->has('categoria') ? ' is-invalid' : '' }}" required value="{{ old('categoria') }}">
                                    <option selected="" value="">Selecione a categoria do seu produto</option>
                                    <option value="processado">Produto processado</option>
                                    <option value="c_permanente">Cultura permanente</option>
                                    <option value="c_temporaria">Cultura temporária</option>
                                </select>
                                <div class="invalid-feedback">
                                    Categoria do produto é obrigatório!
                                </div>
                                @if ($errors->has('categoria'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('categoria') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Cadastrar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
