@extends('layouts.admin-master')

@section('title')
Adicionar Manejo
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar perda para (---)</h1>
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
                    <form method="POST" name="addmanejo" action="{{route('painel.storePerdaPlantio', ['plantio'=>$plantio])}}"  class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                    <label>Data<span class="text-danger">*</span></label>
                                    <input name="data_manejo" type="date" class="form-control {{ $errors->has('data_manejo') ? ' is-invalid' : '' }}" required="">
                                    <div class="invalid-feedback">
                                        Qual foi a data da perda?
                                    </div>
                                    @if ($errors->has('data_manejo'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('data_manejo') }}
                                    </div>
                                    @endif
                            </div>  
                            <div class="form-group">
                                <label>Destino<span class="text-danger">*</span></label>
                                <select name="manejo" class="custom-select form-control {{ $errors->has('manejo') ? ' is-invalid' : '' }}" required value="{{ old('manejo') }}">
                                    <option selected="" value="">Selecione um destino</option>
                                    @foreach ($destinos as $destino)
                                    <option value="{{$destino->id}}">{{$destino->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Destino é obrigatório!
                                </div>
                                @if ($errors->has('manejo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('manejo') }}
                                </div>
                                @endif
                            </div> 
                            <div class="form-group">
                                <label>Quantidade<span class="text-danger">*</span></label>
                                <input name="horas_utilizadas" type="number" min="1" class="form-control {{ $errors->has('horas_utilizadas') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 5">
                                <div class="invalid-feedback">
                                    Quantos produtos foram perdidos?
                                </div>
                                @if ($errors->has('horas_utilizadas'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('horas_utilizadas') }}
                                </div>
                                @endif
                            </div>    
                            <div class="form-group">
                                <label>Descrição</span></label>
                                <input name="descricao" type="text" class="form-control">
                            </div>     
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Cadastrar Perda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

