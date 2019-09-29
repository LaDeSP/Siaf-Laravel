@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/Responsive-2.2.2/css/responsive.bootstrap4.css')}}"/>
@endpush

@section('title')
Plantio
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gestão de plantios</h1>
    </div>
    <div class="section-body">
            <div class="row d-flex justify-content-center">
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible show fade col-10">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>×</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif
            </div>
            
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Plantios <span>({{count($plantios)}})</span></h4>
                        <div class="card-header-action">
                            <a href="{{route('painel.plantio.create')}}" class="btn btn-success">Adicionar <i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <br>
                    <div class="card-body p-3">
                        <div class="table-responsive table-invoice">
                            @if (count($plantios) > 0)
                            <table id="table-1" class="table table-striped display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Produto</th>
                                        <th class="text-center">Tipo do produto</th>
                                        <th class="text-center">Data semeadura</th>
                                        <th class="text-center">Data Plantio</th>
                                        <th class="text-center">Quantidade de plantas</th>
                                        <th class="text-center">Talhão</th>
                                        <th data-priority="1" class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plantios as $plantio)
                                    <tr>
                                        <td class="text-center">{{$plantio->produto->nome}}</td>
                                        <td class="text-center">{{$plantio->produto()->first()->tipo == "c_permanente"? "Permanente":"Temporário"}}</td>
                                        <td class="text-center">{{$plantio->data_semeadura ? date('d/m/Y', strtotime($plantio->data_semeadura)) : 'Sem Data'}}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($plantio->data_plantio))}}</td>
                                        <td class="text-center">{{$plantio->quantidade_pantas}}</td>
                                        <td class="text-center">{{$plantio->talhao->nome}}</td>
                                        <td class="text-center">
                                            <a data-id="{{$plantio->slug()}}" href="#" class="btn btn-danger @if(isset($plantio->perda) || isset($plantio->manejo)) disabled @endif delete-plantio">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="{{route('painel.plantio.edit', ['plantio'=>$plantio])}}" class="btn btn-warning @if(isset($plantio->perda) || isset($plantio->manejo)) disabled @endif">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('painel.createPerdaPlantio', ['plantio'=>$plantio])}}" class="btn btn-dark @if($plantio->quantidade_pantas == 0) disabled @endif">
                                                <i class="fas fa-exclamation"></i>  
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Produto</th>
                                        <th class="text-center">Tipo do produto</th>
                                        <th class="text-center">Data semeadura</th>
                                        <th class="text-center">Data Plantio</th>
                                        <th class="text-center">Quantidade de plantas</th>
                                        <th class="text-center">Talhão</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @else
                            <div class="text-center p-3 text-muted">
                                <h5>{{ collect(explode(' ', ucwords(strtolower(Auth::user()->name))))->slice(0, 1)->implode(' ') }}, você não possui nenhum plantio cadastrado!</h5>
                                <p>Clique no botão Adicionar para cadastrar novos plantios.</p>
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
<script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{ asset('assets/js/page/modules-sweetalert.js')}}"></script>
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
