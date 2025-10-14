<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/html/sistema/util/login/logado.php';
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/cabecalho.php"; ?>
        <title>LISTAR | CONVIDADOS</title>        
    </head>
    <body class="bg-light">
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/menu.php"; ?>
        <div class="container shadow bg-white p-3 rounded-3">   
            <div>
                <!--ADICIONAR-->
                <a href="/html/sistema/view/convidados/cadastrar.php?id=0" class="btn btn-success">
                    <i class="bi bi-person-add me-2"></i>Adicionar                    
                </a>
            </div>
            
            <div class="table-responsive mt-1 bg-white">
                <table id="table_listar_convidados" class="display table tabled-striped table-bordered w-100">
                
                </table>
            </div>           
        </div>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/rodape.php"; ?>
    </body>
</html>
