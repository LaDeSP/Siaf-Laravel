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
            <input class="col-5" type="text" name="descricao" value="@isset($dados){{$dados->descricao}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-5">Data:<span class="text-danger">*</span></label>
            <input class="col-5" type="date" name="data_hora" required='required' value="@isset($dados){{$dados->data_hora}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-5">Horas Utilizadas:</label>
            <input class="col-5" type="number" min="1" name="horas_utilizadas" value="@isset($dados){{$dados->horas_utilizadas}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-3">Manejo:<span class="text-danger">*</span></label>

            <select class="col-9" name="manejo_id" required='required'>
                    @foreach ($Manejos as $manejo)
                        <option  @isset($dados)@if($manejo['id']== $dados->id ) echo selected  @endif @endisset value="{{$manejo->id}}">{{$manejo->nome}}</option>
                    @endforeach
            </select>
         </div>
         <input class="col-5" type="hidden"  name="plantio_id" value="@isset($Plantio){{$Plantio}}@endisset @isset($dados){{$dados->plantio_id}}@endisset">

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-success">Salvar</button>

    </div>
    {{ Form::close() }}
  </div>
</div>
