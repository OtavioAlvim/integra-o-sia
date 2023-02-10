<?php
include('../login/verifica_login.php');

$db = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');

//Consulta sql
$query = $db->query("SELECT * FROM PRODUTOS limit 20");
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
    <link rel="stylesheet" href="../css/produtos.css">
  </head>
    <title>Consulta de Produtos</title>
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="../menu.php">Voltar</a>
    </div>

  </nav>
  <br>

  <br><br><br>

    <div class="title">
        <h1>Consulta de Produtos</h1>
        <!-- <a class="btn btn-primary" href="../menu.php" role="button">Voltar</a> -->
        <hr>
        <form class="d-flex" role="search" action="pesquisa_produto.php" method="get">
            <input class="form-control me-2" name="descricao" type="search" placeholder="Pesquiar Descrição" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Pesquisar</button>
        </form>
    </div>
    
    <hr>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">DESCRIÇÃO</th>
      <th scope="col">UNIDADE</th>
      <th scope="col">QUANTIDADE</th>
      <th scope="col">CUSTO</th>
      <th scope="col">VENDA</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach($result_query as $row=> $info_prod){
          $id_prod = $info_prod['ID_PRODUTO'];
        ?>
        <tr>
            <th scope="row"><?php echo $info_prod['ID_PRODUTO']?></th>
            <td><?php echo $info_prod['DESCRICAO']?></td>
            <td><?php echo $info_prod['UNIDADE']?></td>
            <td><?php echo $info_prod['QTD']?></td>
            <td><?php echo $info_prod['PRECOCUSTO']?></td>
            <td><?php echo $info_prod['PRECO']?></td>
        </tr>
    <?php } ?>

  </tbody>
</table>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</body>
</html>