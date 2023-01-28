<?php
include('../login/verifica_login.php');
$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$pegaCidades = $_POST['id'];
$busca = $pdo->query("SELECT * FROM PLANOXFORMA P JOIN PLANOSPGTO F ON P.ID_PLANOPGTO = F.ID_PLANOPGTO WHERE P.ID_FORMAPGTO = {$pegaCidades}");
$resultado = $busca->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $rows=> $linhas){
    echo '<option value="'.$linhas['ID_PLANOPGTO'].'">'.$linhas['DESCRICAO'].'</option>';
} 

?>