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
                        <thead class="thead-light">
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
                                            <a onclick="edit1(this)" id ="editInvest" class="btn btn-xs btn-warning" data-id="{{$propriedade['id']}}">Editar</a>
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
                            <font class="lead font-weight-bold"> Talhão</font>
                            <div class="col-md-10 col-sm-2 text-right">
                                <a id="add" data-toggle="modal" data-target="#talhaoModal" class="btn btn-success text-white">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                                <table class="table table-hover table-condensed">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Área</th>
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
                                                            <a onclick="edit2(this)" id ="editTalhao" class="btn btn-xs btn-warning" data-id="{{$t['id']}}">Editar</a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <form method="post" id="talhaoDelete" action="/talhao/{{$t['id']}}">
                                                                @csrf
                                                                @method("DELETE")
                                                                <button type="submit" id="regitrarInves" class="btn btn-xs btn-danger delete confirm"  msg='Tem certeza que deseja excluir o talhão {{$t->nome}}.' name="salvar">Excluir</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @if(($talhao->isEmpty()))
                                <div class="text-center">
                                    <p>Por favor, adicione um talhão!</p>
                                </div>
                            @endif
                        </blockquote>
                    </div>
                </div>
        &nbsp;
                <div class="col-5 card ">
                    <div class="card-header">
                        <div class="row">
                            <font class="lead font-weight-bold">Produto</font>
                            <div class="col-md-10 col-sm-2 text-right">
                                <a id="add" data-toggle="modal" data-target="#produtoModal" class="btn btn-success text-white">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <table class="table table-hover table-condensed">
                                <thead class="thead-light">
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
                                                        <a onclick="edit(this)" id ="editProduto" class="btn btn-xs btn-warning" data-id="{{$p['id']}}">Editar</a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <form method="post" id="produtoDelete" action="/produto/{{$p['id']}}">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" id="regitrarInves" class="btn btn-xs btn-danger delete confirm"  msg='Tem certeza que deseja excluir o produto {{$p->nome}} . ' name="salvar">Excluir</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(($produto->isEmpty()))
                                <div class="text-center">
                                    <p>Por favor, adicione um produto!</p>
                                </div>
                            @endif

                        </blockquote>
                    </div>
                </div>
    </div>
