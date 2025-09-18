<?php
session_start();

if(isset($_SESSION) && isset($_SESSION['logadoform']) && $_SESSION['logadoform']==true){
    ?><script nonce>location.href = "/html/sistema/view/inicio/";</script><?php
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="index.css?nocache=<?= uniqid()?>" rel="stylesheet" type="text/css"/>        
    </head>
    <body>
        <div class="container">
            <?php                                
                $erro = false;                                
                
                if(!empty($_POST)){               
                    $usuario = array();
                    $usuario['usuario'] = "admin";
                    $usuario['senha'] = "inspira";
                    
                    $input = array();
                    $input['usuario'] = $_POST['usuario'];
                    $input['senha'] = $_POST['senha'];
                    
                    if($usuario['usuario']==$input['usuario'] && $usuario['senha']==$input['senha']){
                        ?><div class="logado">Usuário logado com sucesso!</div><?php                        
                        $erro = false;                        
                        $_SESSION['logadoform'] = true;
                        $_SESSION['usuarioform'] = $input['usuario'];
                        $_SESSION['nomeusuarioform'] = "Lucas Barbosa Romanha";
                        ?><script nonce>
                            document.addEventListener("DOMContentLoaded", function(event){
                                location.href = "/html/sistema/view/inicio/";
                            });
                       </script><?php
                    }else{
                        ?><div class="erro">Usuário e/ou senha inválidos!</div><?php
                        $erro = true;
                    }
                }                                
            ?>                       
            <div id="clogin" class="clogin">
                <form method="post" action="#">
                    <label>Usuário:</label><br>
                    <input 
                        type="text" 
                        name="usuario" 
                        id="usuario" 
                        <?=($erro==false) ? "autofocus" : "" ?> 
                        value="<?= ($erro==true) ? $input['usuario'] : ""?>" 
                        placeholder="Digite o seu usuário..."
                        required
                    >                
                    <br>
                    <label>Senha:</label><br>
                    <input 
                        type="password" 
                        name="senha" 
                        id="senha" 
                        <?= ($erro==true) ? "autofocus" : "" ?>
                        placeholder="Digite a sua senha..." 
                        required
                    >
                    <br>
                    <div class="botoes">
                        <input type="reset" value="Limpar">    
                        <input type="submit" value="Entrar">    
                    </div>    
                </form>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function(event){
                if(<?=$_SESSION['logadoform'] ?>){
                    document.getElementById("clogin").style.display = "none";
                }
            });                        
        </script>
    </body>
</html>
