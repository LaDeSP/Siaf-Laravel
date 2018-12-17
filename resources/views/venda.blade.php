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
      href="/venda/create"
      data-endpoint="/venda/create"
      data-target="exampleModal"
      data-cache="false",
      data-async="true">Adicionar</a>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header text-center">
               <h4 class="modal-title">Adicionar Venda</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body mx-3">
               <div class="md-form mb-5">
                  <i class="fa fa-envelope prefix grey-text"></i>
                  <label data-error="wrong" data-success="right" for="defaultForm-email">Quantidade</label>
                  <input type="email" id="defaultForm-email" class="form-control validate">
               </div>
               <div class="md-form mb-4">
                  <i class="fa fa-lock prefix grey-text"></i>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Valor</label>
                  <input type="password" id="defaultForm-pass" class="form-control validate">
               </div> 
            </div>
            <div class="modal-footer d-flex ">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button class="btn btn-success">Login</button>
            </div>
         </div>
      </div>
   </div>
   <div class="table-responsive-sm">
      <table class="table table-hover ">
         <thead>
            <tr>
               <th>Produto</th>
               <th>Quantidade</th>
               <th>Unidade</th>
               <th>Valor unitário R$</th>
               <th>Total R$</th>
               <th>Destino</th>
               <th>Data</th>
               <th>Ações</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($Vendas as $venda)
            <tr>
               <td>{{$venda->produto}}</td>
               <td>{{$venda->quantidade}}</td>
               <td>{{$venda->unidade}}</td>
               <td>{{$venda->valor_unit}}</td>
               <td>{{$venda->quantidade * $venda->valor_unit}}</td>
               <td>{{$venda->nome}}</td>
               <td class="data">{{$venda->data}}</td>
               <td>
                  <div class="row">      
                     <a class="btn  btn-warning"
                        href="/venda/{{$venda->id}}/edit"
                        data-endpoint="/venda/{{$venda->id}}/edit"
                        data-target="exampleModal"
                        data-cache="false",
                        data-async="true">Editar
                     </a>                                         
                     <form  class="col-sm-6 	" method="post"  action="/venda/{{$venda->id}}">
                        @method("DELETE")
                        @csrf
                        <button  type="submit" msg="Tem certeza que deseja Excluir essa Venda?" class="btn btn-xs btn-danger delete confirm">Excluir</button>
                     </form>
                  </div>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div> 
   @if(count($Vendas)==0)
      Por favor, adicione novas vendas!
   @endif
</div>

@endsection
