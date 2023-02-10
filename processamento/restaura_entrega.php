<?php

include('../login/verifica_login.php');
include('../DB/conexao.php');

$id_entrega = $_POST['id_entrega'];

$sql = "UPDATE entregas e SET e.entregue = 'N' WHERE e.numero_pedido = '{$id_entrega}' and e.cnpj = '{$_SESSION['cnpj']}' ";

if($conn->exec($sql)){
    $_SESSION['pedidoRestaurado'] = true;
	header('Location: ../entrega/entregue.php');
	exit();
}
?>