<?php
include('./verifica_login.php');

if($_SESSION['privilegio'] =='ADMINISTRACAO'){
    header('Location: ../administrador/index.php');
}else{
    header('Location: ../menu.php');
}
?>