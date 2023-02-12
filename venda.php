

<?php
include('./login/verifica_login.php');
$db_prodd = new PDO('sqlite:./DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$pdo = new PDO('sqlite:./DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
/////////////////////////////////////////////////////////////////////////////////////////////////
$consulta_sqlite = $pdo->query("SELECT coalesce(i.DESCRICAO, 0) as resultado, p.ID_PEDIDO  from TMPPEDIDOS p left join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.VENDEDOR = '{$_SESSION['usuario']}' order by p.ID_PEDIDO DESC limit 1");
$produto = $consulta_sqlite->fetchAll(PDO::FETCH_ASSOC);
foreach($produto as $row => $produtos){
    $desc = $produtos['resultado'];
    $id_ultimo_pedido = $produtos['ID_PEDIDO'];
};

$_SESSION['id_ultimo_pedido'] = $id_ultimo_pedido;
if ($desc == 0 ){
    $desc = "PEDIDO DE VENDA";
}else {
    $consulta_sqlit = $pdo->query("select substr(t.DESCRICAO,1, 30) AS DESCRICAO from TMPITENS_PEDIDO t where t.ID_PEDIDO = {$id_ultimo_pedido} order by t.id desc limit 1");
    $produt = $consulta_sqlit->fetchAll(PDO::FETCH_ASSOC);
    foreach($produt as $row => $produtos){
        $desc = $produtos['DESCRICAO'];
    };
    // $desc = "tem produtos";
};
/////////////////////////////////////////////////////////////////////////////////////////////////
$total_venda = $pdo->query("select coalesce(round(sum(t.total),2),0)as total_pedido from TMPITENS_PEDIDO t where t.ID_PEDIDO = {$id_ultimo_pedido}");
$resultado_total_vendas = $total_venda->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_total_vendas as $row => $total_venda_item){
    $tot_vendas = $total_venda_item['total_pedido'];
    $total_venda_item['total_pedido'];
};
if ($tot_vendas == 0 ){
    $tot_vendas = "00.00";
}

$_SESSION['valor_total_pedido'] = $tot_vendas;
/////////////////////////////////////////////////////////////////////////////////////////////////
$sql = $pdo->query("SELECT T.ID,T.UNITARIO,T.total,T.QTD, substr(T.DESCRICAO,1, 27) AS DESCRICAO FROM TMPITENS_PEDIDO T WHERE T.ID_PEDIDO = {$id_ultimo_pedido}");
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $row => $container_vendas){

    $id_cont_vendas = $container_vendas['ID'];
    $desc_cont_vendas = $container_vendas['DESCRICAO'];
    $unit_cont_vendas = $container_vendas['UNITARIO'];
    $tot_cont_vendas = $container_vendas['TOTAL'];
    $qtd_cont_vendas = $container_vendas['QTD'];

};

/////////////////////////////////////////forma de pagamento//////////////////////////////////////////
$formapgto = $db_prodd->query("SELECT * FROM PLANOXFORMA P JOIN FORMASPGTO F ON P.ID_FORMAPGTO = F.ID_FORMAPGTO GROUP BY DESCRICAO");
$forma_pagamento_sia = $formapgto->fetchAll(PDO::FETCH_ASSOC);

/////////////////////////////////////////forma de pagamento//////////////////////////////////////////
$planopgto = $db_prodd->query("SELECT ID_PLANOPGTO, DESCRICAO from PLANOSPGTO");
$result_planopgto_sia = $planopgto->fetchAll(PDO::FETCH_ASSOC);

////////////////////////////////////////////////////////////////////////////////////////////////////
$busca_cliente = $pdo->query("SELECT substr(t.NOME_CLIENTE,0,26) as NOME_CLIENTE,t.DEBITOS,t.LIMITE,t.* from TMPPEDIDOS t where t.ID_PEDIDO = {$id_ultimo_pedido}");
$resultado_cliente = $busca_cliente->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_cliente as $row=> $cliente){
    $cliente['NOME_CLIENTE'];
}
if($cliente['LIMITE'] == 0){
    $cli_cred = "00,00";
}else{
    $cli_cred = $cliente['LIMITE'];
}

