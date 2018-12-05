@extends('master')

@section('usuario', $User)

@section('conteudo')
<br>
<div class="container-fluid">
    <div class="row align-content-center">
        <div class="card col-12">
            <div class="card-header">
                Propriedade
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <table class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Localização</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($propriedades as $propriedade)
                            <tr>
                                <td>{{$propriedade['propriedade']['nome']}}</td>
                                <td>{{$propriedade['propriedade']['localizacao']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </blockquote>
            </div>
        </div>
    </div>
    <div style="padding-top: 1%;" class="row align-content-center">
                <div class="col-6 card">
                    <div class="card-header">
                        Talhão
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                                <table class="table table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Area</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach ($propriedades as $propriedade)
                                        @if($propriedade['talhao'])
                                            @foreach ($propriedade['talhao'] as $prop)
                                                @if($prop)
                                                    <tr>
                                                        <td>{{$prop['nome']}}</td>
                                                        <td>{{$prop['area']}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                        </blockquote>
                        <a href="#" class="btn btn-primary">Inserir</a>
                    </div>
                </div>
        &nbsp;
                <div class="col-5 card ">
                    <div class="card-header">
                        Produto
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Unidade</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($propriedades as $propriedade)
                                    @if($propriedade['produtos'])
                                        @foreach ($propriedade['produtos'] as $prop)
                                            @if($prop)
                                                <tr>
                                                    <td>{{$prop['nome']}}</td>
                                                    <td>{{$prop['unidade_id']}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </blockquote>
                    </div>
                </div>
    </div>
</div>
@endsection