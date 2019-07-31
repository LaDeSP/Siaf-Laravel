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
            <label class="col-4">Data Semeadura:</label>
            <input class="col-7" type="date" name="data_semeadura" value="@isset($dados){{$dados->data_semeadura}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-4">Data Plantio:<span class="text-danger">*</span></label>
            <input class="col-7" type="date" name="data_plantio" required='required' value="@isset($dados){{$dados->data_plantio}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-4">Número de Plantas:<span class="text-danger">*</span></label>
            <input class="col-7" type="number" min="1" name="quantidade_pantas" required='required' value="@isset($dados){{$dados->quantidade_pantas}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-4">Talhão:<span class="text-danger">*</span></label>

            <select class="col-7" name="talhao_id" required='required'>
                    @foreach ($Propriedade['talhao'] as $talhao)
                        <option  @isset($dados)@if($talhao['id']== $dados->talhao_id ) echo selected  @endif @endisset value="{{$talhao['id']}}">{{$talhao['nome']}}</option>
                    @endforeach
            </select>
         </div>
         <div class="row linhaFrom">
            <label class="col-4">Produto:<span class="text-danger">*</span></label>
            <select class="col-7" name="produto_id" required='required'>
                    @foreach ($Propriedade['produto'] as $produto)
                        <option  @isset($dados)@if($produto['id']== $dados->produto_id ) echo selected  @endif @endisset value="{{$produto['id']}}">{{$produto['nome']}}</option>
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
