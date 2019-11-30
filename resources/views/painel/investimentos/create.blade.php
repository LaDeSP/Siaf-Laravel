@extends('layouts.admin-master')

@section('title')
Adicionar Investimento
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar Investimento</h1>
    </div>
    <div class="section-body">
        <div class="row d-flex justify-content-center">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-action">
                            <a href="{{route('painel.investimento.index')}}" class="btn btn-success">Listar Investimentos <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form method="POST" name="addinvestimento" action="{{ route('painel.investimento.store') }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Investimento<span class="text-danger">*</span></label>
                                <input name="investimento" type="text" class="form-control {{ $errors->has('investimento') ? ' is-invalid' : '' }}" value="{{ old('investimento') }}" required="" placeholder="Ex: Compra de pá">
                                <div class="invalid-feedback">
                                    Investimento é obrigatório!
                                </div>
                                @if ($errors->has('investimento'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('investimento') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <input name="descricao" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Quantidade de itens comprados<span class="text-danger">*</span></label>
                                <input name="quantidade" type="number" min="1" class="form-control {{ $errors->has('quantidade') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 40" value="{{ old('quantidade') }}">
                                <div class="invalid-feedback">
                                    Quantidade de itens é obrigatório!
                                </div>
                                @if ($errors->has('quantidade'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('quantidade') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Valor do investimento<span class="text-danger">*</span></label>
                                <input name="valor_investimento" type="number" min="1" step="0.01" class="form-control {{ $errors->has('valor_investimento') ? ' is-invalid' : '' }}" pattern="[0-9]$" required="" placeholder="Ex: 5,50">
                                <div class="invalid-feedback">
                                    Valor do investimento é obrigatório!
                                </div>
                                @if ($errors->has('valor_investimento'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('valor_investimento') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Data do investimento<span class="text-danger">*</span></label>
                                <input name="data_investimento" type="date" class="form-control {{ $errors->has('data_investimento') ? ' is-invalid' : '' }}" required="" value="{{ old('data_investimento') }}">
                                <div class="invalid-feedback">
                                    Data do investimento é obrigatório!
                                </div>
                                @if ($errors->has('data_investimento'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_investimento') }}
                                </div>
                                @endif
                            </div>        
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Cadastrar Investimento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



