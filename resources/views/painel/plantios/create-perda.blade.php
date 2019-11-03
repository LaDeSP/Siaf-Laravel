@extends('layouts.admin-master')

@section('title')
Adicionar Manejo
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar perda para o plantio de {{$plantio->produto->nome}}</h1>
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
                            <a href="{{route('painel.plantio.index')}}" class="btn btn-success">Listar Plantios <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form method="POST" name="addperda" action="{{route('painel.storePerdaPlantio', ['plantio'=>$plantio])}}"  class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Data perda<span class="text-danger">*</span></label>
                                <input name="data_perda" type="date" class="form-control {{ $errors->has('data_perda') ? ' is-invalid' : '' }}" required="">
                                <div class="invalid-feedback">
                                    Data da perda é obrigatório!
                                </div>
                                @if ($errors->has('data_perda'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_perda') }}
                                </div>
                                @endif
                            </div>  
                            <div class="form-group">
                                <label>Destino<span class="text-danger">*</span></label>
                                <select name="destino" class="custom-select form-control {{ $errors->has('destino') ? ' is-invalid' : '' }}" required value="{{ old('destino') }}">
                                    <option selected="" value="">Selecione um destino</option>
                                    @foreach ($destinos as $destino)
                                    <option value="{{$destino->id}}">{{$destino->nome}}</option>
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
                                <label>Quantidade máxima de perda: {{$plantio->quantidade_pantas}}
                                    <span class="text-danger">*</span></label>
                                    <input id="quantidade" name="quantidade_perda" type="number" min="1" max="{{$plantio->quantidade_pantas}}" class="form-control {{ $errors->has('quantidade_perda') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 5">
                                    <div class="invalid-feedback">
                                        Quantidade é obrigatório!
                                    </div>
                                    @if ($errors->has('quantidade_perda'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quantidade_perda') }}
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
    
    @push('scripts')
    <script>
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
    </script>
    @endpush