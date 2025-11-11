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
                        
                        <?php elseif ($timeHoje <= $timeDtExp OR $convidado->getConfirmado()<>1): ?>
                            
                            <!-- mensagem de boas vindas principal -->
                            <p class="card-text">
                                Será uma grande alegria contar com sua presença neste momento tão especial,
                                celebrando a nossa confraternização de final de ano.
                            </p>
                            
                            
                            <!-- local da festa -->
                            <p class="card-text">
                                <strong>Local da cerimônia: </strong>
                                <br>
                                <a href="https://maps.app.goo.gl/w85uoMyjpTB91u5V9" target="_blank" 
                                   style="text-decoration: underline; color: #007BFF;">
                                    SENAC (Colatina)
                                    <br>
                                    Av. Adauto Barcelos de Carvalho, 400, Esplanada, Colatina/ES
                                </a>
                            </p>
                            
                            <!-- hora da festa -->
                            <p class="card-text"><strong>Data e hora:</strong> 12 de Dezembro de 2025 - 19 horas</p>
                            
                            <!-- mensagem para quem já confirmou a presença (confirmado==3) -->
                            <?php if($convidado->getConfirmado()==3): ?>
                                <p class="card-text">
                                    A sua presença já foi confirmada! <3
                                    <br>
                                    Caso tenha ocorrido algum engano ou deseje alterar a sua resposta,
                                    por favor, entre em contato conosco.
                                </p>
                            <?php endif ?>
                            
                            <!--CASO ESTEJA NO PRAZO E AINDA NÃO RESPONDEU (CONFIRMADO==1) -->                            
                            <?php if($timeHoje <= $timeDtExp AND $convidado->getConfirmado()==1): ?>
                                <p class="mt-4" style="font-size: 1.1rem;">
                                    Por favor, confirme sua presença clicando em umas das opções abaixo                                                                                   
                                    até o dia <strong><?= dtSqlToBrasil( $convidado->getDtExpiracao() ) ?>.</strong>
                                </p>
                                
                                <div class="mt-3 bg-danger-subtle gap-2 p-3 rounded-3">
                                    <!-- BOTAO DE CONFIRMAR PRESENÇA -->
                                    <a href="/html/sistema/validacao/convite/confirmar_convite.php?id=<?=$convidado->getId()?>&confirmado=3"
                                       class="btn btn-success mt-1 btn-lg"
                                    >
                                        Sim, estarei presente!
                                    </a>
                                    
                                    <!-- BOTAO PARA NEGAR A PRESENÇA (NÃO VAI) -->
                                    <a href="/html/sistema/validacao/convite/confirmar_convite.php?id=<?=$convidado->getId()?>&confirmado=2"
                                       class="btn btn-danger mt-1 btn-lg"
                                    >
                                        Infelizmente não poderei comparecer.
                                    </a>
                                </div>    
                                
                            <?php endif ?>
                                
                                
                        <?php endif ?>
                    </div>
                </div>
            <?php else: ?>
                <center><h4>Convidado não encontrado!</h4></center>
            <?php endif ?>
        </div>
        <?php $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/estrutura/rodape.php" ?>
    </body>
</html>
