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
        
        if($id===0){
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
            
            <form 
                name="formcadastrarconvidados" id="formcadastrarconvidados" method="post" 
                action="/html/sistema/validacao/convidados/salvar.php"
            >                
                  
            <?php
            if($id===0){
                ?><input class='form-control' type='hidden' id='id' name='id' value='<?=htmlspecialchars($id)?>' required readonly>
            <?php }else{ 
                ?><div class='form-floating'>
                    <input class='form-control' type='text' id='id' name='id' value='<?=htmlspecialchars($id)?>' required readonly>
                    <label for='id'>Código:</label>
                </div>
            <?php } ?>
                
            <div class="row">
                <!--nome do convidado -->
                <div class='col-sm-6'>
                    
                    <div class='form-floating mt-1'>
                        <input type='text' placeholder="Nome do convidado..." maxlength="150" class='form-control' 
                        id='nome' name='nome' value='<?=htmlspecialchars($nome)?>' autofocus required>
                        <label for='nome'>Nome do Convidado</label>
                    </div>
                
                </div>
                <!--celular do convidado -->
                <div class='col-sm-6'>
                
                    <div class='form-floating mt-1'>
                        <input type='text' placeholder="Celular do convidado..." class='form-control' id='celular' name='celular'
                        value='<?= htmlspecialchars($celular)?>' required>
                        <label for='celular'>Celular:</label>                        
                    </div>
                    
                    <script>
                        $("#celular").mask('(00) 00000-0000');
                    </script>
                    
                </div>
            </div>
                <div class='row'>
                    <!-- data de expiração -->
                    <div class='col-sm-6'>
                        
                        <div class='form-floating mt-1'>
                            <input type='text' placeholder='Data de expiração...' class='form-control' id='dtExpiracao'
                                   name='dtExpiracao' value='<?=htmlspecialchars( dtSqlToBrasil($dtExpiracao) )?>' required>
                            <label for='dtExpiracao'>Data de Expiração</label>
                        </div>
                        
                        <script>
                            $("#dtExpiracao").mask('00/00/0000', {reverse: false});
                            
                            $("#dtExpiracao").datepicker({
                               language: 'pt-BR',
                               format: 'dd/mm/yyyy',
                               startView: 1                            
                            });
                        </script>
                        
                    </div>
                    <!-- confirmado -->
                    <div class='col-sm-6'>
                        
                        <div class='form-floating mt-1'>
                            <select id='confirmado' name='confirmado' class='form-select w-100'>
                                <option value='1' <?= ($confirmado==1) ?? "selected" ?> >Não respondeu</option>
                                <option value='2' <?= ($confirmado==2) ?? "selected" ?> >Não vai</option>
                                <option value='3' <?= ($confirmado==3) ?? "selected" ?> >Confirmado</option>
                            </select> 
                            <label for='confirmado'>Confirmado:</label>
                        </div>
                                               
                    </div>
                </div>
                
                <!-- BOTÕES -->
                <div class="row mt-2">
                    <!-- BOTAO DE FECHAR -->
                    <div class="col">
                        <a id="btnfechar" name="btnfechar" href="/html/sistema/view/convidados/listar.php" class="btn w-100 btn-warning">
                            <i class="bi bi-arrow-left-circle"></i> Voltar
                        </a>
                    </div>
                    <!-- BOTAO DE EXCLUIR -->
                    <div class="col">
                        <a id="btnExc" name="btnExc" class="btn w-100 btn-danger">
                            <i class='bi bi-backspace-fill'></i> Excluir
                        </a>
                    </div>
                    <!-- BOTAO DE SALVAR -->
                    <div class="col">
                        <button type='submit' id='btnsalvar' name='btnsalvar' class='btn w-100 btn-primary'>
                            <i class='bi bi-check2-square'></i> Salvar
                        </button>
                    </div>
                </div>
                
                
            </div>
            </form>
        </div>
        <script src="cadastrar.js?v=<?= uniqid()?>" type="text/javascript"></script>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/rodape.php"; ?>
    </body>
</html>
