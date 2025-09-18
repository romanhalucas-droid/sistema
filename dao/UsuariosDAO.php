<?php
require $_SERVER['DOCUMENT_ROOT']."/html/sistema/obj/Usuarios.php";

class UsuariosDAO{
    
    private static function estruturarSQL($conn, $ln){
        try{
            $obj = new Usuarios(null);
            $obj->setId($ln['id']);
            $obj->setNome($ln['nome']);
            $obj->setCpf($ln['cpf']);
            $obj->setDatanasc($ln['datanasc']);
            $obj->setContato1($ln['contato1']);
            $obj->setEmail($ln['email']);
            $obj->setUsuario($ln['usuario']);
            $obj->setSenha($ln['senha']);
            $obj->setSexo($ln['sexo']);
            
            return $obj;
        } catch (Exception $ex) {
            echo "ERRO: {$ex->getMessage()}";
            return false;
        }
    }
        
    private static function verExpection($logica, $valor, $message){
        if($logica){
            return $valor;
        }else{
            throw new Exception($message);
        }
    }
    
    public static function selectIndex($array){
        try{ 
            //$conn = !empty($array['conn']) ? $array['conn'] : throw new Exception('A conexão não foi aberta!');            
            $conn = self::verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            $id = !empty($array['id']) ? $array['id'] : null;
            
            $sql = $conn->prepare("SELECT * FROM usuarios obj WHERE obj.id = :id");
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
    
    public static function selectAll($array){
        try{ 
            $conn = self::verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            
            $sql = $conn->prepare("SELECT * FROM usuarios obj");
            
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
    
    public static function save($array){
        try{            
            $conn = self::verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            $obj = self::verExpection(!empty($array['obj']), $array['obj'], 'O objeto não existe!');
            
            if($obj->getId()>0){
                //ATUALIZAR
                $sql = "UPDATE usuarios SET nome=:nome, cpf=:cpf, datanasc=:datanasc, contato1=:contato1,"
                        . "email=:email, usuario=:usuario, senha=:senha, sexo=:sexo WHERE id=:id";
                $sql = $conn->prepare($sql);
                $sql->bindValue(":id", $obj->getId());
            }else{
                //CRIAR
                $sql = "INSERT INTO usuarios(nome, cpf, datanasc, contato1, email, usuario, senha, sexo) "
                        . "VALUES (:nome, :cpf, :datanasc, :contato1, :email, :usuario, :senha, :sexo)";
                $sql = $conn->prepare($sql);
            }
            
            $sql->bindValue(":nome", $obj->getNome());//RELACIONAR OBJETO COM PARAMETROS DO BANCO DE DADOS
            $sql->bindValue(":cpf", $obj->getCpf());
            $sql->bindValue(":datanasc", $obj->getDatanasc());
            $sql->bindValue(":contato1", $obj->getContato1());
            $sql->bindValue(":email", $obj->getEmail());
            $sql->bindValue(":usuario", $obj->getUsuario());
            $sql->bindValue(":senha", $obj->getSenha());
            $sql->bindValue(":sexo", $obj->getSexo());
            
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
    
    public static function excluir($array){
        try{            
            $conn = self::verExpection(!empty($array['conn']), $array['conn'], 'A conexão não foi aberta!');
            $obj = self::verExpection(!empty($array['obj']), $array['obj'], 'O objeto não existe!');

            $sql = "DELETE FROM usuarios WHERE id=:id";
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
           $sql = "SELECT count(*) as qtd FROM Usuarios";
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
}