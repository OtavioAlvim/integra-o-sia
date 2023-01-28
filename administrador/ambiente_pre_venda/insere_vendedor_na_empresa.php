<?php
include('../../login/verifica_login.php');
include('../../DB/conexao.php');
$pdo = new PDO('sqlite:../../DB/'.$_SESSION['cnpj_cli'].'/DB-SISTEMA/'.$_SESSION['id_vendedor'].'');
date_default_timezone_set("America/Sao_Paulo");
$data = date("Y-m-d") ." ". date("H:i");
$data2 = date("Y-m-d");
// inserindo vendedor na base de dados

$_SESSION['fantasia'];
$_SESSION['telefone'];
$_SESSION['endereco']; 
$_SESSION['cnpj_cli'];
$_SESSION['dados adicionais'];
$_SESSION['id_tipopedido'];
$_SESSION['descricao_tipopedido'];
$_SESSION['idClienteSia']; 
$_SESSION['nomeClientePadrao'];
$_SESSION['id_ultimo_pedido'];
$_SESSION['id_vendedor'];
$_SESSION['nomeVendedor'];
$_SESSION['email'];
$_SESSION['senha'];


if(empty($_SESSION['id_ultimo_pedido'])){
    $id_pedido = 1;
}else{
    $id_pedido = $_SESSION['id_ultimo_pedido'];
}

$insere_vendedor = "INSERT INTO TMPPEDIDOS 
(
ID_PEDIDO, 
ID_CLIENTE, 
ID_TIPOPEDIDO, 
ID_PLANOPGTO, 
ID_FORMAPGTO, 
FORMA_PAG, 
DATA, 
DESCONTO, 
VALOR_RECEBIDO, 
TROCO, 
TOTAL, 
TRANSMITIDO, 
NOME_CLIENTE, 
ACRESCIMO, 
LIMITE, 
DEBITOS, 
PORCENTAGEM_DESCONTO, 
PORCENTAGEM_ACRESCIMO, 
CANCELADO, 
VENDEDOR, 
ID_VENDEDOR, 
RAZAO, 
ID_EMPRESA, 
JATRANSMITIDO, 
FRETE, 
OUTRO_DESC, 
ENDERECO, 
BAIRRO, 
ESTADO, 
CIDADE, 
CEP, 
TELEFONE, 
ID_ROTA, 
NUMERO, 
COMPLEMENTO, 
ENTREGAR, 
NOVOENDERECO, 
ID_CIDADE, 
DESPESAS_BOLETO, 
ID_OPERACAO, 
DATA_PESQ
) VALUES (
'{$id_pedido}', 
'{$_SESSION['idClienteSia']}', 
'{$_SESSION['id_tipopedido']}', 
'1', 
'1', 
'', 
'{$data}', 
'0.0',
'', 
'0.0', 
'0.0', 
'N', 
'{$_SESSION['nomeClientePadrao']}', 
'0', 
'0', 
'0', 
'0', 
'0', 
'N', 
'{$_SESSION['nomeVendedor']}', 
'{$_SESSION['id_vendedor']}', 
'{$_SESSION['fantasia']}', 
'1', 
'N', 
'0.0', 
'0', 
'', 
'', 
'', 
'', 
'', 
'', 
'0', 
'', 
'', 
'N', 
'N', 
'0', 
'0', 
'1', 
'{$data2}')";
$pdo->exec($insere_vendedor);
// INSERE DADOS EMPRESA 
$sql = "INSERT INTO DADOS_EMPRESA (
    FANTASIA, 
    TELEFONE, 
    ENDERECO_ABREVIADO, 
    CNPJ, 
    DADOS_ADICIONAIS, 
    ID_TIPOPEDIDO, 
    DESCRICAO_TIPO_PEDIDO, 
    CLIENTE_PADRAO, 
    ID_CLIENTE_PADRAO) VALUES 
    ('{$_SESSION['fantasia']}', 
    '{$_SESSION['telefone']}', 
    '{$_SESSION['endereco']}', 
    '{$_SESSION['cnpj_cli']}', 
    '{$_SESSION['dados adicionais']}', 
    '{$_SESSION['id_tipopedido']}', 
    '{$_SESSION['descricao_tipopedido']}', 
    '{$_SESSION['nomeClientePadrao']}', 
    '{$_SESSION['idClienteSia']}')";
    if($pdo->exec($sql) == true){
        $insere_registro_criacao = "INSERT INTO registro_criacao (fantasia, cnpj, dados_adicionais, id_tipo_pedido, id_cliente_padrao, descricao_tipo_pedido, descricao_cliente, telefone, endereco) VALUES ('{$_SESSION['fantasia']}', '{$_SESSION['cnpj_cli']}', '{$_SESSION['dados adicionais']}', '{$_SESSION['id_tipopedido']}', '{$_SESSION['idClienteSia']}', '{$_SESSION['descricao_tipopedido']}', '{$_SESSION['nomeClientePadrao']}', '{$_SESSION['telefone']}', '{$_SESSION['endereco']}');";
        

        if($conn->exec($insere_registro_criacao)== true){
        $inserindo_login = "INSERT INTO `config` (`email`, `senha`, `usuario`, `id_vendedor_sia`, `cnpj`, `chave-acesso`, `razao`, `id_empresa`, `privilegio`) VALUES ('{$_SESSION['email']}', '{$_SESSION['senha']}', '{$_SESSION['nomeVendedor']}', '{$_SESSION['id_vendedor']}', '{$_SESSION['cnpj_cli']}', '0000000000', '', 1, 'PRODUCAO')";
            if($conn->exec($inserindo_login) == true){
                $_SESSION['usuario_cadastrado'] = true;
                header('Location: ./pre_venda.php');
                exit();
            }
        }
    
    }
?>
