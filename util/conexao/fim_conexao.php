<?php
try{
    if($conn_db){
        $conn_db = null;
    }
} catch (Exception $ex) {
    echo "ERRO: {$ex->getMessage()}";
}