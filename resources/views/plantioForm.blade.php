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


        <input type="date" name="data_semeadura" value="@isset($dados){{$dados->data_semeadura}}@endisset">
        <input type="date" name="data_plantio" value="@isset($dados){{$dados->data_plantio}}@endisset">
        <input type="number" name="quantidade_pantas" value="@isset($dados){{$dados->quantidade_pantas}}@endisset">
        <select name="talhao_id">
                @foreach ($Propriedade['talhao'] as $talhao)
                    <option  @isset($dados)@if($talhao['id']== $dados->talhao_id ) echo selected  @endif @endisset value="{{$talhao['id']}}">{{$talhao['nome']}}</option>
                @endforeach
        </select>

        <select name="produto_id">
                @foreach ($Propriedade['produto'] as $produto)
                    <option  @isset($dados)@if($produto['id']== $dados->produto_id ) echo selected  @endif @endisset value="{{$produto['id']}}">{{$produto['nome']}}</option>
                @endforeach
        </select>



    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      <button type="submit" class="btn btn-primary">Salvar</button>

    </div>
    {{ Form::close() }}
  </div>
</div>
