@extends('master')

@section('usuario', $User)

@section('conteudo')
    <div>
      <form action="/plantio" method="post">
        @csrf
        <input type="date" name="data_semeadura" value="">
        <input type="date" name="data_plantio" value="">
        <input type="number" name="quantidade_plantas" value="">
        <select>
        @foreach ($Propriedades as $propriedade)
                <p>This is user {{ $propriedade['talhao'] }}</p>
                @foreach ($propriedade['talhao'] as $talhao)
                    <option value="{{$talhao['id']}}">{{$talhao['nome']}}</option>
                @endforeach
        @endforeach
        </select>
        <input type="number" name="talhao_id" value="">
        <input type="number" name="produto_id" value="">
        <input type="submit">
    </div>
@endsection
