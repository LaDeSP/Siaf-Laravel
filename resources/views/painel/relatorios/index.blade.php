@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/modules/daterangepicker/css/daterangepicker.css')}}">
@endpush

@section('title')
Gerar Relatórios
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gerar Relatórios</h1>
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
                    <p class="section-lead m-2">Campos marcado com (<b><span class="text-danger">*</span></b>) são obrigatórios</p>
                    <form method="GET" name="addinvestimento" action="{{ route('painel.gerarRelatorio') }}" class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Relatório que deseja gerar<span class="text-danger">*</span></label>
                                <select name="tipoRelatorio" class="custom-select form-control {{ $errors->has('tipoRelatorio') ? ' is-invalid' : '' }}" required value="{{ old('tipoRelatorio') }}">
                                    <option selected="" value="">Selecione um relatório</option>
                                    <option value="investimentos"> Investimentos realizados por período </option>
                                    <option value="despesa"> Despesa realizadas por período</option>
                                    <option value="plantios"> Plantios realizados por período</option>
                                    <option value="manejoTalhao"> Manejos realizados por período por talhão </option>
                                    <option value="manejoPropriedade"> Manejos realizados por período por propriedade </option>
                                    <option value="colheitas">Colheitas realizadas por período </option>
                                    <option value="talhao"> Talhões por propriedade</option>
                                    <option value="produtosAtivosInativos"> Produtos ativos e inativos por propriedade</option>
                                    <option value="historicoManejoPlantio"> Histórico de manejo por plantio</option>
                                    <option value="estoquePropriedade"> Estoque por propriedade por período </option>
                                    <option value="vendas"> Vendas realizadas por período</option>
                                    <option value="perdas"> Perdas por período</option>
                                </select>
                                <div class="invalid-feedback">
                                    Escolha um relatório!
                                </div>
                                @if ($errors->has('tipoRelatorio'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tipoRelatorio') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Período do relatório</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="dates" id="dates">
                                    <div class="invalid-feedback">
                                        Escolha o períododo do relatório!
                                    </div>
                                    @if ($errors->has('dates'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('dates') }}
                                    </div>
                                    @endif
                                </div>
                            </div>        
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success" formtarget="_blank">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/modules/daterangepicker/js/daterangepicker.min.js')}}"></script>

<script>
    $(function() {
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            opens: 'center',
            locale: {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "De",
                "toLabel": "Até",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sáb"
                ],
                "monthNames": [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
                ],
                "firstDay": 1
            }
        });
        
        $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' até ' + picker.endDate.format('DD/MM/YYYY'));
        });
        
        $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        
        $('select[name=tipoRelatorio]').change(function () {
            tipo = $(this).val();
            var inputE = document.getElementById("dates");
            if (tipo == 'talhao' || tipo == 'produtosAtivosInativos'){
                inputE.disabled = true;
            }else{
                inputE.disabled = false;
            }                   
        });
    });
</script>
@endpush



