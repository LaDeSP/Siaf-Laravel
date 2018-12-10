@extends('master')

@section('usuario', $User)

@section('conteudo')
<script type="text/javascript">

$( document ).ready(function() {
  $('a[data-async="true"]').click(function(e){
      e.preventDefault();
      var self = $(this),
          url = self.data('endpoint'),
          target = self.data('target'),
          cache = self.data('cache');

      $.ajax({
          url: url,
          cache : cache,
          success: function(data){
                         if (target !== 'undefined'){

                            $('#'+target).modal('show');
                            $('#'+target).html( data );
                         }
                   }
      });
  });


});



</script>

<div class="main">
  <a class="btn  btn-primary"
    href="/plantio/create"
    data-endpoint="/plantio/create"
    data-target="exampleModal"
    data-cache="false",
    data-async="true">Adicionar</a>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary">Savar</button>
          </div>
        </div>
      </div>
    </div>








			<table class="table">
				<thead>
					<tr>
            <th>Data semeadura</th>
        		<th>Data plantio</th>
        		<th>Quantidade plantas</th>
        		<th>Talhao</th>
        		<th>Produto</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
			       @foreach ($Plantios as $Plantio)
					    <tr>
                <td>{{$Plantio->data_semeadura}}</td>
                <td>{{$Plantio->data_plantio}}</td>
                <td>{{$Plantio->quantidade_pantas}}</td>
                <td>{{$Plantio->nomet}}</td>
                <td>{{$Plantio->nomep}}</td>
								<td>
									<div class="row">



                    <a class="btn  btn-primary"
                      href="/plantio/{{$Plantio->id}}/edit"
                      data-endpoint="/plantio/{{$Plantio->id}}/edit"
                      data-target="exampleModal"
                      data-cache="false",
                      data-async="true">Editar</a>


										<form  class="col-sm-6 	" method="post" id="investimento" action="/plantio/{{$Plantio->id}}">
											@method("DELETE")
											@csrf
											<button  type="submit" class="btn btn-xs btn-danger delete alert">Excluir</button>
										</form>

									</div>
								</td>
							</tr>
					@endforeach


				</tbody>
			</table>
	</div>


@endsection
