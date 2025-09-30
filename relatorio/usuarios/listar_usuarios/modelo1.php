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

//ABRIR CONEXÃO
require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";

//CARREGAR USUÁRIOS
$usuarios = UsuariosDAO::selectAll([
   'conn' => $conn_db    
]);

//FECHAR CONEXÃO
require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";

$css .= "
    @page {
        margin: 30px 50px 50px 50px;
    }
    ";

$head .= "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Listar usuários - Modelo 1</title>
        <style>{$css}</style>
    </head>
    <body>
    ";

// id, nome, cpf, datanasc, contato1, email, usuario, senha, sexo 
$body .= "
    <h1>Listagem de usuários</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data de nascimento</th>
                <th>Contato 1</th>
                <th>E-mail</th>
                <th>Usuário</th>
                <th>Sexo</th>
            </tr>
        </thead>
        <tbody>
    ";

//PERCORRER TODOS OS USUÁRIOS
foreach($usuarios as $u){
    $body .= "<tr>
            <td>{$u->getNome()}</td>
            <td>{$u->getCpf()}</td>
            <td>{$u->getDatanasc()}</td>
            <td>{$u->getContato1()}</td>
            <td>{$u->getEmail()}</td>
            <td>{$u->getUsuario()}</td>
            <td>{$u->getSexo()}</td>
           </tr>
        ";
}

$body .= "
        </tbody>
    </table>
    ";

$rodape .= "</body></html>";
$html = $head . $body . $rodape;
$dompdf->loadHtml($html); //CARREGANDO O HTML NO DOMPDF
$dompdf->setPaper('A4', 'portrait'); //TIPO E ORIENTAÇÃO DE PAPEL
$dompdf->render(); //CRIAR O MEU PDF
$dompdf->stream('listar_usuarios_modelo1.pdf', ["Attachment" => 0]); //EXIBIR EM TELA O PDF