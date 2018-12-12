
@extends('master')

@section('usuario', $User)

@section('conteudo')
    <div class="">
        <div class="col-10 text-right">
            <a id="add" data-toggle="modal" data-target="#myModalAdd" class="btn btn-success">Adicionar</a>
        </div>
            @if((!empty($dados[0])))
                <div class="conteiner col-10">
                    <table class="table">
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
                                    <td>{{ \Carbon\Carbon::parse($d->data)->format('d/m/Y')}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <a onclick="edit(this)" id ="editInvest" class="btn btn-xs btn-warning" data-id="{{$d->id}}">Editar</a>                    
                                            </div>
                                            <div class="col-sm-4">
                                                <a onclick="excluir(this)" id ="deleteInvest" class="btn btn-xs btn-danger " data-option='{{$d}}'>Excluir</a> 
                                            </div>
                                        </div>
                                    </td>
                               </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center">
                    <p>Por favor, adicione investimentos!</p>
                </div>
            @endif
    </div>  
    <!-- Modal add -->
    <div class="modal fade" id="myModalAdd" role="dialog">
        <div class="modal-dialog modal-lg">
    
           <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" id="investimento" action="/api/investimento">
                    @csrf
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
                                <input type="number" min="1" pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="" value="" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
                                <input type="number" min="1" step="0.01" pattern="[0-9]$"class="form-control " id="valor" name="valor_unit" placeholder="" value="" required>
                            </div>
                        <div class="form-group date col-md-4">
                            <label for="data" class="control-label">Data<span style="color: red">*</span></label>
                            <input type="date" class="form-control data " id="data" name="data" value="{{ isset($dados->data) ? $dados->data : '' }}" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" id="regitrarInves" class="btn btn-success" name="salvar">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
      
        </div>
    </div>
  <!-- Modal edit -->
  <div class="modal fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" id="investimentoEdit" action="">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="propriedade_id">Propriedade</label>
                            <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="investimento" class="form-control-plaintext" name="propriedade_id" disabled>
                                        <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>   
                                </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nome" class="control-label">Investimento<span style="color: red">*</span></label>
                        <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{6,255}$" id="nome" name="nome" placeholder="Nome" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descricao" class="control-label">Descrição</label>
                    <textarea class="form-control " id="descricao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="descricao" placeholder="Descrição"></textarea>
                </div>
                <div class="row">
                            <div class="form-group col-md-4">
                                <label for="valor_unit" class="control-label">Quantidade<span style="color: red">*</span></label>
                                <input type="number" min="1" pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="" value="" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
                                <input type="number" min="1" step="0.01" pattern="[0-9]$"class="form-control " id="valor" name="valor_unit" placeholder="" value="" required>
                            </div>
                    <div class="form-group date col-md-4">
                        <label for="data" class="control-label">Data<span style="color: red">*</span></label>
                        <input type="date" class="form-control data " id="data" name="data" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" id="salvarInves" class="btn btn-success" name="salvar">Salvar</button>
                </div>
            </form>
        </div>
      </div>
      
    </div>
  </div>
    <!-- Modal delete -->
    <div class="modal fade" id="myModalDelete" role="dialog">
        <div class="modal-dialog">
    
           <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                
                <p> Tem certeza que deseja excluir o investimento <strong></strong> ?</p>
                <div class="modal-footer">
                    <form method="post" id="investimentoDelete" action="">
                        <button type="submit" id="regitrarInves" class="btn btn-success" name="salvar">Sim</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    </form>
                </div>
            </div>
        </div>
      
        </div>
    </div>
        <!-- The Modal -->
    <div class="modal fade " id="myModalSucess">
        <div class="modal-dialog ">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header alert-success">
              <h4 class="modal-title">Sucesso</h4>
              <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body alert-success alert-dismissible fade show" role="alert">
                <p> <span></span> <strong> </strong>!</p>
            </div>
          </div>
        </div>
    </div>

 <!-- The Modal -->
    <div class="modal fade " id="myModalFalha">
        <div class="modal-dialog ">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header alert-danger">
              <h4 class="modal-title">Falha</h4>
              <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body alert-danger alert-dismissible fade show" role="alert">
                <p><span></span> <strong> </strong>!</p>
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
        url: "api/investimento/"+my
    }).done(function(data){
        $("form#investimentoEdit input[name='nome']").val(data.nome);
        $("form#investimentoEdit textarea[name='descricao']").val(data.descricao);
        $("form#investimentoEdit input[name='quantidade']").val(data.quantidade);
        $("form#investimentoEdit input[name='valor_unit']").val(data.valor_unit);
        $("form#investimentoEdit input[name='data']").val(data.data);
        $("form#investimentoEdit input[name='propriedade_id']").val(data.propriedade_id);
        var url = "/api/investimento/"+data.id;
        $("form#investimentoEdit").attr('action',url);
        $("#myModalEdit").modal('show');
    });      
};
function excluir(elem) {
    var my = $(elem).attr('data-option');
    my = $.parseJSON(my);
    var url = "/api/investimento/"+my.id;
    $("form#investimentoDelete").attr('action',url);
    $("div#myModalDelete strong").text(my.nome);
    $("#myModalDelete").modal('show');
};
    
