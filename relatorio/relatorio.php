<?php
include('../login/verifica_login.php');

$db_prodd = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
$recupera_forma_pag = $db_prodd->query("SELECT t.FORMA_PAG,t.ID_FORMAPGTO from TMPPEDIDOS t group by t.FORMA_PAG");
$resultado = $recupera_forma_pag->fetchAll(PDO::FETCH_ASSOC);

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
        <h1>Relatorio de vendas por FormaPgto</h1>
        <hr>    
        <div class="float-start">
            <a class="btn btn-primary" href="../menu.php" role="button">voltar</a>
        </div>
        <br>
    </div>

    <div class="container text-center " style="width: 400px;">
        <br>
        <form action="pesquisa-relatorio.php" method="POST">
          <label for=""><strong>Inicio:</p></strong></label>
          <input type="date" name="inicio" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"><br>
          <label for=""><strong>Fim:</strong></label><br>
          <input type="date" name="fim" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"><br>
          <label for=""><strong>Forma de Pagamento</strong></label>
          <select name="forma_pag" class="form-select" aria-label="Default select example">
            <option selected></option>
            <?php
            foreach($resultado as $row=>$registro){?>
              <option><?php echo $registro['FORMA_PAG']?></option>
          <?php }
            ?>
          </select><br>
          <button type="submit" class="btn btn-primary">Pesquisar</button>
      </form>
    </div>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>