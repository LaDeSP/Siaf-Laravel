@extends('master')

@section('usuario', $User)

@section('conteudo')

<div class="container">
	<div class="card text-center" >
            <form id="relatorio" action="/relatorio" method="POST">
                @csrf
                <div class="card-header">
                  <h5 class="mb-0">
                    <div class="row align-center">
                            <select  form="relatorio" id="tipo" name="tipo" class="custom-select col-8 p-0 offset-2" >
                                <option hidden selected>Selecione uma opção</option>
                                <option value="investimentos" class="col-4"> Investimentos realizados por período </option>
                                <option value="despesa" class="col-4"> Despesa realizadas por período</option>
                                <option value="plantios" class="col-4"> Plantios realizados por período</option>
                                <option value="manejo-talhão" class="col-4"> Manejos realizados por período por talhão </option>
                                <option value="manejo-propriedade" class="col-4"> Manejos realizados por período por propriedade </option>
                                <option value="colheitas" class="col-4">Colheitas realizadas por período </option>
                                <option value="talhão" class="col-4"> Talhões por propriedade</option>
                                <option value="produtos-ativos-e-não-propriedade" class="col-4"> Listar produtos ativos e inativos por propriedade</option>
                                <option value="historico-manejo-plantio" class="col-4"> Listar histórico de manejo por plantio</option>
                                <option value="estoque-propriedade" class="col-4"> Listar estoque por propriedade por período </option>
                                <option value="vendas" class="col-4"> Vendas realizadas por período</option>
                                <option value="perdas" class="col-4"> Perdas por período</option>
                            </select>
                            <select form="relatorio" id="selectD" name="propriedade_id" class="custom-select col-8 p-0 offset-2"@if(is_array($propriedades) && count($propriedades) > 1) style="display: none" @else style="-moz-appearance: none; -webkit-appearance: none; appearance: none; display: none" @endif>
										@foreach ($propriedades as $propriedade)
											<option value="{{$propriedade->id}}"> {{$propriedade->nome}}</option>
										@endforeach
						     </select>
                        <input class="col-3 p-0 offset-2" type="date" name="date-inicio">
                        <input class="col-3 p-0 offset-2" type="date" name="date-final">
                        <div class="col-10">
                        	<button id="gerar" class="col-2 btn btn-info"  class="btn btn-link" type="submit"> Gerar</button>  	
                        </div>
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
							    <th>{{$t}} 
							    	@if($t == 'Área') 
										(m²)
									@elseif($t == 'Total' || $t == 'Valor Unitário')
										(R$)
									@endif
							    </th>
							@endforeach					
	                    </thead>
	                    <tbody>
							@foreach($conteudo as $c)
	                            <tr>
			                        @php
			                            $i=0;
			                        @endphp
									@foreach($topo as $cp)
										@if(count($formatData) > 0)
											@if($i < count($formatData) && $formatData[$i] == $cp)
												@php
													if(count($formatData) >= $i+1 ){
					                            		$i=$i+1;
													}
					                            @endphp
												<td class="data">{{$c->{$cp} }}</td>
											@else
				                       			<td>{{$c->{$cp} }}</td>
											@endif
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
					            <th colspan="{{(count($topo)/2)}}" scope="col">{{$campoLast}} 
					            	@if($campoLast == 'Área Total' || $campoLast == 'Área') 
										(m²)
									@elseif($campoLast == 'Total' || $campoLast == 'Valor Unitário')
										(R$)
									@endif
					            </th>   
						    @endforeach
	                   	</thead>
	                   	<tbody>	                                
		                    @foreach($totalG as $total)
								<tr>
		                           	@foreach($lastLine as $campoLast)
										<td colspan="{{(count($topo)/2)}}">{{$total->{ str_slug($campoLast, "_")} }} </td>
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
	$( document ).ready(function() {
		$("select[name=tipo]").change(function () {
	   		if($('option:selected').val()=='talhão'){
	   			console.log('talhão');
	   			$("input[name=date-inicio]").css('display','none');
				$("input[name=date-final]").css('display','none');
				$("select[name=propriedade_id]").show();
				
	   		}else if($('option:selected').val() =='manejo-propriedade' || $('option:selected').val()=='produtos-ativos-e-não-propriedade'){
	   			$("input[name=date-inicio]").css('display','block');
				$("input[name=date-final]").css('display','block');
	   			$("select#selectD").show();
	   		}else if($('option:selected').val()=='produtos-ativos-e-não-propriedade'){
	   			$("select#selectD").show();
	   		}else{
	   			$("input[name=date-inicio]").css('display','block');
				$("input[name=date-final]").css('display','block');
				$("select#selectD").css('display','none');
	   		}
	  	}).change();
	});
</script>
@endsection