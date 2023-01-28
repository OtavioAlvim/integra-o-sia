<?php
include('./login/verifica_login.php');
$zip = new ZipArchive();
$nomeArquivoCompactado = 'siadown.zip';
$diretorio = __DIR__;

$diretorioBancoCompactado = $diretorio  .DIRECTORY_SEPARATOR. "DB". DIRECTORY_SEPARATOR . $_SESSION['cnpj'] . DIRECTORY_SEPARATOR ."DB-IMPORTACAO". DIRECTORY_SEPARATOR .$nomeArquivoCompactado;

$diretorioBancoDescompactado = $diretorio .DIRECTORY_SEPARATOR. "DB". DIRECTORY_SEPARATOR . $_SESSION['cnpj'] . DIRECTORY_SEPARATOR. "DB-SIA" .DIRECTORY_SEPARATOR. "sia";




if(file_exists($diretorioBancoCompactado)){
    unlink($diretorioBancoDescompactado);
    if($zip->open($diretorioBancoCompactado)){
        $zip->extractTo('./DB/'.$_SESSION['cnpj'].'/DB-SIA');
        $zip->close();
        unlink($diretorioBancoCompactado);
        if(file_exists($diretorioBancoDescompactado)){
            $_SESSION['importacao-concluida'] = true;
            header('location: ./exporta_ped/exporta_pedido.php');
            exit();
            
        }
        // "Arquivo extraido com sucesso!";
    }else{
        // "Esse arquivo não existe na pasta";
    };
    // "Encontramos um arquivo!";
}else{
    $_SESSION['erro-ao-sustituir-base'] = true;
    header('location: ./exporta_ped/exporta_pedido.php');
    exit();
    // "ERRO! Não existe um arquivo neste caminho!";
}
?>