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






<div class="card-header" style="margin-top:10px;">
  <div class="row">
      <div class="col-2"><b>Data plantio</b></div>
      <div class="col-6"><b>Talhao</b></div>
      <div class="col-3"><b>Produto</b></div>
  </div>
</div>
<div id="accordion">
@foreach ($Plantios as $Plantio)
  <div class="card">
        <div class="card-header"  id="heading{{$Plantio->id}}">
          <a  data-toggle="collapse" data-target="#collapse{{$Plantio->id}}" aria-expanded="fase" aria-controls="collapse{{$Plantio->id}}">
            <div class="row">
              <div class="col-2">{{$Plantio->data_plantio}}</div>
              <div class="col-6">{{$Plantio->nomet}}</div>
              <div class="col-3">{{$Plantio->nomep}}</div>
            </div>
          </a>
        </div>


    <div id="collapse{{$Plantio->id}}" class="collapse @isset($Mostrar) @if($Mostrar==$Plantio->id) {{$show}} @endif @endisset" aria-labelledby="heading{{$Plantio->id}}" data-parent="#accordion">
      <div class="card-body">

        <div class="col-10 text-right adicionar">
          <a class="btn  btn-success"
            href="/manejo/create/{{$Plantio->id}}"
            data-endpoint="/manejo/create/{{$Plantio->id}}"
            data-target="exampleModal"
            data-cache="false",
            data-async="true">Adicionar</a>
        </div>

        <table class="table">
  				<thead>
  					<tr>
              <th>Descrição</th>
          		<th>Horario</th>
          		<th>Quantidade de Horas</th>
          		<th>Manejo</th>
              <th>Ações</th>
  					</tr>
  				</thead>
  				<tbody>


                @foreach ($Plantio->manejo as $Manejo)

                <tr>
                  <td>{{$Manejo->descricao}}</td>
                  <td>{{$Manejo->data_hora}}</td>
                  <td>{{$Manejo->horas_utilizadas}}</td>
                  <td>{{$Manejo->nome}}</td>
                  <td>
                    <div class="row">



                      <a class="btn  btn-warning col-3"
                        href="/manejo/{{$Manejo->id}}/edit"
                        data-endpoint="/manejo/{{$Manejo->id}}/edit"
                        data-target="exampleModal"
                        data-cache="false",
                        data-async="true">Editar</a>


                      <form  class="col-4 	" method="post" id="investimento" action="/manejo/{{$Manejo->id}}">
                        @method("DELETE")
                        @csrf
                        <button  type="submit" class="btn btn-xs btn-danger delete confirm" msg='Tem certeza que deseja excluir o {{$Tela}} {{$Manejo->nome}} . '>Excluir</button>
                      </form>

                      @if($Manejo->manejo_id==4)

                      <a class="btn  btn-primary col-3"
                        href="/manejo/estoque/{{$Manejo->id}}"
                        data-endpoint="/manejo/estoque/{{$Manejo->id}}"
                        data-target="exampleModal"
                        data-cache="false",
                        data-async="true">Estoque</a>

                    <!---  <form  class="col-4 	" method="get"  action="/manejo/estoque/{{$Manejo->id}}">
                        @csrf
                        <button  type="submit" class="btn btn-xs btn-primary  " msg='Tem certeza que deseja enviar a {{$Manejo->nome}} para Estoque . '>Estoque</button>
                      </form>-->
                      @endif



                    </div>
                  </td>
                </tr>


                @endforeach


              </tbody>
            </table>
            @if(count($Plantio->manejo)==0)
              Por favor, adicione novos manejos!
            @endif
      </div>
    </div>
  </div>


@endforeach
</div>

@if(count($Plantios)==0)
  Por favor, adicione novos Plantios!
@endif





@endsection
