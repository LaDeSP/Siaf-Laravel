@extends('layouts.admin-master')

@section('title')
Adicionar Talhão
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar Talhão</h1>
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
                                <label>Nome do talhão<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" placeholder="Ex: Talhão 1">
                                <div class="invalid-feedback">
                                    Qual o nome do talhão?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Área em m²<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" placeholder="Ex: 50">
                                <div class="invalid-feedback">
                                    Qual o tamanho do talhão?
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


