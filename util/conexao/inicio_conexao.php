<?php
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/conexao/conexao.php";

try{
    $conn_db = conDB();
    
    if($conn_db->inTransaction()){
        $conn_db->rollBack();
    }
    
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
    
} catch (Exception $e) {
    if(isset($conn_db)){
        $conn_db = null;
    }
    echo "ERRO: {$e->getMessage()}";
} catch (PDOException $e){
    if(isset($conn_db)){
        $conn_db = null;
    }
    echo "ERRO: {$e->getMessage()}";
}