@extends('layouts.admin-master')

@section('title')
Adicionar plantio
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Estocar a colheita do plantio {{$plantio->produto()->first()->nome}}</h1>
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
                            <a href="{{route('painel.manejosPlantios', ['plantio'=>$plantio])}}" class="btn btn-success">Listar Manejos <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form method="POST" name="addplantio" action="{{ route('painel.storeEstoqueColheitaManejo', ['manejo'=>$manejo]) }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Produto<span class="text-danger">*</span></label></label>
                                <input value="{{$plantio->produto()->first()->nome}}" name="produto" type="text" class="form-control {{ $errors->has('produto') ? ' is-invalid' : '' }}" value="{{ old('produto') }}" readonly>
                                @if ($errors->has('produto'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('produto') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Data de Manejo<span class="text-danger">*</span></label></label>
                                <input value="{{date('d/m/Y', strtotime($manejo->data_hora))}}" name="data_manejo" type="text" class="form-control {{ $errors->has('data_manejo') ? ' is-invalid' : '' }}" value="{{ old('data_manejo') }}" readonly>
                                @if ($errors->has('data_manejo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_manejo') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Manejo<span class="text-danger">*</span></label>
                                <select name="manejo" class="custom-select form-control {{ $errors->has('manejo') ? ' is-invalid' : '' }}" required value="{{ old('manejo') }}" disabled>
                                    <option selected="" value="">Selecione o manejo</option>
                                    @foreach ($manejos as $manejoo)
                                    <option value={{$manejoo->id}} {{ ($manejoo->id == $manejo->manejo_id) ? 'selected' : '' }}>{{$manejoo->nome}} em {{$plantio->produto()->first()->unidade()->first()->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Manejo é obrigatório!
                                </div>
                                @if ($errors->has('manejo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('manejo') }}
                                </div>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                @if($plantio->produto == "c_temporaria")
                                <label>Quantidade máxima colhida do produto: {{$plantio->quantidade_pantas}}
                                    @else
                                    <label>Quantidade colhida do produto
                                        @endif
                                        <span class="text-danger">*</span></label>
                                        <input name="quantidade" type="number" min="1" @if($plantio->produto == "c_temporaria") max="{{$plantio->quantidade_pantas}}" id="quantidade"  @endif class="form-control {{ $errors->has('quantidade') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 40" value="{{ old('quantidade') }}">
                                        <div class="invalid-feedback">
                                            Quantidade é obrigatório!
                                        </div>
                                        @if ($errors->has('quantidade'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('quantidade') }}
                                        </div>
                                        @endif
                                    </div>             
                                </div>
                                <div class="card-footer text-center">
                                    <button class="btn btn-success">Cadastrar Colheita</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endsection
        
        @push('scripts')
        <script>
            if(document.querySelector("#quantidade")){
                var foo = document.querySelector("#quantidade");
                
                //Cria uma função que será usando no keyup e no blue
                var f = maxNumber({{$plantio->quantidade_pantas}});
                
                foo.addEventListener('keyup', f);
                foo.addEventListener('blur', f);
                
                function maxNumber(max){
                    var running = false;
                    
                    return function () {
                        //Para evitar conflito entre o blur e o keyup
                        if (running) return;
                        
                        //Bloqueia multiplas chamadas do blur e keyup
                        running = true;
                        
                        //Se o input for maior que quantidade do plantio ele irá fixa o valor maximo no value
                        if (parseFloat(this.value) > max) {
                            this.value = {{$plantio->quantidade_pantas}};
                        }
                        
                        //Habilita novamente as chamadas do blur e keyup
                        running = false;
                    };
                }
            }
        </script>
        @endpush