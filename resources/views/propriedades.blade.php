@extends('master')

@section('usuario', $User)

@section('conteudo')

<script type="text/javascript">
    $( document ).ready(function() {
        $('a[data-async="true"]').click(function(e){
            e.preventDefault();
            var self = $(this),
                url = self.data('endpoint'),
                target = self.data('target'),
                cache = self.data('cache');

            $.ajax({
                url: url,
                cache : cache,
                success: function(data){
                    if (target !== 'undefined'){

                        $('#'+target).modal('show');
                        $('#'+target).html( data );
                    }
                }
            });
        });
    });
</script>
     <br>
<div class="container-fluid">
    <div class="row align-content-center">
        <div class="card col-12">
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <table class="table table-hover table-condensed">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Localização</th>
                            <th scope="col"> Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{$propriedade['nome']}}</td>
                                <td>{{$propriedade['localizacao']}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4 adicionar">
                                            <a id ="editProp"
                                               class="btn btn-xs btn-warning"
                                               href="/propriedade/{{$propriedade['id']}}/edit"
                                               data-endpoint="/propriedade/{{$propriedade['id']}}/edit"
                                               data-target="propModal"
                                               data-cache="false",
                                               data-async="true">Editar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </blockquote>
            </div>
        </div>
    </div>
           <div style="padding-top: 1%;" class="row align-content-center">
                <div class="col-6 card">
                    <div class="card-header">
                        <div class="row">
                            <font class="lead font-weight-bold"> Talhão</font>
                            <div class="col-md-10 col-sm-2 text-right adicionar">
                                    <a class="btn btn-success"
                                       href="/talhao/create"
                                       data-endpoint="/talhao/create"
                                       data-target="propModal"
                                       data-cache="false",
                                       data-async="true">Adicionar</a>
                                </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            @if(($talhao->isEmpty()))
                                <div class="text-center">
                                    <p>Por favor, adicione um talhão!</p>
                                </div>
                            @else
                                <table class="table table-hover table-condensed">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Área</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($talhao as $t)
                                            <tr>
                                                <td>{{$t['nome']}}</td>
                                                <td>{{$t['area']}}m²</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <a id ="editTalhao"
                                                               class="btn btn-xs btn-warning"
                                                               href="/talhao/{{$t['id']}}/edit"
                                                               data-endpoint="/talhao/{{$t['id']}}/edit"
                                                               data-target="propModal"
                                                               data-cache="false",
                                                               data-async="true">Editar</a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <form method="post" id="talhaoDelete" action="/talhao/{{$t['id']}}">
                                                                @csrf
                                                                @method("DELETE")
                                                                <button type="submit"
                                                                        @if(\App\Http\Controllers\PropriedadeController::findUsageT($t))
                                                                            disabled
                                                                        @endif id="regitrarInves" class="btn btn-xs btn-danger delete confirm"  msg='Tem certeza que deseja excluir o talhão {{$t->nome}}.' name="salvar">Excluir</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @endif
                        </blockquote>
                        @if($talhao instanceof \Illuminate\Pagination\LengthAwarePaginator )
                            {{$talhao->appends('produto', \Illuminate\Support\Facades\Input::get('produto',1))->links()}}
                        @endif
                    </div>
                </div>
        &nbsp;
                <div class="col-5 card ">
                    <div class="card-header">
                        <div class="row">
                            <font class="lead font-weight-bold">Produto</font>
                            <div class="col-md-10 col-sm-2 text-right adicionar">
                                <a class="btn btn-success"
                                   href="/produto/create"
                                   data-endpoint="/produto/create"
                                   data-target="propModal"
                                   data-cache="false",
                                   data-async="true">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">

                            @if(($produto->isEmpty()))
                                <div class="text-center">
                                    <p>Por favor, adicione um produto!</p>
                                </div>
                            @else
                            <table class="table table-hover table-condensed">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Unidade</th>
                                    <th scope="col">Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                    @foreach ($produto as $p)
                                        <tr>
                                           <td>{{$p['nome']}}</td>
                                            <td>{{$p['unidade_id']}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a id ="editTalhao"
                                                           class="btn btn-xs btn-warning"
                                                           href="/produto/{{$p['id']}}/edit"
                                                           data-endpoint="/produto/{{$p['id']}}/edit"
                                                           data-target="propModal"
                                                           data-cache="false",
                                                           data-async="true">Editar</a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <form method="post" id="produtoDelete" action="/produto/{{$p['id']}}">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" id="regitrarInves"
                                                                    @if(\App\Http\Controllers\PropriedadeController::findUsageP($p))
                                                                        disabled
                                                                    @endif class="btn btn-xs btn-danger delete confirm"  msg='Tem certeza que deseja excluir o produto {{$p->nome}} . ' name="salvar">Excluir</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                        </blockquote>
                        @if($produto instanceof \Illuminate\Pagination\LengthAwarePaginator )
                            {{$produto->appends('talhao', \Illuminate\Support\Facades\Input::get('talhao',1))->links()}}
                        @endif
                    </div>
                </div>
    </div>

    <div class="modal fade" id="propModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Savar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection