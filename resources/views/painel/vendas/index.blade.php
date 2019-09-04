@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/Responsive-2.2.2/css/responsive.bootstrap4.css')}}"/>
@endpush

@section('title')
Vendas
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gestão de Vendas</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Vendas <span>({{count($vendas)}})</span></h4>
                        <div class="card-header-action">
                            <a href="{{route('painel.venda.create')}}" class="btn btn-success">Adicionar <i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <br>
                    <div class="card-body p-3">
                        <div class="table-responsive table-invoice">
                            @if (count($vendas) > 0)
                            <table id="table-1" class="table table-striped display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Produto</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-center">Unidade</th>
                                        <th class="text-center">Valor Unitário R$</th>
                                        <th class="text-center">Total R$</th>
                                        <th class="text-center">Destino</th>
                                        <th class="text-center">Data</th>
                                        <th data-priority="1" class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendas as $venda)
                                    <tr>
                                        <td class="text-center">{{$venda->id}}</td>
                                        <td class="text-center">{{$venda->quantidade}}</td>
                                        <td class="text-center">{{$venda->estoque->produto->unidade->nome}}</td>
                                        <td class="text-center">{{$venda->valor_unit}}</td>
                                        <td class="text-center">2011/04/25</td>
                                        <td class="text-center">{{$venda->destino->nome}}</td>
                                        <td class="text-center">{{$venda->data}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <a href="{{route('painel.venda.edit', ['produto'=>$venda->id])}}" class="btn btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Produto</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-center">Unidade</th>
                                        <th class="text-center">Valor Unitário R$</th>
                                        <th class="text-center">Total R$</th>
                                        <th class="text-center">Destino</th>
                                        <th class="text-center">Data</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @else
                            <div class="text-center p-3 text-muted">
                                    <h5>{{ collect(explode(' ', ucwords(strtolower(Auth::user()->name))))->slice(0, 1)->implode(' ') }}, você não possui nenhuma venda cadastrada!</h5>
                                    <p>Clique no botão Adicionar para cadastrar novas vendas.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/modules/datatables/DataTables-1.10.18/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/modules/datatables/DataTables-1.10.18/js/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/modules/datatables/Responsive-2.2.2/js/dataTables.responsive.js')}}"></script>
<script>
    $(document).ready( function () {
        $('#table-1')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
            columnDefs: [
            { 
                responsivePriority: 1, targets: 0 
            },
            { 
                responsivePriority: 2, 
                targets: -1 
            }
            ]
        } );
    } );
</script>
@endpush
