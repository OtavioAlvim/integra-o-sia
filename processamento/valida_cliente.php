<?php

include('../login/verifica_login.php');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

$verifica_cli = $db_prod->query("SELECT coalesce(i.DESCRICAO, 0) as resultado,p.NOME_CLIENTE,p.ID_PEDIDO  from TMPPEDIDOS p left join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.VENDEDOR = '{$_SESSION['usuario']}' order by p.ID_PEDIDO DESC limit 1");
$resultado_verifica = $verifica_cli->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_verifica as $chave=> $registro){

}
if ($registro['NOME_CLIENTE'] == 'CLIENTE INDEFINIDO'){
    $_SESSION['Cliente não definido'] = true;
	header('Location: ../venda.php');
	exit();
}else{
    header('location: ../venda.php');
    exit();
}
?>