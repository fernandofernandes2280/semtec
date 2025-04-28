

$(document).ready(function() {
	

	//Codigo ajax requisição MVC
	$("body").on("click", "[data-action]", function(e){
		e.preventDefault();
		var data = $(this).data();
		
		
		$.post(data.action,data,function(name){
			
			alert(name);
		
			
			
		},"json").fail(function(){
			console.log("erro");
		});
	});
	
	
	//executa os comandos SQl no Tutorial
	   $("#executar").click(function (){ 
       var form = new FormData($("#formresposta")[0]);
       $.ajax({
           url: '{{URL}}../../../app/Controller/Ajax/TreineSql.php',
           type: 'post',
           dataType: 'json',
           cache: false,
           processData: false,
           contentType: false,
           data: form,
           timeout: 8000,
           success: function(resultado){
           
              //mostra resultado no textArea resultado
               $("#resultado").html(resultado[0]);
               
               //Imprime nome do banco selecionado na tela
               if(resultado[3] == 'use')
               $("#banco").text(resultado[1]);
               
               //recebe o valor do txtArea para mudar a cor para(verde ou vermelho)
              var mensagem = document.getElementById("resultado").value;
              var textArea = document.getElementById("resultado");
              
               // faz a comparacao aqui
               if ((resultado[0] == "Comando executado com Sucesso!") || (resultado[0].substr(1, [5])=="table")){
                   textArea.style.color = "green";
                   textArea.style.background = "#98FB98";

			 //Caso o banco não possua tabelas, exibe essa mensagem	
			  if(resultado[3] == "showtables") 	$("#resultado").html(resultado[0]+'<br>'+resultado[2]);

			//limpa o nome do banco atual caso este tenha sido excluído
               if(resultado[3] == "dropBancoAtual")
               $("#banco").text("");	

             }else{
                       textArea.style.color = "red";
                       textArea.style.background = "#e4b9b9";
                    }
           }
       });
    });
	
	//Limpa o text area resposta	
	$("#limpar").click(function (){
		 $('#resposta').val('');
	}); 
	

    //aciona o botão de limpar com a tecla ESC
	 document.onkeyup=function(e){
        if(e.which == 27){
            $('#limpar').click();
            return false;
        }
    }
	
	 //aciona o botão de Executar
	 document.onkeyup=function(e){
        if(e.which == 113){
            $('#executar').click();
            return false;
        }
    }

	$(document).ready(function(){
  $("executar1").click(function(event){
    event.preventDefault();
  });
});
	
	})










