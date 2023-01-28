<?php
include('../login/verifica_login.php');
// *********************conexão com o banco de dados************************
$db_prodd = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
// *****************recebendo os dados vindos atraves de um formulario Post*********************
$id_produto = $_POST['id_produto'];
$_SESSION['id_ultimo_pedido'];
if(isset($id_produto)){

    $sql_consulta_id = $db_prodd->query("SELECT coalesce(count(*),0) as resultado FROM TMPITENS_PEDIDO where ID_PEDIDO = {$_SESSION['id_ultimo_pedido']}");
    $resultado_consulta = $sql_consulta_id->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado_consulta as $row=> $registro){

    }

    if($registro['resultado'] == 0){
        //"não existe resultados para essa exclusão";
        header('Location: ../venda.php');
    }else{
        $sql_exclusao = "DELETE FROM TMPITENS_PEDIDO WHERE ID = '{$id_produto}' AND VENDEDOR = '{$_SESSION['usuario']}'";

        if($db_prodd->exec($sql_exclusao) == true){
            $_SESSION['exclui'] = true;
            header('Location: ../venda.php');
          }else{
            //"erro não catalogado!";
            header('Location: ../venda.php');
          }

    }
}else{

    header('Location: ../venda.php');
}
?>