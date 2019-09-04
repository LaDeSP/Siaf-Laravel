@extends('layouts.admin-master')

@section('title')
Adicionar plantio
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar plantio</h1>
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
                                <label>Data da semeadura</label>
                                <input type="date" class="form-control" required="">
                                <div class="invalid-feedback">
                                    Qual foi a data da semadura?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Data do plantio<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" required="">
                                <div class="invalid-feedback">
                                    Qual foi a data do plantio?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Número de plantas<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" placeholder="Ex: 40">
                                <div class="invalid-feedback">
                                    Qual a quantidade de plantas?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Talhão<span class="text-danger">*</span></label>
                                <select class="form-control">
                                    <option>Talhãozão do tomilho</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Produto<span class="text-danger">*</span></label>
                                <select class="form-control">
                                    <option>tomate</option>
                                    <option>batata</option>
                                </select>
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
