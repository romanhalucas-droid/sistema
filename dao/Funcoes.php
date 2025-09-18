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
