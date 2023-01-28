<?php
session_start();
include('../DB/conexao.php');

//Verifica se existe algum dado vindo do formulario post
if(empty($_POST['usuario']) || empty($_POST['senha'])){
	$_SESSION['errorr'] = true;
	header('Location: ../index.php');
	exit();   
}
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];


//verifica se existe o usuario no banco de dados, caso ele exista, ele prosegue com a validação, caso contrario, ele volta para a tela inicial
$consulta_usuario_banco = $conn->query("SELECT COUNT(*) AS total FROM config c WHERE c.email = '{$usuario}' AND c.senha = '{$senha}'");
$resultadoConsulta = $consulta_usuario_banco->fetchAll(PDO::FETCH_ASSOC);
//após ele fazer a consulta no banco de dados, se ele retornar zero, significa que ele não encontrou nenhum registro correspndente.
foreach($resultadoConsulta as $row=> $resulta){
    $resulta['total'];
}
if($resulta['total'] == 0) {
	$_SESSION['erro_de_login'] = true;
	header('Location: ../index.php');
	exit;
}

$sql = $conn->query("SELECT * FROM config c WHERE c.email = '{$usuario}' AND c.senha = '{$senha}'");
$resultado_sql = $sql->fetchAll(PDO::FETCH_ASSOC);
// verificar linha do codigo
if(isset($resultado_sql)){
foreach($resultado_sql as $row=> $registro){
	$_SESSION['fanta'] = $registro['razao'];
	$_SESSION['usuario'] = $registro['usuario'];
	// $_SESSION['usuario'] = 'ADALBERTO SOUZA';
	$_SESSION['ID_EMPRESA'] = $registro['id_empresa'];
	$_SESSION['ID'] = $registro['id_vendedor_sia'];
	// $_SESSION['ID'] = '30';
	$_SESSION['privilegio'] = $registro['privilegio'];
	$_SESSION['cnpj'] = $registro['cnpj'];
	$_SESSION['login_aprovado'] = true;
	// header('Location: ../menu.php');
	header('Location: ./permissao.php');
	exit();
}
}else{
	$_SESSION['erro'] = true;
	header('Location: ../index.php');
}
?>