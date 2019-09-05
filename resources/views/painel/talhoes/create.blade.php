@extends('layouts.admin-master')

@section('title')
Adicionar Talhão
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar Talhão</h1>
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
                    <form method="POST" name="addtalhao" action="{{ route('painel.talhao.store') }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome do talhão<span class="text-danger">*</span></label>
                                <input name="nome_talhao" type="text" class="form-control {{ $errors->has('nome_talhao') ? ' is-invalid' : '' }}" required="" placeholder="Ex: Talhão 1" value="{{ old('nome_talhao') }}">
                                <div class="invalid-feedback">
                                    Nome do talhão é obrigatório!
                                </div>
                                @if ($errors->has('nome_talhao'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nome_talhao') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Área em m²<span class="text-danger">*</span></label>
                                <input name="area_talhao" type="number" min="1" class="form-control {{ $errors->has('area_talhao') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 50" value="{{ old('area_talhao') }}">
                                <div class="invalid-feedback">
                                    Área do talhão é obrigatório!
                                </div>
                                @if ($errors->has('area_talhao'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('area_talhao') }}
                                </div>
                                @endif
                            </div>         
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Cadastrar Talhão</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


