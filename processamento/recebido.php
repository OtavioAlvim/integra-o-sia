<?php
include('../login/verifica_login.php');
if(empty($_POST['troco'])){
    $troco = 0;
}else{
    $troco = $_POST['troco'];
}

$valor = $_SESSION['valor_total_pedido'];
$res = $troco - $valor ;
if($res < 0){
    echo "<input type='text' value='Valor menor que total' disabled>";
}else{
    echo "<input type='number' value=".$res." disabled>";
}


?>