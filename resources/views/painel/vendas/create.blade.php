@extends('layouts.admin-master')

@section('title')
Adicionar venda
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar venda</h1>
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
                            <a href="{{route('painel.venda.index')}}" class="btn btn-success">Listar Vendas <i class="fas fa-list"></i></a>
                        </div>
                    </div>
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form method="POST" name="addvenda" action="{{route('painel.venda.store')}}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Estoque<span class="text-danger">*</span></label>
                                <select name="estoque" class="custom-select form-control {{ $errors->has('estoque') ? ' is-invalid' : '' }}" required value="{{ old('estoque') }}">
                                    <option selected="" value="">Selecione um estoque</option>
                                    @foreach ($estoques as $estoque)
                                    <option value="{{$estoque->slug()}}">{{$estoque->produto()->first()->nome}}</option>
                                    @endforeach
                                </select>
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
                                <label>Quantidade máxima para venda: <span id="span" name="resultado">0</span> 
                                    <span class="text-danger">*</span></label>
                                    <input id="quantidade" name="quantidade_venda" type="number" min="1" max="" class="form-control {{ $errors->has('quantidade_venda') ? ' is-invalid' : '' }}" required="" placeholder="Ex: 5" disabled>
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
                                    <input name="valor_unit" type="number" min="1" step="0.01" class="form-control {{ $errors->has('valor_unit') ? ' is-invalid' : '' }}" pattern="[0-9]$" required="" placeholder="Ex: 5,50">
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
                                    <input name="data_venda" type="date" class="form-control {{ $errors->has('data_venda') ? ' is-invalid' : '' }}" required="" value="{{ old('data_venda') }}">
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
                                <button class="btn btn-success">Cadastrar Venda</button>
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
        $( document ).ready(function() {
            $('select[name=estoque]').change(function () {
                var idEstoque = $(this).val();
                var inputE = document.getElementById("quantidade");
                if(idEstoque){
                    $.ajax({
                        url: '/painel/estoque/'+idEstoque+'/quantidade', 
                        success: function(quantidade){
                            inputE.disabled = false;
                            var input=$('#quantidade')
                            input.val('');
                            input.attr({'max':quantidade})
                            document.getElementById("span").innerHTML = quantidade;
                        },
                        error: function(data) {
                            inputE.disabled = true;
                            alert('Erro na solicitação')
                        },
                    });
                }else{
                    document.getElementById("span").innerHTML = 0;
                    inputE.disabled = true;
                }       
            });
            
            $('#quantidade').change(function (){
                if(( parseInt( $(this).val(),10 ) > parseInt( $(this).attr('max'), 10))) {
                    $(this).val($(this).attr('max') )
                }
                if($(this).val()< $(this).attr('min')  ) {
                    $(this).val($(this).attr('min'))
                }
            });
        });
    </script>
    @endpush
    