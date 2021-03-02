<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"> 
    <title>Drag e Drop // S3ND</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<!DOCTYPE html>
<html>
<head>
 	<link href="css/jquery-ui.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="dd">
  <div id="divGeral" class="droppable">

  </div>
</div>
<div>
  <p><button id="reordenar">Reordenar</button></p>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () { 

    	/**
    	 * FUNÇÃO PARA PEGAR OS IDS
    	 * DAS DIVS EM ORDEM
    	 */
    	function Dropped(event, ui){
	        var list = $(".draggable").map(function () {
			      return $(this).attr("id");
		    }).get().join("");

		    /**
		     * VERIFICA SE A ORDEM É 321 E ENVIA
		     * UM POST PARA ATUALIZAR OS MINUTOS 
		     * PARA 99
		     */
	        if(list == 312){
	        	$.post("handle.php", {action: 'tempoDIV'},   function (data) {});
	        }
	    }

	    /**
	     * FUNÇÃO PARA CRIAR AS DIVS
	     */
	    function criarDiv(n){
	    	var divs = "";
	    	for(var i = 1; i <= n;++i) {
	    		divs += '<div id="'+i+'" class="draggable">'+i+'</div>';
	    	}
	    	$("#divGeral").append(divs);

	    	/**
	    	 * INICIALIZANDO A FUNÇÃO DO DROP
	    	 */
	    	$(".droppable").sortable({
	      		update: function( event, ui ) {
	        		Dropped();
	      		}
	 		});
	    }

	    /**
	     * CHAMADA DA FUNÇÃO
	     * COM O NUMERO DE DIVS
	     */
	    criarDiv(3);

	    /**
	     * REORDENAR AS DIVS
	     * REMOVE E CRIA NOVAMENTE
	     */
      	$("#reordenar").mouseover(function(){
      		$(".draggable").each(function(){
	        	$(this).detach();
	      	});
	      	criarDiv(3);
      	});
  });
</script>
</body>
</html>