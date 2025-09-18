<?php
//BLOQUEAR ACESSO DIRETO AO ARQUIVO
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('location:/html/sistema/view/inicio/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';
require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";

$id = $_POST['id'];

try{        
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false); //DESATIVANDO O SALVAMENTO AUTOMÁTICA
    $conn_db->beginTransaction(); //INICIANDO CONEXÃO MANUALMENTE    
    
    $obj = UsuariosDAO::selectIndex([
       'conn' => $conn_db,
       'id' => $id
    ])[0];
    
    if(UsuariosDAO::excluir(['conn' => $conn_db, 'obj' => $obj])){
        //SE CONSEGUIR EXCLUIR, ENTÃO:
        $conn_db->commit(); //SALVAR
        ?><div class="alert alert-success" role="alert">Excluido com sucesso!</div><?php
    }else{
        $conn_db->rollBack(); //CANCELAR A EXCLUSÃO
        ?><div class="alert alert-danger" role="alert">Algo deu errado ao excluir...</div><?php 
    }
    
} catch (PDOException $e){
    $conn_db->rollBack();
    ?><div class="alert alert-danger" role="alert">ERRO DB: <?= $epdo->getMessage() ?></div><?php
} catch (Exception $e) {
    $conn_db->rollBack();
    ?><div class="alert alert-danger" role="alert"><?= $e->getMessage() ?></div><?php
} finally {
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true); 
    require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
}
