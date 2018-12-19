@extends('master')
@section('usuario', $User)
@section('conteudo')
<link href="plugin-tempo/jquery.weather.br.min.css" media="all" rel="stylesheet" />
<script src="plugin-tempo/jquery.weather.br.js"></script>
<style type="text/css">
    #weather {
        margin-top:15px;
        margin-bottom:0%;
    }
</style>

<script>
    $(function() {
        $('#weather').weather({
            geoLocation:false,
            locationLat: {{$Latitude}},
            locationLon: {{$Longitude}}
        });
    });
 </script>

 <div class="ml-auto " id="weather"></div>

@endsection
