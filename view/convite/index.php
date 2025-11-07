<?php
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/conexao/inicio_conexao.php";
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/Funcoes.php";
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/ConvidadosDAO.php";

$id = empty($_GET['id']) ? 0 : $_GET['id'];

if (!empty($id)){
    try{
        
        $convidado = ConvidadosDAO::selectIndex(['conn' => $conn_db, 'id' => $id])[0];
        $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false); //desativando save automático
        
        $convidado->setVistoPorUltimo(getDatetimeNow());
        
        if(ConvidadosDAO::save(['conn' => $conn_db, 'obj' => $convidado])){
            $conn_db->commit();//salvar alteração (visto por ultimo)
        }else{
            $conn_db->rollBack();//desfazer alteração
        }
                
        
    } catch (Exception $e) {
        $conn_db->rollBack();    
        echo $e->getMessage();
    } catch (SQLException $e) {
        $conn_db->rollBack();    
        echo $e->getMessage();
    }finally{
        $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
    }
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>CONVITE: CONFRATERNIZAÇÃO FINAL DE ANO</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/estrutura/cabecalho.php"; ?>
    </head>
    <body class="bg-light">
        <div class="container">
            
        </div>
    </body>
</html>
