<?php

/**
 * INICINANDO A SESSION
 */
session_start(); 

/**
 * AÇÃO QUE ATUALIZA O TEMPO RESTANTE
 */
if (isset($_POST['action']) and $_POST['action'] == 'tempoRestante') { 


    /**
     * VERIFICA SE EXISTE O TEMPO QUE VEIO DA DIV
     */
     $reiniciar = 0;
     if(isset($_SESSION['tempoDIV'])){
        $_POST['total'] = $_SESSION['tempoDIV']*60*1000;
        unset($_SESSION['tempoDIV']);
        $reiniciar = 1;
     }

    /**
     * ATUALIZANDO O TEMPO NA SESSION
     * EM MILISSEGUNDOS
     */
     $_SESSION['tempo'] = $_POST['total'];

    /**
     * CALCULANDO O TEMPO
     */
    $segundos = floor(($_POST['total'] / 1000)  % 60);
    $minutos = floor(($_POST['total'] / 1000 / 60)  % 60);
    $horas = floor(($_POST['total'] / (1000 * 60 * 60)) % 24);
    $dias = floor($_POST['total'] / (1000 * 60 * 60 * 24));

    /**
     * RETORNO
     */
    $results = array(
        "total" => $_POST['total'],
        "dias" => $dias,
        "horas" => $horas,
        "minutos" => $minutos,
        "segundos" => $segundos,
        "reiniciar" => $reiniciar
    );

    /**
     * CONVERT EM JSON
     */
    echo  json_encode($results);
    die;
}

/**
 * AÇÃO QUE DESTROI A SESSION
 */
if (isset($_POST['action']) and $_POST['action'] == 'destroy') { 
    unset($_SESSION['tempo']);
    session_destroy();
}

/**
 * ACÃO PARA SETAR O TEMPO DA DIV
 * EM 99 MINUTOS
 */
if (isset($_POST['action']) and $_POST['action'] == 'tempoDIV') { 
    echo $_SESSION['tempoDIV'] = 99;
    die;
}