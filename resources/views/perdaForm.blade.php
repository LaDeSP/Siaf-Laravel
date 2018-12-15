<div class="modal-dialog" role="document">
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
            <label class="col-5">Descricao:</label>
            <input class="col-5" type="text" name="descricao" value="">
        </div>

        <div class="row linhaFrom">
            <label class="col-5">Quantidade:</label>
            <input class="col-5" type="number" name="quantidade" value="">
        </div>

        <div class="row linhaFrom">
                <label class="col-3">Estoque:<span class="text-danger">*</span></label>
            <select class="col-7 form-control" name="estoque_id" required='required'>
                @foreach ($estoques as $estoque)
                <option  @isset($Vendas)@if($estoque->id == $Vendas->estoque_id) echo selected  @endif @endisset value="{{$estoque->id}}">{{$estoque->nomep}} / {{ $estoque->data}}</option>
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

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-success">Salvar</button>

    </div>
    {{ Form::close() }}
  </div>
</div>
