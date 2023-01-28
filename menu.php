<?php
include('./login/verifica_login.php');
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu</title>
    <link rel="shortcut icon" href="imgens/Nova pasta/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="./api/sweetalert2.js"></script>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-basket2" viewBox="0 0 16 16">
            <path d="M4 10a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm3 0a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm3 0a1 1 0 1 1 2 0v2a1 1 0 0 1-2 0v-2z"/>
            <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.623l-1.844 6.456a.75.75 0 0 1-.722.544H3.69a.75.75 0 0 1-.722-.544L1.123 8H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.163 8l1.714 6h8.246l1.714-6H2.163z"/>
          </svg></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Pedido
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                  <li><a class="dropdown-item" href="./processamento/valida_cliente.php">Novo Pedido</a></li>
                  <!-- <li><a class="dropdown-item" href="#">Pedidos Mobile</a></li> -->
                  <li><a class="dropdown-item" href="pedidos/pedidos.php">Consultar Pedido</a></li>
                  <li><a class="dropdown-item" href="exporta_ped/exporta_pedido.php">Carga</a></li>
                </ul>
              </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Produto
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="produtos/index.php">Consultar produtos</a></li>
                    <!-- <li><a class="dropdown-item" href="produtos/consulta_produto.php">Consulta Rápida</a></li> -->
                  </ul>
                </li>
              </ul>
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Clientes
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="clientes/index.php">Consultar cliente</a></li>
                    <!-- <li><a class="dropdown-item" href="clientes/limite_cliente.php">Consultar limite</a></li> -->
                  </ul>
                </li>
              </ul>
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Relatorios
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="./relatorio/relatorio.php">Resumo de Pedidos</a></li>
                  </ul>
                </li>
              </ul>
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Configurações
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="configuracoes/configuracao.php">Configuraçoes gerais</a></li>
                    <li><a class="dropdown-item" href="./login/logout.php">Sair</a></li>
                  </ul>
                </li>
              </ul>
          </div>
        </div>
      </nav>
<!-- Modal abertura -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Abertura</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="./operacoes/abertura_caixa.php" method="POST">
          <h1>Valor de Abertura</h1>
          <input name="valor_abertura" type="text">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Inserir</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Fechamento-->
<div class="modal fade" id="exampleModall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Fechamento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <h3>Deseja realmente fazer o fechamento de caixa?</h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="./operacoes/fechamento_caixa.php"><button type="button" class="btn btn-primary">Continuar</button></a>
        </div>
    </div>
  </div>
</div>

<!-- Modal suprimento -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Suprimento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3>Insira o valor do suprimento:</h3>
        <form action="./operacoes/suprimento.php" method="POST">
        <input name="suprimento" type="text" >
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Inserir</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Sangria-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Sangria</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3>Insira o valor da sangria:</h3>
        <form action="./operacoes/sangria.php" method="POST">
        <input name="sangria" type="text">
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Inserir</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- ********PARTE DESTINADO OS ALERTAS VINDOS DE ALGUM RETORNO DA PAGINA************ -->

<!-- MODAL PARA MOSTRAR BOAS VINDAS AO USUARIO -->
<?php
if(isset($_SESSION['login_aprovado'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'SEJA BEM VINDO <?php echo($_SESSION['usuario']); ?>!',
  showConfirmButton: false,
  timer: 2500
})
</script>
 <?php
endif;
unset($_SESSION['login_aprovado']);
?>





<!-- destinado caso o modal não seja preenchido e tente enviar para validação -->
<?php
if(isset($_SESSION['sem_valor'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'O valor do campo, encontra-se vazio!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['sem_valor']);
?>

<!-- modal que mostra que o caixa ja esta aberto naquele dia -->

<?php
if(isset($_SESSION['caixa_ja_aberto'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'O caixa ja se encontra aberto!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['caixa_ja_aberto']);
?>
<!-- MODAL PARA MOSRAR CAIXA ABERTO COM SUCESSO -->

<?php
if(isset($_SESSION['caixa_aberto'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Caixa aberto com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['caixa_aberto']);
?>


<!-- modal que mostra que o caixa ai não foi aberto  -->

<?php
if(isset($_SESSION['caixa_não_aberto'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Não existe abertura de caixa neste dia, Necessario fazer a abertura!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['caixa_não_aberto']);
?>


<!-- modal que mostra que o caixa ja foi fechado e é necessario reabrir  -->

<?php
if(isset($_SESSION['caixa_ja_foi_fechado'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'O caixa ja foi fechado! Necessario reabrir',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['caixa_ja_foi_fechado']);
?>


<!-- MODAL PARA mostrar suprimento efetuado com sucesso -->
<?php
if(isset($_SESSION['suprimento_efetuado'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Suprimento realizado com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['suprimento_efetuado']);
?>


<!-- MODAL PARA mostrar suprimento efetuado com sucesso -->
<?php
if(isset($_SESSION['sangria_efetuada'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Sangria realizada com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['sangria_efetuada']);
?>


<!-- modal que mostra que caixa ja foi fechado  -->

<?php
if(isset($_SESSION['caixa_ja_feito_fechamento'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Ja existe um fechamento para este ID',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['caixa_ja_feito_fechamento']);
?>


<!-- MODAL fechamento de caixa efetuado com sucesso -->
<?php
if(isset($_SESSION['fechamento_caixa_efetuado'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Fechamento de caixa realizada com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['fechamento_caixa_efetuado']);
?>


<!-- modal valor do campo não permitido  -->

<?php
if(isset($_SESSION['valor_nao_permitido'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Valor inserido não permitido!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['valor_nao_permitido']);
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>


