
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
	<style type="text/css">
		a:hover,a{
  			color: inherit; /* blue colors for links too */
  			text-decoration: inherit; /* no underline */
		}

		.menu{
			background-color: #f8f8f8;
			font-size:1.7vw;
		}
		.rodape{
			background-color: #80808099;
			border-top: 1px solid #2e54678f;
			padding: 20px
		}
		.conteudo{
			border-left: 1px solid #6178844f;
			border-top: 1px solid #6178844f;
			
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div  class="row menu"> 
			<div  class="col-6 col-sm-3 col-md-2" >
				<img class="img-fluid" src="/images/log.png">
			</div>
			<div   class="col-5 offset-1  col-sm-3 offset-sm-6 col-md-2 offset-md-8" >
				<a href="/usuario">
					<img  class="img-fluid col-12 offset-sm-6 col-sm-6" src="/images/agr.png">	
					<div  class="user col-12 offset-sm-6 col-sm-6 text-center">@yield('usuario')</div>
				</a>		
			</div>
		</div>
		<div  class="row">

			<div  class="col-2 col-sm-2 col-md-3 col-xl-3 menu">
				<div class="row">
					
					<div class=" col-md-6 ">
						<a href="/home">
						 <div class="row"> 
						 	<div>
						 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
						 	</div>
						 	
						 </div>
						 <div class="row">
						 	<div  class=" col-md-12 text-center">Inicio</div>	
						 </div>	
						</a>
					</div>
					
					<div class=" col-md-6 ">
					<a href="/venda">	
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Vendas</div>	
					 </div>	
					</a>
					</div>
				</div>
				<div class="row"> 
					<div class=" col-md-6 ">
					<a href="/estoque">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Estoque</div>	
					 </div>
					</a>
					</div>

					<div class=" col-md-6 ">
					<a href="/plantio">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Plantio</div>	
					 </div>	
					</a>
					</div>
				</div>
				<div class="row"> 
					<div class=" col-md-6 ">
					<a href="/manejo">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Manejo</div>	
					 </div>
					</a>	
					</div>

					<div class=" col-md-6 ">
					<a href="/propriedade">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Propriedade</div>	
					 </div>	
					</a>
					</div>
				</div>
				<div class="row"> 
					<div class=" col-md-6 ">
					<a href="/despesa">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center ">Despesas</div>	
					 </div>
					 </a>	
					</div>

					<div class=" col-md-6 ">
					<a href="/investimento">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Investimentos</div>	
					 </div>	
					</a>
					</div>
				</div>

				<div class="row"> 
					<div class=" col-md-6 ">
					<a href="/relatorio">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center ">Relatorios</div>	
					 </div>
					 </a>	
					</div>

					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 			
					 	</div>
					 	
					 </div>
					 <div class="row">
					 		
					 </div>	
					</div>
				</div>
																				
			</div>

			<div  class="conteudo col-10 col-sm-10 col-md-9 col-xl-9">
				  @yield('conteudo')

			</div>

			
		</div>
		<div class="row ">
			<div class="rodape col-12 text-center">Desenvolvido e mantido por Leco Ufms.</div>
		</div>
	</div>
</body>
</html>