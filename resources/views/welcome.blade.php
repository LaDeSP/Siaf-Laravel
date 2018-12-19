@extends('master')
@section('usuario', $User)
@section('conteudo')
<link href="plugin-tempo/jquery.weather.br.min.css" media="all" rel="stylesheet" />
<script src="plugin-tempo/jquery.weather.br.js"></script>
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
                <img class="col-9 offset-2 img-fluid" src="/images/carinha4.png">
            </div>
            <div class="col-8">
                <div class="card" style="margin-top:25px;">
                    <div class="card-body">
                        <h4 class="card-title">Sua Fazenda</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fazenda</th>
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
                <div class="card" style="margin-top:25px;">
                    <div class="card-body">
                        <h4 class="card-title">Vendas nos últimos 15 dias</h4>
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
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card" style="margin-top:25px;">
                    <div class="card-body">
                        <h4 class="card-title">Estoque nos últimos 15 dias</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Total Entrada</th>
                                    <th>Total Atual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estoques as $estoque)
                                <tr>
                                    <td>{{$estoque->produto}}</td>
                                    <td>{{$estoque->total}}</td>
                                    <td>{{$estoque->total_atual}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
