@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" media="all"  type="text/css" href="{{ asset('assets/modules/jquery.weather.br-master/dist/jquery.weather.br.css')}}"/>
@endpush

@section('title')
Início
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
            <div class="card text-center shadow-lg" style="min-height:300px; max-height:300px">
                <div class="card-header">
                    <h4>Estoques nos últimos 15 dias</h4>
                </div>
                @if ($estoques->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Total Unidade</th>
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
                    </div>
                </div>
                @else
                <div class="text-muted my-auto">
                    <h5>Nenhum estoque cadastrado nos últimos 15 dias!</h5>
                </div>
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
            <div class="card text-center shadow-lg" style="min-height:300px; max-height:300px">
                <div class="card-header">
                    <h4>Vendas nos últimos 15 dias</h4>
                </div>
                @if ($vendas->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Total Unidade</th>
                                    <th>Total (R$)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendas as $venda)
                                <tr>
                                    <td>{{$venda->produto}}</td>
                                    <td>{{$venda->total_unidade}}</td>
                                    <td>{{$venda->total}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="text-muted my-auto">
                    <h5>Nenhuma venda cadastrada nos últimos 15 dias!</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row-lg-12">
                <div class="card text-center shadow-lg">
                    <div class="card-header">
                        <h4>Sua propriedade</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Propriedade</th>
                                        <th>Município</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>                         
                                    <tr>
                                        <td>{{$propriedade->nome}}</td>
                                        <td>{{$propriedade->cidade()->first()->nome}}</td>
                                        <td>{{$propriedade->cidade()->first()->estado()->first()->nome}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-lg-12">
                <div class="shadow-lg">
                    <div class="card table-responsive" style="min-height:205px; max-height:205px">
                        <div id="weather">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card gradient-bottom shadow-lg">
                <div class="card-header">
                    <h4>Top 5 produtos mais vendidos</h4>
                </div>
                <div class="card-body" id="top-5-scroll">
                    <ul class="list-unstyled list-unstyled-border">
                        @foreach ($produtos as $produto)
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="assets/img/products/product-4-50.png" alt="product">
                            <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">{{$produto->quantidadeVenda}} Vendas</div></div>
                                <div class="media-title">{{$produto->nome}}</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-success" data-width="64%"></div>
                                        <div class="budget-price-label">R${{$produto->lucroVenda}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer pt-3 d-flex justify-content-center">
                    <div class="budget-price justify-content-center">
                        <div class="budget-price-square bg-success" data-width="30"></div>
                        <div class="budget-price-label">Lucro em vendas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/crypto-js@3.1.9-1/crypto-js.js"></script>
<script src="{{asset('assets/modules/jquery.weather.br-master/dist/jquery.weather.br.js')}}"></script>

<script>
    $(function() {
        $('#weather').weather({
            geoLocation:false,
            locationLat: {{$propriedade->cidade()->first()->latitude}},
            locationLon: {{$propriedade->cidade()->first()->longitude}}
        });
    });
</script>
@endpush