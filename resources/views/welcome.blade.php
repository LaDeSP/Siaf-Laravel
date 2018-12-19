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

<div>
        <div class="row">
				<div class="col-md-2">
					<img class="img-fluid" src="/images/carinha4.png">
				</div>	
				<div class="col-5 card" style="width: 40rem;">
					<div class="card-body">
						<h5 class="card-title">Ultimas Vendas</h5>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">First</th>
										<th scope="col">Last</th>
										<th scope="col">Handle</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Mark</td>
										<td>Otto</td>
										<td>@mdo</td>
									</tr>
									<tr>
										<td>Jacob</td>
										<td>Thornton</td>
										<td>@fat</td>
									</tr>
									<tr>
										<td>Larry</td>
										<td>the Bird</td>
										<td>@twitter</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
 </div>
 <div class="ml-auto col-2" id="weather">
 </div>

@endsection
