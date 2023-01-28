<?php
include('../login/verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Exportar pedidos</title>
    <script src="../api/sweetalert2.js"></script>
</head>
<body>

    <div class="container">
        <br>
        <h1>Exportar pedidos</h1>
        <hr>
            <a class="btn btn-primary" href="../menu.php" role="button">voltar</a>
            <br>
        <br>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Importa carga</h5>
            <p class="card-text">Importa carga gerada pelo sistema.</p>
            <a href="../importabancosia.php" class="btn btn-primary">Importa Carga</a>
        </div>
    </div>
    <br>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Exportar Carga</h5>
            <p class="card-text">Gera arquivo de exportação para Sia.</p>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Exportar Carga</a>
        </div>
    </div>
    <br>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">IMPORTA CODBARRA</h5>
            <p class="card-text">Recebe a carga de dados vinda do sia</p>
            <a href="#" class="btn btn-primary" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">importar carga</a>
        </div>
    </div>
    </div>


<!-- Parte responsavel pelo modal de geração de carga de codigos de barra -->


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Carga de codigos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Atenção! O processo de carga pode levar até 4 minutos, dependendo da quantidade de codigos da tabela,se caso demorar, ele não esta travado, esta apenas atualizando a base, não recarregue a pagina.</p>
      <p>Carregando....</p>
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="./importa_codbarra.php" class="btn btn-primary">Importar Carga</a>
      </div>
    </div>
  </div>
</div>



<!-- modal para inserção de dados para reexportação de pedidos -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Exportação completa de dados</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="container">
        <h3>Insira os dados para exportação!</h3><br>
        <form action="./exporta.php" method="post">
        <label>Inicio</label>
        <input name="inicio" type="date">
        <label>Fim</label>
        <input name="fim" type="date"><br>
        <br>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <input type="submit" class="btn btn-primary">
      </form>
      </div>
    </div>
  </div>
</div>




<!-- tmodal Não existe uma arquivo para importar, gere um arquivo antes! -->

<?php
if(isset($_SESSION['erro-ao-sustituir-base'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Erro ao importar arquivo, não existe um arquivo de carga no diretório!',
})
</script>
 <?php
endif;
unset($_SESSION['erro-ao-sustituir-base']);
?>



<!-- MODAL importação efetuada com sucesso -->

<?php
if(isset($_SESSION['importacao-concluida'])):
?>

<script>
Swal.fire({
  icon: 'info',
  title: 'Arquivo importado com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['importacao-concluida']);
?>









<!-- tmodal Não existe pedidos para exportar-->

<?php
if(isset($_SESSION['erro_exportados'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Não existe pedidos para exportar na base!',
})
</script>
 <?php
endif;
unset($_SESSION['erro_exportados']);
?>


<!-- MODAL exportacao efetuada com sucesso -->

<?php
if(isset($_SESSION['pedidos_exportados'])):
?>

<script>
Swal.fire({
  icon: 'info',
  title: 'Arquivo exportado com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['pedidos_exportados']);
?>


<!-- informe data-->

<?php
if(isset($_SESSION['informe-data'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Data inicial ou final não informados!',
})
</script>
 <?php
endif;
unset($_SESSION['informe-data']);
?>


<!-- periodo invalido-->

<?php
if(isset($_SESSION['periodo-invalido'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Periodo Invalido!',
})
</script>
 <?php
endif;
unset($_SESSION['periodo-invalido']);
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>