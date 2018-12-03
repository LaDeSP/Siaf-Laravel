
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="/images/https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="/images/https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
	<style type="text/css">
		.menu{
			background-color: #f8f8f8;
		}
		.rodape{
			background-color: #80808099;
			padding: 20px
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
				<img  class="img-fluid col-12 offset-sm-6 col-sm-6" src="/images/agr.png">	
				<div  class="user col-12 offset-sm-6 col-sm-6 text-center">@yield('usuario')</div>		
			</div>
		</div>
		<div  class="row">

			<div  class="col-2 col-sm-1 col-md-2 menu">
				<div class="row"> 
					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Inicio</div>	
					 </div>	
					</div>

					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Vendas</div>	
					 </div>	
					</div>
				</div>
				<div class="row"> 
					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Estoque</div>	
					 </div>	
					</div>

					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Produção</div>	
					 </div>	
					</div>
				</div>
				<div class="row"> 
					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Manejo</div>	
					 </div>	
					</div>

					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Despesas</div>	
					 </div>	
					</div>
				</div>
				<div class="row"> 
					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center ">Investimentos</div>	
					 </div>	
					</div>

					<div class=" col-md-6 ">
					 <div class="row"> 
					 	<div>
					 		<img class="col-md-12 img-fluid" src="/images/agr.png" >	
					 	</div>
					 	
					 </div>
					 <div class="row">
					 	<div  class=" col-md-12 text-center">Relatorios</div>	
					 </div>	
					</div>
				</div>
																				
			</div>

			<div  class="col-10 col-sm-9 col-md-10">
				  @yield('conteudo')

			</div>

			
		</div>
		<div class="row ">
			<div class="rodape col-12 text-center">Mussum Ipsum, cacilds vidis litro abertis. Nullam volutpat risus nec leo commodo, ut interdum diam laoreet.</div>
		</div>
	</div>
</body>
</html>