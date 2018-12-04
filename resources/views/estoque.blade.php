
@extends('master')

@section('usuario', $User);

@section('conteudo')

{{--<form method="post"  action="api/estoque">--}}
    <div class="form-group">

                    {!! Form::open(["url"=>'api/estoque',"files"=>"true"])!!}
                    Insira o nome da sessão: {!! Form::password("section_name", ["class"=>"form-control", "required"=>true]) !!}<br>
                    Upload image: {!! Form::file('image') !!}<br>
                    {!! Form::submit("Inserir", ["class"=> "btn btn-danger"])!!}
                    {!! Form::close() !!}
    </div>
<table class="table table-striped table-hover table-condensed">
    <thead>
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Unidade</th>
        <th>Ações</th>
    </tr>
    </thead>

    <tbody>
        @foreach($produtos as $prod)
{{--            <td>{{$prod['nome_produto']}}</td>
            <td>{{$prod['quantidade']}}</td>
            <td>{{$prod['Unidade']}}</td>--}}
            <td>
                <button class="btn btn-xs btn-primary"> Editar </button> | <button class="btn btn-xs btn-danger">Perda</button>
            </td>
        @endforeach
    </tbody>

</table>

@endsection
	