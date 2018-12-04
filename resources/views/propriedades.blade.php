@extends('master')

@section('usuario', $User)

@section('conteudo')
@foreach ($propriedades as $propriedade)
    {{$propriedade['propriedade']}}<br>
    @if(!$propriedade['produtos']->isEmpty())
        {{$propriedade['produtos']}}
    @endif
    <br>
    @if(!$propriedade['talhao']->isEmpty())
        {{$propriedade['talhao']}}
    @endif
    <br>
    <br>
@endforeach
@endsection