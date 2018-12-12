
<!DOCTYPE html>
<html>
<head>
	<title> SIAF </title>
	<link rel="icon" href="/images/icon.png">
	<script src="/js/JQuery/jquery-2.2.4.min.js"></script>
	<script src="/bootstrap/js/popper.min.js"></script>
	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/bootbox/bootbox.min.js"></script>
	<script src="/js/moment-with-locales.min.js"></script>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
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
			padding: 20px
		}
		.conteudo{
					border-left: 1px solid #6178844f;
					border-top: 1px solid #6178844f;
		      width: 100%;

        }
				.btn-warning, .btn-warning:hover{
					color: #fff;
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

	</style>
	<script type="text/javascript">
		$( document ).ready(function() {

			$('#exampleModal').on('shown.bs.modal', function () {
				$('[type=date').each(function(e){
					if(this.value==='')
							this.value=moment().format('YYYY-MM-DD')
				});
			});


					$(".confirm").on("click", function(e) {
									e.preventDefault();
									form=this.closest('form');
								bootbox.confirm({ message:"Tem certeza que deseja excluir.",
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


			});



</script>
</head>
<body>
	<div class="container-fluid">
		<div  class="row menu align-items-center">
			<div  class="col-6 col-sm-3 col-md-2" >
				<img class="img-fluid" src="/images/log.png">
			</div>
            <div class="col-md-2 offset-3 text-center lead caret">
                <h2>{{$Tela}}</h2>
            </div>
				<div   class="col-2 offset-3 "  data-toggle="modal" data-target=".bd-user-modal-sm"  data-backdrop="false" >
						<img  class="btn img-fluid col-6   offset-3" src="/images/agr.png">
						<div class="col-8 text-center offset-2" >{{$User}} </div>
				</div>

				<div class="modal fade bd-user-modal-sm" tabindex="-1" role="dialog" aria-labelledby="opções" aria-hidden="true">
			  	<div class="modal-dialog modal-sm op">
						    <div class="modal-content">
									<ul class="list-group">
											<li class=" list-group-item list-group-item-action list-group-item-success">
													<a href="/usuario"> <h8>Perfil</h8> </a>
											</li>
											<li class=" list-group-item list-group-item-action list-group-item-success">
						      			<a href="{{ route('logout') }}"
							                    	onclick="event.preventDefault();
							                    	document.getElementById('logout-form').submit();">
							                    	<h8>Sair</h8>
												</a>
											</li>

											</ul>
												<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
														@csrf
											</form>
						    </div>
			  		</div>
				</div>
			</div>
		</div>
		<div  class="row">

			<div  class="col-2 col-sm-2 col-md-2 col-xl-2 menu">
				<div class="row">

					<div class=" col-md-5 ">
						<a href="/home">
						 <div class="row">
						 	<div>
						 		<img class="col-md-12 img-fluid" src="/images/Inicio.png" >
						 	</div>

						 </div>
						 <div class="row">
						 	<div class="col-md-12 lead text-center">Inicio</div>
						 </div>
						</a>
					</div>

					<div class=" col-md-5 ">
					<a href="/venda">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Vendas.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 lead text-center">Vendas</div>
					 </div>
					</a>
					</div>
				</div>
				<div class="row">
					<div class=" col-md-5 ">
					<a href="/estoque">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Estoque.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 lead     text-center">Estoque</div>
					 </div>
					</a>
					</div>

					<div class=" col-md-5 ">
					<a href="/plantio">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Plantio.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 lead text-center">Plantio</div>
					 </div>
					</a>
					</div>
				</div>
				<div class="row">
					<div class=" col-md-5 ">
					<a href="/manejo">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Manejo.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 lead text-center">Manejo</div>
					 </div>
					</a>
					</div>

					<div class=" col-md-5 ">
					<a href="/propriedade">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Propriedade.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div class="col-12 md-12 lead text-center">Propriedade</div>
					 </div>
					</a>
					</div>
				</div>
				<div class="row">
					<div class=" col-md-5 ">
					<a href="/despesa">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Despesas.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 lead text-center ">Despesas</div>
					 </div>
					 </a>
					</div>

					<div class=" col-md-5 ">
					<a href="/investimento">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Investimento.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 lead text-center">Investimentos</div>
					 </div>
					</a>
					</div>
				</div>

				<div class="row">
					<div class=" col-md-5 ">
					<a href="/relatorio">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Relatorio.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 lead text-center ">Relatorios</div>
					 </div>
					 </a>
					</div>

					<div class=" col-md-5 ">
					<a href="/manual">
					 <div class="row">
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/Manual.png" >
					 	</div>

					 </div>
					 <div class="row">
					 	 <div  class=" col-md-12 lead text-center ">Manual</div>
					 </div>
					 </a>
					</div>
				</div>

			</div>

			<div  class="conteudo col-10 col-sm-10">
				@isset($mensagem)
						<div class="mensagem alert alert-{{$status}} fade in">
								{{$mensagem}}
						</div>
				@endisset
                    @yield('conteudo')
			</div>


		</div>
		<div class="row ">
			<div class="rodape col-12 text-center">Desenvolvido e mantido por Leco Ufms.</div>
		</div>
	</div>
</body>
</html>
