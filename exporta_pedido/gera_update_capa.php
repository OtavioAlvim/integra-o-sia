<?php
include('../login/verifica_login.php');

$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/BASE-TMPPEDIDOS/'.$_SESSION['ID'].'');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

//Consulta sql
$query = $db_prod->query("SELECT p.* from TMPPEDIDOS p join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.TRANSMITIDO = 'N'   group by p.ID_PEDIDO");
//execução da consulta sql
$result_query = $query->fetchAll(PDO::FETCH_ASSOC);


// gera update na tabela tmpitens_pedidos setando como enviado igual sim, se o pedido existir no banco de exportação


foreach($result_query as $row=> $id_update_capa){
    $id_update_capa['ID_PEDIDO'];
    // procura se existe esse id no banco de exportação
    $verifica_se_existe_banco = $pdo->query("SELECT count(*) as verifica from TMPPEDIDOS where ID_PEDIDO = {$id_update_capa['ID_PEDIDO']}");
    // executa consulta de verificação
    $executa_verifica_se_existe_banco = $verifica_se_existe_banco->fetchAll(PDO::FETCH_ASSOC);
    foreach($executa_verifica_se_existe_banco as $row=> $verifica){
      $verifica['verifica'];
    }
    if($verifica['verifica'] == 1){
        $gera_update = ("UPDATE TMPPEDIDOS set TRANSMITIDO = 'S' where ID_PEDIDO ={$id_update_capa['ID_PEDIDO']} ");
        if($db_prod->exec($gera_update) == true){
          header('Location: compactaBase.php');
        }

    }else{
      echo "ainda não existe no banco!";
    }
}
?>