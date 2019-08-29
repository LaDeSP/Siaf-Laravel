@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}"/>
<link rel="stylesheet"media="all"  type="text/css" href="{{ asset('assets/modules/plugin-tempo/jquery.weather.br.min.css')}}"/>
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
            <div class="card-stats-title">Total de produtos estocados - 
              <div class="dropdown d-inline">
                <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">August</a>
                <ul class="dropdown-menu dropdown-menu-sm">
                  <li class="dropdown-title">Select Month</li>
                  <li><a href="#" class="dropdown-item">January</a></li>
                  <li><a href="#" class="dropdown-item">February</a></li>
                  <li><a href="#" class="dropdown-item">March</a></li>
                  <li><a href="#" class="dropdown-item">April</a></li>
                  <li><a href="#" class="dropdown-item">May</a></li>
                  <li><a href="#" class="dropdown-item">June</a></li>
                  <li><a href="#" class="dropdown-item">July</a></li>
                  <li><a href="#" class="dropdown-item active">August</a></li>
                  <li><a href="#" class="dropdown-item">September</a></li>
                  <li><a href="#" class="dropdown-item">October</a></li>
                  <li><a href="#" class="dropdown-item">November</a></li>
                  <li><a href="#" class="dropdown-item">December</a></li>
                </ul>
              </div>
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
            <div class="card-stats-title">total de lucro - 
              <div class="dropdown d-inline">
                <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">August</a>
                <ul class="dropdown-menu dropdown-menu-sm">
                  <li class="dropdown-title">Select Month</li>
                  <li><a href="#" class="dropdown-item">January</a></li>
                  <li><a href="#" class="dropdown-item">February</a></li>
                  <li><a href="#" class="dropdown-item">March</a></li>
                  <li><a href="#" class="dropdown-item">April</a></li>
                  <li><a href="#" class="dropdown-item">May</a></li>
                  <li><a href="#" class="dropdown-item">June</a></li>
                  <li><a href="#" class="dropdown-item">July</a></li>
                  <li><a href="#" class="dropdown-item active">August</a></li>
                  <li><a href="#" class="dropdown-item">September</a></li>
                  <li><a href="#" class="dropdown-item">October</a></li>
                  <li><a href="#" class="dropdown-item">November</a></li>
                  <li><a href="#" class="dropdown-item">December</a></li>
                </ul>
              </div>
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
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2 shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-stats">
                <div class="card-stats-title">Total de produtos vendidos - 
                  <div class="dropdown d-inline">
                    <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">August</a>
                    <ul class="dropdown-menu dropdown-menu-sm">
                      <li class="dropdown-title">Select Month</li>
                      <li><a href="#" class="dropdown-item">January</a></li>
                      <li><a href="#" class="dropdown-item">February</a></li>
                      <li><a href="#" class="dropdown-item">March</a></li>
                      <li><a href="#" class="dropdown-item">April</a></li>
                      <li><a href="#" class="dropdown-item">May</a></li>
                      <li><a href="#" class="dropdown-item">June</a></li>
                      <li><a href="#" class="dropdown-item">July</a></li>
                      <li><a href="#" class="dropdown-item active">August</a></li>
                      <li><a href="#" class="dropdown-item">September</a></li>
                      <li><a href="#" class="dropdown-item">October</a></li>
                      <li><a href="#" class="dropdown-item">November</a></li>
                      <li><a href="#" class="dropdown-item">December</a></li>
                    </ul>
                  </div>
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
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
          <div class="card-header">
            <h4>Budget vs Sales</h4>
          </div>
          <div class="card-body"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <canvas id="myChart" height="280" style="display: block; width: 533px; height: 280px;" width="533" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card gradient-bottom shadow-lg p-3 mb-5 bg-white rounded">
          <div class="card-header">
            <h4>Top 5 Produtos</h4>
          </div>
          <div class="card-body" id="top-5-scroll" style="height: 315px; overflow: hidden; outline: currentcolor none medium;" tabindex="2">
            <ul class="list-unstyled list-unstyled-border">
              <li class="media">
                <img class="mr-3 rounded" src="assets/img/products/product-3-50.png" alt="product" width="55">
                <div class="media-body">
                  <div class="float-right"><div class="font-weight-600 text-muted text-small">86 Sales</div></div>
                  <div class="media-title">oPhone S9 Limited</div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square bg-primary" data-width="64%" style="width: 64%;"></div>
                      <div class="budget-price-label">$68,714</div>
                    </div>
                    <div class="budget-price">
                      <div class="budget-price-square bg-danger" data-width="43%" style="width: 43%;"></div>
                      <div class="budget-price-label">$38,700</div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="media">
                <img class="mr-3 rounded" src="assets/img/products/product-4-50.png" alt="product" width="55">
                <div class="media-body">
                  <div class="float-right"><div class="font-weight-600 text-muted text-small">67 Sales</div></div>
                  <div class="media-title">iBook Pro 2018</div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square bg-primary" data-width="84%" style="width: 84%;"></div>
                      <div class="budget-price-label">$107,133</div>
                    </div>
                    <div class="budget-price">
                      <div class="budget-price-square bg-danger" data-width="60%" style="width: 60%;"></div>
                      <div class="budget-price-label">$91,455</div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="media">
                <img class="mr-3 rounded" src="assets/img/products/product-1-50.png" alt="product" width="55">
                <div class="media-body">
                  <div class="float-right"><div class="font-weight-600 text-muted text-small">63 Sales</div></div>
                  <div class="media-title">Headphone Blitz</div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square bg-primary" data-width="34%" style="width: 34%;"></div>
                      <div class="budget-price-label">$3,717</div>
                    </div>
                    <div class="budget-price">
                      <div class="budget-price-square bg-danger" data-width="28%" style="width: 28%;"></div>
                      <div class="budget-price-label">$2,835</div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="media">
                <img class="mr-3 rounded" src="assets/img/products/product-3-50.png" alt="product" width="55">
                <div class="media-body">
                  <div class="float-right"><div class="font-weight-600 text-muted text-small">28 Sales</div></div>
                  <div class="media-title">oPhone X Lite</div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square bg-primary" data-width="45%" style="width: 45%;"></div>
                      <div class="budget-price-label">$13,972</div>
                    </div>
                    <div class="budget-price">
                      <div class="budget-price-square bg-danger" data-width="30%" style="width: 30%;"></div>
                      <div class="budget-price-label">$9,660</div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="media">
                <img class="mr-3 rounded" src="assets/img/products/product-5-50.png" alt="product" width="55">
                <div class="media-body">
                  <div class="float-right"><div class="font-weight-600 text-muted text-small">19 Sales</div></div>
                  <div class="media-title">Old Camera</div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square bg-primary" data-width="35%" style="width: 35%;"></div>
                      <div class="budget-price-label">$7,391</div>
                    </div>
                    <div class="budget-price">
                      <div class="budget-price-square bg-danger" data-width="28%" style="width: 28%;"></div>
                      <div class="budget-price-label">$5,472</div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="card-footer pt-3 d-flex justify-content-center">
            <div class="budget-price justify-content-center">
              <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
              <div class="budget-price-label">Selling Price</div>
            </div>
            <div class="budget-price justify-content-center">
              <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
              <div class="budget-price-label">Budget Price</div>
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
              <div class=" col-12" id="weather">
                </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script src="{{asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/crypto-js@3.1.9-1/crypto-js.js"></script>
<script src="{{asset('assets/modules/plugin-tempo/jquery.weather.br.js')}}"></script>

<script>
    $(function() {
        $('#weather').weather({
            geoLocation:false,
            locationLat: "MS",
            locationLon: "Corumbá"
        });
    });
</script>
@endpush
