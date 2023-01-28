<?php
include('../login/verifica_login.php');
$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');

if(empty($_POST['codbarra'])) {
	// $_SESSION['produto_nao_encontrado'] = true;
	// header('Location: ../venda.php');
	// exit();
}

$verifica_cli = $db_prod->query("SELECT coalesce(i.DESCRICAO, 0) as resultado,p.NOME_CLIENTE,p.ID_PEDIDO  from TMPPEDIDOS p left join TMPITENS_PEDIDO i on p.ID_PEDIDO = i.ID_PEDIDO where p.VENDEDOR = '{$_SESSION['usuario']}' order by p.ID_PEDIDO DESC limit 1");
$resultado_verifica = $verifica_cli->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_verifica as $chave=> $registro){

}
if ($registro['NOME_CLIENTE'] == 'CLIENTE INDEFINIDO'){
    // $_SESSION['INSIRA_CLIENTE'] = true;
	// header('Location: ../venda.php');
	// exit();
}


$valor1 = $_POST['codbarra'];

if (strpos($valor1, ",") !== false) {
$valor = str_replace(",",".","$valor1") ;
}else{
    $valor = $valor1;
}
if (strpos($valor,"/") !== false) {
    echo "usaremos o codigo interno";
}else{
    echo "usaremos codigo de barras";
}

$completa_cod = '00000000000000';

