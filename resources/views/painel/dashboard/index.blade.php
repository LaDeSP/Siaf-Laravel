@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" media="all"  type="text/css" href="{{ asset('assets/modules/plugin-tempo/jquery.weather.br.min.css')}}"/>
@endpush

@section('title')
Inicio
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2 shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-stats">
                    <div class="card-stats-title text-center">Estoques
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">24</div>
                            <div class="card-stats-item-label">Pending</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">12</div>
                            <div class="card-stats-item-label">Shipping</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">23</div>
                            <div class="card-stats-item-label">Completed</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-success">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Orders</h4>
                    </div>
                    <div class="card-body">
                        59
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2 shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-stats">
                    <div class="card-stats-title text-center">Vendas
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">24</div>
                            <div class="card-stats-item-label">Pending</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">12</div>
                            <div class="card-stats-item-label">Shipping</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">23</div>
                            <div class="card-stats-item-label">Completed</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-success">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Orders</h4>
                    </div>
                    <div class="card-body">
                        59
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2 shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-stats">
                    <div class="card-stats-title text-center">Finanças
                    </div> 
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">24</div>
                            <div class="card-stats-item-label">Lucro</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">12</div>
                            <div class="card-stats-item-label">Investimento</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">23</div>
                            <div class="card-stats-item-label">Despesas</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Orders</h4>
                    </div>
                    <div class="card-body">
                        59
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
            <div class="card text-center">
                <div class="card-header">
                    <h4>Estoques nos últimos 15 dias</h4>
                </div>
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
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
            <div class="card text-center">
                <div class="card-header">
                    <h4>Vendas nos últimos 15 dias</h4>
                </div>
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
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Budget vs Sales</h4>
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
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card gradient-bottom">
                <div class="card-header">
                    <h4>Top 5 Produtos mais Vendidos</h4>
                </div>
                <div class="card-body" id="top-5-scroll">
                    <ul class="list-unstyled list-unstyled-border">
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="assets/img/products/numero1.png" alt="product">
                            <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">86 Sales</div></div>
                                <div class="media-title">oPhone S9 Limited</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-success" data-width="64%"></div>
                                        <div class="budget-price-label">$68,714</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="assets/img/products/product-4-50.png" alt="product">
                            <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">67 Sales</div></div>
                                <div class="media-title">iBook Pro 2018</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-success" data-width="84%"></div>
                                        <div class="budget-price-label">R$12507,33</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="assets/img/products/product-1-50.png" alt="product">
                            <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">63 Sales</div></div>
                                <div class="media-title">Headphone Blitz</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-success" data-width="34%"></div>
                                        <div class="budget-price-label">$3,717</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="assets/img/products/product-3-50.png" alt="product">
                            <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">28 Sales</div></div>
                                <div class="media-title">oPhone X Lite</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-success" data-width="45%"></div>
                                        <div class="budget-price-label">$13,972</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="assets/img/products/product-5-50.png" alt="product">
                            <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">19 Sales</div></div>
                                <div class="media-title">Old Camera</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-success" data-width="35%"></div>
                                        <div class="budget-price-label">$7,391</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer pt-3 d-flex justify-content-center">
                    <div class="budget-price justify-content-center">
                        <div class="budget-price-square bg-success" data-width="30"></div>
                        <div class="budget-price-label">Lucro de venda</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-md-12">
              <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-header">
                  <h4>Best Products</h4>
                </div>
                <div class="card-body">
                    <div id="weather">
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
<script src="{{asset('assets/modules/plugin-tempo/jquery.weather.br.js')}}"></script>

<script>
    $(function() {
        $('#weather').weather({
            geoLocation:false,
            locationLat: {{$propriedade->cidade->latitude}},
            locationLon: {{$propriedade->cidade->longitude}}
        });
    });
</script>
@endpush