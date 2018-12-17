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
            <label class="col-5">Quantidade:</label>
            <input class="col-5" type="number" min="1" name="quantidade" value="@isset($dados){{$dados->quantidade}}@endisset">
        </div>

        <div class="row linhaFrom">
           <label class="col-5">Produto:<span class="text-danger">*</span></label>
           <select class="col-5" name="produto_id" required='required'>
                   @foreach ($Propriedade['produto'] as $produto)
                       <option  @isset($dados)@if($produto['id']== $dados->produto_id ) echo selected  @endif @endisset value="{{$produto['id']}}">{{$produto['nome']}}</option>
                   @endforeach
           </select>

       </div>

        <div class="row linhaFrom">
            <label class="col-5">Data:<span class="text-danger">*</span></label>
            <input class="col-5" type="date" name="data" required='required' value="@isset($dados){{$dados->data}}@endisset">
        </div>


         <input class="col-5" type="hidden"  name="propriedade_id" value="@isset($Propriedade){{$Propriedade['propriedade']->id}}@endisset ">

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-success">Salvar</button>

    </div>
    {{ Form::close() }}
  </div>
</div>