if (strpos($valor,"*") !== false) {
    // "é um produto multiplicativo";
    // valida quando o produto tem fator multiplicativo
    $cod_produto = explode('*',$valor);
    $qtd_processado = $cod_produto['0'];
    $cod_processado = $cod_produto['1'];
    $cod_processado_completo = substr($completa_cod . $cod_processado,-14);
    $consulta_sqlite = $pdo->query("SELECT count(*) as total FROM produtos where produtos.CODBARRA = '{$cod_processado_completo}' and produtos.ID_EMPRESA = 1");
    $produto = $consulta_sqlite->fetchAll(PDO::FETCH_ASSOC);
    foreach($produto as $row => $produtos){
        $total = $produtos['total'];
    }
    if($total == 0){
        // "produto de balança não cadastrado";
        // $_SESSION['produto_nao_encontrado'] = true;
        // header('Location: ../venda.php');
        // exit();
    }else if($total == 1){
        // "encontramos $total registro no banco de dados";
        $inclui_produto = $pdo->query("SELECT produtos.ID_PRODUTO,produtos.CODBARRA,produtos.DESCRICAO,produtos.UNIDADE,produtos.UNITARIO FROM produtos where produtos.CODBARRA = '{$cod_processado_completo}' and produtos.ID_EMPRESA = 1");
        $executei = $inclui_produto->fetchAll(PDO::FETCH_ASSOC);
        foreach($executei as $row => $produtos){
            $id_produto = $produtos['ID_PRODUTO'];
            $codbarra = $produtos['CODBARRA'];
            $descricao = $produtos['DESCRICAO'];
            $unitario = $produtos['UNITARIO'];
            $unidade = $produtos['UNIDADE'];
            // $id_produto;
            // "<br>";
            // $codbarra;
            // "<br>";
            // $descricao;
            // "<br>";
            // $unidade;
            // "<br>";
            // $unitario;
            // "<br>";
            // $unidade;
        //*************************************BUSCA PERCENTUAL DO PERFIL DO CLIENTE CASO TENHA SIDO CONFIGURADO NO SIA

        $busca_valor_perfil= $db_prod->query("SELECT t.PORCENTAGEM_ACRESCIMO,t.PORCENTAGEM_DESCONTO from TMPPEDIDOS t where t.ID_PEDIDO = {$_SESSION['id_ultimo_pedido']}");
        $resultado_perfil = $busca_valor_perfil->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultado_perfil as $id=> $percentual){
        }
        //************************************VERIFICA SE TEM ACRESCIMO OU DESCONTO NO CADASTRO DO CLIENTE
        if($percentual['PORCENTAGEM_ACRESCIMO'] <> 0){
            // "perfil de acrescimo encontrado";
            $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto} and produtos.ID_EMPRESA = 1");
            $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $row=> $registros){
            }
            $valor_com_acrescimo = $registros['UNITARIO'] * $qtd_processado * $percentual['PORCENTAGEM_ACRESCIMO'] / 100;
            $valor_total = $registros['UNITARIO'] * $qtd_processado + $valor_com_acrescimo;
            $valor_unidade = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_ACRESCIMO'] / 100;
            $valor_unitario_total = $registros['UNITARIO'] + $valor_unidade;

        }else if($percentual['PORCENTAGEM_DESCONTO'] <> 0){
            // "perfil de desconto encontrado";
            $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto} and produtos.ID_EMPRESA = 1" );
            $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $row=> $registros){
            }
            $valor_com_desconto = $registros['UNITARIO'] * $qtd_processado * $percentual['PORCENTAGEM_DESCONTO'] / 100;
            $valor_total = $registros['UNITARIO'] * $qtd_processado - $valor_com_desconto;
            $valor_unidade = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_DESCONTO'] / 100;
            $valor_unitario_total = $registros['UNITARIO'] - $valor_unidade;

        }else{
            //"PODEMOS USAR O VALOR PADRÃO DA TABELA DE CLIENTES DO SIA SEM O PERFIL DE CLIENTES";
            // SE CASO ELE NÃO ENCONTRAR NENHUM VALOR NA TABELA REFERENTE A ACRESCIMO OU DESCONTO, ELE VAI USAR O VALOR PADRAO DO PRODUTO PRESENTE NA TABELA PRODUTOS
                $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto} and produtos.ID_EMPRESA = 1");
                $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultado as $row=> $registros){
                }
                $valor_unitario_total = $registros['UNITARIO'];
                $valor_total = $qtd_processado * $unitario;
            }
        }              
        $sql = "INSERT INTO TMPITENS_PEDIDO (ID_PEDIDO, ID_EMPRESA, ID_PRODUTO, QTD, UNITARIO, DESCONTO, TOTAL, DADOADICIONAL, DESCRICAO, PRECOINICIAL, ID_TONALIDADE, UNITARIOBASE, EMPROMOCAO, DESPESAS_BOLETO, VENDEDOR ) VALUES ({$_SESSION['id_ultimo_pedido']}, '1', {$id_produto}, {$qtd_processado}, {$valor_unitario_total}, '0.0', {$valor_total}, '', '{$descricao}', {$valor_unitario_total}, '0', {$valor_unitario_total}, 'N', '0', '{$_SESSION['usuario']}')";
        // $db_prod->exec($sql);
        // header('Location: ../venda.php');
        // exit();

}else{
    // $_SESSION['tamanho-campo-invalido'] = true;
    // header('Location: ../venda.php');
    // exit();
    // "Produto invalido, codbarra menor que o permitido!";
}


}else{
    // VALIDAÇÃO CRIADA PARA PRODUTO DE BALANÇA 6 E CONTEM PREÇO
    $valida_balanca = substr($valor, 0, 1);
    
    // CONFIGURAÇÃO PARA 6 E CONTEM PREÇO
    if ($valida_balanca == 2) {
        //"esse produto é de balanca!";
        $completa_cod = '00000000000000';
        $gera_cod_prod = substr($valor, 1, 6);
        $prod_cod_sis = substr($completa_cod . $gera_cod_prod, -14); // codigo do produto para pesquisar sia
        $gera_val = substr($valor, -6);
        $gera_val1 = substr($valor, -6, -1);
        $gera_val2 = substr($valor, -3, -1); // centavos
        $gera_val3 = substr($valor, -6, -3); // real
        $gera_valor_final = "$gera_val3" . "." . "$gera_val2";
        $v_prod = ltrim($gera_valor_final, "0"); //valor do cupom

        $consulta_sqlite = $pdo->query("SELECT count(*) as total FROM produtos where produtos.CODBARRA = '{$prod_cod_sis}' and produtos.ID_EMPRESA = 1");
        $produto = $consulta_sqlite->fetchAll(PDO::FETCH_ASSOC);
        foreach ($produto as $row => $produtos) {
            $total = $produtos['total'];
        }
        if ($total == 0) {
            // "produto não encontrado";
            // $_SESSION['produto_nao_encontrado'] = true;
            // header('Location: ../venda.php');
            // exit();
        }else if($total == 1){
            //"produto encontrado no banco de dados";
            // "encontramos $total registro no banco de dados";
            $inclui_produto = $pdo->query("SELECT produtos.ID_PRODUTO,produtos.CODBARRA,produtos.DESCRICAO,produtos.UNIDADE,produtos.UNITARIO FROM produtos where produtos.CODBARRA = '{$prod_cod_sis}' and produtos.ID_EMPRESA = 1");
            $executei = $inclui_produto->fetchAll(PDO::FETCH_ASSOC);
            foreach($executei as $row => $produtos){
                $id_produto = $produtos['ID_PRODUTO'];
                $codbarra = $produtos['CODBARRA'];
                $descricao = $produtos['DESCRICAO'];
                $unitario = $produtos['UNITARIO'];
                $unidade = $produtos['UNIDADE'];
                // echo $id_produto;
                // echo "<br>";
                // echo $codbarra;
                // echo "<br>";
                // echo $descricao;
                // echo "<br>";
                // echo $unidade;
                // echo "<br>";
                // echo $unitario;
                // echo "<br>";
                // echo $unidade;
            }
            $peso_prod =  round($v_prod / $unitario, 3) ;
            $sql = "INSERT INTO TMPITENS_PEDIDO (ID_PEDIDO, ID_EMPRESA, ID_PRODUTO, QTD, UNITARIO, DESCONTO, TOTAL, DADOADICIONAL, DESCRICAO, PRECOINICIAL, ID_TONALIDADE, UNITARIOBASE, EMPROMOCAO, DESPESAS_BOLETO, VENDEDOR) VALUES ({$_SESSION['id_ultimo_pedido']}, '{$_SESSION['ID_EMPRESA']}', {$id_produto}, {$peso_prod}, {$unitario}, '0.1', {$v_prod}, '', '{$descricao}', {$unitario}, '0', {$unitario}, 'N', '0', '{$_SESSION['usuario']}')";
            // $db_prod->exec($sql);
            // header('Location: ../venda.php');
            // exit();
        };
    }else{ //USA QUANDO O PRODUTO É UM PRODUTO NORMAL E NÃO É UM CODIGO DE BALANÇA OU PRODUTO MULTIPLICATIVO
        // "produto sem fator multiplicativo";
        $codigo_prod_completo = substr($completa_cod . $valor, -14);
        $consulta_sqlite = $pdo->query("SELECT count(*) as total FROM produtos where produtos.CODBARRA = '{$codigo_prod_completo}' and produtos.ID_EMPRESA = 1");
        $produto = $consulta_sqlite->fetchAll(PDO::FETCH_ASSOC);
        foreach($produto as $row => $produtos){
            $total = $produtos['total'];
        }
        if($total == 0){
            //"produto não cadastrado";
            // $_SESSION['produto_nao_encontrado'] = true;
            // header('Location: ../venda.php');
            // exit();
        }else if($total == 1){
            //"encontramos $total registro no banco de dados";
            $inclui_produto = $pdo->query("SELECT produtos.ID_PRODUTO,produtos.CODBARRA,produtos.DESCRICAO,produtos.UNIDADE,produtos.UNITARIO FROM produtos where produtos.CODBARRA = '{$codigo_prod_completo}' and produtos.ID_EMPRESA = 1");
            $executei = $inclui_produto->fetchAll(PDO::FETCH_ASSOC);
            foreach($executei as $row => $produtos){

                $id_produto = $produtos['ID_PRODUTO'];
                $codbarra = $produtos['CODBARRA'];
                $descricao = $produtos['DESCRICAO'];
                $unitario = $produtos['UNITARIO'];
                $unidade = $produtos['UNIDADE'];
                // $id_produto;
                // "<br>";
                // $codbarra;
                // "<br>";
                // $descricao;
                // "<br>";
                // $unidade;
                // "<br>";
                // $unitario;
                // "<br>";
                // $unidade;

                //*************************************BUSCA PERCENTUAL DO PERFIL DO CLIENTE CASO TENHA SIDO CONFIGURADO NO SIA

                $busca_valor_perfil= $db_prod->query("SELECT t.PORCENTAGEM_ACRESCIMO,t.PORCENTAGEM_DESCONTO from TMPPEDIDOS t where t.ID_PEDIDO = {$_SESSION['id_ultimo_pedido']}");
                $resultado_perfil = $busca_valor_perfil->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultado_perfil as $id=> $percentual){
                }
                //************************************VERIFICA SE TEM ACRESCIMO OU DESCONTO NO CADASTRO DO CLIENTE
                if($percentual['PORCENTAGEM_ACRESCIMO'] <> 0){
                    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto} and produtos.ID_EMPRESA = 1");
                    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
                    foreach($resultado as $row=> $registros){
                    }
                    $valor_com_acrescimo = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_ACRESCIMO'] / 100;
                    $valor_total = $registros['UNITARIO'] + $valor_com_acrescimo;
                }else if($percentual['PORCENTAGEM_DESCONTO'] <> 0){
                    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto} and produtos.ID_EMPRESA = 1");
                    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
                    foreach($resultado as $row=> $registros){
                    }
                    $valor_com_desconto = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_DESCONTO'] / 100;
                    $valor_total = $registros['UNITARIO'] - $valor_com_desconto;
                }else{
                    //"PODEMOS USAR O VALOR PADRÃO DA TABELA DE CLIENTES DO SIA SEM O PERFIL DE CLIENTES";
                    // SE CASO ELE NÃO ENCONTRAR NENHUM VALOR NA TABELA REFERENTE A ACRESCIMO OU DESCONTO, ELE VAI USAR O VALOR PADRAO DO PRODUTO PRESENTE NA TABELA PRODUTOS
                        $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$id_produto} and produtos.ID_EMPRESA = 1");
                        $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
                        foreach($resultado as $row=> $registros){
                        }
                        $valor_total = $registros['UNITARIO'];
                    }

            }
            $sql = "INSERT INTO TMPITENS_PEDIDO (ID_PEDIDO, ID_EMPRESA, ID_PRODUTO, QTD, UNITARIO, DESCONTO, TOTAL, DADOADICIONAL, DESCRICAO, PRECOINICIAL, ID_TONALIDADE, UNITARIOBASE, EMPROMOCAO, DESPESAS_BOLETO, VENDEDOR) VALUES ({$_SESSION['id_ultimo_pedido']}, {$_SESSION['ID_EMPRESA']}, {$valor_total}, 1, {$valor_total}, '0', {$valor_total}, '', '{$descricao}', {$valor_total}, '0', {$valor_total}, 'N', '0', '{$_SESSION['usuario']}')";
            // $db_prod->exec($sql);
            // header('Location: ../venda.php');
            // exit();
        };
    }
}



?>