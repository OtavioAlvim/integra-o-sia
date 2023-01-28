<?php
include('../login/verifica_login.php');
$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/BASE-TMPPEDIDOS/'.$_SESSION['ID'].''); 
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
date_default_timezone_set("America/Sao_Paulo");
$zip = new ZipArchive();

//nome do arquivo que sera gerado
// $nome_arquivo = 'orderpack1.';
$Minha_data_hora = getdate(date("U"));
$minha_hora = "$Minha_data_hora[mday]"."$Minha_data_hora[mon]"."$Minha_data_hora[year]"."$Minha_data_hora[hours]"."$Minha_data_hora[minutes]"."$Minha_data_hora[seconds]";

$nome_arquivo = "orderpack".$_SESSION['ID']."." . $minha_hora . ".zip";


$Spath = __DIR__;

$caminho = substr($Spath, 0, -14);

$diretorio_completo = $caminho . DIRECTORY_SEPARATOR . "DB" .DIRECTORY_SEPARATOR. $_SESSION['cnpj'] .DIRECTORY_SEPARATOR. "DB-EXPORTACAO" .DIRECTORY_SEPARATOR. $nome_arquivo;

if($zip->open($diretorio_completo, ZipArchive::CREATE)){
    $zip->addFile(
        $caminho . '/DB/' .$_SESSION['cnpj']. '/BASE-TMPPEDIDOS/'.$_SESSION['ID'].'', 'tmppedidos'
    );
    $zip->close();
}
if(file_exists($diretorio_completo)){
    $_SESSION['pedidos_exportados'] = true;
    header('Location: ../gera_cupom/cupom.php');
    exit;
}else{
    echo "Arquivo não foi criado";
}


?>