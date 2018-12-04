
@extends('master')

@section('usuario', 'LULU da casa')

@section('conteudo')
@if ($method === 'get')
    
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Propriedade</th>
						<th>Investimento</th>
						<th>Descrição</th>
						<th>Valor R$</th>
						<th>Data</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
				
					<tr class="linha">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>
						<button type="button" class="btn btn-xs btn-primary">
								Editar
						</button>
						<button  href=""class="btn btn-xs btn-danger">Excluir</button>
						</td>
					</tr>
				</tbody>
			</table>

@elseif ($method === 'create')
	<form method="post" action="api/investimento">
		@csrf
		    <div>
				<div class="form-group">
					<label for="nome" class="control-label">Investimento<span style="color: red">*</span></label>
					<input type="text" class="form-control " pattern="[A-Za-zÀ-ú]{5,255}$" id="nome" name="nome" placeholder="Nome" required>
					
				</div>
		        <div class="form-group">
		           	<label for="descricao" class="control-label">Descrição</label>
		       	    <textarea class="form-control " id="descricao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="descricao" placeholder="Descrição"></textarea>
		        </div>
		        <div class="row">
					<div class="form-group col-md-6">
						<label for="valor_unit" class="control-label">Quantidade<span style="color: red">*</span></label>
						<input type="number"  pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="Quantidade" required>
					</div>
					<div class="form-group col-md-6">
						<label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
						<input type="number"  pattern="[0-9.]$"class="form-control " id="valor" name="valor_unit" placeholder="Valor R$" required>
					</div>
		        </div>
		    	<div class="form-group date col-md-8">
					<label for="data" class="control-label">Data<span style="color: red">*</span></label>
				   	<input type="date" class="form-control data " id="data" name="data" value="" required>
				</div>
		    	<div class="text-center">
		    		<button type="submit" class="btn btn-success" name="salvar">Registrar</button>
				</div>
	    	</div>
	</form>
@endif

@endsection
	