@extends('master')
@section('usuario', $User)
@section('conteudo')
<link href="plugin-tempo/jquery.weather.br.min.css" media="all" rel="stylesheet" />
<script src="plugin-tempo/jquery.weather.br.js"></script>
<style type="text/css">
    #weather {
        margin-right:1px;
        width: 300px;
    }
</style>
<script>
    $(function() {
        $('#weather').weather({
            geoLocation:false,
            locationLat: -19.4703,
            locationLon: -42.5476
        });
    });
 </script>
  <div class="ml-auto" id="weather"></div>


@endsection
