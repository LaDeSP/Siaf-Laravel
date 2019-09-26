@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/Responsive-2.2.2/css/responsive.bootstrap4.css')}}"/>
@endpush

@section('title')
Estoques
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gestão de estoque</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Estoques <span>({{count($estoques)}})</span></h4>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive table-invoice">
                            @if (count($estoques) > 0)
                            <table id="table-1" class="table table-striped display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Produto</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-center">Unidade</th>
                                        <th class="text-center">Data Estoque</th>
                                        <th class="text-center">Data semeadura</th>
                                        <th class="text-center">Data plantio</th>
                                        <th class="text-center">Talhão</th>
                                        <th class="text-center">Data colheita</th>
                                        <th data-priority="1" class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estoques as $estoque)
                                    <tr>
                                        <td class="text-center">{{$estoque->produto->nome}}</td>
                                        <td class="text-center">{{$estoque->quantidade}}</td>
                                        <td class="text-center">{{$estoque->produto->unidade->nome}}</td>
                                        <td class="text-center">{{$estoque->data}}</td>
                                        <td class="text-center">{{$estoque->data}}</td>
                                        <td class="text-center">{{$estoque->manejoplantio_id}}</td>
                                        <td class="text-center">{{$estoque->manejoplantio->plantio->talhao->nome}}</td>
                                        <td class="text-center">{{$estoque->data}}</td>
                                        <td class="text-center">
                                            <a href="{{route('painel.createPerdaEstoque', ['estoque'=>$estoque])}}" class="btn btn-dark">
                                                    <i class="fa fa-frown"></i>  
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
                                        <th class="text-center">Data Estoque</th>
                                        <th class="text-center">Data semeadura</th>
                                        <th class="text-center">Data plantio</th>
                                        <th class="text-center">Talhão</th>
                                        <th class="text-center">Data colheita</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @else
                            <div class="text-center p-3 text-muted">
                                    <h5>{{ collect(explode(' ', ucwords(strtolower(Auth::user()->name))))->slice(0, 1)->implode(' ') }}, você não possui nenhum estoque cadastrado!</h5>
                                    <p>Clique no botão Adicionar para cadastrar novos estoques.</p>
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
