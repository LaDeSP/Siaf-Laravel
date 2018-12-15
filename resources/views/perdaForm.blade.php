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
            if(( parseInt( $(this).val(),10 ) > parseInt( $(this).attr('max') ,10) )   ) {
                $(this).val($(this).attr('max') )
            }
            if($(this).val()< $(this).attr('min')  ) {
                $(this).val($(this).attr('min'))
            }
        });
    });

</script>

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
            <label class="col-3">Descricao:</label>
            <input class="col-7" type="text" name="descricao" value="">
        </div>

        <div class="row linhaFrom">
            <label class="col-3">Data:</label>
            <input class="col-7" type="date" name="data" value="">
        </div>





          <input  type="hidden" name='estoque_id' value="{{$Estoque}}">

        <div class="row linhaFrom">
            <label class="col-3">Destino:<span class="text-danger">*</span></label>
            <select class="col-7 form-control" name="destino_id" required='required'>
                @foreach ($Destinos as $destino)
                <option  @isset($Vendas)@if($destino->id == $Vendas->destino_id) echo selected  @endif @endisset value="{{$destino->id}}">{{$destino->destino}}</option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="row linhaFrom">
        <label class="col-3">Quantidade:</label>
        <input  id='tentacles' class="col-7" type="number" name="quantidade" min=0 max={{$Max}} value="">
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-success">Salvar</button>

    </div>
    {{ Form::close() }}
  </div>
</div>
