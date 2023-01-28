<?php
include('../login/verifica_login.php');
	//Incluir a conexão com banco de dados
	$pdo = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SIA/sia');
	$db_prod = new PDO('sqlite:../DB/'.$_SESSION['cnpj'].'/DB-SISTEMA/'.$_SESSION['ID'].'');
	//Recuperar o valor da palavra
	$cursos = $_POST['palavra'];
	
	//Pesquisar no banco de dados nome do curso referente a palavra digitada pelo usuário
	$sth = $pdo->prepare("SELECT substr(p.DESCRICAO,1, 20) AS DESCRI,p.* from produtos p where p.DESCRICAO like '%{$cursos}%' and p.ID_EMPRESA = 1 limit 10");
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
    $t = count($result);

	if(count($result) <= 0){
		echo "<h1 class='id_modal_prods'>"."Nenhum produto encontrado... "."</h1>";
	}else{ ?> 
		<!-- <table>
			<tr>
				<th class="titulo_cod_modal_prod"><h2>COD</h2></th>
				<th class="titulo_desc_modal_prod"><h2>DESCRIÇÃO</h2></th>
				<th class="titulo_un_modal_prod"><h2>UN</h2></th>
				<th class="titulo_unitario_modal_prod"><h2>VALOR</h2></th>
			</tr>
		</table> -->
	<?php

		foreach($result as $row=> $rows){
//*************************************BUSCA PERCENTUAL DO PERFIL DO CLIENTE CASO TENHA SIDO CONFIGURADO NO SIA

$busca_valor_perfil= $db_prod->query("SELECT t.PORCENTAGEM_ACRESCIMO,t.PORCENTAGEM_DESCONTO from TMPPEDIDOS t where t.ID_PEDIDO = {$_SESSION['id_ultimo_pedido']}");
$resultado_perfil = $busca_valor_perfil->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado_perfil as $id=> $percentual){
}
//************************************VERIFICA SE TEM ACRESCIMO OU DESCONTO NO CADASTRO DO CLIENTE
if($percentual['PORCENTAGEM_ACRESCIMO'] <> 0){
    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$rows['ID_PRODUTO']}");
    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $row=> $registros){
    }
    $valor_com_acrescimo = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_ACRESCIMO'] / 100;
    $valor_total = $registros['UNITARIO'] + $valor_com_acrescimo;
}else if($percentual['PORCENTAGEM_DESCONTO'] <> 0){
    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$rows['ID_PRODUTO']}");
    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $row=> $registros){
    }
    $valor_com_desconto = $registros['UNITARIO'] * 1 * $percentual['PORCENTAGEM_DESCONTO'] / 100;
    $valor_total = $registros['UNITARIO'] - $valor_com_desconto;
}else{
//"PODEMOS USAR O VALOR PADRÃO DA TABELA DE CLIENTES DO SIA SEM O PERFIL DE CLIENTES";
// SE CASO ELE NÃO ENCONTRAR NENHUM VALOR NA TABELA REFERENTE A ACRESCIMO OU DESCONTO, ELE VAI USAR O VALOR PADRAO DO PRODUTO PRESENTE NA TABELA PRODUTOS
    $sql_busca_produto_banco_sia = $pdo->query("SELECT * FROM PRODUTOS where ID_PRODUTO = {$rows['ID_PRODUTO']}");
    $resultado = $sql_busca_produto_banco_sia->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $row=> $registros){
    }
	$valor_total = $registros['UNITARIO'];
}				
			?>
		
			<tr>
				<br>
				<div class="modal_prod_pesq">
					<div class="id_modal_prods">
						<td><strong><?php echo $rows['ID_PRODUTO'];?> - </strong></td>
					</div>
					<div class="desc_modal_prods">
						<td><strong> <?php echo $rows['DESCRI'];?></strong></td>
					</div>
					<div class="unid_modal_prods">
						<td><strong><?php echo $rows['UNIDADE'];?></strong></td>
					</div>
					<div class="unit_modal_prods">
						<td><strong><?php echo str_replace(".",",",$valor_total) ;?></strong></td>
					</div>
					<div class="botao_inserir_modal_prod">
						<td><a href="./processamento/insere_item_grid.php?id=<?php echo $rows['ID_PRODUTO']?>"><button id="meubotao">INSERIR</button></a></td>
					</div>
				</div>
				<hr>
			</tr>
		<?php
		}
	}
?>
