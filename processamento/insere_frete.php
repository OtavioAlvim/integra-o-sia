<?php
session_start();

// conexão banco mysql
include('../DB/conexao.php');

// conexão banco sqlite
$db_prod = new PDO('sqlite:../DB/' . $_SESSION['cnpj'] . '/DB-SISTEMA/' . $_SESSION['ID'] . '');

// seta a data de são paulo
date_default_timezone_set("America/Sao_Paulo");
$data_atual = date("Y-m-d");

$nome_cliente = $_POST['nome_cliente'];
$endereco_cliente = $_POST['endereco_entrega'];
$_SESSION['id_ultimo_pedido'];

// verifica se algum dos campos estão vindo vazio da grid de pedidos de venda
if (empty($_POST['id_pedido']) || empty($_POST['nome_cliente']) || empty($_POST['endereco_entrega'])) {
    // echo "algum dos campos do formulario esta vazio";
};
$valor_custo = $_POST['custo_entrega'];
// verifica se o valor do frete esta vazio, se estiver vazio, colocar um valor igaul a 0
if (empty($valor_custo)) {
    $custo_entrega = 0;
} else {
    $custo_entrega =  $valor_custo;
    // verifica se o valor contem virgula
    if (strpos($custo_entrega, ",") !== false) {
        // removeo a virgula caso o campo contenha
        $custo_entrega = str_replace(",", ".", "$valor_custo");
    } else {
        $custo_entrega = $valor_custo;
    }
}
// verifica se o id que vem da grid é igual a do pedido atual

if ($_POST['id_pedido'] != $_SESSION['id_ultimo_pedido']) {
    $Verifica_se_existe_pedidos = $db_prod->query("SELECT count(*) as total,ENTREGAR from TMPPEDIDOS where ID_PEDIDO ='{$_POST['id_pedido']}'");
    // print_r($Verifica_se_existe_pedidos);
    $resultado = $Verifica_se_existe_pedidos->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultado as $row => $linhas) {
        // echo $linhas['total'];
    }
    if ($linhas['total'] == 0) {
        $_SESSION['nao_existe_pedido_com_esse_id'] = true;
        header('Location: ../venda.php');
        exit();
    }else{
        // verifica se pedido ja existe no banco remoto mysql
        $verifica_mysql_banco = $conn->query("SELECT COUNT(*) as registro FROM entregas e WHERE e.numero_pedido = '{$_POST['id_pedido']}'");
        $resultado_consulta = $verifica_mysql_banco->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultado_consulta as $entregue){
            $entregue['registro'];
        }
        if($entregue['registro'] == 0){
             // INSERE O PEDIDO DE ENTREGA NO BANCO MYSQL 
            $insere_banco_entrega = "INSERT INTO entregas (`nome`, `endereco`, `valor_frete`, `entregue`, `vendedor`, `numero_pedido`, `cnpj`,`data`) VALUES ('{$nome_cliente}','{$endereco_cliente}','{$custo_entrega}','N','{$_SESSION['usuario']}','{$_POST['id_pedido']}','{$_SESSION['cnpj']}','{$data_atual}');";
            if ($conn->exec($insere_banco_entrega) == true) {
                $_SESSION['DadosInseridosComSucessoNecesarioCobrar'] = true;
                header('Location: ../venda.php');
                exit();
            }


        }else{
            $_SESSION['ja_existe_pedido_entrega'] = true;
            header('Location: ../venda.php');
            exit();
        }
    }
    


} else {
    // verifica se o valor de entrega ja foi inserido

    $Verifica_se_existe_pedidos = $db_prod->query("SELECT ENTREGAR from TMPPEDIDOS where ID_PEDIDO ='{$_SESSION['id_ultimo_pedido']}'");
    // print_r($Verifica_se_existe_pedidos);
    $resultado = $Verifica_se_existe_pedidos->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultado as $row => $linhas) {
        echo $linhas['ENTREGAR'];
    }
    if ($linhas['ENTREGAR'] == 'S') {

        $_SESSION['ja_existe_pedido_entrega'] = true;
        header('Location: ../venda.php');
        exit();
    }
    // INSERE OS DADOS NO BANCO DO SISMA DE FRETE E ENTREGAR IGUAL A SIM
    $insere_banco_sistema = "UPDATE TMPPEDIDOS set FRETE = '{$custo_entrega}', ENTREGAR = 'S' where ID_PEDIDO = {$_SESSION['id_ultimo_pedido']}";
    $db_prod->exec($insere_banco_sistema);

    // INSERE O PEDIDO DE ENTREGA NO BANCO MYSQL 
    $insere_banco_entrega = "INSERT INTO entregas (`nome`, `endereco`, `valor_frete`, `entregue`, `vendedor`, `numero_pedido`, `cnpj`,`data`) VALUES ('{$nome_cliente}','{$endereco_cliente}','{$custo_entrega}','N','{$_SESSION['usuario']}','{$_SESSION['id_ultimo_pedido']}','{$_SESSION['cnpj']}','{$data_atual}');";
    if ($conn->exec($insere_banco_entrega) == true) {
        $_SESSION['DadosInseridosComSucesso'] = true;
        header('Location: ../venda.php');
        exit();
    }
}
