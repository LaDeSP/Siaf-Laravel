@extends('master')

@section('usuario', $User)

@section('conteudo')
<style type="text/css">

		@media    print {
		    .myDivToPrint {
		        background-color: white;
		        height: 6%;
		        width: 90%;
		        position: fixed;
		        top: 0;
		        left: 20%;
		        margin: 0;
		        padding: 15px;
		        font-size: 14px;
		        line-height: 18px;
		    }
		    .tableRelatorio{
		    	background-color: white;
		        height: 100%;
		        width: 100%;
		        position: fixed;
		        top: 5%;
		        left: 0;
		        margin: 0;
		        padding: 15px;
		        font-size: 14px;
		        line-height: 18px;
		    }
			.rodape{
				background-color: white;
		        height: 100%;
		        width: 100%;
		        position: fixed;
		        top: 95%;
		        left: 0;
		        margin: 0;
		        padding: 15px;
		        font-size: 14px;
		        line-height: 18px;
			}

	}



</style>
<div class="container">
	<div class="card text-center" >
            <form id="relatorio" action="relatorio" method="POST">
                {{ csrf_field() }}
                <div class="card-header">
                  <h5 class="mb-0">
                    <div class="col-10">
                    	<div class="row offset-3 mb-2">
                            <label for="tipo" class="col-sm-3"> Relatório:<span class="text-danger">*</span></label>
                            <select  form="relatorio" id="tipo" name="tipo" class=" ml-3 custom-select col-8 p-0 pl-3" >
                                <option hidden selected>Selecione uma opção</option>
                                <option value="investimentos" class="col-8"> Investimentos realizados por período </option>
                                <option value="despesa" class="col-8"> Despesa realizadas por período</option>
                                <option value="plantios" class="col-8"> Plantios realizados por período</option>
                                <option value="manejo-talhão" class="col-8"> Manejos realizados por período por talhão </option>
                                <option value="manejo-propriedade" class="col-8"> Manejos realizados por período por propriedade </option>
                                <option value="colheitas" class="col-8">Colheitas realizadas por período </option>
                                <option value="talhão" class="col-8"> Talhões por propriedade</option>
                                <option value="produtos-ativos-e-não-propriedade" class="col-8"> Produtos ativos e inativos por propriedade</option>
                                <option value="historico-manejo-plantio" class="col-8"> Histórico de manejo por plantio</option>
                                <option value="estoque-propriedade" class="col-8"> Estoque por propriedade por período </option>
                                <option value="vendas" class="col-8"> Vendas realizadas por período</option>
                                <option value="perdas" class="col-8"> Perdas por período</option>
                            </select>
                    	</div>
                    	<div id="selectProp" class="row offset-3 mb-2">
                            <label for="propriedade_id" style="display: none;" class="mr-1 col-sm-3 p-0"> Fazenda:<span class="text-danger">*</span></label>
                            <select form="relatorio" name="propriedade_id" class="custom-select col-8 p-0"@if(is_array($propriedades) && count($propriedades) < 2) style="display: none" @else style="-moz-appearance: none; -webkit-appearance: none; appearance: none; display: none" @endif>
										@foreach ($propriedades as $propriedade)
											<option value="{{$propriedade->id}}"> {{$propriedade->nome}}</option>
										@endforeach
						     </select>
                    	</div>
                    	<div id="dateInicio" class="row offset-3 mb-2">
							<label for="date-inicio" class=" col-sm-3 p-0 ml-2" > Data inicio:<span class="text-danger">*</span></label>
	                        <input class=" ml-2 form-control col-4" type="date" name="date-inicio">
                    	</div>
                    	<div id="dateFinal" class="row offset-3 mb-2">
	                        <label for="date-inicio" class="p-0 col-sm-3"> Data final:<span class="text-danger">*</span></label>
	                        <input class=" ml-3 form-control col-4" type="date" name="date-final">
                    	</div>
                    </div>
                  </h5>
                        <div class="col-10 offset-2 mt-3">
                        	<button id="gerar" class="col-2 btn btn-info"   type="submit"> Gerar</button>
                        </div>
                </div>
            </form>
            <div class="myDivToPrint">
            </div>
	            <div class=" tableRelatorio card-body">
	            	@if(isset($topo))
				    	<h4 id="tituloTab" ></h4>
				    	<table id="informacoes" class="table table-hover table-condensed">
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
	                        <div id="results-wrapper">
								@foreach($conteudo as $c)
		                            <tr>
				                        @php
				                            $i=0;
				                        @endphp
										@foreach($topo as $cp)
											@if(count($formatDataTopo) > 0)
												@if($i < count($formatDataTopo) && $formatDataTopo[$i] == $cp)
													@php
														if(count($formatDataTopo) >= $i+1 ){
						                            		$i=$i+1;
														}
						                            @endphp
													<td class="data">{{$c->{str_slug($cp, "_")} }}</td>
												@else
					                       			<td>{{$c->{str_slug($cp, "_")} }}</td>
												@endif
											@else
				                       			<td>{{$c->{str_slug($cp, "_")} }}</td>
											@endif
										@endforeach
		                            </tr>
								@endforeach
	                        </div>
		                    </tbody>
		                </table>
		                <br>
		                <table class="table table-hover table-condensed">
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

				                        @php
				                            $i=0;
				                        @endphp
			                           	@foreach($lastLine as $campoLast)
											@if(count($formatDataLast) > 0)
												@if($i < count($formatDataLast) && $formatDataLast[$i] == $campoLast)
													@php
														if(count($formatDataLast) >= $i+1 ){
						                            		$i=$i+1;
														}
						                            @endphp
													<td class="data" colspan="{{(count($topo)/2)}}">{{$total->{ str_slug($campoLast, "_")} }} </td>
												@else
					                       			<td colspan="{{(count($topo)/2)}}">{{$total->{ str_slug($campoLast, "_")} }} </td>
												@endif
											@else
				                       			<td colspan="{{(count($topo)/2)}}">{{$total->{ str_slug($campoLast, "_")} }} </td>
											@endif
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

    // $(document).on('click', '#pagination-wrapper a', function(e){
    //     e.preventDefault();
    //     $('#results-wrapper').load($(this).attr('href') + '#results-wrapper');
    //  });

