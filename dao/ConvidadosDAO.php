<?php
require $_SERVER['DOCUMENT_ROOT']."/html/sistema/obj/Convidados.php";

class ConvidadosDAO{
    private static function estruturarSQL($conn, $ln){
        try{
            $obj = new Convidados(null);
            $obj->setId($ln['id']);
            $obj->setNome($ln['nome']);
            $obj->setCelular($ln['celular']);
            $obj->setConfirmado($ln['confirmado']);
            $obj->setDtExpiracao($ln['dtExpiracao']);
            $obj->setVistoPorUltimo($ln['vistoPorUltimo']);           
            $obj->setUsuario(UsuariosDAO::selectIndex(['conn' => $conn, 'id' => $ln['idusuario']])[0]);           
            
            return $obj;
        } catch (Exception $ex) {
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
    
    
}