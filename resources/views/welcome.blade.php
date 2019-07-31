@extends('master')
@section('usuario', $User)
@section('conteudo')
<script src="https://cdn.jsdelivr.net/npm/crypto-js@3.1.9-1/crypto-js.js"></script>
<link href="/siaf/public/plugin-tempo/jquery.weather.br.min.css" media="all" rel="stylesheet" />
<script src="/siaf/public/plugin-tempo/jquery.weather.br.js"></script>
<style type="text/css">
    #weather {
        margin-top:15px;
        margin-bottom:0%;
    }
</style>

<script>
    $(function() {
        $('#weather').weather({
            geoLocation:false,
            locationLat: {{$Latitude}},
            locationLon: {{$Longitude}}
        });
    });
</script>
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <img class="col-8 offset-2 img-fluid" style="" src="/siaf/public/images/carinha4.png">
            </div>
            <div class="col-8">
                <div class="card" style="margin-top:25px;">
                    <div class="card-body">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Propriedade</th>
                                    <th>Localização</th>
                                    <th>Municipio</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$Propriedade->nome}}</td>
                                    <td>{{$Propriedade->localizacao}}</td>
                                    <td>{{$dadosP->cidade}}</td>
                                    <td>{{$dadosP->estado}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Vendas nos últimos 15 dias</h4>
                        @if(count($Vendas)==0)
                        <p class="text-center">Por favor, adicione novas vendas!</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Total (R$)</th>
                                    <th>Total Unidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Vendas as $venda)
                                <tr>
                                    <td>{{$venda->produto}}</td>
                                    <td>{{$venda->total}}</td>
                                    <td>{{$venda->total_unidade}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Estoques nos últimos 15 dias</h4>
                        @if(count($estoques)==0)
                        <p class="text-center">Por favor, adicione novos Estoques!</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Total Atual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estoques as $estoque)
                                <tr>
                                    <td>{{$estoque->produto}}</td>
                                    <td>{{$estoque->total_atual}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class=" col-12" id="weather">
    </div>
</div>




@endsection
