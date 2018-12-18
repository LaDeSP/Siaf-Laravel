<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{ Form::open(array('url'=>$Url, 'method' => $Method, 'class'=>'col-md-12')) }}
            <div class="modal-header">
                <h5 class="modal-title" id="propriedadeModalLabel">Editar Propriedade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nome" class="control-label">Nome<span style="color: red">*</span></label>
                            <input type="text" class="form-control " pattern="[A-Za-zÀ-ú ]{2,255}$" id="nome" name="nome"  placeholder="Nome" value="{{ isset($propriedade->nome) ? $propriedade->nome : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="control-label">Localização</label>
                        <input class="form-control" id="localiza" name="localiza"  placeholder="Localização" value="{{ isset($propriedade->localizacao) ? $propriedade->localizacao: '' }}" required>
                    </div>
                    <div class="form-group">
                        <div class='form-group'>
                            <label>
                                Estado
                                <span style="color: red">*</span></label>
                                <select class="custom-select" name="estados" id="uf" required>
                                    @foreach ($estados as $estado)
                                        <option @if($estado->id == $mestado->id)
                                                selected
                                                @endif value={{$estado->id}}>{{ $estado->nome }}</option>
                                    @endforeach
                                </select>

                        </div>
                        <div class='form-group'>
                            <label>
                                Cidade
                                <span style="color: red">*</span></label>
                                <select class="custom-select" name="cidade" id="cidade" required>
                                    <option value="{{$mcidade->id}}">{{$mcidade->nome}}</option>
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

    </div>
</div>

<script type="text/javascript">
    $('select[name=estados]').change(function () {
        var idEstado = $(this).val();
        $.get('/cidades/' + idEstado, function (cidades) {
            $('select[name=cidade]').empty();
            $.each(cidades, function (key, value) {
                $('select[name=cidade]').append('<option value=' + value.id + '>' + value.nome + '</option>');
            });
        });
    });
</script>