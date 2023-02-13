
<script>
// function ClosePrint() {
//       setTimeout(function () { window.print(); }, 500);
//       window.onfocus = function () { 
//         setTimeout(function () {
//             window.location.href = "../venda.php"; 
//         }, 500); 

//     }
// }
</script>

<?php
include('../DB/conexao.php');
include('../login/verifica_login.php');
// header('Location: index.php');
$n = $_SESSION['id_ultimo_pedido'];

$db = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
$db_prodd = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
// ***************************sql para buscar os dados para a geração dos itens do cupom***************************
$consulta_sqlite = $db->query("SELECT t.total as total_nota,t.ID_FORMAPGTO,t.VALOR_RECEBIDO,t.TROCO,t.ENTREGAR, ped.* from TMPPEDIDOS t join TMPITENS_PEDIDO ped on t.ID_PEDIDO = ped.ID_PEDIDO where ped.ID_PEDIDO = {$n}");
$produto = $consulta_sqlite->fetchAll(PDO::FETCH_ASSOC);
foreach($produto as $row => $produtos){
    $total = $produtos['total_nota'];
    $forma_pagamento_id = $produtos['ID_FORMAPGTO'];
}
// ************************sql para buscar a descrição da forma de pagamento no banco***************************
$sql_puxar_descricao_formapgto = $db_prodd->query("select DESCRICAO from FORMASPGTO where ID_FORMAPGTO = {$forma_pagamento_id}");
$resultado_forma = $sql_puxar_descricao_formapgto->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_forma as $row=> $forma){
    $forma['DESCRICAO']; 
}
// **************************sql para buscar os dados da empresa na tabela do caixa*******************************

$sql_informacoes_empresa = $db->query("SELECT * FROM DADOS_EMPRESA");
$resultado_consulta = $sql_informacoes_empresa->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_consulta as $row=> $dados){
    $dados['FANTASIA'];
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cupom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <title>cupom Pedido de Venda</title>
</head>
<body onload="ClosePrint()">
    <div class="cupom">
        <br>
        <div class="informa">
            <h5 id="razao"><?php echo $dados['FANTASIA']?></h5>
            <h5 id="cnpj">CNPJ:<?php echo $dados['CNPJ']?></h5>
            <h5 id="endereco"><?php echo $dados['ENDERECO_ABREVIADO']?></h5>
            <h5 id="tel">Tel:(35) 3421-7775</h5>
        </div>
        <p id="linha">--------------------------------------------------------------</p> 
        <h3>Pedido de venda - <?php echo $produtos['ID_PEDIDO']?></h3>
        <p id="linha">--------------------------------------------------------------</p> 
        <div class="containner_descricao_produto">
                <h5 class="container_formas_descricao">DESCRICAO</h5>
                <h5 class="container_formas_unitarios">UN</h5>
                <h5 class="container_formas_quantidade">QTD</h5>
                <h5 class="container_formas_total">TOTAL</h5>

            </div>
        <p id="linha">--------------------------------------------------------------</p>  
            <?php
            $sn=0;
            foreach($produto as $row => $produtos){
                $sn++;
                $desc = $produtos['DESCRICAO'];
                $uni = $produtos['UNITARIO'];
                $qtd = $produtos['QTD'];
                $tot = $produtos['TOTAL'];
                echo "<h5 class=desc_item>". $sn . " - ". substr($desc,0,18)  . "</h5>";
                echo "<div class=container_formas>";
                echo "<p class=container_formas_unitario>R$ ". $uni . "</p>";
                echo "<p class=container_formas_gtd>". $qtd . "</p>";
                echo "<p class=container_formas_tot>R$". $tot . "</p>";
                echo "</div>";
                
            }
            ?>
            <br>
            <p id="linha">--------------------------------------------------------------</p> 
            <div class="finaliza">
                <h4 class="valor_final">VALOR TOTAL: R$ <?php echo $total; ?></h4>
                <h4 class="valor_final">VALOR RECEBIDO: R$ <?php echo $produtos['VALOR_RECEBIDO']; ?></h4>
                <h4 class="valor_final">VALOR TROCO: R$ <?php echo $produtos['TROCO']; ?></h4>
                <h4 id="form_pagamento">FORMA DE PAGAMENTO: <?php echo $forma['DESCRICAO']?></h4>
                <?php
                if($produtos['ENTREGAR'] == 'S'){
                    $insere_endereco = $conn->query("SELECT * FROM entregas e where e.cnpj = '{$_SESSION['cnpj']}' and e.numero_pedido = '{$n}'");
                    $resultado_endereco = $insere_endereco->fetchAll(PDO::FETCH_ASSOC);
                    foreach($resultado_endereco as $end => $endereco_entrega){

                    }
                    ?>
                    <h4 class="valor_final">ENDEREÇO DE ENTREGA: <p> <?php echo $endereco_entrega['endereco'] ?> </p></h4>
                <?php } 
                ?>
                <h5 id="volte_sem">VOLTE SEMPRE!</h5>
            </div>
            <p id="linha">--------------------------------------------------------------</p> 
    </div>
</body>
</html>