if($cliente['LIMITE'] == 0){
    $cli_deb = "00,00";
}else{
    $cli_deb = $cliente['LIMITE'];
}
//////////////////////////////////////////////////////////////////////////////////////////////////
$ultimo_troco_recebido = $pdo->query("SELECT * from TMPPEDIDOS p join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.VENDEDOR = '{$_SESSION['usuario']}' order by p.ID_PEDIDO DESC limit 1");
$resultado_ultimo_troco = $ultimo_troco_recebido->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_ultimo_troco as $val_troco => $troco){
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imgens/Nova pasta/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/vendas.css">
    <link rel="stylesheet" href="css/modal_produto.css">
    <link rel="stylesheet" href="css/modal_clientes.css">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
	<script type="text/javascript" src="./api/javascriptpersonalizado.js"></script>
    <script type="text/javascript" src="./api/javascriptpersonalizados.js"></script>
    <script src="./api/sweetalert2.js"></script>
    <script src="./api/script.js"></script>


    <title>Tela de vendas</title>
</head>
<body> 
    <a href="menu.php"><input class="voltar" type="button" value="voltar" accesskey="q"></a>

<!-- //////////////////////////////////// Display de exebição de produtos///////////////////////// -->

    <div class="topo">
        <p><?php echo $desc; ?></p>
    </div>

<!-- /////////////////////////////////////Container descrição////////////////////////////////////////////// -->

<div class="container_vendas" >
    <h5 id="item">Item</h5>
    <div class="descricao">
        <h5 id="desc">Descrição</h5>
    </div>
    <div class="valores">    
        <div class="qtdd">
            <h5>Qtd</h5>
        </div>    
       <div class="unitarioo">
            <h5>Unitario</h5>
        </div>
        <div class="totall">
            <h5>Total</h5>
        </div>     
    </div>
</div>
    <div id="quebra_linha">
    </div>


<!-- ////////////////////////////////////////////Container de produtos/////////////////////////////////////// -->

<div class="container_prod" >
        <table>
            <tr>
            <?php
            $n=0;
                foreach($resultado as $row => $produtos){
                    $n++;
                    $id_cont_vendas = $produtos['ID'];
                    $desc_cont_vendas = $produtos['DESCRICAO'];
                    $unit_cont_vendas = $produtos['UNITARIO'];
                    $tot_cont_vendas = $produtos['TOTAL'];
                    $qtd_cont_vendas = $produtos['QTD'];
                    echo "<div class =c >";
                    // echo "<p class =id>" . $produtos['ID'] ."</p>";
                    echo "<p class =id>" . $n ."</p>";
                    echo "<p class =desc>" .$id_cont_vendas ." - ". $produtos['DESCRICAO'] ."</p>";
                    echo "<p class =qtd>" . number_format($produtos['QTD'],2,',','')  ."</p>";
                    echo "<p class =unitario> R$ " . number_format($produtos['UNITARIO'],2,',','') ."</p>";
                    echo "<p class =tot> R$ " . number_format($produtos['TOTAL'],2,',','')  ."</p>";
                    echo "</div>";		
                }
                echo "</table>";
                
            ?>
</div>
<!-- /////////////////////////////Lateral direita de informaçoes//////////////////////////////////// -->

    <div class="lateral_direita">
        <div class="informa">
            <div id="teste">
                    <h1 class="nome_emitente"><?php echo substr($cliente['NOME_CLIENTE'],0,26)?></h1>
                    <div id="saldo_emitente">
                        <h2 class="saldo">CREDITO: R$ <?php echo $cli_cred?></h2>
                        <h2>DEBITO: R$ <?php echo $cli_deb?></h2>
                    </div>
            </div>
            <div id="logo">
                <img src="imgens/carrinho de compras.jpg" alt="">
            </div>
        </div>
    </div>
<!-- ///////////////////////////////Modal forma de pagamento///////////////////////////////// -->
    <div class="baixo">
        <button class="trigger" onclick="showModal()" accesskey="s">Finalizar - (F2)</button>
        <div class="modal" id="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">
                    &times;
                </span>
                <div id="meu_lor">
                    <h1>Pagamento</h1>
                    <hr>
                </div>
                <div id="forma_pagamento_finalizar">                
                    <form class="finaliza" action="processamento/finaliza.php" method="GET">
                        <div  class="testado">
                            <h1>TOTAL R$:</h1> 
                            <input type="text" name="valor" value="<?php echo $tot_vendas;?>" disabled>
                        </div>
                        <div class="testado">
                            <h1>DESCONTO</h1> 
                            <input type="text" value="00.00" disabled>
                        </div>
                        <div class="testado">
                            <h1>VALOR FINAL</h1> 
                            <input type="text" value="00.00" disabled>
                        </div>
                        <div id="testado" class="testado">
                            <h1>VALOR RECEBIDO</h1> 
                            <input name="valor_recebido" type="number" step="0.01" id="troco">
                        </div>
                        <div class="testado">
                            <h1>VALOR TROCO</h1> 
                            <!-- <input type="text" value="00.00" disabled> -->
                            <span id="resultado_troco"><input type="number" value ="nenhum desconto inserido" disabled></span>
                        </div>
                        <strong><p>FORMAPGTO</p></strong>
                        <select id="estados" name="forma">
                        <option value="">FORMA DE PAGAMENTO</option>
                            <?php
                                foreach($forma_pagamento_sia as $ress => $form_pag){
                                    echo '<option value="'.$form_pag['ID_FORMAPGTO'].'">'.$form_pag['DESCRICAO'].'</option>'; 
                                }
                            ?>
                        </select>
                        <strong><p>PLANOPGTO</p></strong>
                        <select name="plano" id="cidades" style="display:none ">
                        </select>
                        <br>
                        <div class="finalizar_venda">
                            <input id="submit" type="submit" value="finalizar" accesskey="s">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>




<!-- //////////////////////formulario de pesquisa de itens/////////////////////////// -->
        <form class="pesq_itens" action="processamento/insere_item.php" method="POST">
            <div class="pesquisa">            
                <div class="pesq_item">
                    <input type="text" name="codbarra" id="codbarra" placeholder="CODIGO DE BARRAS" autofocus>
                    
                </div>
            </div>
        </form>
            <div class="total">



<!-- Modal para inserir dados de entrega -->


<a href="#" onclick="abreModalEntrega()">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
</svg></a>
            <div class="modal" id="modal_endereco">
                <div class="modal-content">
                    <span class="close-button" onclick="fechaModalEntrega()">
                        &times;
                    </span>
                    <div class="container_entrega">
                        <h3 id="titulo_exclui_item">Insira os dados para entrega</h3><hr>
                        <form action="./processamento/insere_frete.php" method="post">
                            <div class="dados_para_entrega">
                                <label class="entrega_dados" for="exampleFormControlInput1">Pedido:</label>
                                <input type="number" id="frete" name="id_pedido" value="<?php echo $id_ultimo_pedido; ?>" required><br>
                            </div>
                            <div class="dados_para_entrega">
                                <label class="entrega_dados" for="exampleFormControlInput1">Custo da entrega:</label>
                                <input type="number" name="custo_entrega" step="0.01" ><br>
                            </div>
                            <div class="dados_para_entrega">
                                <label class="entrega_dados" for="exampleFormControlInput1" class="form-label">Nome do cliente:</label>
                                <input type="text" class="form-control" name="nome_cliente" id="exampleFormControlInput1" value="<?php echo $cliente['NOME_CLIENTE']?>" required><br>
                            </div>
                            <div class="dados_para_entregas">
                                <label class="entrega_dados" for="exampleFormControlTextarea1" class="form-label">Endereço:</label><br>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="endereco_entrega"  required><?php echo $cliente['ENDERECO'] . ", BAIRRO :" . $cliente['BAIRRO'] ?></textarea><br>
                            </div>
                                    
                                    <button type="submit" id="endereco-enviar">Inserir Endereço</button>
                        </form>
                        <br>
                    </div>
                </div>
            </div>



<!-- /////////////////////////////modal para inserir produto//////////////////////////// -->

            <a href="#" onclick="abreModalProduto()" accesskey="P">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
  <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
</svg></a>
        <div class="modalss" id="modalss">
                <div class="modal-contentss">
                    <span class="close-buttonss" onclick="fechaModalProduto()">
                        &times;
                    </span>
                    <div class="container theme-showcase" role="main">
                    <div class="page-header">
                        <h1 id="titulo_modal_produtos">Pesquisar produtos</h1>
                        <form method="POST" id="form-pesquisa" action="">
                            <div class="form-group">
                                <input type="text" name="pesquisa" class="pesquisa_modal_item" id="pesquisa" placeholder="Pesquisar produto">
                            </div>
                        </form>
                        
                        
                    </div>
                    <div class="row">
                    <table class="testandoGrid">
                    <tr>
                        <th class="titulo_cod_modal_prod"><h2>COD</h2></th>
                        <th class="titulo_desc_modal_prod"><h2>DESCRIÇÃO</h2></th>
                        <th class="titulo_un_modal_prod"><h2>UN</h2></th>
                        <th class="titulo_unitario_modal_prod"><h2>VALOR</h2></th>
                    </tr>
                    </table>
                        <div class="col-md-6">
                            <ol class="resultado">

                            </ol>
                        </div>
                    </div>
                    
                    </div>
                </div>
    </div>

<!-- /////////////////////////////modal para inserir cliente//////////////////////////// -->

            <a href="#" onclick="abreModalClientes()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
</svg></a>
        <div class="modalsss" id="modalsss">
            <div class="modal-contentss">
                <span class="close-buttonss" onclick="fechaModalClientes()">
                    &times;
                </span>
                <div class="container theme-showcase" role="main">
                <div class="page-header">
                    <h1 id="titulo_modal_clientes">Pesquisar Clientes</h1>
                    <form method="POST" id="form-pesquisa" action="">
                        <div class="form-group">
                            <input type="text" name="pesquisa_emitente" class="pesquisa_modal_clientes" id="pesquisa_emitente" placeholder="Pesquisar Emitente">
                        </div>
                    </form>
                    
                    
                </div>
                <div class="row">
                <table class="testandoGridClientes">
                <tr>
                    <th class="titulo_cod_modal_cli"><h2>COD</h2></th>
                    <th class="titulo_desc_modal_cli"><h2>RAZAO</h2></th>
                    <th class="titulo_un_modal_cli"><h2>FANTASIA</h2></th>
                </tr>
                </table>
                    <div class="col-md-6">
                        <ol class="resultado-emitente">

                        </ol>
                    </div>
                </div>
                
                </div>
            </div>
        </div>

<!-- ////////////////////////modal para acessar a exclusão de item//////////////////////////// -->
            <a href="#" onclick="abreModal()" accesskey="t">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg></a>
            <div class="modal" id="modals">
                <div class="modal-content">
                    <span class="close-button" onclick="fechaModal()">
                        &times;
                    </span>
                    <div id="meu_lor">
                        <h1 id="titulo_exclui_item">Insira o codigo do item</h1>
                        <form action="./processamento/exclui_item.php" method="post">
                            <input id="id_produto" name="id_produto" class="exclui_item" type="text">
                            <input class="enviar_exlusao" type="submit" value="Excluir">
                        </form>
                        <br>
                    </div>
                </div>
            </div>

<!-- ///////////////////////////////// botão para voltar ao menu/////////////////////// -->

                <a href="menu.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
  <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
</svg></a>
<!-- ////////////////////////////////////valor total///////////////////////////////// -->
<h1>Total R$: <?php echo number_format($tot_vendas,2,',',' ') ;?></h1>
                
            </div>
            <label id="ultimo_troco" for=""><strong>ULTIMO TROCO: R$: <?php echo number_format($troco['TROCO'],2,',',' ') ;?></strong></label>                
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./api/bootstrap.min.js"></script>
    <script src="./api/desconto.js"></script>
    <script src="./api/recebido.js"></script>
    <script src="./api/formapag.js"></script>

<!-- LOCAL DESTINADO PARA MODAL DE VALIDAÇÃO DA TELA DE VENDAS -->

<!-- modal para mostrar inserção de cliente -->
<?php
if(isset($_SESSION['Cliente não definido'])):
?>
    <body onload="abreModalClientes()">
 <?php
endif;
unset($_SESSION['Cliente não definido']);
?>

<!-- modal inserir cliente padrao -->

<?php
if(isset($_SESSION['INSIRA_CLIENTE'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Cliente não inserido',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['INSIRA_CLIENTE']);
?>



<!-- modal para produto de balança nao encontrado -->

<?php
if(isset($_SESSION['produto_nao_encontrado'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'produto não cadastrado',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['produto_nao_encontrado']);
?>


<!-- tamanho do campo menor que o permitido -->

<?php
if(isset($_SESSION['tamanho-campo-invalido'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Produto invalido, codbarra menor, ou maior que o permitido!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['tamanho-campo-invalido']);
?>


<!-- MODAL exclusão de item efetuado com sucesso -->

<?php
if(isset($_SESSION['exclui'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Item excluido com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['exclui']);
?>

<!-- FINALIZAÇÃO CONCLUIDA COM SUCESSO -->

<?php
if(isset($_SESSION['venda_finalizada_com_sucesso'])):

    
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Pedido finalizado com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['venda_finalizada_com_sucesso']);

?>

<!-- ERRO AO FINALIZAR FINALIZAÇÃO, POIS NÃO EXISTE ITENS NA GRID -->
<?php
if(isset($_SESSION['grid_vazia'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Grid de produtos vazia!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['grid_vazia']);
?>

<!-- ERRO AO FINALIZAR FINALIZAÇÃO, POIS NÃO EXISTE ITENS NA GRID -->
<?php
if(isset($_SESSION['forma_pag'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Preeencha forma de Pagamento!!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['forma_pag']);
?>












<!-- modals destinados a entregas -->
<!-- DadosInseridosComSucesso -->

<?php
if(isset($_SESSION['DadosInseridosComSucesso'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Endereço de entrega inserido com sucesso!',
  showConfirmButton: false,
  timer: 1500
})
</script>
 <?php
endif;
unset($_SESSION['DadosInseridosComSucesso']);
?>




<!-- ERRO nao_existe_pedido_com_esse_id -->
<?php
if(isset($_SESSION['nao_existe_pedido_com_esse_id'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Não existe Pedidos com esse ID',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['nao_existe_pedido_com_esse_id']);
?>

<!-- ///////////////////////////////////////////////////////////////////////////////// -->

<!-- ERRO ja_existe_pedido_entrega -->
<?php
if(isset($_SESSION['ja_existe_pedido_entrega'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Ja existe um pedido de entrega para esse ID!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['ja_existe_pedido_entrega']);
?>


<!-- ///////////////////////////////////////////////////////////////////////////////// -->
<!-- Dados Inseridos Com Sucesso Necesario Cobrar taxa-->

<?php
if(isset($_SESSION['DadosInseridosComSucessoNecesarioCobrar'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Entrega inserido com sucesso! Valor cobrado separadamente!',
  showConfirmButton: false,
  timer: 2500
})
</script>
 <?php
endif;
unset($_SESSION['DadosInseridosComSucessoNecesarioCobrar']);
?>

</body>
</html>