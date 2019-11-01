@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/Responsive-2.2.2/css/responsive.bootstrap4.css')}}"/>
@endpush

@section('title')
Manejos
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gestão de manejos do plantio {{$plantio->produto->nome}}</h1>
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
                        <h4>Manejos <span>({{count($manejos)}})</span></h4>
                        <div class="card-header-action">
                            <a href="{{route('painel.manejoCreate', ['plantio'=>$plantio])}}" class="btn btn-success">Adicionar <i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <br>
                    <div class="card-body p-3">
                        <div class="table-responsive table-invoice">
                            @if (count($manejos) > 0)
                            <table id="table-1" class="table table-striped display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Manejo</th>
                                        <th class="text-center">Data Manejo</th>
                                        <th class="text-center">Quantidade de Horas</th>
                                        <th class="text-center">Descrição</th>
                                        <th data-priority="1" class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($manejos as $manejo)
                                    <tr>
                                        <td class="text-center">{{$manejo->pivot->manejo->nome}}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($manejo->pivot->data_hora))}}</td>
                                        <td class="text-center">{{$manejo->pivot->horas_utilizadas}}</td>
                                        <td class="text-center">{{$manejo->pivot->descricao}}</td>
                                        <td class="text-center">
                                            <a data-id="{{$manejo->pivot->slug()}}" href="#" class="btn btn-danger @if(isset($manejo->estoque)) disabled @endif delete-manejo">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="{{route('painel.manejo.edit', ['manejo'=>$manejo->pivot->slug()])}}" class="btn btn-warning @if(isset($manejo->estoque)) disabled @endif">
                                                <i class="fa fa-edit" style="font-size:10px"></i>
                                            </a>
                                            @if ($manejo->pivot->manejo_id == 4)
                                            <a href="{{route('painel.createEstoqueColheitaManejo', ['manejo'=>$manejo->pivot])}}" class="btn btn-primary @if(isset($manejo->estoque) || $plantio->quantidade_pantas == 0) disabled @endif" title="Estocar este plantio">
                                                <i class="fa fa-archive" style="font-size:10px"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Manejo</th>
                                        <th class="text-center">Horário</th>
                                        <th class="text-center">Quantidade de Horas</th>
                                        <th class="text-center">Descrição</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @else
                            <div class="text-center p-3 text-muted">
                                <h5>{{ collect(explode(' ', ucwords(strtolower(Auth::user()->name))))->slice(0, 1)->implode(' ') }}, você não possui nenhum manejo para este plantio!</h5>
                                <p>Clique no botão Adicionar para novos manejos para este plantio.</p>
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
