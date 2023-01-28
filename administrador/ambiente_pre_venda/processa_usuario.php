<?php
include('../../login/verifica_login.php');
include('../../DB/conexao.php');

date_default_timezone_set("America/Sao_Paulo");
$data = date("Y-m-d") ." ". date("H:i");
$data2 = date("Y-m-d");
$cnpj_cli = $_POST['cnpj_empresa'];
$email_cli = $_POST['email'];
$senha_cli = $_POST['senha'];
$id_vendedor_sia = $_POST['id_vendedor_sia'];
$nome_vendedor_sia = $_POST['nome_vendedor_sia'];
$id_ultimo_pedido = $_POST['id_ultimo_pedido'];

if($cnpj_cli == 'SELECIONAR EMPRESA'){
    $_SESSION['selecione_empresa'] = true;
    header('Location: ./pre_venda.php');
    exit();
}

$zip = new ZipArchive();

$fileName = 'itens_venda.zip';
$fileName1 = 'pedidos.zip';

$path = __DIR__;

// caminho completo dos banco de dados compactados

$fullPath = substr($path,0, -19) .DIRECTORY_SEPARATOR . "baseNovaEmpresa".DIRECTORY_SEPARATOR. $fileName;


$fullPath1 = substr($path,0, -19) .DIRECTORY_SEPARATOR . "baseNovaEmpresa".DIRECTORY_SEPARATOR. $fileName1;


// caminho raiz do projeto
$raiz = substr($path, 0, -32);


$diretorio_completo = $raiz ."DB".DIRECTORY_SEPARATOR.$cnpj_cli . DIRECTORY_SEPARATOR . "DB-SISTEMA".DIRECTORY_SEPARATOR;

// diretorio da base tmp pedidos

$diretorio_tmppedido = $raiz ."DB".DIRECTORY_SEPARATOR.$cnpj_cli . DIRECTORY_SEPARATOR . "BASE-TMPPEDIDOS".DIRECTORY_SEPARATOR;



// verificando se aquele vendedor que esta tentando cadastrar, ja existe uma base criada para ele

if(file_exists($diretorio_completo . $id_vendedor_sia)){
    //"vendedor ja existe na base de dados!";
    $_SESSION['errorr'] = true;
    header('Location: ./pre_venda.php');
    exit();
}else{//caso não exista o diretorio ele vai criar
    if($zip->open($fullPath)){
    $zip->extractTo($diretorio_completo);
    $zip->close();
    rename($diretorio_completo . "itens_venda", $diretorio_completo . $id_vendedor_sia);
}
}

if(file_exists($diretorio_tmppedido . $id_vendedor_sia)){
    //"vendedor ja existe na base de dados!";
    $_SESSION['errorr'] = true;
    header('Location: ./pre_venda.php');
    exit();
}else{//caso não exista o diretorio ele vai criar
    if($zip->open($fullPath1)){
    $zip->extractTo($diretorio_tmppedido);
    $zip->close();
    rename($diretorio_tmppedido . "pedidos", $diretorio_tmppedido . $id_vendedor_sia);

}
}

// inserindo dados de login para acessar na pedido de venda

$inserindo_login = "INSERT INTO `config` (`email`, `senha`, `usuario`, `id_vendedor_sia`, `cnpj`, `chave-acesso`, `razao`, `id_empresa`, `privilegio`) VALUES ('{$email_cli}', '{$senha_cli}', '{$nome_vendedor_sia}', '{$id_vendedor_sia}', '{$cnpj_cli}', '0000000000', '', 1, 'PRODUCAO')";
$conn->exec($inserindo_login);


// recupera dadas da empresa
$pdo = new PDO('sqlite:../../DB/'.$cnpj_cli.'/DB-SISTEMA/'.$id_vendedor_sia.'');

$recupera_dados_emrpesa = $conn->query("SELECT * FROM registro_criacao c WHERE c.cnpj = {$cnpj_cli} ");
$resultado = $recupera_dados_emrpesa->fetchAll(PDO::FETCH_ASSOC);

foreach($resultado as $key=> $linhas){
    $linhas['fantasia'];
    $linhas['cnpj'];
    $linhas['dados_adicionais'];
    $linhas['id_tipo_pedido'];
    $linhas['id_cliente_padrao'];
    $linhas['descricao_tipo_pedido'];
    $linhas['descricao_cliente'];
    $linhas['telefone'];
    $linhas['endereco'];
}
// verifica se o id ultimo pedido esta vazio, caso contrario, se estiver, ele coloca o valor de 1 


if(empty($id_ultimo_pedido)){
    $id_pedido = 1;
}else{
    $id_pedido = $id_ultimo_pedido;
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
'{$linhas['id_cliente_padrao']}', 
'{$linhas['id_tipo_pedido']}', 
'1', 
'1', 
'', 
'{$data}', 
'0.0',
'', 
'0.0', 
'0.0', 
'N', 
'{$linhas['descricao_cliente']}', 
'0', 
'0', 
'0', 
'0', 
'0', 
'N', 
'{$nome_vendedor_sia}', 
'{$id_vendedor_sia}', 
'{$linhas['fantasia']}', 
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
    ('{$linhas['fantasia']}', 
    '{$linhas['telefone']}', 
    '{$linhas['endereco']}', 
    '{$linhas['cnpj']}', 
    '{$linhas['dados_adicionais']}', 
    '{$linhas['id_tipo_pedido']}', 
    '{$linhas['descricao_tipo_pedido']}', 
    '{$linhas['descricao_cliente']}', 
    '{$linhas['id_cliente_padrao']}')";
$pdo->exec($sql);
// inserindo dados da empresa e de ultimo pedido

$_SESSION['usuario_cadastrado'] = true;
header('Location: ./pre_venda.php');
exit();




