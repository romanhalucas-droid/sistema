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
                <table id="tabela_listar_convidados" class="display table table-striped table-bordered w-100">
                    <!-- id, nome, celular, confirmado, dtExpiracao, vistoPorUltimo, resposavel_cadastro -->
                    <thead>
                        <tr><!--linha-->
                            <th>Id</th><!--coluna-->
                            <th>Nome</th><!--coluna-->
                            <th>Celular</th><!--coluna-->
                            <th>Confirmado?</th><!--coluna-->
                            <th>Data de Expiração</th><!--coluna-->
                            <th>Responsável pelo cadastro</th><!--coluna-->
                            <th>Visto por último</th><!--coluna-->
                            <th>Opções</th><!--coluna-->
                        </tr>
                    </thead>
                    <tbody>                       
                        <?php
                        require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";
                        
                        $convidados = ConvidadosDAO::selectAll([
                            'conn' => $conn_db
                        ]);
                        
                        require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
                        
                        foreach ($convidados as $c){
                            ?><tr>
                                <td><?=$c->getId()?></td>
                                <td><?=$c->getNome()?></td>
                                <td><?=$c->getCelular()?></td>
                                <td><?=$c->getConfirmadoAsString()?></td>
                                <td><?=dtSqlToBrasil( $c->getDtExpiracao() )?></td>
                                <td><?=$c->getUsuarios()->getNome()?></td>
                                <td><?=$c->getVistoPorUltimo()?></td>
                                <td>
                                    
                                    <!-- BOTAO WHATSAPP -->
                                    <?php
                                        //FORMATANDO TEXTO PARA URL
                                        $text = urlencode("Apenas teste");
                                    ?>
                                    <a target="_blank"
                                       href="https://wa.me/55<?=$c->getCelular()?>?text=<?=$text?>"
                                    >
                                        <i class="bi bi-whatsapp link-success" style="font-size: 22px;"></i>
                                    </a>                                    
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>           
        </div>
        <script nonce="<?=uniqid()?>">
            $(document).ready(function () {
                
                //INICIO TABELA
                let tableConvidados = $('#tabela_listar_convidados').DataTable({
                    language: {
                        "sEmptyTable": "Nenhum registro encontrado",
                        info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 até 0 de 0 registros",
                        infoFiltered: "(Filtrados de _MAX_ registros)",
                        infoPostFix: "",
                        infoThousands: ".",
                        decimal: ',',
                        thousands: '.',
                        lengthMenu: "_MENU_ resultados por página",
                        loadingRecords: "Carregando...",
                        "sProcessing": "Processando...",
                        zeroRecords: "Nenhum registro encontrado",
                        "sSearch": "Pesquisar",
                        "oPaginate": {
                            "sNext": "<i class='bi bi-caret-right-fill'></i>",
                            "sPrevious": "<i class='bi bi-caret-left-fill'></i>",
                            "sFirst": "<i class='bi bi-skip-backward-fill'></i>",
                            "sLast": "<i class='bi bi-skip-forward-fill'></i>"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        }
                    }
                });
                //FIM TABELA
                
                
            });
        </script>
        
        
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/rodape.php"; ?>
    </body>
</html>
