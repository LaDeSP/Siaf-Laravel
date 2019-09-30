@extends('layouts.admin-master')

@section('title')
Adicionar plantio
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar plantio</h1>
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
                    <form method="POST" name="addplantio" action="{{ route('painel.plantio.store') }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Data da semeadura</label>
                                <input name="data_semeadura" type="date" class="form-control {{ $errors->has('data_semeadura') ? ' is-invalid' : '' }}" value="{{ old('data_semeadura') }}">
                                @if ($errors->has('data_semeadura'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_semeadura') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Data do plantio<span class="text-danger">*</span></label>
                                <input name="data_plantio" type="date" class="form-control {{ $errors->has('data_plantio') ? ' is-invalid' : '' }}" required="" value="{{ old('data_plantio') }}">
                                <div class="invalid-feedback">
                                    Qual foi a data do plantio?
                                </div>
                                @if ($errors->has('data_plantio'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_plantio') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Número de plantas<span class="text-danger">*</span></label>
                                <input name="numero_plantas" type="number" min="1" class="form-control {{ $errors->has('numero_plantas') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 40" value="{{ old('numero_plantas') }}">
                                <div class="invalid-feedback">
                                    Qual a quantidade de plantas?
                                </div>
                                @if ($errors->has('numero_plantas'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('numero_plantas') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Talhão<span class="text-danger">*</span></label>
                                <select name="talhao" class="custom-select form-control {{ $errors->has('talhao') ? ' is-invalid' : '' }}" required value="{{ old('talhao') }}">
                                    <option selected="" value="">Selecione o talhão</option>
                                    @foreach ($talhoes as $talhao)
                                    <option value="{{$talhao->slug()}}">{{$talhao->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Talhão é obrigatório!
                                </div>
                                @if ($errors->has('talhao'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('talhao') }}
                                </div>
                                @endif
                            </div>
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
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Cadastrar Plantio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
