<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';

//USA O NAMESPACE DO DOMPDF
use Dompdf\Dompdf;
use Dompdf\Options;

//INICIAR O DOMPDF
$option = new Options();
$option->set('isHtml5ParserEnabled', true); //ATIVAR HTML5 NO DOMPDF
$option->set('isPhpEnabled', true); //ATIVAR PHP NO DOMPDF
$dompdf = new Dompdf($option); //INICIANDO O DOMPDF