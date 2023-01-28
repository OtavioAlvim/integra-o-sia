<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Faça Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
	<script src="./api/sweetalert2.js"></script>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="./login/login.php" method="POST">
					<span class="login100-form-title">
						Seja bem Vindo!
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Usuario Requerido">
						<input class="input100" type="text" name="usuario" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Senha requerida">
						<input class="input100" type="password" name="senha" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							
							Entrar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!-- LOCAL DESTINADO A MODAL DE VALIDAÇÃO DA PAGINA -->

<!-- destinado caso o modal não seja preenchido e tente enviar para validação -->
<?php
if(isset($_SESSION['errorr'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Existe campos vazios!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['errorr']);
?>

<!-- destinado caso o modal não seja preenchido e tente enviar para validação -->
<?php
if(isset($_SESSION['erro_de_login'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Usuario e senha não encontrados!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['erro_de_login']);
?>


<!-- destinado caso o modal não seja preenchido e tente enviar para validação -->
<?php
if(isset($_SESSION['erro_de_login'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Usuario e senha não encontrados!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['erro_de_login']);
?>

<!-- destinado caso o modal não seja preenchido e tente enviar para validação -->
<?php
if(isset($_SESSION['erro'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Erro não identificado!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['erro']);
?>
</body>
</html>