<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/html/sistema/util/login/logado.php';



$id = !empty($_GET['id']) ? $_GET['id'] : 0;
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/cabecalho.php"; ?>
        <title>CADASTRAR | USUÁRIOS</title>                
    </head>
    <body class="bg-light">
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/menu.php"; ?>
                
        <?php 
        if($id == 0){ // se id for igual a 0
            //ESTOU INICIANDO UM REGISTRO NOVO
            $id = 0;
            $nome = "";
            $cpf = "";
            $datanasc = "";
            $contato1 = "";
            $email = "";
            $usuario = "";
            $senha = "";
            $sexo = "";
        }else{ //senão
            //ESTOU ABRINDO UM REGISTRO JÁ EXISTENTE
            require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";//iniciando conexão
            $obj = UsuariosDAO::selectIndex([
                'conn' => $conn_db,
                'id' => $id
            ]); //LISTANDO O USUÁRIO POR ID UTILIZANDO BANCO DE DADOS
            //            
            //CARREGAR INFORMAÇÕES NAS VARIÁVEIS            
            $id = $obj[0]->getId();
            $nome = $obj[0]->getNome();
            $cpf = $obj[0]->getCpf();
            $datanasc = $obj[0]->getDatanasc();
            $contato1 = $obj[0]->getContato1();
            $email = $obj[0]->getEmail();
            $usuario = $obj[0]->getUsuario();
            $senha = $obj[0]->getSenha();
            $sexo = $obj[0]->getSexo();

            require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php"; // FIM DA CONEXÃO
        }
        ?>        
        <div class="container bg-white shadow p-3 rounded-3">
            <h3>Cadastro de Usuários:</h3>
            <hr>
            <form name="formcadastrarusuario" id="formcadastrarusuario" action="/html/sistema/validacao/usuarios/salvar.php" method="post">
                <!-- id, nome, cpf, datanasc, contato1, email, usuario, senha, sexo -->
                <?php
                    if($id==0){
                        ?><input class="form-control" type="hidden" id="id" name="id" value="<?= htmlspecialchars($id) ?>" required readonly>
                    <?php }else{
                        ?><div class="form-floating">
                            <input class="form-control" type="text" id="id" name="id" value="<?= htmlspecialchars($id) ?>" required readonly>
                            <label for="id">Código:</label>
                        </div><?php
                    }                
                ?>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-floating mt-1">
                            <input type="text" class="form-control obrigatorio"  id="nome" name="nome" value="<?=$nome?>" placeholder="Digite o nome do usuário..." required>
                            <label for="nome">Nome do usuário:</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-floating mt-1">
                            <input type="text" class="form-control" value="<?=$cpf?>" id="cpf" name="cpf" placeholder="Digite o cpf..."  maxlength="14" required>
                            <label for="cpf">CPF:</label>
                        </div>
                        <script>                         
                            $("#cpf").mask("000.000.000-00");                             
                        </script>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">          
                        
                        <div class="form-floating mt-1">
                            <input type="text" class="form-control" value="<?= dtSqlToBrasil($datanasc)?>" id="datanasc" name="datanasc" placeholder="Digite a data..." required>
                            <label for="datanasc">Data de nascimento:</label>
                        </div>
                        <script>
                            
                            $("#datanasc").mask('00/00/0000', {reverse: false});
                            
                            function getDataMaxima() {
                                const hoje = new Date();
                                hoje.setFullYear(hoje.getFullYear() - 18);
                                return hoje;
                            }
                            
                            $("#datanasc").datepicker({
                               language: 'pt-BR',
                               format: 'dd/mm/yyyy',
                               startView: 2,
                               endDate: getDataMaxima()
                               //minViewMode: 1,
                               
                            });
                        </script>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-floating mt-1">
                            <input type="text" class="form-control" value="<?=$contato1?>" name="contato1" id="contato1" placeholder="Digite o número...">                            <label for="contato1">Contato 1:</label>
                        </div>
                        <script>
                            $("#contato1").mask('(00) 00000-0000');
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-floating mt-1">
                            <input type="email" class="form-control"  value="<?=$email?>"  name="email" id="email" placeholder="Digite o email...">
                            <label for="email">E-mail:</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-floating mt-1">
                           <input required type="text" class="form-control" value="<?=$usuario?>" name="usuario" id="usuario" placeholder="Digite o usuário...">
                           <label for="usuario">Usuário:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">                  
                            <div class="form-floating d-flex align-items-center mt-1"> <!-- AQUI <<<<<<<<<<<<<<< -->
                                <input required type="password" class="form-control me-1" value="<?=$senha?>" name="senha" id="senha" minlenght="8" placeholder="Digite a senha...">
                                <label for="senha">Senha:</label> 
                                <!-- OLHO -->
                                <a id="olho1" class="btn btn-secondary p-2 rounded-3 text-white" style="font-size: 26px">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </div>                            
                            <script>
                                let olho1 = false;
                                
                                $('#olho1').click(function(){
                                   if(olho1 === true) {
                                       olho1=false;
                                       $('#senha').attr("type", "password");
                                       $("#olho1").html("<i class='bi bi-eye-fill'></i>");
                                   }else{
                                       olho1=true;
                                       $('#senha').attr("type", "text");  
                                       $("#olho1").html("<i class='bi bi-eye-slash-fill'></i>");
                                   }
                                });
                            </script>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-floating d-flex align-items-center mt-1">
                           <input required type="password" class="form-control me-1" value="<?=$senha?>" name="confirmarsenha" id="confirmarsenha" minlength="8" placeholder="Digite a senha novamente...">
                           <label for="confirmarsenha">Confirmar Senha:</label>
                           <a id="olho2" class="btn btn-secondary p-2 rounded-3 text-white" style="font-size: 26px"><i class="bi bi-eye-fill"></i></a>
                        </div>
                        <script>
                            let olho2 = false;

                            $('#olho2').click(function(){
                               if(olho2 === true) {
                                   olho2=false;
                                   $('#confirmarsenha').attr("type", "password");
                                   $("#olho2").html("<i class='bi bi-eye-fill'></i>");
                               }else{
                                   olho2=true;
                                   $('#confirmarsenha').attr("type", "text");  
                                   $("#olho2").html("<i class='bi bi-eye-slash-fill'></i>");
                               }
                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="border rounded-3 mt-1 p-2">
                            <label class="label-select text-secondary">Sexo:</label>
                            <select class="form-control w-100" name="sexo" id="sexo" aria-label="Selecione o sexo da pessoa" required>
                              <option disabled <?=empty($sexo) ? "selected" : "" ?>>Selecione...</option>
                              <option value="M" <?=($sexo=="M") ? "selected" : "" ?>>Masculino</option>
                              <option value="F" <?=($sexo=="F") ? "selected" : "" ?>>Feminino</option>                              
                            </select>                                                                                          
                        </div>
                        <script>
                            $("#sexo").select2();
                        </script>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <!-- FECHAR -->
                        <a id="btnfechar" name="btnfechar" href="/html/sistema/view/usuarios/listar.php" class="btn w-100 btn-warning">
                            <i class="bi bi-arrow-left-circle"></i> Voltar
                        </a>
                    </div>
                    <div class="col">
                        <!-- EXCLUIR -->
                        <a id="btnExc" name="btnExc" class="btn w-100 btn-danger">
                            <i class="bi bi-backspace-fill"></i> Excluir
                        </a>
                    </div>
                    <div class="col">
                        <!-- SALVAR -->
                        <button type="submit" id="btnsalvar" name="btnsalvar" class="btn w-100 btn-primary">
                            <i class="bi bi-check2-square"></i> Salvar
                        </button>
                    </div>
                </div>            
            </form>
        </div>
        <!--div id="teste"></div-->
        <script nonce="<?= uniqid() ?>">
            $(document).ready(function (){                         
                //$("#teste").html("Olá mundo!");                
                $("#formcadastrarusuario").submit(function (e){                    
                    e.preventDefault();
                    
                    let form = $(this);
                    $.post(form.attr('action'), form.serialize(), function(retorno){
                       let resultado = retorno.indexOf("success") != -1;
                       retornoToast(retorno, getDateHour());
                       if(resultado > 0){
                           window.location.href = "/html/sistema/view/usuarios/listar.php";
                       }
                    });
                });   
                
                $('#btnExc').on('click', function(e){
                    //e.preventDefault();                                        
                    
                    bootbox.confirm({
                        size: "small",
                        message: "Deseja remover esse registro?",
                        buttons: {
                            confirm: {
                                label: '<i class="bi bi-check-circle me-1"></i>Sim',
                                className: 'btn-success'
                            },
                            cancel: {
                                label: '<i class="bi bi-x-circle me-1"></i>Não',
                                className: 'btn-danger'
                            }
                        },
                        callback: function (result){
                            //bootbox.alert({size: 'small', message: result});
                        }
                    });
                });
                
            });
        </script>
        <?php include_once $_SERVER['DOCUMENT_ROOT'] .'/html/sistema/util/estrutura/rodape.php'; ?>                    
    </body>
</html>