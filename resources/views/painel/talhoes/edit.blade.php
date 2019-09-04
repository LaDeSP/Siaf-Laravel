@extends('layouts.admin-master')

@section('title')
Adicionar Produto
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adicionar Produto</h1>
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
                                <label>Nome do produto</label>
                                <input type="text" class="form-control" required="" placeholder="Ex: Tomate">
                                <div class="invalid-feedback">
                                    Qual o nome do produto?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Unidade</label>
                                <select class="form-control">
                                    <option>KG</option>
                                    <option>LT</option>
                                    <option>UN</option>
                                    <option>DZ</option>
                                </select>
                            </div>
                            <div class="form-group">
                            <div class="form-check">
                              <label class="form-check-label" for="defaultCheck1">  
                              <input class="form-check-input" type="checkbox" id="defaultCheck1">
                              Plantável
                              </label>
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
