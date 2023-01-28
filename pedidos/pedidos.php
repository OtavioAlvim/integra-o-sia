<?php
include('../login/verifica_login.php');

$db_prodd = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
$consulta = $db_prodd->query("SELECT t.ID_PEDIDO,T.DATA,T.NOME_CLIENTE,T.total, T.VENDEDOR from TMPPEDIDOS t join TMPITENS_PEDIDO i on t.ID_PEDIDO = i.ID_PEDIDO group by t.ID_PEDIDO");
$pesquisar = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/pedidos.css">
    <title>Consultar Pedidos</title>
</head>
<body>

    <div class="voltar">
        <a class="btn btn-primary" href="../menu.php" role="button">voltar</a>
    </div>

    <h1 id="pedido">Pedidos Realizados</h1>
    <hr>
    <div class="container_pedidos">
        <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">PEDIDO</th>
            <th scope="col">DATA</th>
            <th scope="col">CLIENTE</th>
            <th scope="col">VENDEDOR</th>
            <th scope="col">TOTAL</th>
            <th scope="col">VISUALIZAR</th>
            <th scope="col">IMPRIMIR</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($pesquisar as $row => $resultado){
                $id_ped = $resultado['ID_PEDIDO'];
                echo "<tr>";
                echo "<th scope=col>". $resultado['ID_PEDIDO'] ."</th>";
                echo "<td scope=col>". $resultado['DATA'] ."</td>";
                echo "<td scope=col>". $resultado['NOME_CLIENTE'] ."</td>";
                echo "<td scope=col>". $resultado['VENDEDOR'] ."</td>";
                echo "<td scope=col> R$ ". $resultado['TOTAL'] ."</td>";
                echo "<td><a class='btn btn-primary' href=info_ped.php?id_ped=".$id_ped." role=button>ITENS</a></td>";
                echo "<td><a class='btn btn-primary' href=../gera_cupom/cupom_sorteado.php?id_ped=".$id_ped." target='_blank' role=button>CUPOM</a></td>";
                echo "</tr>";

            }
            ?>
        </tbody>
        </table>
    </div>
    <div class="bola">
        
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
