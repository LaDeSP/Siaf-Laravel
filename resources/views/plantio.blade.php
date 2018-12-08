@extends('master')

@section('usuario', $User)

@section('conteudo')
    <div>
      <form action="/plantio" method="post">
        @csrf
        <input type="date" name="data_semeadura" value="">
        <input type="date" name="data_plantio" value="">
        <input type="number" name="quantidade_plantas" value="">
        <p>This is user {{  $Propriedade['propriedade']['nome'] }}</p>
        <select>

                @foreach ($Propriedade['talhao'] as $talhao)
                    <option value="{{$talhao['id']}}">{{$talhao['nome']}}</option>
                @endforeach
        </select>
        <input type="number" name="talhao_id" value="">
        <input type="number" name="produto_id" value="">
        <input type="submit">
    </div>
@endsection
