<?php
include('../../login/verifica_login.php');
$_SESSION['fantasia'] = $_POST['fantasia'];
$_SESSION['telefone'] = $_POST['telefone'];
$_SESSION['endereco'] = $_POST['endereco'];
$_SESSION['cnpj_cli'] = $_POST['cnpj'];
$_SESSION['dados adicionais'] = $_POST['dadosAdicionais'];
$_SESSION['id_tipopedido'] = $_POST['id_tipopedido'];
$_SESSION['descricao_tipopedido'] = $_POST['descricao_tipopedido'];
$_SESSION['idClienteSia'] = $_POST['idClienteSia']; 
$_SESSION['nomeClientePadrao'] = $_POST['nomeClientePadrao'];

$_SESSION['id_ultimo_pedido'] = $_POST['pedido_vendedor'];
$_SESSION['id_vendedor'] = $_POST['idVendedor'];
$_SESSION['nomeVendedor'] = $_POST['nomeVendedor'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['senha'] = $_POST['senha'];

// verifica se ja não existe essa empresa cadastrada

$zip = new ZipArchive();

$fileName = 'base.zip';
$path = __DIR__;
$fullPath = substr($path,0, -19) .DIRECTORY_SEPARATOR . "baseNovaEmpresa".DIRECTORY_SEPARATOR. $fileName;

$diretorioComPasta = __DIR__ .DIRECTORY_SEPARATOR ."base";
$raiz = substr($path, 0, -32);

// diretorio do bando de dados do sistema
$diretorio_completo = $raiz ."DB".DIRECTORY_SEPARATOR.$_SESSION['cnpj_cli'] . DIRECTORY_SEPARATOR . "DB-SISTEMA".DIRECTORY_SEPARATOR;

// diretorio da base tmp pedidos

$diretorio_tmppedido = $raiz ."DB".DIRECTORY_SEPARATOR.$_SESSION['cnpj_cli'] . DIRECTORY_SEPARATOR . "BASE-TMPPEDIDOS".DIRECTORY_SEPARATOR;


if(file_exists($raiz.'DB'.DIRECTORY_SEPARATOR.$_SESSION['cnpj_cli'])){
    $_SESSION['errorr'] = true;
    header('Location: ./pre_venda.php');
    exit();
}else{//caso não exista o diretorio ele vai criar
    if($zip->open($fullPath)){
    $zip->extractTo($raiz .'/DB/'.$_SESSION['cnpj_cli']);
    $zip->close();
    //verifica se a base do novo cliente foi criado
    if(file_exists($raiz.'DB'.DIRECTORY_SEPARATOR.$_SESSION['cnpj_cli'])){
        // preciso verificar esse campo
        rename($diretorio_completo . "itens_venda", $diretorio_completo . $_SESSION['id_vendedor']);
        rename($diretorio_tmppedido . "pedidos", $diretorio_tmppedido . $_SESSION['id_vendedor']);
        header('location: ./insere_vendedor_na_empresa.php');
        exit();
    }else{
        $_SESSION['errorr'] = true;
        header('Location: ./pre_venda.php');
        exit();
    }
}
}



?>