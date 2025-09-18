<?php
function conDB(){
    try{
        $username = "root";
        $password = "root";
        $ip = "127.0.0.1";
        $port = "3306";
        $dbname = "sistema";

        $conn = new PDO(
                "mysql:host={$ip};port={$port};dbname={$dbname}", 
                $username, 
                $password, 
                array(PDO::ATTR_PERSISTENT => true)
                );
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }catch (PDOException $e){
        echo "ERRO: {$e->getMessage()}";
    } catch (Exception $e){
        echo "ERRO: {$e->getMessage()}";
    }
}

function execSQL($sql){
    try{
        return conDB()->prepare($sql);
    }catch (PDOException $e){
        echo "ERRO: {$e->getMessage()}";
    } catch (Exception $e){
        echo "ERRO: {$e->getMessage()}";
    }    
}