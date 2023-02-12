<?php
include('../login/verifica_login.php');
include('../DB/conexao.php');


$entregas = $conn->query("SELECT SUBSTR(e.nome,1,15) AS nomes,SUBSTR(e.endereco,1,30) AS enderecos,e.* FROM entregas e WHERE e.entregue = 'S' and e.cnpj = '{$_SESSION['cnpj']}' ORDER BY e.numero_pedido asc");

$resultado_entrega = $entregas->fetchAll(PDO::FETCH_ASSOC);


?>
<!doctype html>
<html lang="pt-br ">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Controle de entregas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="../api/sweetalert2.js"></script>
    <link rel="stylesheet" href="../css/entrega.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../menu.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                </svg></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">Aguardando entrega</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </nav>
    <div class="container" style="margin-top: 100px; ">

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z" />
            </svg>
        </button>
        <h1>Pedidos entregues</h1>
        <hr>
        <div class="row row-cols-1 row-cols-sm-3 row-cols-md-4 g-3 " style="margin-top: 20px; ">



        <?php  


            if(empty($resultado_entrega)){
                echo "<h1>Nenhum pedido entregue</h1>";
            }
            foreach($resultado_entrega as $linhas=> $entrega){?>
                <div class="col">
                    <div class="card">
                        <img src="../images/imagem_entregas/pedidos_entregue.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" >Pedido n <?php echo $entrega['numero_pedido'] ?></h5>
                            <p class="card-title"><strong><?php echo $entrega['nomes'] ?></strong> </p>
                            <p class="card-text"> <?php echo $entrega['enderecos'] ?></p>
                            <form action="../processamento/restaura_entrega.php" method="post">
                                <div class="d-grid gap-2 d-md-block">
                                    <input type="hidden" name="id_entrega" value="<?php echo $entrega['numero_pedido'] ?>">
                                    <button class="btn btn-outline-success" type="submit">Restaurar entrega</button>
                                    <!-- <button class="btn btn-outline-danger" type="button">Cancelar</button> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php }
        ?>

        </div>
    </div>




    <!-- Modal filtro -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Filtro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2 d-md-block">
                        <label for="">Data inicial</label>
                        <input type="date" name="" id="">
                        <label for="">Data Final</label>
                        <input type="date" name="" id="">
                        <br><br>
                        <label for="">Numero Pedido</label>
                        <input type="number" name="" id="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-success">Pesquisar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>

<!--MODAL ENTREGA RESTAURADA COM SUCESSO-->

<?php
if(isset($_SESSION['pedidoRestaurado'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Pedido restaurado com sucesso!',
  showConfirmButton: false,
  timer: 2500
})
</script>
 <?php
endif;
unset($_SESSION['pedidoRestaurado']);
?>