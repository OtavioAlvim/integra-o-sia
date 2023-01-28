<?php
include('../login/verifica_login.php');
$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

$id_cliente_modal = $_GET['id'];

$sql_busca_cliente_banco_sia = $pdo->query("select * from CLIENTES where ID_CLIENTE = {$id_cliente_modal}");
$resultado = $sql_busca_cliente_banco_sia->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $row=> $registros){

}
$sql_busca_debito = $pdo->query("SELECT coalesce(sum(c.VALOR),0) as valor_total from CRECEBER c where c.ID_CLIENTE = {$id_cliente_modal}");
$resultado = $sql_busca_debito->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $linha=> $result){

}
$sql = "UPDATE  TMPPEDIDOS 
set ID_CLIENTE = {$registros['ID_CLIENTE']}, 
NOME_CLIENTE = '{$registros['FANTASIA']}',
LIMITE  = '{$registros['LIMITE_CREDITO_ATUAL']}',
DEBITOS = '{$result['valor_total']}',
PORCENTAGEM_DESCONTO = '{$registros['DESCONTO_PALM']}',
PORCENTAGEM_ACRESCIMO = '{$registros['ACRESCIMO']}'
where 
ID_PEDIDO = {$_SESSION['id_ultimo_pedido']} 
and VENDEDOR = '{$_SESSION['usuario']}'";
$db_prod->exec($sql);
header('Location: ../venda.php');
?>