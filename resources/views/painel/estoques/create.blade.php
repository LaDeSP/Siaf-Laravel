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
                    <form  method="POST" name="addproduto" action="{{ route('painel.estoque.store') }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Produto<span class="text-danger">*</span></label>
                                <select name="produto" class="custom-select form-control {{ $errors->has('produto') ? ' is-invalid' : '' }}" required value="{{ old('produto') }}">
                                    <option selected="" value="">Selecione o produto</option>
                                    @foreach ($produtos as $produto)
                                    <option value="{{$produto->slug()}}">{{$produto->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Produto é obrigatório!
                                </div>
                                @if ($errors->has('produto'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('produto') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Data<span class="text-danger">*</span></label>
                                <input name="data_estoque" type="date" class="form-control {{ $errors->has('data_estoque') ? ' is-invalid' : '' }}" required="" value="{{ old('data_estoque') }}">
                                <div class="invalid-feedback">
                                    Data de estoque é obrigatório!
                                </div>
                                @if ($errors->has('data_estoque'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_estoque') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Quantidade produto<span class="text-danger">*</span></label>
                                <input name="quantidade" type="number" min="1" class="form-control {{ $errors->has('data_estoque') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 40" value="{{ old('data_estoque') }}">
                                <div class="invalid-feedback">
                                    Quantidade de produto é obrigatório!
                                </div>
                                @if ($errors->has('data_estoque'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_estoque') }}
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
