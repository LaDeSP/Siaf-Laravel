@extends('master')
@section('usuario', $User)
@section('conteudo')
<link href="plugin-tempo/jquery.weather.br.min.css" media="all" rel="stylesheet" />
<script src="plugin-tempo/jquery.weather.br.js"></script>
<style type="text/css">
    #weather {
        margin-top:20px;
        width: 300px;
        bottom: 0%;
    }
</style>

<script>
    $(function() {
        $('#weather').weather({
            geoLocation:false,
            locationLat: 0.3166667,
            locationLon: -50.8833333
        });
    });
 </script>

 <div class="ml-auto " id="weather"></div>

@endsection
