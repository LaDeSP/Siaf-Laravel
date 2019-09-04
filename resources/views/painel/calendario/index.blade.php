@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/Responsive-2.2.2/css/responsive.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/fullcalendar/fullcalendar.min.css')}}"/>
@endpush


@section('title')
Estoque
@endsection

@section('content')
<section class="section">
  <div class="section-header">
      <h1>Calendário</h1>
  </div>
  <div class="section-body">
      <div class="form-group">
          <label>Selecione</label>
          <select class="form-control">
            <option>Abacate</option>
            <option>Abacaxi</option>
            <option>Abóbora Comum</option>
            <option>Abóbora Kabotian</option>
            <option>Abóbora Moranga</option>
            <option>Acelga</option>
            <option>Acerola</option>
            <option>Agrião</option>
            <option>Alface</option>
            <option>Almeirão</option>
            <option>Banana da Terra</option>
            <option>Banana Maçã</option>
            <option>Banana Nanica</option>
            <option>Batata Doce</option>
            <option>Berinjela</option>
            <option>Beterraba</option>
            <option>Cebolinha</option>
            <option>Cenoura</option>
            <option>Chicória</option>
            <option>Coco Verde</option>
            <option>Coentro</option>
            <option>Couve Folha</option>
            <option>Espinafre</option>
            <option>Fruta do conde</option>
            <option>Goiaba</option>
            <option>Jiló</option>
            <option>Laranja</option>
            <option>Limão</option>
            <option>Mamão Formosa</option>
            <option>Mamão Papaya</option>
            <option>Mandioca Mesa</option>
            <option>Manga</option>
            <option>Maracujá</option>
            <option>Maxixe</option>
            <option>Melancia</option>
            <option>Melão</option>
            <option>Mostarda</option>
            <option>Pepino</option>
            <option>Pimentão</option>
            <option>Poncã</option>
            <option>Quiabo</option>
            <option>Rabanete</option>
            <option>Repolho</option>
            <option>Rúcula</option>
            <option>Salsa</option>
            <option>Tomate</option>
            <option>Tomate cereja</option>
            <option>Vagem</option>
          </select>
        </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/modules/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/js/page/modules-calendar.js')}}"></script>
@endpush
