<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        {{ Form::open(array('url'=>$Url, 'method' => $Method, 'class'=>'col-md-12')) }}
            <div class="modal-header">
                <h5 class="modal-title" id="talhaoModalLabel">{{$Title}}</h5>
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
                        <div class="form-group col-md-6">
                            <label for="nome" class="control-label">Nome do Talhão<span style="color: red">*</span></label>
                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú][1-9]+{1,255}$" id="nome" name="nome" placeholder="Nome" value="{{ isset($talhao->nome) ? $talhao->nome : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="control-label">Área em m²</label>
                        <input type="text" class="form-control " pattern="{6,255}$" id="area" name="area" placeholder="exemplo: 20" value="{{ isset($talhao->area) ? $talhao->area : '' }}" required>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                    </div>
                {{Form::close()}}
            </div>
        </div>

    </div>
</div>