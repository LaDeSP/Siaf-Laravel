<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        {{ Form::open(array('url'=>$Url, 'method' => $Method, 'class'=>'col-md-12')) }}
        <div class="modal-header">
            <h5 class="modal-title" id="produtoModalLabel">{{$Title}}</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="propriedade_id">Propriedade</label>
                    <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" class="form-control-plaintext" name="propriedade_id">
                        <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>
                    </select>
                </div>
                        <div class="form-group col-md-12">
                            <label for="nome" class="control-label">Produto<span style="color: red">*</span></label>
                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{2,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($produto->nome) ? $produto->nome : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="control-label">Unidade</label>
                        <select class="form-control-plaintext" id="unidade_id" name="unidade_id">
                            @foreach($unidades as $u)
                                <option @if(isset($munidade))
                                            @if($u->id == $munidade))
                                                selected
                                            @endif
                                        @endif value="{{$u->id}}"> {{$u->nome}} </option>
                            @endforeach
                        </select>
                    </div>
                        <div class="form-group">
                            <label for="nome" class="control-label">Plantável</label>
                            <input type="checkbox"
                                   @if(isset($produto->plantavel))
                                   @if($produto->plantavel)
                                   checked
                                   @endif
                                   @endif
                                   id="plantavel" name="plantavel">

                        </div>
                        <div class="form-group">
                            <label for="nome" class="control-label" data-toggle="tooltip" data-placement="top" title="Indique se o produto ainda está em uso.">Ativo</label>
                            <input type="checkbox"
                                   @if(isset($produto->status))
                                   @if($produto->status)
                                   checked
                                   @endif
                                   @endif
                                   id="status" name="status">

                        </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>