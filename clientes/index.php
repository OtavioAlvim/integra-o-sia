<?php
include('../login/verifica_login.php');

$db = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$query = $db->query("SELECT * FROM CLIENTES limit 20");
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
  </head>
    <title>Consulta de Participantes</title>
</head>
<body>

    <div class="title">
        <h1>Consulta de Participantes</h1>
        <a class="btn btn-primary" href="../menu.php" role="button">Voltar</a>
        <hr>
        <form class="d-flex" role="search" action="pesquisa_cliente.php" method="get">
            <input class="form-control me-2" name="descricao" type="search" placeholder="Pesquiar fantasia" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Pesquisar</button>
        </form>
    </div>
    <hr>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">RAZAO</th>
      <th scope="col">FANTASIA</th>
      <th scope="col">ESTADO</th>
      <th scope="col">CNPJ</th>
      <th scope="col">EDITAR</th>
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
            <td>
                <a href="detalhes_clientes.php?id=<?php echo $id_prod?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg></a></i></td>
        </tr>
    <?php } ?>

  </tbody>
</table>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</body>
</html>