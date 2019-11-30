@extends('layouts.admin-master')

@section('title')
Adicionar Despesa
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar Despesa</h1>
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
                            <a href="{{route('painel.despesa.index')}}" class="btn btn-success">Listar Despesas <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form method="POST" name="addDespesa" action="{{ route('painel.despesa.store') }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Despesa<span class="text-danger">*</span></label>
                                <input name="despesa" type="text" class="form-control {{ $errors->has('despesa') ? ' is-invalid' : '' }}" value="{{ old('despesa') }}" required="" placeholder="Ex: Compra de pá">
                                <div class="invalid-feedback">
                                    Despesa é obrigatório!
                                </div>
                                @if ($errors->has('despesa'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('despesa') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <input name="descricao" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Quantidade de itens<span class="text-danger">*</span></label>
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
                                <label>Valor da despesa<span class="text-danger">*</span></label>
                                <input name="valor_despesa" type="number" min="1" step="0.01" class="form-control {{ $errors->has('valor_despesa') ? ' is-invalid' : '' }}" pattern="[0-9]$" required="" placeholder="Ex: 5,50">
                                <div class="invalid-feedback">
                                    Valor da despesa é obrigatório!
                                </div>
                                @if ($errors->has('valor_despesao'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('valor_despesao') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Data da despesa<span class="text-danger">*</span></label>
                                <input name="data_despesa" type="date" class="form-control {{ $errors->has('data_despesa') ? ' is-invalid' : '' }}" required="" value="{{ old('data_despesa') }}">
                                <div class="invalid-feedback">
                                    Data da despesa é obrigatório!
                                </div>
                                @if ($errors->has('data_despesa'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_despesa') }}
                                </div>
                                @endif
                            </div>        
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Cadastrar Despesa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