@isset($conteudo)
	$( document ).ready(function() {
		$('option').each(function(e){
			if(this.value === '{{$tipo}}'){
				this.selected=true;
				texto = $(this).text().replace('Listar ','');
				if($('option:selected').val()=='talhão'){
					texto = $(this).text().replace('Listar ','');
	   			}else if($('option:selected').val() =='manejo-propriedade' || $('option:selected').val() =='estoque-propriedade'){
		   			texto = texto.replace('por','');
					texto = texto.replace('período','');
					texto = texto.replace('periodo ','');
					texto = texto.replace('propriedade','');
					texto = texto.replace('por','');
					texto = texto+ ' por propriedade em '+'{{\Carbon\Carbon::parse($inicio)->format("d/m/Y")}}'+'-'+'{{\Carbon\Carbon::parse($final)->format("d/m/Y")}}';
					console.log(texto + $('option:selected').val());
		   		}else if($('option:selected').val()=='produtos-ativos-e-não-propriedade'){
		   			texto = texto.replace('por ','');
					texto = texto.replace('período','');
					texto = texto.replace('periodo ','');
					texto = texto.replace('propriedade','');
					texto = texto+ ' por propriedade';
					console.log(texto + $('option:selected').val());
		   		}else if($('option:selected').val()=='historico-manejo-plantio'){
		   			texto = texto.replace('por ','');
					texto = texto.replace('período','');
					texto = texto.replace('periodo ','');
					texto = texto.replace('propriedade','');
					texto = texto+ ' por propriedade';
					console.log(texto + $('option:selected').val());
		   		}else{
		   			texto = texto.replace('por ','');
					texto = texto.replace('período','');
					texto = texto.replace('periodo ','');
					texto = texto.replace('propriedade','');
					texto = texto+ ' em '+'{{\Carbon\Carbon::parse($inicio)->format("d/m/Y")}}'+'-'+'{{\Carbon\Carbon::parse($final)->format("d/m/Y")}}';
					console.log(texto + $('option:selected').val());
		   		}
		   		$("#tituloTab").text(texto);
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
	   			$("#dateInicio").css('display','none');
				$("#dateFinal").css('display','none');
				@if(is_array($propriedades) && count($propriedades) > 1)
					$("select[name=propriedade_id]").show();
				@endif
	   		}else if($('option:selected').val() =='manejo-propriedade'){
	   			$("#dateInicio").css('display','flex');
				$("#dateFinal").css('display','flex');
				@if(is_array($propriedades) && count($propriedades) > 1)
	   				$("div#selectProp").show();
	   			@endif
	   		}else if($('option:selected').val()=='produtos-ativos-e-não-propriedade'){
	   			$("#dateInicio").css('display','none');
				$("#dateFinal").css('display','none');
	   			@if(is_array($propriedades) && count($propriedades) > 1)
	   				$("div#selectProp").show();
	   			@endif
	   		}else if($('option:selected').val()=='historico-manejo-plantio'){
	   			$("#dateInicio").css('display','none');
				$("#dateFinal").css('display','none');
	   		}else{
	   			$("#dateInicio").css('display','flex');
				$("#dateFinal").css('display','flex');
				@if(is_array($propriedades) && count($propriedades) > 1)
					$("div#selectProp").css('display','none');
				@endif
	   		}
	  	}).change();
	});

</script>
@endsection
