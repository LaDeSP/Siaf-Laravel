@extends('master')
@section('usuario', $User)
@section('conteudo')
    <div class="">
    	<div class="col-10 text-right">
    		<a id="add" data-toggle="modal" data-target="#myModalAdd" class="btn btn-success">Adicionar</a>
    	</div>
			@if(empty($dados[0]))
				<div class="text-center">
					<p>Por favor, adicione despesas!</p>
				</div>
			@else
				<div class="col-10" >
					<table class="table">
                        <thead>
                            <tr>
                                <th>Propriedade</th>
                                <th>Despesa</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                                <th>Valor (R$)</th>
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
                                            <div class="col-sm-6">
                                                <a onclick="edit(this)" id ="editDespesa" class="btn btn-xs btn-warning" data-id="{{$d->id}}">Editar</a>                    
                                            </div>
                                            <div class="col-sm-6">
                                                <a onclick="excluir(this)" id ="deleteDespesa" class="btn btn-xs btn-danger " data-dado='{ "nome" : "{{$d->nome}}", "id" : {{$d->id}}}' >Excluir</a> 
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
	                <form method="POST" id="despesa" action="/api/despesa">
	                    @csrf
	                    <div class="row">
	                        <div class="form-group col-md-6">
	                            <label for="propriedade_id">Propriedade</label>
	                            <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="despesa" class="form-control-plaintext" name="propriedade_id" disabled>
	                                        <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>   
	                                </select>
	                        </div>
	                        <div class="form-group col-md-6">
	                            <label for="nome" class="control-label">Despesa<span style="color: red">*</span></label>
	                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{6,255}$" id="nome" name="nome" placeholder="" value="" required>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="descricao" class="control-label">Descrição</label>
	                        <textarea class="form-control " id="descricao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="descricao" placeholder=""></textarea>
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
	                            <input type="date" class="form-control data " id="data" name="data" value="" required>
	                        </div>
	                    </div>
	                    <div class="text-center">
	                        <button type="submit" id="regitrarDespesa" class="btn btn-success" name="salvar">Registrar</button>
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
	          <form method="POST" id="despesaEdit" action="">
	                <div class="row">
	                    <div class="form-group col-md-6">
	                        <label for="propriedade_id">Propriedade</label>
	                            <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="despesa" class="form-control-plaintext" name="propriedade_id" disabled>
	                                        <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>   
	                                </select>
	                    </div>
	                    <div class="form-group col-md-6">
	                        <label for="nome" class="control-label">Despesa<span style="color: red">*</span></label>
	                        <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{6,255}$" id="nome" name="nome" placeholder="" required>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="descricao" class="control-label">Descrição</label>
	                    <textarea class="form-control " id="descricao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="descricao" placeholder=""></textarea>
	                </div>
	                <div class="row">
	                    <div class="form-group col-md-4">
	                        <label for="valor_unit" class="control-label">Quantidade<span style="color: red">*</span></label>
	                        <input type="number" min="1" pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="" required>
	                    </div>
	                    <div class="form-group col-md-4">
	                        <label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
	                        <input type="number" min="1" step="0.01" pattern="[0-9]$"class="form-control " id="valor" name="valor_unit" placeholder="" required>
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
                
                <p> Tem certeza que deseja excluir <strong></strong> ?</p>
                <div class="modal-footer">
                    <form method="post" id="despesaDelete" action="">
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
       'X-CSRF-TOKEN': $("form#despesa input[name=_token]").val()
    }
});
function edit(elem) {
    var my = $(elem).attr('data-id');
    $.ajax({
        url: "api/despesa/"+my
    }).done(function(data){
        console.log(data);
        $("form#despesaEdit input[name='nome']").val(data.nome);
        $("form#despesaEdit textarea[name='descricao']").val(data.descricao);
        $("form#despesaEdit input[name='quantidade']").val(data.quantidade);
        $("form#despesaEdit input[name='valor_unit']").val(data.valor_unit);
        $("form#despesaEdit input[name='data']").val(data.data);
        $("form#despesaEdit input[name='propriedade_id']").val(data.propriedade_id);
        var url = "/api/despesa/"+data.id;
        $("form#despesaEdit").attr('action',url);
        $("#myModalEdit").modal('show');
    });      
};

function excluir(elem) {
    var my =  $(elem).data('dado');
    console.log(my);
    var url = "/api/despesa/"+my.id;
    $("form#despesaDelete").attr('action',url);
    $("div#myModalDelete strong").text("a despesa "+my.nome);
    $("#myModalDelete").modal('show');
};
    
$("#despesa").submit(function( event ) {
    event.preventDefault();
    $('form#despesa select').removeAttr('disabled');
    var dado = $(this).serialize();
    $('form#despesa select').attr('disabled', 'disabled');
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: dado,
        success: function envio(data)
        {
            console.log(data);
            if (data == 200) {
                $('#myModalAdd').modal('hide');
                $("div#myModalSucess span").text("Despesa");
                $("div#myModalSucess strong").text("registrado");
                $("#myModalSucess").modal('show');
                  
            }else{
              	$('#myModalAdd').modal('hide');
              	$("div#myModalFalha span").text("Despesa");
                $("div#myModalFalha strong").text("registro");
                $("#myModalFalha").modal('show');
            }
        }
    }).fail(function (error) {
        $('#myModalAdd').modal('hide');
        $("div#myModalFalha span").text("Despesa");
        $("div#myModalFalha strong").text("excluir");
        $("#myModalFalha").modal('show');
        console.log(error);
    });
});

$("#despesaEdit").submit(function( event ) {
    event.preventDefault();
    console.log($(this).attr('action'));
    $('form#despesaEdit select').removeAttr('disabled');
    var dado = $(this).serialize();
    $('form#despesaEdit select').attr('disabled', 'disabled');
    $.ajax({
        type: "PUT",
        url: $(this).attr('action'),
        data: dado,
        success: function envio(data)
        {
            console.log(data);
            if (data == 200) {
            $('#myModalEdit').modal('hide');
            $("div#myModalSucess span").text("Despesa");
            $("div#myModalSucess strong").text("alterado");
            $("#myModalSucess").modal('show');
                  
            }else{
              	$('#myModalAdd').modal('hide');
               	$("div#myModalFalha span").text("Despesa");
                $("div#myModalFalha strong").text("alteração");
                $("#myModalFalha").modal('show');
            }
        }
    });
});
    
$('#myModalSucess').on('hide.bs.modal', function (e) {
    location.reload();
})

$("#despesaDelete").submit(function( event ) {
    event.preventDefault();
    console.log($(this).attr('action'));
    $.ajax({
        type: "DELETE",
        url: $(this).attr('action'),
        success: function (data)
        {
            console.log(data);
            if (data == 200) {
                $('#myModalDelete').modal('hide');
                $("div#myModalSucess span").text("Despesa");
                $("div#myModalSucess strong").text("excluído");
                $("#myModalSucess").modal('show');
            }else{
              	$('#myModalAdd').modal('hide');
               	$("div#myModalFalha span").text("Despesa");
                $("div#myModalFalha strong").text("excluir");
                $("#myModalFalha").modal('show');
            }
        }
    }).fail(function (error) {
        $('#myModalAdd').modal('hide');
        $("div#myModalFalha span").text("Despesa");
        $("div#myModalFalha strong").text("excluir");
        $("#myModalFalha").modal('show');
        console.log(error);
    });
});
</script>
@endsection