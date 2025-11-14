<!DOCTYPE html><!-- VALIDACAO => CONVITE => confirmar_convite.php -->
<html>
    <head>
        <title>CONVITE: CONFRATERNIZAÇÃO FINAL DE ANO</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/estrutura/cabecalho.php"; ?>
    </head>
    <body class="bg-light">
        <div class="container">
            <?php
            require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/conexao/inicio_conexao.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/Funcoes.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/ConvidadosDAO.php";

            $id = $_GET['id'];
            $confirmado = $_GET['confirmado'];
            
            try{
                $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
                $conn_db->beginTransaction(); //modificado aqui
                
                //carregar o convidado
                $obj = ConvidadosDAO::selectIndex(['conn' => $conn_db, 'id' => $id])[0];
                
                $timeHoje = strtotime('today');
                $timeDtExp = strtotime($obj->getDtExpiracao() . '+1 day');
                
                //verificar se o usuário está no prazo para responder
                if($timeHoje > $timeDtExp){
                    throw new Exception("O prazo para confirmar ou cancelar a presença já terminou.");
                }
                
                //se já respondeu que não vai, vamos deixar isso claro usuário, pois ele não pode responder de novo.
                if($obj->getConfirmado()==2){
                    throw new Exception("Você já informou que não poderá comparecer :/.<br>Caso tenha ocorrido algum engano"
                            . "ou deseje alterar sua resposta, por favor, entre em contato conosco.");
                }
                
                //se já respondeu que vai, vamos deixar isso claro para o usuário, pois ele não pode responder de novo.
                if($obj->getConfirmado()==3){
                    throw new Exception("A sua presença já foi confirmada <3 <br>Caso tenha ocorrido algum engano"
                            . "ou deseje alterar sua resposta, por favor, entre em contato conosco.");
                }
                
                
                
            } catch (PDOException $e) {
                $conn_db->rollBack();
                ?><div class="alert alert-danger" role="alert"><?=$e->getMessage()?></div><?php
            } catch (Exception $e) {
                $conn_db->rollBack();
                ?><div class="alert alert-danger" role="alert"><?=$e->getMessage()?></div><?php
            }
            ?>
        </div>
    </body>
</html>
        