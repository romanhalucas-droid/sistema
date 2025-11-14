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
                
                //carregar informação no objeto
                $obj->setId($id);
                $obj->setConfirmado($confirmado);
                
                //atualizar convidado
                if(ConvidadosDAO::save(['conn' => $conn_db, 'obj' => $obj])){
                    $conn_db->commit(); //confirmar as alterações (save point)
                    
                    if($confirmado==3){//ele vai
                        ?><div class="alert alert-success text-center" role="alert">
                            Presença confirmada!
                            <br>
                            Mal podemos esperar para te ver lá!
                        </div><?php
                    }else{//ele não vi
                        ?><div class="alert alert-warning text-center" role="alert">
                            Poxa! Que pena que você não podera ir :'(
                            <br>
                            Mas obrigado por avisar. <3
                        </div><?php
                    }
                    
                }else{
                    $conn_db->rollBack();
                    ?><div class="alert alert-danger" role="alert">Algo deu errado ao salvar...</div><?php
                }
                
                
            } catch (PDOException $e) {
                $conn_db->rollBack();
                ?><div class="alert alert-danger" role="alert"><?=$e->getMessage()?></div><?php
            } catch (Exception $e) {
                $conn_db->rollBack();
                ?><div class="alert alert-danger" role="alert"><?=$e->getMessage()?></div><?php
            } finally {
                $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
                require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
            }
            ?>
        </div>
        <?php require_once $_SERVER["DOCUMENT_ROOT"].'/html/sistema/util/estrutura/rodape.php'; ?>
    </body>
</html>
        