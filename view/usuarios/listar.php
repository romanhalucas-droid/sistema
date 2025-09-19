<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/html/sistema/util/login/logado.php';
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/cabecalho.php"; ?>
        <title>LISTAR | USUÁRIOS</title>        
    </head>
    <body class="bg-light">
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/menu.php"; ?>
        <div class="container shadow bg-white p-3 rounded-3">   
            <div>
                <a href="/html/sistema/view/usuarios/cadastrar.php?id=0" class="btn btn-success"><i class="bi bi-person-fill-add me-1"></i>Adicionar</a>
            </div>            
            
            <div class="table-responsive mt-1 bg-white">
                <table id="tabela_listar_usuarios" class="display table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Usuário</th>                            
                            <th>Opções</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                           require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";
                           
                           $usuarios = UsuariosDAO::selectAll([
                               'conn' => $conn_db
                           ]);
                           
                           require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
                           
                           foreach ($usuarios as $usuario){
                        ?>
                            <tr>
                                <td><?=$usuario->getId()?></td>
                                <td><?=$usuario->getNome()?></td>
                                <td><?=$usuario->getUsuario()?></td>
                                <td>
                                    <!--EDITAR-->
                                    <a class="link-success link-offset-2" style="font-size: 30px" href="/html/sistema/view/usuarios/cadastrar.php?id=<?=$usuario->getId()?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr> 
                           <?php } ?>
                    </tbody>
                </table>
            </div>            
        </div>
        <script nonce="<?= uniqid() ?>">
            $(document).ready(function () {
                let tableUsuarios = $('#tabela_listar_usuarios').DataTable();
            });
        </script>
        <?php include_once $_SERVER['DOCUMENT_ROOT'] .'/html/sistema/util/estrutura/rodape.php'; ?>        
    </body>
</html>
