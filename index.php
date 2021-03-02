<?php 
/**
 * INICINANDO A SESSION
 */
session_start();
/**
 * VERIFICANDO E EXISTE O TEMPO VIA SESSION
 */
if(isset($_SESSION['tempo']) and $_SESSION['tempo'] >= 0){
    /**
     * RESGATA O TEMPO DA SESSION
     */
    $tempo = $_SESSION['tempo'];
}else{
    /**
     * VALIDA E PEGA O TEMPO DA URL
     * TRANSFORMA O TEMPO EM MILISSEGUNDOS
     */
    $tempo =  (isset($_GET['tempo']) and !empty($_GET['tempo']) and is_numeric($_GET['tempo']) and $_GET['tempo'] > 0) ? $_GET['tempo']*60*1000 : '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cronômetro // S3ND</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"> 
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div id="relogio" style="display:none">
  <h1>Cronômetro</h1>
  <div>
    <span class="dias"></span>
    <div class="descricao">dias</div>
  </div>
  <div>
    <span class="horas"></span>
    <div class="descricao">horas</div>
  </div>
  <div>
    <span class="minutos"></span>
    <div class="descricao">minutos</div>
  </div>
  <div>
    <span class="segundos"></span>
    <div class="descricao">segundos</div>
  </div>
</div>
<div>
  <p><button id="destroy" style="display:none">Zerar Cronômetro</button></p>
</div>
<div id="error" style="display:none"><h1>Por favor, entre com um tempo em minutos válido. <br /> Ex: ?tempo=60</h1></div>
<input type="hidden" id="tempo" value="<?php echo $tempo; ?>">
<audio class="hide" id="sound"><source src="sounds/plim.mp3" type="audio/mp3" muted></audio>
<div id="playSound" class="hide" onclick="document.getElementById('sound').play()"></div>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () { 

        /**
         * FUNÇÃO PARA CHECAR O TEMPO VIA URL
         */
        function checaURL(){
          if($("#tempo").val() != ""){
            $("#relogio, #destroy").removeAttr("style");
            return true;
          }else{
            $("#error").removeAttr("style");
            return false;
          }
        }

        /**
         * FUNÇÃO PARA INICIALIZAR O RELÓGIO
         */
        function inicializaRelogio(prazoFinal) {

            function atualizaRelogio() {
              const t = tempoRestante(prazoFinal);
              if (t <= 0) {
                setInterval(() => {$("#playSound").trigger("click")}, 1000);
                clearInterval(window.intervalo);
              }
              return t;
            }

            atualizaRelogio();
            window.intervalo = setInterval(atualizaRelogio, 1000);
        }


        /**
         * FUNÇÃO PARA CALCULAR O TEMPO RESTANTE
         * E EXIBIR NA PAGINA HTML
         */
       	function tempoRestante(prazoFinal) {
  			  var total = Date.parse(prazoFinal) - Date.parse(new Date());
          $.post("handle.php", {action: 'tempoRestante',total:total},   function (data) { 
              var result = JSON.parse(data);
              if(result.reiniciar == 1){
                $("#tempo").val(result.total);
                clearInterval(window.intervalo);
                init();
              }else{
                if(result.total >= 0){
                  $('.dias').text(result.dias);
                  $('.horas').text(('0' +result.horas).slice(-2));
                  $('.minutos').text(('0' + result.minutos).slice(-2));
                  $('.segundos').text(('0' + result.segundos).slice(-2));
                  document.title = $('.dias').text() + "d " + $('.horas').text() + ":" + $('.minutos').text() + ":" + $('.segundos').text();
                  $("#tempo").val(result.total);
                }
              }
          });
          return $("#tempo").val();
			  }

        /**
         * FUNÇÃO PRINCIPAL
         * TEMPO EM MILISSEGUNDOS
         */
        function init(){
          var dataAtual = Date.parse(new Date());
          var prazoFinal = new Date(dataAtual);
          prazoFinal.setMilliseconds($("#tempo").val());
          inicializaRelogio(prazoFinal);
        }

        /**
         * CHECANDO A URL
         */
        var aURL = checaURL();

        /**
         * SE A URL FOR VÁLIA CONTINUA O PROCESSO
         */
        if(aURL){
            init();
        }

        /**
         * ZERAR O RELOGIO
         */
        $('#destroy').click(function(){
            $.post("handle.php", {action: 'destroy'},   function (data) {
                window.location.href="index.php"
            });
        });

    });
</script>
</body>
</html>