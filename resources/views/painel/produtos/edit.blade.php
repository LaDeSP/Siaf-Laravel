@extends('layouts.admin-master')

@section('title')
Adicionar Produto
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Editar Produto</h1>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-action">
                            <a href="{{route('painel.produto.index')}}" class="btn btn-success">Listar Produtos <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form  method="POST" name="addproduto" action="{{ route('painel.produto.update', ['produto'=>$produto]) }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome do produto <span class="text-danger">*</span></label>
                                <input name="nome_produto" type="text" value="{{$produto->nome}}" class="form-control {{ $errors->has('nome_produto') ? ' is-invalid' : '' }}" required placeholder="Ex: Tomate" value="{{ old('nome_produto') }}">
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
                                    <option value={{$unidade->id}} {{ ($produto->unidade_id == $unidade->id) ? 'selected' : '' }}>{{$unidade->nome}}</option>
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
                                    @foreach ($categorias as $categoria)
                                    <option value={{$categoria}} {{ ($produto->tipo == $categoria) ? 'selected' : '' }}>@if($categoria == "processado") Processado @elseif($categoria == "c_permanente") Cultura Permanente @else Cultura Temporária @endif</option>
                                    @endforeach
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
                            <button class="btn btn-success">Editar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
