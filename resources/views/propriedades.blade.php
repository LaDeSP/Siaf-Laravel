@extends('master')

@section('usuario', 'LULU da casa')

@section('conteudo')
@foreach ($propriedades as $prop)
    {{$prop}}
@endforeach
@endsection