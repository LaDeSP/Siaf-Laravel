@extends('layouts.admin-master')

@section('title')
Create User
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar Produto Processado</h1>
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
                                <input name="nome_produto" type="text" class="form-control {{ $errors->has('nome_produto') ? ' is-invalid' : '' }}" required placeholder="Ex: Manteiga" value="{{ old('nome_produto') }}">
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
                                <label>Data<span class="text-danger">*</span></label>
                                <input name="data_plantio" type="date" class="form-control {{ $errors->has('data_plantio') ? ' is-invalid' : '' }}" required="" value="{{ old('data_plantio') }}">
                                <div class="invalid-feedback">
                                    Qual foi a data de estoque do produto?
                                </div>
                                @if ($errors->has('data_plantio'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_plantio') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Quantidade<span class="text-danger">*</span></label>
                                <input name="numero_plantas" type="number" min="1" class="form-control {{ $errors->has('numero_plantas') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 40" value="{{ old('numero_plantas') }}">
                                <div class="invalid-feedback">
                                    Qual a quantidade de produto estocado?
                                </div>
                                @if ($errors->has('numero_plantas'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('numero_plantas') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Cadastrar Estoque</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
