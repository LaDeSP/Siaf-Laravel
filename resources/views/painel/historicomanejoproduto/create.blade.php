@extends('layouts.admin-master')

@section('title')
Adicionar Manejo
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar manejo</h1>
    </div>
    <div class="section-body">
        <div class="row d-flex justify-content-center">
            <!--<div class="alert alert-success alert-dismissible show fade col-10">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    This is a danger alert.
                </div>
            </div>-->
            <div class="col-12">
                <div class="card">
                    <form class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Manejo<span class="text-danger">*</span></label>
                                <select class="form-control">
                                    <option>Capina</option>
                                    <option>Desbaste</option>
                                    <option>Rega</option>
                                    <option>Colheita</option>
                                    <option>Adubação</option>
                                    <option>Controle de pragas</option>
                                    <option>Aração</option>
                                </select>
                            </div>  
                            <div class="form-group">
                                <label>Descrição</span></label>
                                <input type="text" class="form-control">
                                <div class="invalid-feedback">
                                    Qual a quantidade de plantas?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Horas Utilizadas<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" placeholder="Ex: 5">
                                <div class="invalid-feedback">
                                    Qual horas foram utilizadas num manejo?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Data<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" required="">
                                <div class="invalid-feedback">
                                    Qual foi a data do manejo
                                </div>
                            </div>          
                          </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

