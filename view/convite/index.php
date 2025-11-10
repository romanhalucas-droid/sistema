<?php
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/conexao/inicio_conexao.php";
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/Funcoes.php";
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/ConvidadosDAO.php";

$id = empty($_GET['id']) ? 0 : $_GET['id'];
$convidado = null;

if (!empty($id)){
    try{
        
        $convidado = ConvidadosDAO::selectIndex(['conn' => $conn_db, 'id' => $id])[0];
        $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false); //desativando save automático
        $conn_db->beginTransaction(); //iniciar conexão manualmente
        
        $convidado->setVistoPorUltimo(getDatetimeNow());
        
        $timeHoje = strtotime(date('Y-m-d')); //convertendo data para formato numérico
        $timeDtExp = strtotime($convidado->getDtExpiracao()); //convertendo data para formato numérico
        
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
            
            <?php if(!empty($convidado) AND !empty($convidado->getId())): ?>
                <!--CONTEÚDO-->
                <div class="card mt-4 mx-auto bg-white border-0 shadow-sm" style="max-width: 600px;">
                    <div class="card-body text-center">

                        <!-- TÍTULO DO CONVITE -->
                        <h4 class="card-title"><?=saudacao()?>, <strong><?=$convidado->getNome() ?></strong>!</h4>
                        <!-- 1 = NÃO RESPONDEU, 2 = NÃO VAI, 3 = CONFIRMADO -->
                        <?php if($convidado->getConfirmado()==2): ?>
                            <!--MENSAGEM PARA CONVIDADO QUE JÁ RESPONDEU QUE NÃO VAI -->
                            <p class="card-text">
                                Você já informou que não poderá comparecer :(<br>
                                Caso tenha ocorrido algum engano ou deseja alterar sua resposta, por favor, entre
                                em contato conosco.
                            </p>
                        
                        <?php elseif ($convidado->getConfirmado()<>1): ?>
                            
                        <?php endif ?>
                    </div>
                </div>
            <?php else: ?>
                <center><h4>Convidado não encontrado!</h4></center>
            <?php endif ?>
        </div>
    </body>
</html>
