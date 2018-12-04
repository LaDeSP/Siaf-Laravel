
@extends('master')

@section('usuario', $User);

@section('conteudo')
<form method="post"  action="api/estoque">
	@csrf
	    <div>

	        <div class="form-group">
	        	<div class="form-group">
					{{--<br />
    				{!! Form::label('Produto') !!}<br />
    				{!! Form::select('produto_id',
        					['0' => 'Selecione o Produto'] + $produto->toArray(), 
            				null,
            				array('class' => 'form-control', 'id' => 'nome') 
            			);	 
            		!!}--}}
				</div>
			</div>
{{--

			<div class="row">
				<div class="form-group date col-md-8">
					<label for="data" class="control-label">Data</label>
				   	<input type="date" class="form-control data " id="data" name="data" value="{{data}}" required>
				</div>

	        	<div class="form-group col-md-8">
					<label for="quantidade" class="control-label">Quantidade</label>
					<input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="Quantidade" value="{{quantidade}}" required>
				</div>

	    	</div>
--}}

	    	<div class="form-group">
	        	<div class="form-group">
					<br />
{{--
    				{!! Form::label('Propriedade') !!}<br />
    				{!! Form::select('propriedade_id', 
        					['0' => 'Selecione a Propriedade'] + $propriedade->toArray(), 
            				null,
            				array('class' => 'form-control', 'id' => 'nome') 
            			);	 
            		!!}
--}}
				</div>
			</div>

		</div>

	    	<div class="text-center">
	    		<button type="submit" class="btn btn-success" name="salvar">Registrar</button>
			</div>

    	</div>
</form>

@endsection
	