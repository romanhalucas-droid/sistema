<?php
//SISTEMA => VALIDACAO => CONVIDADOS => SALVAR.PHP

//bad + TAB
//BLOQUEAR ACESSO DIRETO AO ARQUIVO
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('location:/html/sistema/view/inicio/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';
require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";

//RECEBENDO DADOS DO FORMULÁRIO
$id = $_POST['id'];
$nome = $_POST['nome'];
$celular = $_POST['celular'];
$confirmado = $_POST['confirmado'];
$dtExpiracao = $_POST['dtExpiracao'];

try{
    //DESLIGAR O SALVAMENTO AUTOMÁTICO
    //SO SERÁ SALVO QUANDO EXECUTAR O COMMIT()
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $conn_db->beginTransaction();//inicia a transação
    
    //se o ID for diferente de 0 quer dizer que é uma atualização de registro existente
    if($id <> 0){
        //busca registro no banco para editar
        $obj = ConvidadosDAO::selectIndex(['conn' => $conn_db, 'id' => $id])[0];
    }else{
        //caso contrário, cria um novo objeto (convidado)
        $obj = new Convidados(null);
    }
    
    //DEFINE (SETA) os atributos do objeto com os valores recebidos do formulário
    $obj->setId($id);
    $obj->setNome($nome);
    $obj->setCelular(deixarNumero($celular)); //formatar numero de telefone(deixar somente numeros)
    $obj->setConfirmado($confirmado);
    $obj->setDtExpiracao(dtBrasilToSql($dtExpiracao)); //converter formato de data BR para SQL(banco de dados)
    $obj->setUsuarios(new Usuarios($_SESSION['idusuarioform']));
    
    //A função de save salva o objeto no banco de dados (novo ou editado)
    if($return = ConvidadosDAO::save(['conn' => $conn_db, 'obj' => $obj])){
        $conn_db->commit(); //confirmar (salvar) alterações no banco de dados
        ?><div class='alert alert-success' role='alert'>Salvo com sucesso!</div><?php
    }else{
        //caso ocorra erro, desfaz as alterações da transação
        $conn_db->rollBack();
        ?><div class='alert alert-danger' role='alert'>Algo deu errado ao salvar...</div><?php
    }
    
} catch (PDOException $e) {
    //caso ocorra qualquer erro (exceção) no banco de dados, desfaz as alteração e exibi a mensagem de erro
    $conn_db->rollBack();
    ?><div class='alert alert-danger' role='alert'> ERRO BD: <?=$e->getMessage()?></div><?php
} catch (Exception $e){
    //caso ocorra qualquer erro (exceção), desfaz as alteração e exibi a mensagem de erro
    $conn_db->rollBack();
    ?><div class='alert alert-danger' role='alert'> ERRO: <?=$e->getMessage()?></div><?php
} finally {
    //REATIVAR O AUTO SALVAMENTO
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);    
    require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
}