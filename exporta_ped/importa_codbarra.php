<?php
include('../login/verifica_login.php');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
ini_set('max_execution_time',0);

$limpa_base = "DELETE FROM CODIGOS";
$db_prod->exec($limpa_base);


$diretorio = "../DB/" .$_SESSION['cnpj']."/DB-SISTEMA/codigo.csv";
// $row = 0;


if(file_exists($diretorio)){

    $handle = fopen("../DB/" .$_SESSION['cnpj']."/DB-SISTEMA/codigo.csv", "r");
    while ($line = fgetcsv($handle, 1000, ";")) {
        //     if ($row++ == 0) {
        // 	continue;
        // }
            $sql = "INSERT INTO CODIGOS (CODITEM, CODBARRA) VALUES ('{$line[1]}','{$line[0]}')".";";
            $db_prod->exec($sql);
            // $line[0] . " ";
            // $line[1] . "<br>";
    }
    $_SESSION['importacao-concluida'] = true;
    header('location: exporta_pedido.php');
    exit();
}else{
    $_SESSION['erro_exportados'] = true;
    header('location: exporta_pedido.php');
    exit();
}




?>