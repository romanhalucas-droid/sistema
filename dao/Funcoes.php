<?php

function dtSqlToBrasil($data) {
    if (!empty($data)) {
        $temp = explode("-", $data);
        return "{$temp[2]}/{$temp[1]}/{$temp[0]}";
    } else {
        return "";
    }
}

function dtBrasilToSql($data) {
    if (!empty($data)) {
        $temp = explode("/", $data);
        return "{$temp[2]}-{$temp[1]}-{$temp[0]}";
    } else {
        return "";
    }
}

function deixarNumero($string) {
    return !empty($string) ? preg_replace("/[^0-9]/", "", $string) : NULL;
}

function verException($logica, $valor, $message){
    if($logica){
        return $valor;
    }else{
        throw new Exception($message);
    }
}

function getDatetimeNow(){
    $dtz = new DateTimeZone("America/Sao_Paulo"); //pegar fuso
    $dt = new DateTime("now", $dtz); //pegar data e hora atual de acordo com o fuso
    return $dt->format("Y-m-d H:i:s");
}

function saudacao(){
    date_default_timezone_set('America/Sao_Paulo');
    $hora = date('H');
    if($hora >= 5 AND $hora < 12){
        return 'Bom dia';
    }else if($hora>=12 AND $hora<18){
        return 'Boa tarde';
    }else{
        return 'Boa noite';
    }
}
