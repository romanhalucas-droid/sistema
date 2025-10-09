<?php
require $_SERVER['DOCUMENT_ROOT']."/html/sistema/obj/Convidados.php";

use Ramsey\Uuid\Uuid;

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
            $obj->setUsuarios(UsuariosDAO::selectIndex(['conn' => $conn, 'id' => $ln['idusuario']])[0]);           
            
            return $obj;
        } catch (Exception $ex) {
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
    
    ///////////////////////////////////
    //SELECIONAR POR ID
    ///////////////////////////////////
    public static function selectIndex($array){
        try{ 
            //$conn = !empty($array['conn']) ? $array['conn'] : throw new Exception('A conexão não foi aberta!');            
            $conn = verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            $id = !empty($array['id']) ? $array['id'] : null;
            
            $sql = $conn->prepare("SELECT * FROM convidados obj WHERE obj.id = :id");
            $sql->bindValue(":id", $id);
            
            $sql->execute();
            
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $objs = array();
            
            foreach ($resultado as $ln){             
                $objs[] = self::estruturarSQL($conn, $ln);
            }
            
            return $objs;
            
        } catch (Exception $ex) {
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
    
    ////////////////////////
    //SELECIONAR TODOS
    ////////////////////////
    public static function selectAll($array){
        try{ 
            $conn = verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            
            $sql = $conn->prepare("SELECT * FROM convidados obj");
            
            $sql->execute();
            
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $objs = array();
            
            foreach ($resultado as $ln){             
                $objs[] = self::estruturarSQL($conn, $ln);
            }
            
            return $objs;
            
        } catch (Exception $ex) {
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
    
    ///////////////////////////////////////////////
    //salvar
    ////////////////////////////////////////////////
    public static function save($array){
        try{            
            $conn = verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            $obj = verExpection(!empty($array['obj']), $array['obj'], 'O objeto não existe!');
            
             //id nome celular confirmado dtExpiracao vistoPorUltimo
            if($obj->getId()>0){
                //ATUALIZAR
                $sql = "UPDATE convidados SET";
                $sql = $conn->prepare($sql);
                $sql->bindValue(":id", $obj->getId());
            }else{
                //CRIAR
                $sql = "INSERT INTO convidados() "
                        . "VALUES ()";
                $sql = $conn->prepare($sql);
            }
            
            $sql->bindValue(":nome", $obj->getNome());//RELACIONAR OBJETO COM PARAMETROS DO BANCO DE DADOS       
            
            if($sql->execute()){
                $id = empty($obj->getID()) ? $conn->lastInsertId() : $obj->getId();
                return $id;
            }else{
                return false;
            }            
            
        } catch (Exception $ex) {            
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
    
    
  ////////////////////fim da classe  
}