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
            <label class="col-4">Descricao:</label>
            <input class="col-7" @isset($disabled){{$disabled}}@endisset type="text" name="descricao" value="@isset($dados){{$dados->descricao}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-4">Data:<span class="text-danger">*</span></label>
            <input class="col-7" @isset($disabled){{$disabled}}@endisset type="date" name="data_hora" required='required' value="@isset($dados){{$dados->data_hora}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-4">Horas Utilizadas:<span class="text-danger">*</span></label>
            <input required='required' class="col-7" @isset($disabled){{$disabled}}@endisset type="number" min="1" name="horas_utilizadas" value="@isset($dados){{$dados->horas_utilizadas}}@endisset">
        </div>
        <div class="row linhaFrom">
            <label class="col-4">Manejo:<span class="text-danger">*</span></label>

            <select class="col-7" @isset($disabled){{$disabled}}@endisset name="manejo_id" required='required'>
                    @foreach ($Manejos as $manejo)
                        <option  @isset($dados)@if($manejo['id']== $dados->manejo_id ) {{$select}}  @endif @endisset value="{{$manejo->id}}">{{$manejo->nome}}</option>
                    @endforeach
            </select>
         </div>
         @isset($disabled)
         <div class="row linhaFrom">
             <label class="col-4">Produtos Colhidos:<span class="text-danger">*</span></label>
             <input  required='required' min=0 class="col-7" type="number" min="1" name="numero_produdos" value="">
         </div>
         @endisset
         <input class="col-5" type="hidden"  name="plantio_id" value="@isset($Plantio){{$Plantio}}@endisset @isset($dados){{$dados->plantio_id}}@endisset">

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-success">Salvar</button>

    </div>
    {{ Form::close() }}
  </div>
</div>
