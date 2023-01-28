<?php
include('../login/verifica_login.php');
date_default_timezone_set("America/Sao_Paulo");

$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

$recupera_dados_empresa = $db_prod->query("SELECT * from DADOS_EMPRESA");
$resultado_dados_empresa = $recupera_dados_empresa->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_dados_empresa as $row=> $registro){

}
$_SESSION['valor_total_pedido'];
if($_SESSION['valor_total_pedido'] == 00.00){
	$_SESSION['grid_vazia'] = true;
	header('Location: ../venda.php');
	exit();
}
if(empty($_GET['valor_recebido'])){
	$valor_recebido = 0;
}else{
	$valor_recebido = $_GET['valor_recebido'];
	if($valor_recebido < $_SESSION['valor_total_pedido']){
		echo "valor menor que o pedido";
	}
}
$valor_recebido;
// id forma de pagamento recuperada do formulario da pagina de vendas
if(empty($_GET['forma'])){
	$_SESSION['grid_vazia'] = true;
	header('Location: ../venda.php');
	exit();
}
if(empty($_GET['plano'])){
	$_SESSION['grid_vazia'] = true;
	header('Location: ../venda.php');
	exit();
}


$forma_pag = $_GET['forma'];
$plano_pag = $_GET['plano'];


// recupera a descrição da forma de pagamento 
$recupera_descricaoFormaPagamento = $pdo->query("SELECT DESCRICAO from FORMASPGTO where ID_FORMAPGTO = {$forma_pag}");
$resultado_forma = $recupera_descricaoFormaPagamento->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_forma as $linhas=> $formaPgto){

}
$total_troco = $valor_recebido - $_SESSION['valor_total_pedido'];


$data = date("Y-m-d") ." ". date("H:i");
$data_atual = date("Y-m-d");
$sqll = "UPDATE TMPPEDIDOS 
SET TOTAL = {$_SESSION['valor_total_pedido']},  
ID_VENDEDOR = {$_SESSION['ID']}, 
ID_TIPOPEDIDO = {$registro['ID_TIPOPEDIDO']}, 
ID_PLANOPGTO = {$plano_pag},
ID_FORMAPGTO = {$forma_pag},
DATA = '{$data}',
DESCONTO = '0',
VALOR_RECEBIDO = '{$valor_recebido}',
TROCO = '{$total_troco}',
FORMA_PAG = '{$formaPgto['DESCRICAO']}',
DATA_PESQ = '$data_atual'
WHERE ID_PEDIDO = {$_SESSION['id_ultimo_pedido']}". ";" . "INSERT INTO TMPPEDIDOS (ID_VENDEDOR, ID_CLIENTE, ID_TIPOPEDIDO, ID_PLANOPGTO, ID_FORMAPGTO, DATA, DESCONTO, TOTAL, TRANSMITIDO, JATRANSMITIDO,NOME_CLIENTE, VENDEDOR, RAZAO, ID_EMPRESA, FRETE, ACRESCIMO, OUTRO_DESC, ENDERECO, BAIRRO, CIDADE, ESTADO, CEP, TELEFONE, ID_ROTA, NUMERO, COMPLEMENTO, ENTREGAR, NOVOENDERECO, ID_CIDADE, DESPESAS_BOLETO,ID_OPERACAO) VALUES ('{$_SESSION['ID']}', '{$registro['ID_CLIENTE_PADRAO']}', '{$registro['ID_TIPOPEDIDO']}', '1', '1', '0000-00-00 00:00', '0.0', '0.0', 'N', 'N','{$registro['CLIENTE_PADRAO']}','{$_SESSION['usuario']}', '{$_SESSION['fanta']}', '1', '0.0', '0.0', '0.0', '', '', '', '', '', '', '0', '', '', 'N', 'N', '0', '0', '1')" . ";";
if($db_prod->exec($sqll) == true){
	$_SESSION['venda_finalizada_com_sucesso'] = true;
	header('Location: ../exporta_pedido/exporta.php');
	exit();
}
// $db_prodd->exec($sqll) == true
//header('Location: ../venda.php');
//header('Location: ../gera_cupom/cupom.php');

?>