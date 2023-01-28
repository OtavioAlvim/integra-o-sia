$(function(){
	//Pesquisar os cursos sem refresh na página
	$("#pesquisa_emitente").keyup(function(){
		
		var pesquisa_emi = $(this).val();
		
		//Verificar se há algo digitado
		if(pesquisa_emi != ''){
			var dadoss = {
				palavras : pesquisa_emi
			}		
			$.post('processamento/busca_emitente.php', dadoss, function(retornar){
				//Mostra dentro da ul os resultado obtidos 
				$(".resultado-emitente").html(retornar);
			});
		}else{
			$(".resultado-emitente").html('');
		}		
	});
});	