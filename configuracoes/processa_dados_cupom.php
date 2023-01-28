<?php
include('../login/verifica_login.php');
$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');



$fantasia = $_POST['fantasia'];
"<br>";
$telefone = $_POST['telefone'];
"<br>";
$endereco = $_POST['endereco'];
"<br>";
$cnpj = $_POST['cnpj'];
"<br>";
$dados = $_POST['dados'];
"<br>";
$tipopedido = $_POST['tipopedido'];
"<br>";
$cliente = $_POST['cliente_padrao'];
"<br>";



$recupra_nome_tipopedido = $pdo->query("SELECT * from TIPOSPEDIDO t where t.ID_TIPOPEDIDO = {$tipopedido}");
$resultado_tipopedido = $recupra_nome_tipopedido->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_tipopedido as $row=> $registro){

}

$recupera_nome_cliente = $pdo->query("SELECT * from CLIENTES c where c.ID_CLIENTE = {$cliente}");
$resultado_nome = $recupera_nome_cliente->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_nome as $rows=>$nome){

}


$update_tabel_emrepesa = "UPDATE 
DADOS_EMPRESA  
SET 
FANTASIA = '{$fantasia}' , 
TELEFONE = '{$telefone}' , 
ENDERECO_ABREVIADO = '{$endereco}',
CNPJ = '{$cnpj}', 
DADOS_ADICIONAIS = '{$dados}', 
ID_TIPOPEDIDO = '{$registro['ID_TIPOPEDIDO']}', 
DESCRICAO_TIPO_PEDIDO = '{$registro['DESCRICAO']}', 
CLIENTE_PADRAO = '{$nome['RAZAO']}', 
ID_CLIENTE_PADRAO = '{$nome['ID_CLIENTE']}' ";

if($db_prod->exec($update_tabel_emrepesa) == true){
    $_SESSION['sucesso'] = true;
    header('location: ./configuracao.php');
	exit();
}






?>