@extends('layouts.admin-master')

@section('title')
Create User
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Editar estoque do produto {{$estoque->produto()->first()->nome}}</h1>
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
                            <a href="{{route('painel.estoque.index')}}" class="btn btn-success">Listar Estoque <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form  method="POST" name="addproduto" action="{{ route('painel.estoque.update', ['estoque'=>$estoque])}}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Produto<span class="text-danger">*</span></label>
                                <select name="produto" class="custom-select form-control {{ $errors->has('produto') ? ' is-invalid' : '' }}" required value="{{ old('produto') }}">
                                    <option selected="" value="">Selecione o produto</option>
                                    @foreach ($produtos as $produto)
                                    <option value={{$produto->slug()}} {{ ($produto->id == $estoque->produto_id) ? 'selected' : '' }}>{{$produto->nome}}</option>
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
                                <input name="data_estoque" type="date" value="{{date('Y-m-d', strtotime($estoque->data))}}" class="form-control {{ $errors->has('data_estoque') ? ' is-invalid' : '' }}" required="" value="{{ old('data_estoque') }}">
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
                                <input name="quantidade" type="number" value="{{$estoque->quantidade}}" min="1" class="form-control {{ $errors->has('data_estoque') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 40" value="{{ old('data_estoque') }}">
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
                            <button class="btn btn-success">Editar Estoque</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
