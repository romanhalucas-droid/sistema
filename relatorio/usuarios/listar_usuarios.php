<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';

if(!empty($_GET)){//verificando se esta recebendo uma requisição GET
    $modelo = $_GET['modelo']; //recebe o modelo selecionado pelo usuario
    
    if($modelo==1){//verifica se o modelo selecionado é igual a 1
        //incluir a pagina do modelo correspondente
        include $_SERVER['DOCUMENT_ROOT']."/html/sistema/relatorio/usuarios/listar_usuarios/modelo1.php";
    }else{
        echo "Modelo inválidoo";
    }
}else{
    echo "Requisição inválida.";
}