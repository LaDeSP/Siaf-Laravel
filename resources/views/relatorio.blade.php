@extends('master')

@section('usuario', $User)

@section('conteudo')

<div class="container">
	<div class="card text-center" >
            <form id="relatorio" action="/relatorio" method="POST">
                @csrf
                <div class="card-header">
                  <h5 class="mb-0">
                    <div class="row">
                        <div class="">
                            <select  form="relatorio" id="tipo" name="tipo" class="custom-select col-12" >
                                <option selected value="vendas" class="col-4"> Listar vendas realizadas por período</option>
                                <option value="investimentos" class="col-4"> Listar investimentos realizados por período </option>
                                <option value="despesa" class="col-4"> Listar despesa realizadas por período</option>
                                <option value="plantios" class="col-4"> Listar plantios realizados por período</option>
                                <option value="manejo-talhão" class="col-4"> Listar manejos realizados por período por talhão </option>
                                <option value="manejo-propriedade" class="col-4"> Listar manejos realizados por período por propriedade </option>
                                <option value="colheitas" class="col-4"> Listar colheitas realizadas por período </option>
                                <option value="talhão" class="col-4"> Listar talhões por propriedade</option>
                                <option value="produtos-propriedade" class="col-4"> Listar produtos ativos e inativos por propriedade</option>
                                <option value="historico-manejo-plantio" class="col-4"> Listar histórico de manejo por plantio</option>
                                <option value="estoque-propriedade" class="col-4"> Listar estoque por propriedade por período </option>
                            </select>
                        </div>
                        <input class="col-2" type="date" name="date-inicio">
                        <input class="col-2" type="date" name="date-final">
                        <button id="gerar" class="col-1 btn btn-info"  class="btn btn-link" type="submit"> Gerar</button>
                    </div>
                  </h5>
                </div>
            </form>
            <div class="card-body">
            	@if(isset($topo))
			    	<h4 id="tituloTab" ></h4>
			    	<table id="informacoes" class="table">
	                    <thead class="thead-light">
							@foreach($topo as $t)
							    <th>{{$t}}</th>
							@endforeach					
	                    </thead>
	                    <tbody>
							@foreach($conteudo as $c)
	                            <tr>
									@foreach($topo as $cp)
										@if($cp == 'Data')
											<td class="data">{{$c->{$cp} }}</td>
										@else
			                       			<td>{{$c->{$cp} }}</td>
										@endif
									@endforeach
	                            </tr>
							@endforeach
	                    </tbody>
	                </table>
	                <br>
	                <table class="table">
	                  	<thead class="thead-light">
	                      	@foreach($lastLine as $campoLast)
					            <th colspan="{{(count($topo)/2)}}" scope="col">{{$campoLast}}</th>   
						    @endforeach
	                   	</thead>
	                   	<tbody>	                                
		                    @foreach($totalG as $total)
								<tr>
		                           	@foreach($lastLine as $campoLast)
										<td colspan="{{(count($topo)/2)}}">{{$total->{$campoLast} }}</td>
									@endforeach
								</tr>
							@endforeach
	                   	</tbody>
	                    </table>
			    @endif
				<div id="container" ></div>
			</div>
        </div>
	</div>
<script type="text/javascript">
@isset($conteudo)
	$( document ).ready(function() {
		$('option').each(function(e){
				if(this.value === '{{$tipo}}'){
					this.selected=true;
					texto = $(this).text().replace('Listar ','');
					$("#tituloTab").text(texto.charAt(1).toUpperCase()+texto.substr(2));
				}
			});
		$("input[name=date-inicio]").val('{{$inicio}}');
		$("input[name=date-final]").val('{{$final}}');
	});
@endisset
</script>
@endsection