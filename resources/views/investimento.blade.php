
@extends('master')

@section('usuario', 'LULU da casa')

@section('conteudo')
<form method="post"  action="api/investimento">
	@csrf
	    <div>
			<div class="form-group">
				<label for="nome" class="control-label">Investimento</label>
				<input type="text" class="form-control" pattern="[A-Za-zÀ-ú., -]{5,255}$" id="nome" name="nome" placeholder="Nome" required>
			</div>
	        <div class="form-group">
	           	<label for="descricao" class="control-label">Descrição</label>
	       	    <textarea class="form-control" id="descricao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="descricao" placeholder="Descrição"></textarea>
	        </div>
	        <div class="row">
				<div class="form-group col-md-8">
					<label for="valor_unit" class="control-label">Valor</label>
					<input type="number"  pattern="[0-9., -]$"class="form-control" id="valor" name="valor_unit" placeholder="Valor R$">
				</div>
	    		<div class="form-group date col-md-8">
					<label for="data" class="control-label">Data</label>
				   	<input type="date" class="form-control data " id="data" name="data" value="{{data}}" required>
				</div>
	    	</div>
	    	<div class="text-center">
	    		<button type="submit" class="btn btn-success" name="salvar">Registrar</button>
			</div>
    	</div>
	</form>

@endsection
	