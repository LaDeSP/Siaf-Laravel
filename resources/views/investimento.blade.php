
@extends('master')

@section('usuario', $User)

@section('conteudo')
    <div class="">
        <div class="col-10 text-right">
            <a id="add" data-toggle="modal" data-target="#exampleModal" class="btn btn-success text-light">Adicionar</a>
        </div>
                <div class="conteiner col-10">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th>Propriedade</th>
                                <th>Investimento</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                                <th>Valor R$</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dados as $d)
                                <tr>
                                    <td> {{$propriedade->nome}} </td>
                                    <td>{{$d->nome}}</td>
                                    <td>{{$d->descricao}}</td>
                                    <td>{{$d->quantidade}}</td>
                                    <td>{{$d->valor_unit}}</td>
                                    <td class="data">{{ $d->data}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a onclick="edit(this)" id ="editInvest" class="btn btn-xs btn-warning" data-id="{{$d->id}}">Editar</a>                    
                                            </div>
                                            <div class="col-sm-6">
                                                <form method="post" id="investimentoDelete" action="/investimento/{{$d->id}}">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" id="regitrarInves" class="btn btn-xs btn-danger delete confirm" msg="Tem certeza que deseja excluir o {{$Tela}} {{$d->nome}} . " name="salvar">Excluir</button>
                                            </form>
                                            </div>
                                        </div>
                                    </td>
                               </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        @if(($dados->isEmpty()))
                <div class="text-center">
                    <p>Por favor, adicione investimentos!</p>
                </div>
            @endif

    </div>  
    <!-- Modal add -->
    <div class="modal fade" id="exampleModal" role="dialog">
        <div class="modal-dialog modal-lg">
    
           <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Adicionar investimento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" id="investimento" action="/investimento">
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
                            <label for="nome" class="control-label">Investimento<span style="color: red">*</span></label>
                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{6,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descricao" class="control-label">Descrição</label>
                        <textarea class="form-control " id="descricao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="descricao" placeholder="Descrição">{{ isset($dados->descricao) ? $dados->descricao : '' }}</textarea>
                    </div>
                    <div class="row">
                            <div class="form-group col-md-4">
                                <label for="valor_unit" class="control-label">Quantidade<span style="color: red">*</span></label>
                                <input type="number" min="1" pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="" value="{{ isset($dados->quantidade) ? $dados->quantidade : '' }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
                                <input type="number" min="1" step="0.01" pattern="[0-9]$"class="form-control " id="valor" name="valor_unit" placeholder="" value="{{ isset($dados->valor_unit) ? $dados->valor_unit : '' }}" required>
                            </div>
                        <div class="form-group date col-md-4">
                            <label for="data" class="control-label">Data<span style="color: red">*</span></label>
                            <input type="date" class="form-control data " id="data" name="data" value="{{ isset($dados->data) ? $dados->data : '' }}" required>
                        </div>
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
function edit(elem) {
    var my = $(elem).attr('data-id');
    $.ajax({
        method: "GET",
        url: "/investimento/"+my
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
        $("form#investimento [name=propriedade_id] option").text();
        $("form#investimento [name=propriedade_id] option").val(data.propriedade_id);
        $("form#investimento [name=propriedade_id]").attr('form',"investimentoEdit");
        $("form#investimento").attr('id',"investimentoEdit");
        $("#exampleModal").modal('show');
    });      
};
    
$("#investimento").submit(function( event ) {
    $('form#investimento select').removeAttr('disabled');
});

$("#investimentoEdit").submit(function( event ) {
    $('form#investimentoEdit select').removeAttr('disabled');
});
</script>
@endsection
    