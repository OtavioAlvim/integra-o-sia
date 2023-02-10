<?php
include('../login/verifica_login.php');

$db_prodd = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
$inicio = $_POST['inicio'];
$fim = $_POST['fim'];
$forma_pag = $_POST['forma_pag'];


// ********* VARIFICA SE A DATA DE INICIO É MAIOR QUE A DATA DE FIM************

if($inicio > $fim){
  echo "Periodo invalido";
}
// *************QUERY PARA RECUPERAR OS DADOS DO BANCO DE DADOS****************

$reculpera_pedidos = $db_prodd->query("SELECT * from TMPPEDIDOS where DATA_PESQ BETWEEN '{$inicio}' and '{$fim}' and FORMA_PAG like '%{$forma_pag}%'");
// print_r($reculpera_pedidos);
$resultado_recuperacao = $reculpera_pedidos->fetchAll(PDO::FETCH_ASSOC);
// print_r($resultado_recuperacao);

// *************QUERY PARA PEGAR TOTAL POR FORMA DE PAGAMENTO*******************

$busca_total = $db_prodd->query("SELECT ID_FORMAPGTO,FORMA_PAG,sum(total) as total from TMPPEDIDOS where DATA_PESQ BETWEEN '{$inicio}' and '{$fim}' and FORMA_PAG like '%{$forma_pag}%' GROUP by FORMA_PAG");

$resultado_busca = $busca_total->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendas por forma de pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/entrega.css">
  </head>
  <body>
    <div class="container text-center">
        <br>
        <h1>Consultar vendas</h1>
        <hr>    
        <div class="float-start">
            <a class="btn btn-primary" href="./relatorio.php" role="button">voltar</a>
        </div>
        <br>
    </div>
    <div class="container text-center">
<!-- ************VALOR TOTAL POR FORMA DE PAGAMENTO**************** -->
      <br>
    <table class="table table-striped table-hover" style="width: 400px;">
      
      <thead>
        <tr>
          <th scope="col">Descrição</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
  <tbody>
  <?php
    foreach($resultado_busca as $row=> $total){?>
      <tr>
        <th scope="row"><?php echo $total['FORMA_PAG']?></th>
        <td><strong>R$ </strong><?php echo number_format($total['total'],2,',','') ?></td>
        
      </tr>
    <?php }?>
    </tbody>
  </table>
  <h4>Pedidos</h4>
      <hr>
    <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Cliente</th>
      <th scope="col">Forma de Pagamentoo</th>
      <th scope="col">Data</th>
      <th scope="col">Valor</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach($resultado_recuperacao as $row=> $registro){?>
        <tr>
          <th scope="row"><?php echo $registro['ID_PEDIDO'] ."<br>"?></th>
          <td><?php echo $registro['NOME_CLIENTE']?></td>
          <td><?php echo $registro['FORMA_PAG']?></td>
          <td><?php echo $registro['DATA']?></td>
          <td>R$ <?php echo number_format($registro['TOTAL'],2,',','')?></td>
          
        </tr>
      <?php } ?>
  </tbody>
</table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>