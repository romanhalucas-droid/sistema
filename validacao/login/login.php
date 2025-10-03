<?php
//BLOQUEAR ACESSO DIRETO AO ARQUIVO
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('location:/html/sistema/view/inicio/');
}

//iniciar sessão
if(!isset($_SESSION)){
    session_start();
}

//iniciar conexão
require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";

$sql = $conn_db->prepare("SELECT id, nome, usuario FROM usuarios WHERE usuario=:usuario");
$sql->bindValue(":usuario", $_POST['usuario']);
$sql->execute();//apertar enter

if($sql->rowCount() == 1){//SE QUANTIDADE DE REGISTRO RETORNADO FOR IGUAL A 
    while($linha = $sql->fetch(PDO::FETCH_ASSOC)){
        //SE PASSWORD DIGITADO PELO USUÁRIO FOR IGUAL AO CRIPTOGRAFADO NO BANCO
        if(password_verify($_POST['senha'], $linha['senha'])){
            session_regenerate_id(); //REINICIAR A O ID DA SESSÃO
            $_SESSION['logadoform'] = true;
            $_SESSION['idusuarioform'] = $linha['id'];
            $_SESSION['usuarioform'] = $linha['usuario'];
            $_SESSION['nomeusuarioform'] = $linha['nome'];
            
            ?><div class='alert alert-success' role='alert'>Usuário logado com sucesso!</div>
            <script nonce="<?=uniqid()?>" language="Javascript">
                //REDIRECIONAR PARA A PÁGINA INICIAL DO SISTEMA
                location.href = "/html/sistema/view/inicio/";             
            </script><?php                        
        }else{
            ?><div class='alert alert-danger' role='alert'>Senha incorreta!</div><?php
        }
    }
    
}else{//SENÃO USUÁRIO NÃO POSSUI CONTA NO SISTEMA
    ?><div class='alert alert-danger' role='alert'>Usuário inválido</div><?php
}



