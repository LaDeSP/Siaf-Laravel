@extends('master')

@section('usuario', $User)

@section('conteudo')

<div class="container">
	<div class="accordion" id="accordionExample">
	  	<div class="card">
		    <div class="card-header" id="headingOne">
		      <h5 class="mb-0">
		        <div class="row">
		        	<div class="">
			        	<select  name="relatorio" class="custom-select col-12">
							<option data-name="vendas" class="col-4"> Listar vendas realizadas por período</option>
							<option data-name="investimentos" class="col-4"> Listar investimentos realizados por período </option>
							<option data-name="despesa" class="col-4"> Listar despesa realizados por período</option>
							<option data-name="plantios" class="col-4"> Listar plantios realizados por período</option>
							<option data-name="manejo-talhão" class="col-4"> Listar manejos realizados por período por talhão </option>
							<option data-name="manejo-propriedade" class="col-4"> Listar manejos realizados por período por propriedade </option>
							<option data-name="colheitas" class="col-4"> Listar colheitas realizadas por período </option>
							<option data-name="talhão" class="col-4"> Listar talhões por propriedade</option>
							<option data-name="produtos-propriedade" class="col-4"> Listar produtos ativos e inativos por propriedade</option>
							<option data-name="vendas" class="col-4"> Listar histórico de manejo por plantio</option>
							<option data-name="vendas" class="col-4"> Listar estoque por propriedade por período </option>
			        	</select>
		        	</div>
					<input class="col-2" type="date" name="date-inicio">
					<input class="col-2" type="date" name="date-final">
					<button id="gerar" data-myCollapse="One" class="col-1 btn btn-info"  class="btn btn-link" type="button"  aria-expanded="true" onclick=" gera(this);"> Gerar</button>
				</div>
		      </h5>
		    </div>
		    
			<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
		      <div class="card-body">
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

		      	<table id="informacoes" class="table">
                        <thead>
                        	
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
<table id="datatable" class="highchart" data-graph-container-before="1" data-graph-type="column" style="display: none">
    <thead>
       
    </thead>
    <tbody>
        
    </tbody>
</table>
		      </div>
		    </div>
	  	</div>
	</div>
</div>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $("input[name=_token]").val()
    }
});
function gera(elem) {
	var pai = $(elem).parent();
	var inicio = $(pai).find("input[name=date-inicio]");
	var fim = $(pai).find("input[name=date-final]");
	var qual = $("[name=relatorio] option:selected").attr("data-name");
	console.log(inicio.val());
	console.log(fim.val());
	var collapse = $(elem).attr('data-myCollapse');
	var cardBody = $("#collapse"+collapse+" .card-body");
	var cardBodyTtopo = $("#collapse"+collapse+" .card-body table tread");
	if ($("#collapse"+collapse).attr("class") == "collapse") {
		$.ajax({
			method: "POST",
			url: "/relatorio",
			data: {
				"qual": qual,
				"date-inicio" : inicio.val(),
				"date-fim" : fim.val()
			}
		}).done(function (data) {
			console.log(data);
			$("#collapse"+"One"+" #informacoes.table thead").html(data.topo);
			$("#collapse"+collapse+" #informacoes.table tbody").html(data.dado);
			$("#collapse"+collapse+" #datatable thead").html(data.topoGraph);
			$("#collapse"+collapse+" #datatable tbody").html(data.dadoGraph);
			$('table.highchart').highchartTable();
			$("#collapse"+collapse).collapse('show');
		}).fail(function(error){
			console.log(error);
		});

	}else{
		$("#collapse"+collapse).collapse('hide');
	}
}

</script>

@endsection