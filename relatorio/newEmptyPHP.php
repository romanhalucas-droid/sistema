<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$option = new Options();
$option->set('isHtml5ParserEnabled', true);
$option->set('isPhpEnabled', true);

$dompdf = new Dompdf($option);

$css = "
    @page {
        margin: 30px 50px 50px 50px;
    }
    body {
        font-family: Arial, sans-serif;
        font-size: 12pt;
        line-height: 1.4;
    }
    h1 {
        text-align: center;
        font-weight: bold;
        font-size: 18pt;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
        font-size: 12pt;
    }
    .header {
        background-color: #d9d9d9;
        font-weight: bold;
    }
    .title {
        font-size: 14pt;
        font-weight: bold;
    }
    #footer {
        position: fixed;
        bottom: 0;
        right: 0;
        text-align: center;
    }
    #footer .page:after {
        content: counter(page);
    }
";

$head = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Relatório para teste</title>
    <style>{$css}</style>
</head>
<body>
";

$body = "
    <h1>REQUISITOS FUNCIONAIS E NÃO FUNCIONAIS</h1>
    <table>
        <tr class='header'>
            <td colspan='3' class='title'>REQUISITOS FUNCIONAIS E NÃO FUNCIONAIS</td>
        </tr>
        <tr class='header'>
            <td>IDENTIFICADOR<br>(RF OU NF)</td>
            <td>REQUISITOS</td>
            <td>PRIORIDADE<br>(ESSENCIAL, IMPORTANTE OU DESEJÁVEL)</td>
        </tr>
        <tr>
            <td>RF01</td>
            <td>O sistema deve permitir que o usuário cadastre o acesso através das contas (Google, iCloud, Microsoft e e-mail)</td>
            <td>IMPORTANTE</td>
        </tr>
        <tr>
            <td>RF02</td>
            <td>O sistema deverá permitir aos clientes criar um perfil com informações de contato e outras informações pessoais.</td>
            <td>ESSENCIAL</td>
        </tr>
    </table>
";

$rodape = "
    <div id='footer'><p class='page'></p></div>
</body>
</html>
";

$html = $head . $body . $rodape;

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('requisitos.pdf', ["Attachment" => 0]); // Mudar para 1 se quiser forçar download
