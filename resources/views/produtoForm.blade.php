
<!-- Modal add -->
<div class="modal fade" id="produtoModal" role="dialog">
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="produtoModalLabel">Adicionar Produto</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url'=>$Url, 'method' => $Method, 'class'=>'col-md-12')) }}
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="propriedade_id">Propriedade</label>
                            <select style="-moz-appearance: none; -webkit-appearance: none; appearance: none;" form="produto" class="form-control-plaintext" id="propriedade_id" name="propriedade_id">
                                <option selected value="{{$propriedade->id}}" >{{$propriedade->nome}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="nome" class="control-label">Produto<span style="color: red">*</span></label>
                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{2,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="control-label">Unidade</label>
                        <select form="produto" class="form-control-plaintext" id="unidade_id" name="unidade_id">
                            @foreach($unidades as $u)
                                <option value="{{$u->id}}"> {{$u->nome}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="nome" class="control-label">Plantável</label>
                        <input type="checkbox" id="plantavel" name="plantavel">
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
