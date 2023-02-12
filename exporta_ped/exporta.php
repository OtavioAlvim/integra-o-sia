<?php
include('../login/verifica_login.php');
$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/BASE-TMPPEDIDOS/'.$_SESSION['ID'].''); 
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

ini_set('max_execution_time',0);

$limpa_base_capa = "DELETE FROM TMPPEDIDOS";
$pdo->exec($limpa_base_capa);

$limpa_base_item = "DELETE FROM TMPITENS_PEDIDO";
$pdo->exec($limpa_base_item);



$inicio = $_POST['inicio'];
$fim = $_POST['fim'];

if(empty($inicio) || empty($fim)){
  $_SESSION['informe-data'] = true;
  header('Location: exporta_pedido.php');
}
if($fim < $inicio){
  $_SESSION['periodo-invalido'] = true;
  header('Location: exporta_pedido.php');
}

//Consulta sql
$query = $db_prod->query("SELECT p.* from TMPPEDIDOS p join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.DATA_PESQ BETWEEN '{$inicio}' and '{$fim}' group by p.ID_PEDIDO ");

//execução da consulta sql
$result_query = $query->fetchAll(PDO::FETCH_ASSOC);
//consulta intens pedido

$query_itens_pedido = $db_prod->query("SELECT i.* from TMPPEDIDOS p join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO  where p.DATA_PESQ BETWEEN '{$inicio}' and '{$fim}'");
$resultado_itens_pedido = $query_itens_pedido->fetchAll(PDO ::FETCH_ASSOC);
// print_r($query_itens_pedido);
//VALIDAÇÃO CAPA DOS PEDIDOS
if(empty($result_query)){

  /////////////////////////////////////////////////verificar esse ponto de escape variavel//////////////////////
  $_SESSION['erro_exportados'] = true;
  header('Location: exporta_pedido.php');
}else{

foreach($result_query as $row=> $teste){
    $t = $teste['ID_PEDIDO'];
    $sql = $pdo->query("SELECT count(*) as tes from TMPPEDIDOS where ID_PEDIDO = {$t}");
    $result_sql = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach($result_sql as $row=> $mauricio){
            $s = $mauricio['tes'];
            if($s == 0){

                $insere_banco = $db_prod->query("SELECT p.* from TMPPEDIDOS p join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.DATA_PESQ BETWEEN '{$inicio}' and '{$fim}' and p.ID_PEDIDO = {$teste['ID_PEDIDO']}  group by p.ID_PEDIDO");
                $result_insere_banco = $insere_banco->fetchAll(PDO::FETCH_ASSOC);
                foreach($result_insere_banco as $row=> $registro){
                  $registro['ID_PEDIDO'];
                  $registro['ID_VENDEDOR'];
                  $registro['ID_CLIENTE'];
                  $registro['ID_TIPOPEDIDO'];
                  $registro['ID_PLANOPGTO'];
                  $registro['ID_FORMAPGTO'];
                  $registro['DATA'];
                  $registro['DESCONTO'];
                  $registro['TOTAL'];
                  $registro['RAZAO'];
                  $registro['ID_EMPRESA'];
                  // inserindo registros no banco de dados
                  $query_inserindo = "INSERT INTO TMPPEDIDOS 
                  (ID_PEDIDO,
                  ID_VENDEDOR, 
                  ID_CLIENTE, 
                  ID_TIPOPEDIDO, 
                  ID_PLANOPGTO, 
                  ID_FORMAPGTO, 
                  DATA, 
                  DESCONTO, 
                  TOTAL, 
                  TRANSMITIDO, 
                  JATRANSMITIDO, 
                  RAZAO, 
                  ID_EMPRESA, 
                  FRETE, 
                  ACRESCIMO, 
                  OUTRO_DESC, 
                  ENDERECO, 
                  BAIRRO, 
                  CIDADE, 
                  ESTADO, 
                  CEP, 
                  TELEFONE, 
                  ID_ROTA, 
                  NUMERO, 
                  COMPLEMENTO, 
                  ENTREGAR, 
                  NOVOENDERECO, 
                  ID_CIDADE, 
                  DESPESAS_BOLETO
                  ) 
                  VALUES ({$registro['ID_PEDIDO']},
                  {$registro['ID_VENDEDOR']},
                  {$registro['ID_CLIENTE']}, 
                  {$registro['ID_TIPOPEDIDO']}, 
                  {$registro['ID_PLANOPGTO']}, 
                  {$registro['ID_FORMAPGTO']}, 
                  '{$registro['DATA']}', 
                  '0',
                  '{$registro['TOTAL']}',
                  'N',
                  'N', 
                  '{$registro['RAZAO']}', 
                  '{$registro['ID_EMPRESA']}',
                  '{$registro['FRETE']}', 
                  '0.0', 
                  '0.0',  
                  '', 
                  '', 
                  '', 
                  '', 
                  '', 
                  '', 
                  '0',
                  '',
                  '',
                  'N',
                  'N',
                  '0',
                  '0'
                  )
                  ";

                  $pdo->exec($query_inserindo);
                }
            }else{
              //"erro";
              $_SESSION['erro_exportados'] = true;
              // header('Location: erro.php');
            }
        }   
}





//VALIDAÇÃO ITENS PEDIDO




foreach($resultado_itens_pedido as $row=> $itens){
  //valida se o mesmo id existe no banco de dados a ser transportado
  $valida_se_item_existe_banco = $pdo->query("SELECT count(*) as totals from TMPITENS_PEDIDO WHERE ID = {$itens['ID']}");
  //execulta a consulta no banco de dados
  $resultado_validacao_itens = $valida_se_item_existe_banco->fetchAll(PDO::FETCH_ASSOC);

    foreach($resultado_validacao_itens as $row=> $itens_pesquisados){
        $itens_pesquisados['totals'];
      if($itens_pesquisados['totals'] == 0){
        //select para buscar as informações no banco do caixa e inser no banco final
        $itens_banco_caixa = $db_prod->query("SELECT i.* from TMPPEDIDOS p join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO  where p.DATA_PESQ BETWEEN '{$inicio}' and '{$fim}' and i.id = {$itens['ID']} ");
        $result_consulta_itens_banco_caixa = $itens_banco_caixa->fetchAll(PDO::FETCH_ASSOC);
        foreach($result_consulta_itens_banco_caixa as $row=> $itens){
          $itens['ID'];
          $itens['ID_PEDIDO'];
          $itens['ID_EMPRESA'];
          $itens['ID_PRODUTO'];
          $itens['QTD'];
          $itens['UNITARIO'];
          $itens['DESCONTO'];
          $itens['TOTAL'];
          $itens['DESCRICAO'];
          $itens['PRECOINICIAL'];
          $itens['UNITARIOBASE'];
          $sql_item = "INSERT INTO TMPITENS_PEDIDO (
            ID, 
            ID_PEDIDO, 
            ID_EMPRESA, 
            ID_PRODUTO, 
            QTD, 
            UNITARIO, 
            DESCONTO, 
            TOTAL, 
            DADOADICIONAL,
            DESCRICAO, 
            PRECOINICIAL, 
            ID_TONALIDADE, 
            UNITARIOBASE, 
            EMPROMOCAO, 
            DESPESAS_BOLETO)
             VALUES (
            {$itens['ID']}, 
            {$itens['ID_PEDIDO']}, 
            {$itens['ID_EMPRESA']}, 
            {$itens['ID_PRODUTO']}, 
            {$itens['QTD']}, 
            {$itens['UNITARIO']}, 
            '0',
            {$itens['TOTAL']}, 
            '', 
            '{$itens['DESCRICAO']}', 
            {$itens['PRECOINICIAL']}, 
            '0', 
            {$itens['UNITARIOBASE']}, 
            'N',
            '0')";
            if($pdo->exec($sql_item) == true){
              header('Location: compactaBase.php');
            }

        }     
      }else{
        header('Location: erro.php');
      }
    }
}

}
?>