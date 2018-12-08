
@extends('master')

@section('usuario', $User)

@section('conteudo')
    <div class="">
    	<div class="col-10 text-right">
    		<a id="add" data-toggle="modal" data-target="#myModalAdd" class="btn btn-success">Adicionar</a>
    	</div>
			@if((!empty($dados[0][0])))
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
							@foreach ($dados as $dado)
							    @foreach ($dado as $d)
							        <tr>
										<td>
											@foreach ($propriedades as $propriedade)
												@if($propriedade->id == $d->propriedade_id)
													{{$propriedade->nome}}
												@endif
										   	@endforeach
											
										</td>
										<td>{{$d->nome}}</td>
										<td>{{$d->descricao}}</td>
										<td>{{$d->quantidade}}</td>
										<td>{{$d->valor_unit}}</td>
										<td>{{ \Carbon\Carbon::parse($d->data)->format('d/m/Y')}}</td>
										<td>
											<div class="row">
												<div class="col-sm-4">
													<a id ="editInvest" class="btn btn-xs btn-warning" onclick="edit('{{ $d->id }}' )">Editar</a>
													
												</div>
												<div class="col-sm-4">
													<a id ="deleteInvest" class="btn btn-xs btn-danger " onclick="excluir('{{ $d->id }}' )">Excluir</a>
													
												</div>
											</div>
										</td>
									</tr>
							    @endforeach
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
					@method("POST")
					@csrf
					<div class="row">
						<div class="form-group col-md-6">
							<label for="propriedade_id">Propriedades</label>
								<select form="investimento" class="form-control" name="propriedade_id" required>
								    @foreach ($propriedades as $propriedade)
										<option value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>	
								   	@endforeach
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
							<input type="number"  pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="Quantidade" value="{{ isset($dados->quantidade) ? $dados->quantidade : '' }}" required>
						</div>
						<div class="form-group col-md-4">
							<label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
							<input type="number"  pattern="[0-9.]$"class="form-control " id="valor" name="valor_unit" placeholder="Valor R$" value="{{ isset($dados->valor_unit) ? $dados->valor_unit : ''}}" required>
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
        	<div class="modal-footer">
          		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
				@method("PUT")
				@csrf
				<div class="row">
					<div class="form-group col-md-6">
						<label for="propriedade_id">Propriedades</label>
							<select form="investimento" class="form-control" name="propriedade_id" required>
							    @foreach ($propriedades as $propriedade)
									<option value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>	
							   	@endforeach
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
						<input type="number"  pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="Quantidade" required>
					</div>
					<div class="form-group col-md-4">
						<label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
						<input type="number"  pattern="[0-9.]$"class="form-control " id="valor" name="valor_unit" placeholder="Valor R$" required>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
				<p> Tem certeza que deseja excluir este investimento?</p>
				<div class="modal-footer">
	            	<form method="post" id="investimentoDelete" action="">
						@method("DELETE")
						@csrf
		        		<button type="submit" id="regitrarInves" class="btn btn-success" name="salvar">Sim</button>
          				<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					</form>
		        </div>
	        </div>
      	</div>
      
    	</div>
    </div>
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	function edit(my) {
		$.ajax({
			url: "api/investimento/"+my
		}).done(function(data){
			console.log(data);
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
	        
	}
	function excluir(my) {
		var url = "/api/investimento/"+my;
		$("form#investimentoDelete").attr('action',url);
		$("#myModalDelete").modal('show');
	}
</script>
@endsection
	