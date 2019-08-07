
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
      href= "estoque/create"
      data-endpoint= "estoque/create"
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
        @isset($Estoques[0]->id)
				<thead>
					<tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Unidade</th>
        		<th>Data Estoque</th>
        		<th>Data Semeadura</th>
            <th>Data Plantio</th>
            <th>Talhao</th>
						<th>Data Colheita</th>
            <th>Ações</th>
					</tr>
				</thead>
        @endisset
				<tbody>

			       @foreach ($Estoques as $Estoque)
             @if($Estoque->disponivel>0)
					    <tr>
                <td>{{$Estoque->nomep}}</td>
                <td>{{$Estoque->disponivel}}</td>
                <td>{{$Estoque->unidade}}</td>
                <td class='data'>{{$Estoque->data}}</td>
                <td class='data'>{{$Estoque->data_semeadura}}</td>
                <td class='data'>{{$Estoque->data_plantio}}</td>
                <td>{{$Estoque->nomet}}</td>
                <td class='data'>{{$Estoque->data_hora}}</td>

								<td>
									<div class="row">


                    <div class="col-6">
                    <a class="btn  btn-warning @if($Estoque->plantavel || ($Estoque->quantidade!=$Estoque->disponivel )  )  disabled @endif"
                      href= "estoque/{{$Estoque->id}}/edit"
                      data-endpoint= "estoque/{{$Estoque->id}}/edit"
                      data-target="exampleModal"
                      data-cache="false",
                      data-async="true">Editar</a>
                    </div>
                    <div class="col-6">
                    <a  class="btn btn-xs btn-danger @if($Estoque->disponivel <= 0 )  disabled @endif"
                        href= "perda/{{$Estoque->id}}"
                        data-endpoint= "perda/{{$Estoque->id}}"
                        data-target="exampleModal"
                        data-cache="false",
                        data-async="true">Perder</a>
                   <div>
                  <!--
										<form  class="col-sm-6 	" method="post" id="investimento"  action= "estoque/{{$Estoque->id}}">
											 {{method_field('DELETE')}}
											{{ csrf_field() }}
											<button  type="submit" msg='Tem certeza que deseja Excluir esse Estoque. ' class="btn btn-xs btn-danger delete @if($Estoque->plantavel)  disabled @endif confirm">Perder</button>
										</form>
                -->
									</div>
								</td>
							</tr>
          @endif
					@endforeach


				</tbody>
			</table>
      {{$Estoques->withPath('estoque')}}
      @if(count($Estoques)==0)
        <div class='text-center'>
          Por favor, adicione novos Estoques!
        </div>
      @endif
	</div>



@endsection
