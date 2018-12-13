@extends('master')

@section('usuario', $User)

@section('conteudo')
<br>
<div class="container-fluid">
    <div class="row align-content-center">
        <div class="card col-12">
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <table class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Localização</th>
                            <th scope="col"> Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{$propriedade['nome']}}</td>
                                <td>{{$propriedade['localizacao']}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <a onclick="edit(this)" id ="editInvest" class="btn btn-xs btn-warning" data-id="{{$propriedade['id']}}">Editar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </blockquote>
            </div>
        </div>
    </div>
    <div style="padding-top: 1%;" class="row align-content-center">
                <div class="col-6 card">
                    <div class="card-header">
                        <div class="row">
                            Talhão
                            <div class="col-md-10 col-sm-2 text-right">
                                <a id="add" data-toggle="modal" data-target="#exampleModal" class="btn btn-success text-white">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                                <table class="table table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($talhao as $t)
                                            <tr>
                                                <td>{{$t['nome']}}</td>
                                                <td>{{$t['area']}}m²</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <a onclick="edit(this)" id ="editInvest" class="btn btn-xs btn-warning" data-id="{{$t}}">Editar</a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <form method="post" id="investimentoDelete" action="/investimento/{{$t}}">
                                                                @csrf
                                                                @method("DELETE")
                                                                <button type="submit" id="regitrarInves" class="btn btn-xs btn-danger delete confirm" name="salvar">Excluir</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </blockquote>
                    </div>
                </div>
        &nbsp;
                <div class="col-5 card ">
                    <div class="card-header">
                        <div class="row">
                            Produto
                            <div class="col-md-10 col-sm-2 text-right">
                                <a id="add" data-toggle="modal" data-target="#exampleModal" class="btn btn-success text-white">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Unidade</th>
                                    <th scope="col">Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                    @foreach ($produto as $p)
                                        <tr>
                                           <td>{{$p['nome']}}</td>
                                            <td>{{$p['unidade_id']}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a onclick="edit(this)" id ="editInvest" class="btn btn-xs btn-warning" data-id="{{$p}}">Editar</a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <form method="post" id="investimentoDelete" action="/investimento/{{$p}}">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" id="regitrarInves" class="btn btn-xs btn-danger delete confirm" name="salvar">Excluir</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </blockquote>
                    </div>
                </div>
    </div>
</div>
<!-- Modal add -->
<div class="modal fade" id="exampleModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Talhão</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="propriedade" action="/propriedade">
                    @csrf
                    @method("POST")
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="propriedade_id">Propriedade</label>
                            <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="investimento" class="form-control-plaintext" name="propriedade_id" disabled>
                                <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nome" class="control-label">Talhão<span style="color: red">*</span></label>
                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{6,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="control-label">Área</label>
                        <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{6,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="regitrarInves" class="btn btn-success" name="salvar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("form#investimento input[name=_token]").val()
        }
    });
/*
    function edit(elem) {
        var my = $(elem).attr('data-id');
        $.ajax({
            url: "api/investimento/"+my
        }).done(function(data){
            $("form#investimento input[name='nome']").val(data.nome);
            $("form#investimento textarea[name='descricao']").val(data.descricao);
            $("form#investimento input[name='quantidade']").val(data.quantidade);
            $("form#investimento input[name='valor_unit']").val(data.valor_unit);
            $("form#investimento input[name='data']").val(data.data);
            $("form#investimento input[name='propriedade_id']").val(data.propriedade_id);
            var url = "/investimento/"+data.id;
            $("form#investimento input[name='_method']").val("PUT");
            $("#exampleModalLabel").text("Editar investimento");
            $("form#investimento").attr('action',url);
            $("form#investimento").attr('id',"investimentoEdit");
            $("#exampleModal").modal('show');
        });
    };
*/

    $("#investimento").submit(function( event ) {
        $('form#investimento select').removeAttr('disabled');
    });

    $("#investimentoEdit").submit(function( event ) {
        $('form#investimentoEdit select').removeAttr('disabled');
    });
</script>
@endsection