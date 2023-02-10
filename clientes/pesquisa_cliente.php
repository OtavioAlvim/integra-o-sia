<?php
include('../login/verifica_login.php');
$texto =$_GET['descricao'];

$db = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');

//Consulta sql
$query = $db->query("SELECT * FROM CLIENTES where FANTASIA like '%{$texto}%' limit 20");
//execução da consulta sql
$result_query = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/clientes.css">
    <link rel="stylesheet" href="../css/entrega.css">
  </head>
    <title>Resultado da Busca:</title>
</head>
<body>

    <div class="title">
        <h1>Resultado da Busca:</h1>
        <a class="btn btn-primary" href="../menu.php" role="button">Voltar</a>
        <hr>
    </div>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">RAZAO</th>
      <th scope="col">FANTASIA</th>
      <th scope="col">ESTADO</th>
      <th scope="col">CNPJ</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach($result_query as $row=> $info_prod){
          $id_prod = $info_prod['ID_CLIENTE'];
        ?>
        <tr>
            <th scope="row"><?php echo $info_prod['ID_CLIENTE']?></th>
            <td><?php echo $info_prod['RAZAO']?></td>
            <td><?php echo $info_prod['FANTASIA']?></td>
            <td><?php echo $info_prod['ESTADO']?></td>
            <td><?php echo $info_prod['CNPJ']?></td>
        </tr>
    <?php } ?>

  </tbody>
</table>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</body>
</html>