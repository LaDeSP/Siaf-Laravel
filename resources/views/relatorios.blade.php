@extends('master')

@section('usuario', $User)

@section('conteudo')

<div class="container col-10">
	@foreach ($dados as $d)
	   	{{$d}}
    @endforeach
</div>
<script type="text/javascript">
</script>

@endsection