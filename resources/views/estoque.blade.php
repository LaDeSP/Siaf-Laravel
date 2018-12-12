
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
  <div class="col-10 text-right adicionar">
    <a class="btn  btn-success"
      href="/estoque/create"
      data-endpoint="/estoque/create"
      data-target="exampleModal"
      data-cache="false",
      data-async="true">Adicionar</a>
  </div>


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
            <th>Quantidade</th>
        		<th>Produto</th>
        		<th>Data Estoque</th>
        		<th>Data Semeadura</th>
            <th>Data Plantio</th>
            <th>Talhao</th>
						<th>Data Colheita</th>
					</tr>
				</thead>
				<tbody>

			       @foreach ($Estoques as $Estoque)
					    <tr>
                <td>{{$Estoque->disponivel}}</td>
                <td>{{$Estoque->nomep}}</td>
                <td>{{$Estoque->data}}</td>
                <td>{{$Estoque->data_semeadura}}</td>
                <td>{{$Estoque->data_plantio}}</td>
                <td>{{$Estoque->nomet}}</td>
                <td>{{$Estoque->data_hora}}</td>

								<td>
									<div class="row">



                    <a class="btn  btn-warning"
                      href="/plantio/{{$Estoque->id}}/edit"
                      data-endpoint="/plantio/{{$Estoque->id}}/edit"
                      data-target="exampleModal"
                      data-cache="false",
                      data-async="true">Editar</a>


										<form  class="col-sm-6 	" method="post" id="investimento" action="/plantio/{{$Estoque->id}}">
											@method("DELETE")
											@csrf
											<button  type="submit" class="btn btn-xs btn-danger delete confirm">Excluir</button>
										</form>

									</div>
								</td>
							</tr>
					@endforeach


				</tbody>
			</table>
      @if(count($Estoques)==0)
        Por favor, adicione novos Plantios!
      @endif
	</div>



@endsection
