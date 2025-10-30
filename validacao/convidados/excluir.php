<?php
//bad + TAB
//BLOQUEAR ACESSO DIRETO AO ARQUIVO
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('location:/html/sistema/view/inicio/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';
require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";

$id = $_POST['id'];

try{
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);//desativar salvamento automático
    $conn_db->beginTransaction(); //INICIAR CONEXÃO DE FORMA MANUAL
    
    $obj = ConvidadosDAO::selectIndex([
       'conn'  => $conn_db,
       'id' => $id
    ])[0];
    
    if(ConvidadosDAO::excluir(['conn' => $conn_db, 'obj' => $obj])){
        //SE CONSEGUIR EXCLUIR ENTÃO...
        $conn_db->commit();//salvar
        ?><div class="alert alert-success" role='alert'>Excluido com sucesso!</div><?php
    }else{
        $conn_db->rollBack();//cancelar exclusão
        ?><div class='alert alert-danger' role='alert'>Algo deu errado ao excluir...</div><?php
    }
    
} catch (PDOException $e) {//EXCESSÃO DO BANCO DE DADOS
    $conn_db->rollBack();
    ?><div class="alert alert-danger" role="alert">ERRO DB: <?=$e->getMessage() ?></div><?php
} catch (Exception $e) {//EXCESSÃO GERAL
    $conn_db->rollBack();
    ?><div class="alert alert-danger" role="alert">ERRO: <?=$e->getMessage() ?></div><?php    
} finally {//INDEPEDENTE DO QUE ACONTECER VAI SER EXECUTADO O FINALLY
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);//ATIVAR SALVAMENTO AUTOMÁTICO
    require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
}