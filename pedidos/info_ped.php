<?php
include('../login/verifica_login.php');

$num_ped = $_GET["id_ped"];
$db_prodd = new PDO('sqlite:../DB/' . $_SESSION['cnpj'] . '/DB-SISTEMA/' . $_SESSION['ID'] . '');
$consulta_capa = $db_prodd->query("SELECT * FROM TMPPEDIDOS T WHERE T.ID_PEDIDO = {$num_ped}");
$pesquisar = $consulta_capa->fetchAll(PDO::FETCH_ASSOC);

$consulta_item = $db_prodd->query("SELECT * FROM TMPITENS_PEDIDO T WHERE T.ID_PEDIDO = {$num_ped}");
$result_item = $consulta_item->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/info_pedidos.css">
  <title>Informações Pedidos</title>
</head>

<body>
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="../menu.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
          <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
        </svg></a>
    </div>
  </nav>
  <br>

  <br><br><br>

  <h1>Informações Gerais</h1>
  <hr>
  <div class="container">
    <div id="info_pedido">

      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Dados Pedido</button>
          <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Itens</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID Pedido</th>
                <th scope="col">Cliente</th>
                <th scope="col">Vendedor</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($pesquisar as $row => $teste) {
              ?>
                <tr>
                  <th scope="row"><?php echo $teste['ID_PEDIDO']; ?></th>
                  <td><?php echo $teste['NOME_CLIENTE']; ?></td>
                  <td><?php echo $teste['VENDEDOR']; ?></td>
                  <td><?php echo number_format($teste['TOTAL'], 2, ',', '') ?></td>
                </tr>
              <?php } ?>

          </table>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
          <div id="desc_item">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">ID Produto</th>
                  <th scope="col">Descrição</th>
                  <th scope="col">UNI</th>
                  <th scope="col">QTD</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $n = 0;
                foreach ($result_item as $row => $item) {
                  $n++;
                ?>
                  <tr>
                    <th scope="row"><?php echo $n; ?></th>
                    <td><?php echo $item['ID_PRODUTO']; ?></td>
                    <td><?php echo $item['DESCRICAO']; ?></td>
                    <td>R$ <?php echo $item['UNITARIO']; ?></td>
                    <td><?php echo $item['QTD']; ?></td>
                    <td>R$ <?php echo $item['TOTAL']; ?></td>
                  </tr>
                <?php  } ?>

            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</html>