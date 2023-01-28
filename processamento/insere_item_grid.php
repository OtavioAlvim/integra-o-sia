<?php
include('../login/verifica_login.php');
$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

//$_SESSION['id_ultimo_pedido'];

// VALIDAD SE NA TELA INICIAL JA EXISTE UM CLIENTE DIFERENTE DE "CLIENTE INDEFINIDO"

$verifica_cli = $db_prod->query("SELECT coalesce(i.DESCRICAO, 0) as resultado,p.NOME_CLIENTE,p.ID_PEDIDO  from TMPPEDIDOS p left join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.VENDEDOR = '{$_SESSION['usuario']}' order by p.ID_PEDIDO DESC limit 1");
$resultado_verifica = $verifica_cli->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_verifica as $chave=> $registro){

}
if ($registro['NOME_CLIENTE'] == 'CLIENTE INDEFINIDO'){
    $_SESSION['INSIRA_CLIENTE'] = true;
	header('Location: ../venda.php');
	exit();
}
// ID PRODUTO RECEBIDO DO MODAL DA TELA DE VENDAS

$id_produto_modal = $_GET['id'];

//BUSCA PERCENTUAL DO PERFIL DO CLIENTE CASO TENHA SIDO CONFIGURADO NO SIA

$busca_valor_perfil= $db_prod->query("SELECT t.PORCENTAGEM_ACRESCIMO,t.PORCENTAGEM_DESCONTO from TMPPEDIDOS t where t.ID_PEDIDO = {$_SESSION['id_ultimo_pedido']}");
$resultado_perfil = $busca_valor_perfil->fetchAll(PDO::FETCH_ASSOC);
// print_r($resultado_perfil);

foreach($resultado_perfil as $id=> $percentual){

}
// VERIFICA SE TEM ACRESCIMO OU DESCONTO NO CADASTRO DO CLIENTE

if($percentual['PORCENTAGEM_ACRESCIMO'] <> 0){
    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto_modal}");
    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $row=> $registros){
        //$registros['ID_PRODUTO']."<br>";
        //$registros['DESCRICAO']."<br>";
        // $registros['UNITARIO']."<br>";
        //$registros['UNIDADE']."<br>";
        //$_SESSION['usuario']."<br>";
        //$_SESSION['ID_EMPRESA']."<br>";
        //$_SESSION['ID']."<br>";
    }
    $valor_com_acrescimo = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_ACRESCIMO'] / 100;
    $valor_total_com_acrescimo = $registros['UNITARIO'] + $valor_com_acrescimo;
    $valor_total_com_acrescimo;
    $sql = "INSERT INTO TMPITENS_PEDIDO (ID_PEDIDO, ID_EMPRESA, ID_PRODUTO, QTD, UNITARIO, DESCONTO, TOTAL, DADOADICIONAL, DESCRICAO, PRECOINICIAL, ID_TONALIDADE, UNITARIOBASE, EMPROMOCAO, DESPESAS_BOLETO, CANCELADO, TRANSMITIDO, VENDEDOR) VALUES ('{$_SESSION['id_ultimo_pedido']}', '{$_SESSION['ID_EMPRESA']}', '{$registros['ID_PRODUTO']}', '1.0', '{$valor_total_com_acrescimo}', '0.0', '{$valor_total_com_acrescimo}', '', '{$registros['DESCRICAO']}', '{$valor_total_com_acrescimo}', '0', '{$valor_total_com_acrescimo}', 'N', '0', 'N', 'N', '{$_SESSION['usuario']}');";
    $db_prod->exec($sql);    
    header('Location: ../venda.php');
    exit();
    //"EXISTE UM PERFIL ACRESCIMO PARA ESTE CLIENTE NA TABELA";

}else if($percentual['PORCENTAGEM_DESCONTO'] <> 0){

    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto_modal}");
    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $row=> $registros){
        //$registros['ID_PRODUTO']."<br>";
        //$registros['DESCRICAO']."<br>";
        // $registros['UNITARIO']."<br>";
        //$registros['UNIDADE']."<br>";
        //$_SESSION['usuario']."<br>";
        //$_SESSION['ID_EMPRESA']."<br>";
        //$_SESSION['ID']."<br>";
    }
    $valor_com_desconto = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_DESCONTO'] / 100;
    $valor_total_com_desconto = $registros['UNITARIO'] - $valor_com_desconto;
    $sql = "INSERT INTO TMPITENS_PEDIDO (ID_PEDIDO, ID_EMPRESA, ID_PRODUTO, QTD, UNITARIO, DESCONTO, TOTAL, DADOADICIONAL, DESCRICAO, PRECOINICIAL, ID_TONALIDADE, UNITARIOBASE, EMPROMOCAO, DESPESAS_BOLETO, CANCELADO, TRANSMITIDO, VENDEDOR) VALUES ('{$_SESSION['id_ultimo_pedido']}', '{$_SESSION['ID_EMPRESA']}', '{$registros['ID_PRODUTO']}', '1.0', '{$valor_total_com_desconto}', '0.0', '{$valor_total_com_desconto}', '', '{$registros['DESCRICAO']}', '{$valor_total_com_desconto}', '0', '{$valor_total_com_desconto}', 'N', '0', 'N', 'N', '{$_SESSION['usuario']}');";
    $db_prod->exec($sql);    
    header('Location: ../venda.php');
    exit();
    //"EXISTE UM PERFIL DESCONTO PARA ESTE CLIENTE NA TABELA";

}else{
    //"PODEMOS USAR O VALOR PADRÃO DA TABELA DE CLIENTES DO SIA SEM O PERFIL DE CLIENTES";

// SE CASO ELE NÃO ENCONTRAR NENHUM VALOR NA TABELA REFERENTE A ACRESCIMO OU DESCONTO, ELE VAI USAR O VALOR PADRAO DO PRODUTO PRESENTE NA TABELA PRODUTOS

    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto_modal}");
    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $row=> $registros){
        //$registros['ID_PRODUTO']."<br>";
        //$registros['DESCRICAO']."<br>";
        //$registros['UNITARIO']."<br>";
        //$registros['UNIDADE']."<br>";
        //$_SESSION['usuario']."<br>";
        //$_SESSION['ID_EMPRESA']."<br>";
        //$_SESSION['ID']."<br>";
    }
    $sql = "INSERT INTO TMPITENS_PEDIDO (ID_PEDIDO, ID_EMPRESA, ID_PRODUTO, QTD, UNITARIO, DESCONTO, TOTAL, DADOADICIONAL, DESCRICAO, PRECOINICIAL, ID_TONALIDADE, UNITARIOBASE, EMPROMOCAO, DESPESAS_BOLETO, CANCELADO, TRANSMITIDO, VENDEDOR) VALUES ('{$_SESSION['id_ultimo_pedido']}', '{$_SESSION['ID_EMPRESA']}', '{$registros['ID_PRODUTO']}', '1.0', '{$registros['UNITARIO']}', '0.0', '{$registros['UNITARIO']}', '', '{$registros['DESCRICAO']}', '{$registros['UNITARIO']}', '0', '{$registros['UNITARIO']}', 'N', '0', 'N', 'N', '{$_SESSION['usuario']}');";
    $db_prod->exec($sql);    
    header('Location: ../venda.php');
    exit();
}


?>