</div>
<!-- Modal add -->
<div class="modal fade" id="produtoModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="produtoModalLabel">Adicionar Produto</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="produto" action="/produto">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="propriedade_id">Propriedade</label>
                            <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="produto" class="form-control-plaintext" id="propriedade_id" name="propriedade_id">
                                <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="nome" class="control-label">Produto<span style="color: red">*</span></label>
                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{2,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="control-label">Unidade</label>
                        <select form="produto" class="form-control-plaintext" id="unidade_id" name="unidade_id">
                            @foreach($unidades as $u)
                                <option value="{{$u->id}}"> {{$u->nome}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="nome" class="control-label">Plantável</label>
                        <input type="checkbox" id="plantavel" name="plantavel">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

 <!-- Modal add -->
 <div class="modal fade" id="propModal" role="dialog">
     <div class="modal-dialog modal-lg">

         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="propriedadeModalLabel">Adicionar Propriedade</h5>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body">
                 <form method="POST" id="propriedade" action="/propriedade">
                     @csrf
                     @method('POST')
                     <div class="row">
                         <div class="form-group col-md-12">
                             <label for="propriedade_id">Propriedade</label>
                             <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="produto" class="form-control-plaintext" id="propriedade_id" name="propriedade_id">
                                 <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>
                             </select>
                         </div>
                         <div class="form-group col-md-12">
                             <label for="nome" class="control-label">Nome<span style="color: red">*</span></label>
                             <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{2,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="area" class="control-label">Localização</label>
                         <input class="form-control-plaintext" id="localiza" name="localiza"  placeholder="Localização" value="{{ isset($dados->localiza) ? $dados->localiza: '' }}" required>
                     </div>
                     <div class="text-center">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                         <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                     </div>
                 </form>
             </div>
         </div>

     </div>
 </div>

 <div class="modal fade" id="talhaoModal" role="dialog">
     <div class="modal-dialog modal-lg">

         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="talhaoModalLabel">Adicionar Talhão</h5>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body">
                 <form method="POST" id="talhao" action="/talhao">
                     @csrf
                     @method("POST")
                     <div class="row">
                         <div class="form-group col-md-6">
                             <label for="propriedade_id">Propriedade</label>
                             <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="talhao" class="form-control-plaintext" name="propriedade_id">
                                 <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>
                             </select>
                         </div>
                         <div class="form-group col-md-6">
                             <label for="nome" class="control-label">Talhão<span style="color: red">*</span></label>
                             <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{2,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="area" class="control-label">Área em m²</label>
                         <input type="text" class="form-control " pattern="{6,255}$" id="area" name="area" placeholder="exemplo: 20" value="{{ isset($dados->area) ? $dados->area : '' }}" required>
                     </div>
                     <div class="text-center">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                         <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                     </div>
                 </form>
             </div>
         </div>

     </div>
 </div>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("form#produto input[name=_token]").val()
        }
    });

    function edit(elem) {
        var my = $(elem).attr('data-id');
        $.ajax({
            url: "/produto/"+my,
            method: "GET"
        }).done(function(data){
            $("form#produto input[name='nome']").val(data.nome);
            $("form#produto [name=plantavel]").prop('checked',data.plantavel);
            $("form#produto input[name='unidade_id']").val(data.unidade_id);
            $("form#produto [name=propriedade_id]").val(data.propriedade_id);
            // console.log($("form#produto input[name='propriedade_id']").val(data.propriedade_id));
            var url = "produto/"+data.id;
            $("form#produto input[name='_method']").val("PUT");
            $("#produtoModalLabel").text("Editar produto");
            console.log(url);
            $("form#produto").attr('action',url);
            $("form#produto [name=propriedade_id]").attr("form","produtoEdit");
            $("form#produto [name=unidade_id]").attr("form","produtoEdit");
            $("form#produto").attr('id',"produtoEdit");
            $("#produtoModal").modal('show');
        });
    };

    function edit1(elem) {
        var my = $(elem).attr('data-id');
        $.ajax({
            url: "/propriedade/"+my,
            method: "GET"
        }).done(function(data){
            $("form#propriedade input[name='nome']").val(data.nome);
            $("form#propriedade input[name='localiza']").val(data.localizacao);
            $("form#propriedade [name='propriedade_id']").val(data.propriedade_id);
            var url = "propriedade/"+data.id;
            $("form#propriedade input[name='_method']").val("PUT");
            $("#propriedadeModalLabel").text("Editar propriedade");
            $("form#propriedade").attr('action',url);
            $("form#propriedade [name=propriedade_id]").attr("form","propEdit");
            $("form#propriedade").attr('id',"propEdit");
            $("#propModal").modal('show');
        });
    };

    function edit2(elem) {
        var my = $(elem).attr('data-id');
        $.ajax({
            url: "/talhao/"+my,
            method: "GET"
        }).done(function(data){
            console.log(data);
            $("form#talhao input[name='nome']").val(data.nome);
            $("form#talhao input[name='area']").val(data.area);
            $("form#talhao [name='propriedade_id']").val(data.propriedade_id);

            var url = "/talhao/"+data.id;
            $("form#talhao input[name='_method']").val("PUT");
            $("#talhaoModalLabel").text("Editar talhão");
            console.log(url);
            $("form#talhao").attr('action',url);
            $("form#talhao [name='propriedade_id']").attr("form","talhaoEdit");
            $("form#talhao").attr('id',"talhaoEdit");
            $("#talhaoModal").modal('show');
        });
    };

    $("#produto").submit(function( event ) {
        $('form#investimento select').removeAttr('disabled');
    });

    $("#produtoEdit").submit(function( event ) {
        alert(this.serialize());
        // $('form#investimentoEdit select').removeAttr('disabled');
    });
</script>
@endsection