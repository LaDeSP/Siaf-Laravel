@extends('master')

@section('usuario', $User)

@section('conteudo')

<div class="container col-10">
	<div class="accordion" id="accordionExample">
	  	<div class="card">
		    <div class="card-header" id="headingOne">
		      <h5 class="mb-0">
		        <div class="row">
					<label data-name="despesa" class="col-4"> Listar despesa realizados por período</label>
					<input class="col-3" type="date" name="date-inicio">
					<input class="col-3" type="date" name="date-fim">
					<button id="gerar" data-myCollapse="One" class="col-2 btn btn-info"  class="btn btn-link" type="button"  aria-expanded="true" onclick=" gera(this);"> Gerar</button>
				</div>
		      </h5>
		    </div>
		    
				<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
		    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
		      <div class="card-body">
		      	<table class="table">
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
	var fim = $(pai).find("input[name=date-fim]");
	var label = $(pai).find("label");
	var qual = $(label).attr("data-name");
	console.log(inicio.val());
	console.log(fim.val());
	var collapse = $(elem).attr('data-myCollapse');
	var cardBody = $("#collapse"+collapse+" .card-body");
		$.ajax({
			method: "POST",
			url: "/relatorio",
			data: {
				"qual": qual,
				"date-inicio" : inicio.val(),
				"date-fim" : fim.val()
			}
		}).done(function (data) {
			
		});
}
</script>

@endsection