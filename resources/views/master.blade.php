
<!DOCTYPE html>
<html>
<head>
	<title> SIAF </title>
	<link rel="icon" href="images/icon.png">
	<script src="js/JQuery/jquery-2.2.4.min.js"></script>
	<script src="js/validator/jQuery.mask1.14.11.min.js"></script>
	<script src="bootstrap/js/popper.min.js"></script>
	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="bootbox/bootbox.min.js"></script>
	<script src="js/moment-with-locales.min.js"></script>
	<script src="js/highcharts/highcharts.js"></script>
	<script src="js/highcharts/modules/data.js"></script>
	<script src="js/highcharts/modules/exporting.js"></script>
	<script src="js/highcharts/modules/export-data.js"></script>
	<script type="text/javascript" src="js/highcharts/jquery.highchartTable.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<style type="text/css">
		.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
			background-color: rgba(97, 255, 240, 0.12);
		}

		.row{
			margin-right: 0;
		}
		.foco{
			border-bottom: 4px solid #00913d;
		}
		a:hover,a{
			color: inherit; /* blue colors for links too */
			text-decoration: inherit; /* no underline */
		}
		.menu{
			background-color: #f8f8f8;
			font-size:1.1vw;
		}
		.rodape{
			background-color: #80808099;
			border-top: 1px solid #2e54678f;

		}
		.rodape img{
			width: 150px;
			top: 0%;
		}
		.conteudo{
			border-left: 1px solid #6178844f;
			border-top: 1px solid #6178844f;
			width: 100%;

		}

		.linhaFrom{
			margin-bottom: 10px
		}
		img{
			padding: 10px;
		}
		@media screen and (min-width: 768px){
			.rwd-break { display: none; }
		}
		.adicionar{
			margin-bottom: 4px;
			margin-top: 4px;
		}

		.p {
			max-width: 10ch;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.pagination > li > a,
		.pagination > li > span {
			color: green;
		}

		.pagination > .active > a,
		.pagination > .active > a:focus,
		.pagination > .active > a:hover,
		.pagination > .active > span,
		.pagination > .active > span:focus{
			background-color: green;
			border-color: green;
			color: green;

		}
		.pagination > .active > span:hover {
			background-color: green;
			border-color: green;
			color: green;
		}
		#title{
			font-size: 3.5vw;
		}
		@media screen and (min-width: 1200px) {
			#title {
				font-size: 36px;
			}
		}
	</style>
	<script type="text/javascript">
		$( document ).ready(function() {

			$('#exampleModal').on('shown.bs.modal', function () {
				$('[type=date').each(function(e){
					if(this.value===''){
						this.value=moment().format('YYYY-MM-DD');
					}
				});

				$('select').each(function(e){
					if($(this).find('option').length==0){
						texto=$(this).parent().find('label').text()
						texto=texto.replace(':','');
						texto=texto.replace('*','');
						msg='Adicione um '+texto;
						$(this).append('<option value="">'+msg+'</option>')
						$(this).prop( "disabled", true );
						$(this).closest('form').find(':submit').prop( "disabled", true );
					}
				})

			});
			$('.data').each(function(e){
				if(this.innerText != ''){
					var d = new Date(this.innerText);
					this.innerText= moment.utc(d).format("D/M/YYYY");
				}
			});

			$('#relatorio [type=date').each(function(e){
				if(this.value===''){
					this.value=moment().format('YYYY-MM-DD');
				}
			});


			$(".confirm").on("click", function(e) {
				e.preventDefault();
				form=this.closest('form');
				msg=this.data;
				msg=$(this).attr('msg');
				bootbox.confirm({ message:msg,
					buttons: {
						confirm: {
							label: 'Sim',
							className: 'btn-danger'
						},
						cancel: {
							label: 'Cancelar',
							className: 'btn-secondary'
						}
					},
					callback:function(result){
						if(result)
						form.submit();

					}});
				});

				$(".mensagem").fadeTo(2000, 500).slideUp(500, function(){
					$(".mensagem").slideUp(500);
				});

				$('.bd-user-modal-sm').css("margin-left", $(window).width() - $('.modal-content').width()*2);

				$('.bd-user-modal-sm').css("margin-top", $('.menu').height());
				$('.op').css("margin",0) ;

				$("#telefone, #celular").mask("(00)00000-0000");

			});



		</script>
	</head>
	<body>
		<div class="container-fluid">
			<div  class="row menu menu-top align-items-center">
				<div  class="col-5 col-sm-4 col-md-2" >
					<img class="img-fluid" src="images/log.png">
				</div>
				<div class="col-2 col-md-2 col-sm-1 offset-md-3 offset-sm-1 text-center lead caret">
					<h3 id="title" class="h3">{{$Tela}}</h3>
				</div>
				<div  class="col-5 col-md-2 col-sm-3 offset-md-3 offset-sm-1"  data-toggle="modal" data-target=".bd-user-modal-sm"  data-backdrop="false" >
					<img  class="btn img-fluid col-6 offset-6" src="images/agr.png">
					<div class="col-6 offset-6 lead text-center" >{{$User}} </div>
				</div>

				<div class="modal fade bd-user-modal-sm" tabindex="-1" role="dialog" aria-labelledby="opções" aria-hidden="true">
					<div class="modal-dialog modal-sm op">
						<div class="modal-content">
							<ul class="list-group">
								<li class=" list-group-item list-group-item-action list-group-item-success">
									<a href="usuario" class="lead"> <h8>Perfil</h8> </a>
								</li>
								<li class=" list-group-item list-group-item-action list-group-item-success">
									<a class="lead" href="{{ route('logout') }}"
									onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
									<h8>Sair</h8>
								</a>
							</li>

						</ul>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div  class="row">

		<div  class="col-2 col-sm-2 col-md-2 col-xl-2 menu menu-left">
			<div class="row">

				<div class="col-md-6   @if(Request::segment(1) == 'home') foco  @endif ">
					<a href="home">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Inicio.png" >
							</div>

						</div>
					</a>
				</div>

				<div class=" col-md-6 @if(Request::segment(1) == 'venda') foco  @endif">
					<a href="venda">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Vendas.png" >
							</div>
						</div>

					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 @if(Request::segment(1) == 'estoque') foco  @endif">
					<a href="estoque">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Estoque.png" >
							</div>
						</div>

					</a>
				</div>

				<div class=" col-md-6 @if(Request::segment(1) == 'plantio') foco  @endif">
					<a href="plantio">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Plantio.png" >
							</div>

						</div>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 @if(Request::segment(1) == 'manejo') foco  @endif">
					<a href="manejo">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Manejo.png" >
							</div>
						</div>

					</a>
				</div>

				<div class=" col-md-6 @if(Request::segment(1) == 'propriedade') foco  @endif">
					<a href="propriedade">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Propriedade.png" >
							</div>

						</div>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6  @if(Request::segment(1) == 'despesa') foco  @endif">
					<a href="despesa">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Despesas.png" >
							</div>

						</div>
					</a>
				</div>

				<div class="col-md-6 @if(Request::segment(1) == 'investimento') foco  @endif">
					<a href="investimento">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Investimento.png" >
							</div>

						</div>
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 @if(Request::segment(1) == 'relatorio') foco  @endif">
					<a href="relatorio">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Relatorio.png" >
							</div>

						</div>
					</a>
				</div>

				<div class=" col-md-6 @if(Request::segment(1) == 'manual') foco  @endif">
					<a href="manual">
						<div class="row">
							<div>
								<img class="col-md-12 img-fluid" src="images/Manual.png" >
							</div>

						</div>
					</a>
				</div>
			</div>

		</div>
		<div  style="margin-left:0%;" class="conteudo col-10 col-sm-10">
			@isset($mensagem)
			<div class="mensagem alert alert-{{$status}} fade in">
				{{$mensagem}}
			</div>
			@endisset
			@yield('conteudo')
		</div>
		<div class="row rodape col-12 ">
			<div class="col-9 text-right">
				<p style="padding-top:2%; margin-bottom: 0rem;">Todos os direitos reservados. Universidade Federal de Mato Grosso do Sul. Copyright © 2018</p>
				<p class="text-center offset-md-5" style="line-height: 80%;" >Corumbá/MS</p>
			</div>
			<div class="col">
				<img style="padding-top: 1%; padding-left: 0;" src="images/Logo_menor.png">
			</div>

		</div>
	</div>



</div>
</body>
</html>