$("#investimento").submit(function( event ) {
    event.preventDefault();
    $('form#investimento select').removeAttr('disabled');
    var dado = $(this).serialize();
    $('form#investimento select').attr('disabled', 'disabled');
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: dado,
        success: function envio(data)
        {
            if (data == 200) {
                $('#myModalAdd').modal('hide');
                $("div#myModalSucess span").text("Investimento");
                $("div#myModalSucess strong").text("registrado");
                $("#myModalSucess").modal('show');
            }else{
                $('#myModalAdd').modal('hide');
                $("div#myModalFalha span").text("Investimento");
                $("div#myModalFalha strong").text("registrado");
                $("#myModalFalha").modal('show');
            }
        }
    });
});

$("#investimentoEdit").submit(function( event ) {
    event.preventDefault();
    console.log($(this).attr('action'));
    $('form#investimentoEdit select').removeAttr('disabled');
    var dado = $(this).serialize();
    $('form#investimentoEdit select').attr('disabled', 'disabled');
    $.ajax({
        type: "PUT",
        url: $(this).attr('action'),
        data: dado,
        success: function envio(data)
        {
            console.log(data);
            if (data != null) {
               $('#myModalEdit').modal('hide');
                $("div#myModalSucess span").text("Investimento");
               $("div#myModalSucess strong").text("alterado");
                $("#myModalSucess").modal('show');
                
            }else{
                $('#myModalAdd').modal('hide');
                $("div#myModalFalha span").text("Investimento");
                $("div#myModalFalha strong").text("alteração");
                $("#myModalFalha").modal('show');
            }
        }
    });
});
    
$('#myModalSucess').on('hide.bs.modal', function (e) {
    location.reload();
})
$("#investimentoDelete").submit(function( event ) {
    event.preventDefault();
    console.log($(this).attr('action'));
    $.ajax({
        type: "DELETE",
        url: $(this).attr('action'),
        success: function (data)
        {
            console.log(data);
            if (data != null) {
                $('#myModalDelete').modal('hide');
                $("div#myModalSucess span").text("Investimento");
                $("div#myModalSucess strong").text("excluído");
                $("#myModalSucess").modal('show');
                    
            }else{
                $('#myModalAdd').modal('hide');
                $("div#myModalFalha span").text("Investimento");
                $("div#myModalFalha strong").text("excluído");
                $("#myModalFalha").modal('show');
            }
        }
    }).fail(function (error) {
        $('#myModalAdd').modal('hide');
        $("div#myModalFalha span").text("Investimento");
        $("div#myModalFalha strong").text("alteração");
        $("#myModalFalha").modal('show');
        
    });
});
</script>
@endsection
    