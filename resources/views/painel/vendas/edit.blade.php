@extends('layouts.admin-master')

@section('title')
Adicionar venda
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar venda</h1>
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
                                <label>Estoque<span class="text-danger">*</span></label>
                                <select class="form-control">
                                    <option>Produto</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Destino<span class="text-danger">*</span></label>
                                <select class="form-control">
                                    <option>Escola</option>
                                    <option>Feira</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quantidade<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" placeholder="Ex: 30">
                                <div class="invalid-feedback">
                                    Qual a quantidade de produtos vendidos?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Preço<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" placeholder="Ex: 3.15">
                                <div class="invalid-feedback">
                                    Por quanto foi vendido cada unidade?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Data da venda<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" required="">
                                <div class="invalid-feedback">
                                    Qual foi a data da venda?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nota</label>
                                <input type="text" class="form-control">
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
