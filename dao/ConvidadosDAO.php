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
            if(!empty($obj->getId())){
                //ATUALIZAR
                $sql = "UPDATE convidados SET id=:id, nome=:nome, celular=:celular, confirmado=:confirmado, idusuario=:idusuario,"
                        . " dtExpiracao=:dtExpiracao, vistoPorUltimo=:vistoPorUltimo WHERE id=:id";
                $sql = $conn->prepare($sql);
                $sql->bindValue(":id", $obj->getId());
                $uuid = $obj->getId(); //NOVO
            }else{
                //CRIAR
                $sql = "INSERT INTO convidados(id, nome, celular, confirmado, dtExpiracao, vistoPorUltimo, idusuario) "
                        . "VALUES (:id, :nome, :celular, :confirmado, :dtExpiracao, :vistoPorUltimo, :idusuario)";
                $sql = $conn->prepare($sql);
                $uuid = Uuid::uuid4(); //NOVO: GERAR UUID(CÓDIGO ALEATÓRIO)
                $sql->bindValue(':id', $uuid->toString());//NOVO
            }
            
            $sql->bindValue(":nome", $obj->getNome());//RELACIONAR OBJETO COM PARAMETROS DO BANCO DE DADOS       
            $sql->bindValue(":celular", $obj->getCelular());   
            $sql->bindValue(":confirmado", $obj->getConfirmado());      
            $sql->bindValue(":dtExpiracao", $obj->getDtExpiracao());    
            $sql->bindValue(":vistoPorUltimo", $obj->getVistoPorUltimo());      
            $sql->bindValue(":idusuario", $obj->getUsuarios()->getId());      
            
            if($sql->execute()){               
                return $uuid; //novo
            }else{
                return false;
            }            
            
        } catch (Exception $ex) {            
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
    
    ///////////////////////////////
    //EXCLUIR
    ///////////////////////////////
    public static function excluir($array){
        try{            
            $conn = self::verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            $obj = self::verExpection(!empty($array['obj']), $array['obj'], 'O objeto não existe!');

            $sql = "DELETE FROM convidados WHERE id=:id"; //MUDANÇA
            $sql = $conn->prepare($sql);
            $sql->bindValue(":id", $obj->getId());

            if($sql->execute()){
                return $obj->getId();
            }else{
                return false;
            }
        } catch (Exception $ex) {
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
    
     public static function selectQtd($array){
       try{
           $conn = self::verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
           $sql = "SELECT count(*) as qtd FROM convidados";
           $sql = $conn->prepare($sql);
           $sql->execute();
           
           $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
           
           foreach ($resultado as $ln){
               return $ln['qtd'];
           }           
           
           return 0;
       } catch (Exception $ex) {
           echo "ERRO: {$ex->getMessage()}";
           return false;
       }
    }
    
  ////////////////////fim da classe  
}