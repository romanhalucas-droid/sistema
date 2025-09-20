<?php
if(!isset($_SESSION)){//SE NÃO TIVER NENHUM CONTEUDO NA SESSÃO
    session_start();
}

if(!isset($_SESSION['logadoform']) OR $_SESSION['logadoform']==false){
    ?><script nonce>location.href = "/html/sistema/view/login/";</script><?php
}

require $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/plugin/vendor/autoload.php";
require $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/conexao/conexao.php";
require $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/UsuariosDAO.php";
require $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/Funcoes.php";