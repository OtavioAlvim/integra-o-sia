
<script>
function ClosePrint() {
      setTimeout(function () { window.print(); }, 500);
      window.onfocus = function () { 
        setTimeout(function () {
          <?php $_SESSION['fechamento_caixa_efetuado'] = true;?>
            window.location.href = "../menu.php"; 
        }, 500); 

    }
}
</script>

<?php
include('../login/verifica_login.php');
$operacao = $_SESSION['id_operacao_banco'];

$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
$db_prodd = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');



// *****************************RECUPERA SOMA DE VALORES DE FECHAMENTO SEM DINHEIRO************************* 
$valores = $db_prod->query("SELECT * from VALORES_FECHAMENTO v where ID_OPERACAO = {$operacao} and v.DESCRICAO <> 'DINHEIRO' AND v.DESCRICAO <> 'SANGRIA' AND v.DESCRICAO <> 'SUPRIMENTO'");
$resultado_valores = $valores->fetchAll(PDO::FETCH_ASSOC);



// ***************************RECUPERA VALOR IGUAL A DINHEIRO************************************

$recupera_dinheiro = $db_prod->query("SELECT * from VALORES_FECHAMENTO v where v.ID_OPERACAO = {$operacao} and v.DESCRICAO = 'DINHEIRO'");
$resultado_dinheiro = $recupera_dinheiro->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_dinheiro as $chave=> $dinheiro){

}

// *****************************RECUPERA O VALOR DE ABERTURA DE CAIXA**************************
$abertura_caixa = $db_prod->query("SELECT substr(o.DESCRICAO,0,9) as descri,o.* from OPERACOES o where id = {$operacao}");
$resultado_abertura = $abertura_caixa->fetchAll(PDO::FETCH_ASSOC);

// *****************************RECUPERA DADOS DE SUPRIMENTO*************************
$suprimento = $db_prod->query("SELECT DESCRICAO, sum(VALOR) AS VALOR from OPERACAO_CAIXA  WHERE ID_OPERACAO = {$operacao} and DESCRICAO = 'SUPRIMENTO' GROUP BY DESCRICAO ");
$resultado_suprimento = $suprimento->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_suprimento as $row=> $suprimentos){
  
}
if(empty($resultado_suprimento)){
  $valor_supri = 0;
  $descricao_supri = "SUPRIMENTO";
}else{
  $descricao_supri = $suprimentos['DESCRICAO'];
  $valor_supri = $suprimentos['VALOR'];
}

// *****************************RECUPERA DADOS SANGRIA*************************
$sangria = $db_prod->query("SELECT DESCRICAO, sum(VALOR) AS VALOR from OPERACAO_CAIXA  WHERE ID_OPERACAO = {$operacao} and DESCRICAO = 'SANGRIA' GROUP BY DESCRICAO ");
$resultado_sangria = $sangria->fetchAll(PDO::FETCH_ASSOC);

foreach($resultado_sangria as $ro=> $sangrias){
  
}
if(empty($resultado_sangria)){
  $valor_sangri = 0;
      $descricao_sangri = "SANGRIA";
}else{
  $descricao_sangri = $sangrias['DESCRICAO'];
  $valor_sangri = $sangrias['VALOR'];
}


// *********************sql para buscar os dados da empresa na tabela do caixa*******************************

$sql_informacoes_empresa = $db_prod->query("SELECT * FROM DADOS_EMPRESA");
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
    <link rel="stylesheet" href="../css/fechamento.css">
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
        <h3>Comprovante de Fechamento - <?php echo $operacao?></h3>
        <p id="linha">--------------------------------------------------------------</p> 
            <div class="containner_descricao_produto">
                <h4 class="descricao">Descrição</h4>
                <h4 class="pdv">PDV</h4>
                <h4 class="inserido">Inserido</h4>
                <h4 class="diferenca">Diferença</h4>
            </div>
        <p id="linha">--------------------------------------------------------------</p>  
        <tbody>
              <?php
              foreach($resultado_abertura as $row=> $abertura){?>
              <div class="containner_informacao">
                <p class="descricao_operacao"><strong><?php echo $abertura['descri']?></strong></p>
                <p class="valor_sis">R$ <?php echo $abertura['VALOR']?></p>
                <p class="valor_inserido">R$ 0</p>
                <p class="diferencas">R$ 0</p><br>
              </div>
              <?php }?>



              <div class="containner_informacao">
                <p class="descricao_operacao"><strong><?php echo $descricao_supri?></strong></p>
                <p class="valor_sis">R$ <?php echo $valor_supri?></p>
                <p class="valor_inserido">R$ 0</p>
                <p class="diferencas">R$ 0</p><br>
              </div>




              <div class="containner_informacao">
                <p class="descricao_operacao"><strong><?php echo $descricao_sangri?></strong></p>
                <p class="valor_sis">R$ <?php echo $valor_sangri?></p>
                <p class="valor_inserido">R$ 0</p>
                <p class="diferencas">R$ 0</p><br>
              </div>
              <br>

              <?php
              foreach($resultado_valores as $row=> $valor){?>
              <div class="containner_informacao">
                <p class="descricao_operacao"><strong><?php echo $valor['DESCRICAO']?></strong></p>
                <p class="valor_sis">R$ <?php echo $valor['VALOR_CALC_SIS']?></p>
                <p class="valor_inserido">R$ <?php echo $valor['VALOR_INSERIDO']?></p>
                <p class="diferencas">R$ <?php echo $valor['DIFERENCA']?></p><br>
              </div>
              <?php } ?>

              <?php
              
              foreach($resultado_dinheiro as $chave=> $dinheiro){
                $total_dinheiro_sistema = $dinheiro['VALOR_CALC_SIS'] + $valor_supri + $abertura['VALOR'] - $valor_sangri;
                ?>
              
              <div class="containner_informacao">
                <p class="descricao_operacao"><strong><?php echo $dinheiro['DESCRICAO']?></strong></p>
                <p class="valor_sis">R$ <?php echo $total_dinheiro_sistema?></p>
                <p class="valor_inserido">R$ <?php echo $dinheiro['VALOR_INSERIDO']?></p>
                <p class="diferencas">R$ <?php echo $dinheiro['VALOR_INSERIDO'] - $total_dinheiro_sistema?></p><br>
              </div>
              <?php } ?>

            </tbody>
    </div>
</body>
</html>