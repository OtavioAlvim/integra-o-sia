<?php

include('../login/verifica_login.php');
include('../DB/conexao.php');
date_default_timezone_set("America/Sao_Paulo");
$id_entrega = $_POST['id_entrega'];
$hora = date("H:i");
$sql = "UPDATE entregas e SET e.entregue = 'S',e.hora_entrega = '{$hora}' WHERE e.numero_pedido = '{$id_entrega}' and e.cnpj = '{$_SESSION['cnpj']}' ";

if($conn->exec($sql)){
    $_SESSION['pedidoEntregue'] = true;
	header('Location: ../entrega/index.php');
	exit();
}
?>