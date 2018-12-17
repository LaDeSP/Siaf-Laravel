<div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
      {{ Form::open(array('url'=>$Url, 'method' => $Method, 'class'=>'col-md-12')) }}
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">{{$Tela}}</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         <div class="row linhaFrom">
            <label class="col-3">Estoque:<span class="text-danger">*</span></label>
            <select class="col-7 form-control" name="estoque_id" required='required'>
               @foreach ($estoques as $estoque)
                  @if(isset($Vendas))
                     @if($estoque->id == $Vendas->estoque_id)
                        <option @isset($Vendas)@if($estoque->id == $Vendas->estoque_id) echo selected  @endif @endisset value="{{$estoque->id}}" disabled>{{$estoque->nomep}} - {{ \Carbon\Carbon::parse($estoque->data)->format('d/m/Y')}}</option>                     
                     @endif
                  @else
                     @if($estoque->quantidadedisponivel>0)
                        <option  value="{{$estoque->id}}">{{$estoque->nomep}} - {{ \Carbon\Carbon::parse($estoque->data)->format('d/m/Y')}}</option>
                     @endif
                  @endif
               @endforeach
            </select>
         </div>
         <div class="row linhaFrom">
            <label class="col-3">Destino:<span class="text-danger">*</span></label>
            <select class="col-7 form-control" name="destino_id" required='required'>
               @foreach ($destinos as $destino)
               <option  @isset($Vendas)@if($destino->id == $Vendas->destino_id) echo selected  @endif @endisset value="{{$destino->id}}">{{$destino->destino}}</option>
               @endforeach
            </select>
         </div>
         <div class="row linhaFrom">
            <label class="col-3">Quantidade:<span class="text-danger">*</span></label></label>
         @foreach ($estoques as $estoque)
            @if(isset($Vendas))
               @if($estoque->id == $Vendas->estoque_id)
                  <input id="tentacles" class="col-7" type="number" min="1" max="@if(isset($Vendas)){{$Vendas->quantidade+$estoque->quantidadedisponivel }}@else{{$estoque->quantidadedisponivel}}@endif" name="quantidade" value="@isset($Vendas){{$Vendas->quantidade}}@endisset" required> 
                  @break
               @endif      
            @else
               @if($estoque->quantidadedisponivel>0)   
                  <input id="tentacles" class="col-7" type="number" min="1" max="@if(isset($Vendas)){{$Vendas->quantidade+$estoque->quantidadedisponivel }}@else{{$estoque->quantidadedisponivel}}@endif" name="quantidade" value="@isset($Vendas){{$Vendas->quantidade}}@endisset" required>
                  @break
               @endif   
            @endif
         @endforeach
      </div>
         <div class="row linhaFrom">
            <label class="col-3">Valor:<span class="text-danger">*</span></label></label>
            <input class="col-7" type="number" min="1" step="0.01" pattern="[0-9]$" id="valor" name="valor_unit" value="@isset($Vendas){{$Vendas->valor_unit}}@endisset" required>
         </div>
         <div class="row linhaFrom">
            <label class="col-3">Data da Venda:<span class="text-danger">*</span></label>
            <input class="col-7" type="date" name="data" value="@isset($Vendas){{$Vendas->data}}@endisset" required>
         </div>
         <div class="row linhaFrom">
            <label class="col-3">Nota:</label>
            <input class="col-7" type="text" name="nota" value="@isset($Vendas){{$Vendas->nota}}@endisset">
         </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
         <button type="submit" class="btn btn-success">Salvar</button>
      </div>
      {{ Form::close() }}
   </div>
</div>
<script type="text/javascript">
   $( document ).ready(function() {
      $('select[name=estoque_id]').change(function () {
         var idEstoque = $(this).val();
         $.get('/quantidade/' + idEstoque, function (quantidade) {
            var input=$('#tentacles')
            input.val('');
            input.attr({'max':quantidade})
         });
      });
      
      $('#tentacles').change(function (){
         if(( parseInt( $(this).val(),10 ) > parseInt( $(this).attr('max'), 10) )   ) {
            $(this).val($(this).attr('max') )
         }
         if($(this).val()< $(this).attr('min')  ) {
            $(this).val($(this).attr('min'))
         }
      });
   });
   
</script>