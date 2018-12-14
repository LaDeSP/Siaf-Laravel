@extends('master')

@section('usuario', $User)

@section('conteudo')

<div class="container">
	<div class="accordion" id="accordionExample">
	  	<div class="card">
            <form id="relatorio" action="/relatorio" method="POST">
                @csrf
                <div class="card-header">
                  <h5 class="mb-0">
                    <div class="row">
                        <div class="">
                            <select  form="relatorio" id="tipo" name="tipo" class="custom-select col-12" >
                                <option selected value="vendas" class="col-4"> Listar vendas realizadas por período</option>
                                <option value="investimentos" class="col-4"> Listar investimentos realizados por período </option>
                                <option value="despesa" class="col-4"> Listar despesa realizados por período</option>
                                <option value="plantios" class="col-4"> Listar plantios realizados por período</option>
                                <option value="manejo-talhão" class="col-4"> Listar manejos realizados por período por talhão </option>
                                <option value="manejo-propriedade" class="col-4"> Listar manejos realizados por período por propriedade </option>
                                <option value="colheitas" class="col-4"> Listar colheitas realizadas por período </option>
                                <option value="talhão" class="col-4"> Listar talhões por propriedade</option>
                                <option value="produtos-propriedade" class="col-4"> Listar produtos ativos e inativos por propriedade</option>
                                <option value="vendas" class="col-4"> Listar histórico de manejo por plantio</option>
                                <option value="vendas" class="col-4"> Listar estoque por propriedade por período </option>
                            </select>
                        </div>
                        <input class="col-2" type="date" name="date-inicio">
                        <input class="col-2" type="date" name="date-final">
                        <button id="gerar" class="col-1 btn btn-info"  class="btn btn-link" type="submit"> Gerar</button>
                    </div>
                  </h5>
                </div>
            </form>
			<div id="container" ></div>
		      	<table id="informacoes" class="table">
                        <thead>
							@if(isset($topo))
								@foreach($topo as $t)

									    <th>{{$t}}</th>
								@endforeach
							@endif
                        </thead>
                        <tbody>
						@if(isset($conteudo))
							@foreach($conteudo as $c)
                                <tr>
                                    @foreach($c as $cc)
                                        <td>{{$cc}}</td>
                                    @endforeach
                                </tr>
							@endforeach
						@endif
                        </tbody>
                    </table>
		    </div>
	</div>
</div>

@endsection