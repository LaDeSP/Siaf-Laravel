@extends('layouts.admin-master')

@section('title')
Adicionar venda
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Editar venda</h1>
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
                            <a href="{{route('painel.venda.index')}}" class="btn btn-success">Listar Vendas <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form method="POST" name="addvenda" action="{{route('painel.venda.update', ['venda'=>$venda])}}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Estoque<span class="text-danger">*</span></label>
                                <input name="estoque" type="text" value={{$estoque}}  class="form-control {{ $errors->has('estoque') ? ' is-invalid' : '' }}" required value="{{ old('estoque') }}" readonly>
                                <div class="invalid-feedback">
                                    Estoque é obrigatório!
                                </div>
                                @if ($errors->has('estoque'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('estoque') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Destino<span class="text-danger">*</span></label>
                                <select name="destino" class="custom-select form-control {{ $errors->has('destino') ? ' is-invalid' : '' }}" required value="{{ old('destino') }}">
                                    <option selected="" value="">Selecione um destino</option>
                                    @foreach ($destinos as $destino)
                                    <option value={{$destino->id}} {{ ($destino->id == $venda->destino_id) ? 'selected' : '' }}>{{$destino->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Destino é obrigatório!
                                </div>
                                @if ($errors->has('destino'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('destino') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Quantidade máxima para venda: <span id="span" name="resultado">{{$quantidadeEstoqueAtual+$venda->quantidade}}</span> 
                                    <span class="text-danger">*</span></label>
                                    <input id="quantidade" name="quantidade_venda" type="number" value="{{$venda->quantidade}}" min="1" max="{{$quantidadeEstoqueAtual+$venda->quantidade}}" class="form-control {{ $errors->has('quantidade_venda') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 5">
                                    <div class="invalid-feedback">
                                        Quantidade é obrigatório!
                                    </div>
                                    @if ($errors->has('quantidade_venda'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quantidade_venda') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Preço unitário<span class="text-danger">*</span></label>
                                    <input name="valor_unit" type="number" min="1" step="0.01" value="{{$venda->valor_unit}}" class="form-control {{ $errors->has('valor_unit') ? ' is-invalid' : '' }}" pattern="[0-9]$" required="" placeholder="Ex: 5,50">
                                    <div class="invalid-feedback">
                                        Preço unitário é obrigatório!
                                    </div>
                                    @if ($errors->has('valor_unit'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('valor_unit') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Data venda<span class="text-danger">*</span></label>
                                    <input name="data_venda" type="date" value="{{date('Y-m-d', strtotime($venda->data))}}" class="form-control {{ $errors->has('data_venda') ? ' is-invalid' : '' }}" required="" value="{{ old('data_venda') }}">
                                    <div class="invalid-feedback">
                                        Data venda é obrigatório!
                                    </div>
                                    @if ($errors->has('data_venda'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('data_venda') }}
                                    </div>
                                    @endif
                                </div>                       
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-success">Editar Venda</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    