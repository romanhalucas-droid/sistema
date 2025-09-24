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

$head = ""; //INICAR CABECALHO
$css = "";
$body = "";
$rodape = "";
$html = ""; //INICIAR VARIAVEL HTML


$css .= "
    @page {
            margin: 30px 50px 50px 50px;
        }
    body{
        font-family: Arial;                
    }
    h1{
        text-align: center;
        font-weight: bold;
    }
    p{
        font-size: 20px;
        text-align: justify;
    }
    #footer {
        position: fixed;
        bottom: 0;       
        right: 0;
        /*width: 100%;*/
        text-align: center;
        /*border-top: 1px solid gray;*/
    }
    
    #footer .page:after{         
        content: counter(page); 
    }
    ";

$head .= "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Relatório para teste</title>
        <style>{$css}</style>
    </head>
    <body>
    ";

$body .= "      
        <h1>Estou testando meu PDF no SENAC</h1>
        <p>É muito legal testar PDF usando dompdf</p>      
    ";

$rodape .= "   
        <div id='footer'><p class='page'></p></div>
        </body>        
        </html>
    ";

$html .= $head . $body . $rodape;

$dompdf->loadHtml($html); //CARREGANDO O HTML NO DOMPDF
$dompdf->setPaper('A4', 'portrait'); //TIPO E ORIENTAÇÃO DE PAPEL
$dompdf->render(); //CRIAR O MEU PDF
$dompdf->stream('teste.pdf', ["Attachment" => 0]); //EXIBIR EM TELA O PDF

