<?php

include('../login/verifica_login.php');

    $pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
    $db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

$recupera_dados_empresa = $db_prod->query("SELECT * from DADOS_EMPRESA");
$resultado_dados_empresa = $recupera_dados_empresa->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_dados_empresa as $row=> $registro){

}

$recupera_tipos_pedido = $pdo->query("SELECT ID_TIPOPEDIDO,DESCRICAO from TIPOSPEDIDO");
$resultado_tipopedido = $recupera_tipos_pedido->fetchAll(PDO::FETCH_ASSOC);

$recupera_cliente_padrao = $pdo->query("SELECT c.ID_CLIENTE,c.RAZAO FROM CLIENTES c where (c.RAZAO = 'CLIENTE PADRAO' OR c.RAZAO = 'CONSUMIDOR PADRAO')");
$resultado_cliente_padrao = $recupera_cliente_padrao->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="../api/sweetalert2.js"></script>
</head>
<body>

    <div class="d-flex align-items-start">
    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Cadastro Empresa</button>
        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Operações</button>
        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Configuraçoes</button>
        <!-- <a href="../menu.php"><button type="button" class="btn btn-danger">CANCELAR</button></a> -->
        <a class="btn btn-primary" href="../menu.php" role="button">VOLTAR</a>
    </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Dados Empresa</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            
            <?php
if(isset($_SESSION['sucesso'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Dados Alterados com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['sucesso']);
?>




                <h1>Dados da empresa - Cupom fiscal</h1><br>
                <form action="processa_dados_cupom.php" method="post">
                    <label for="">Fantasia</label>
                    <input class="form-control" list="datalistOptions" name="fantasia" id="exampleDataList" placeholder="Fantasia" value="<?php echo $registro['FANTASIA'] ?>">
                    <label for="">telefone</label>
                    <input class="form-control" list="datalistOptions" name="telefone" id="exampleDataList" placeholder="telefone" value="<?php echo $registro['TELEFONE'] ?>">
                    <label for="">Endereço abreviado</label>
                    <input class="form-control" list="datalistOptions" name="endereco" id="exampleDataList" placeholder="Endereço abreviado" value="<?php echo $registro['ENDERECO_ABREVIADO'] ?>">
                    <label for="">Cnpj</label>
                    <input class="form-control" list="datalistOptions" name="cnpj" id="exampleDataList" placeholder="cnpj" value="<?php echo $registro['CNPJ'] ?>">
                    <label for="">Dados adicionais</label>
                    <input class="form-control" list="datalistOptions" name="dados" id="exampleDataList" placeholder="Dados adicionais" value="<?php echo $registro['DADOS_ADICIONAIS'] ?>">
                    <label for="">Tipo pedido</label>
                    <!-- <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..."> -->
                    <select  class="form-select" name="tipopedido" aria-label="Default select example">
                        <option value="<?php echo $registro['ID_TIPOPEDIDO'] ?>" selected><?php echo $registro['DESCRICAO_TIPO_PEDIDO'] ?></option>
                        <?php
                            foreach($resultado_tipopedido as $linha=>$result){?>
                                <option value="<?php echo $result['ID_TIPOPEDIDO'] ?>"><?php echo $result['DESCRICAO'] ?></option>
                        <?php }
                        ?>
                    </select>
                    <label for="">Cliente padrão</label>
                    <select class="form-select" name="cliente_padrao" aria-label="Default select example">
                        <option value="<?php echo $registro['ID_CLIENTE_PADRAO'] ?>" selected><?php echo $registro['CLIENTE_PADRAO'] ?></option>
                        <?php
                        foreach($resultado_cliente_padrao as $lin=>$cliente){?>
                            <option value="<?php echo $cliente['ID_CLIENTE']?> "><?php echo $cliente['RAZAO'] ?></option>
                        <?php }
                        ?>
                    </select><br>
                    <a class="btn btn-danger" href="../menu.php" role="button">VOLTAR</a>
                    <!-- <button type="button" class="btn btn-danger">CANCELAR</button> -->
                    <button type="submit" class="btn btn-primary">SALVAR</button>
                </form>
            </div>
        </div>
        </div>

        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">...</div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div>
    </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>


