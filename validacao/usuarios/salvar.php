<?php

//BLOQUEAR ACESSO DIRETO AO ARQUIVO
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('location:/html/sistema/view/inicio/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';
require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/inicio_conexao.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$datanasc = $_POST['datanasc'];
$contato1 = $_POST['contato1'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$confirmarsenha = $_POST['confirmarsenha'];
$sexo = $_POST['sexo'];

try{
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false); //DESATIVANDO O SALVAMENTO AUTOMÁTICA
    $conn_db->beginTransaction(); //INICIANDO CONEXÃO MANUALMENTE
    
    $obj = new Usuarios(null);
    $obj->setId($id);
    $obj->setNome($nome);
    $obj->setCpf(deixarNumero($cpf)); //MODIFICADO AQUI
    $obj->setDatanasc(dtBrasilToSql($datanasc)); //MODIFICADO AQUI
    $obj->setContato1(deixarNumero($contato1)); //MODIFICADO AQUI
    $obj->setEmail($email);
    $obj->setUsuario(mb_strtoupper($usuario, 'UTF-8'));
    
    //SENHA        
    if(strlen($senha)<8){
        throw new Exception("A senha deve possuir pelo menos 8 digítos.");
    }
    
    if($senha!==$confirmarsenha){
        throw new Exception("A senha e a confirmação de senha não correspondem.");
    }    
    
    if($id>0){
        //ENTÃO ATUALIZAÇÃO
        $senha_db = UsuariosDAO::selectIndex([
            'conn' => $conn_db,
            'id' => $id
            ])[0]->getSenha();
        
        if($senha_db===$senha){//SE SENHA DO BANCO FOR IGUAL A SENHA DO FORMULÁRIO
            // NÃO HOUVE ALTERAÇÃO NA SENHA
            $obj->setSenha($senha);
        }else{//SENÃO FOR IGUAL A SENHA DO BANCO E DO FORMULÁRIO
            // CRIPTOGRAFAR A NOVA SENHA PARA EFETUAR A ATUALIZAÇÃO
            $obj->setSenha(password_hash($senha, PASSWORD_DEFAULT));
        }
    }else{
        //REGISTRO NOVO
        $obj->setSenha(password_hash($senha, PASSWORD_DEFAULT));
    }
    
    $obj->setSexo($sexo);
    
    $validar = $obj->validar();
    if(!$validar['result']){        
        throw new Exception($validar['msg']);
    }
    
    $idbd = UsuariosDAO::save([
        'conn' => $conn_db,
        'obj'=> $obj
    ]); //SALVANDO NO BANCO
    
    if($idbd){
        //SE SALVAR COM SUCESSO
        $conn_db->commit(); //CONFIRMAR ALTERAÇÕES
        
        ?><div class="alert alert-success" role="alert">Usuário salvo com sucesso!</div><?php  //MSG DE SUCESSO
    }else{
        //SE ALGO ESTIVER ERRRADO
        $conn_db->rollBack(); //DESFAZER AS ALTEREÇÕES FEITAS
        ?><div class="alert alert-danger" role="alert">Algo deu errado ao salvar...</div><?php //MSG DE ERRO
        
    }
    
} catch (PDOException $epdo) {
    $conn_db->rollBack();
    ?><div class="alert alert-danger" role="alert">ERRO DB: <?= $epdo->getMessage() ?></div><?php
    
} catch (Exception $e){
    $conn_db->rollBack();
    ?><div class="alert alert-danger" role="alert"><?= $e->getMessage() ?></div><?php
    
}finally{
    $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true); 
    require_once "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/conexao/fim_conexao.php";
}


