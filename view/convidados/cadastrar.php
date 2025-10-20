<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/html/sistema/util/login/logado.php';

//EMPTY = VAZIO
//! = DIFERENTE

//SE ID DA URL FOR DIFERENTE DE VAZIO ENTÃO SALVAR ID ENVIADO SENÃO CRIAR ID NOVO(0)
$id = !empty($_GET['id']) ? $_GET['id'] : 0;
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/cabecalho.php"; ?>
        <title>CADASTRAR | CONVIDADOS</title>        
    </head>
    <body class="bg-light">
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/menu.php"; ?>
        
        <?php  
        //abrir conexão com banco de dados
        require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";
        
        if($id==0){
            //REGISTRO NOVO
            $id = 0;
            $nome = "";
            $celular = "";
            $confirmado = 1; //1=NÃO RESPONDEU
            $dtExpiracao = "";
        }else{
            //EDITAR REGISTRO            
            $obj = ConvidadosDAO::selectIndex(['conn' => $conn_db, 'id' => $id])[0];
            $id = $obj->getId();
            $nome = $obj->getNome();
            $celular = $obj->getCelular();
            $confirmado = $obj->getConfirmado();
            $dtExpiracao = $obj->getDtExpiracao();
        }
        
        //finalizar conexão
        require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
        ?>
        
        
        <div class="container bg-white shadow p-3 rounded-3">      
            <h3>Cadastro de Convidados</h3>
            
            <?php
            if($id==0){
                ?><input class='form-control' type='hidden' id='id' name='id' value='<?=htmlspecialchars($id)?>' required readonly>
            <?php }else{ 
                ?><div class='form-floating'>
                    <input class='form-control' type='text' id='id' name='id' value='<?=htmlspecialchars($id)?>' required readonly>
                    <label for='id'>Código:</label>
                </div>
            <?php } ?>
   
        </div>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/rodape.php"; ?>
    </body>
</html>
