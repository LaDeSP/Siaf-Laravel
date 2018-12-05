
@extends('master')

@section('usuario', $User)

@section('conteudo')
@if ($method === 'read')
    
    <div class="main">
    	<a id="add" href="/investimento/create" class="btn  btn-primary">Adicionar</a>
			<table class="table">
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
					@foreach ($dados as $dado)
					    @foreach ($dado as $d)
					        <tr>
								<td>{{$d->propriedade_id}}</td>
								<td>{{$d->nome}}</td>
								<td>{{$d->descricao}}</td>
								<td>{{$d->valor_unit}}</td>
								<td>{{$d->data}}</td>
								<td>
									<div class="row">
										<a href="/investimento/edit/{{$d->id}}" class="btn btn-xs btn-primary edit col-sm-4">Editar</a>
										<form  class="col-sm-6	" method="post" id="investimento" action="/api/investimento{{isset($d->id) ? '/'.$d->id : '' }}">
											@method("DELETE")
											@csrf
											<button  type="submit" class="btn btn-xs btn-danger delete">Excluir</button>
										</form>
									</div>
								</td>
							</tr>
					    @endforeach
					@endforeach			    
						

				</tbody>
			</table>
	</div>	
@elseif ($method === 'create' || $method === 'edit')
	<form method="post" id="investimento" action="/api/investimento{{isset($dados->id) ? '/'.$dados->id : '' }}">
		@if($method === 'edit')
				@method("PUT")
		@endif
		@csrf
				<div class="row">
					<div class="form-group col-md-6">
						<label for="propriedade_id">Propriedades</label>
					    <select form="investimento" class="form-control" name="propriedade_id" required>
					    	@foreach ($propriedades as $propriedade)
					    		<option  value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>
					      	@endforeach
					    </select>
					</div>
					<div class="form-group col-md-6">
						<label for="nome" class="control-label">Investimento<span style="color: red">*</span></label>
						<input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{5,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
						
					</div>
				</div>
		        <div class="form-group">
		           	<label for="descricao" class="control-label">Descrição</label>
		       	    <textarea class="form-control " id="descricao" pattern="[A-Za-zÀ-ú0-9., -]{5,}$" name="descricao" placeholder="Descrição">{{ isset($dados->descricao) ? $dados->descricao : '' }}</textarea>
		        </div>
		        <div class="row">
					<div class="form-group col-md-6">
						<label for="valor_unit" class="control-label">Quantidade<span style="color: red">*</span></label>
						<input type="number"  pattern="[0-9]$"class="form-control " id="quantidade" name="quantidade" placeholder="Quantidade" value="{{ isset($dados->quantidade) ? $dados->quantidade : '' }}" required>
					</div>
					<div class="form-group col-md-6">
						<label for="valor_unit" class="control-label">Valor<span style="color: red">*</span></label>
						<input type="number"  pattern="[0-9.]$"class="form-control " id="valor" name="valor_unit" placeholder="Valor R$" value="{{ isset($dados->valor_unit) ? $dados->valor_unit : ''}}" required>
					</div>
		        </div>
		    	<div class="form-group date col-md-8">
					<label for="data" class="control-label">Data<span style="color: red">*</span></label>
				   	<input type="date" class="form-control data " id="data" name="data" value="{{ isset($dados->data) ? $dados->data : '' }}" required>
				</div>
		    	<div class="text-center">
		    		<button type="submit" class="btn btn-success" name="salvar">Registrar</button>
				</div>
		</form>
@endif

@endsection
	