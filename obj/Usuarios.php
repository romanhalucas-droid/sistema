<?php
class Usuarios{
    private $id;
    private $nome;
    private $cpf;
    private $datanasc;
    private $contato1;
    private $email;
    private $usuario;
    private $senha;
    private $sexo;
        
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function validar(){
        ////////////////////////////////////
        //NOME/////////////////////////////
        ///////////////////////////////////        
        if(empty($this->nome)){ //verificar se está vazio
            return [
              'result'  => false,
              'msg' => "Não permitido o campo NOME ficar VAZIO."
            ];
        }
        
        if(!empty($this->nome) AND (substr($this->nome, 0, 1)==" " OR substr($this->nome, -1) === " ")){
            //SE NOME FOR DIFERENTE DE VAZIO E O PRIMEIRO OU ÚLTIMO CARACTERE FOR ESPAÇO
            return [
                'result' => false,
                'msg' => "Não é permitido espaço como primeiro e/ou último caractere do Nome!"                
            ];
        }
        
        //////////////////////////////////
        //CPF/////////////////////////////
        //////////////////////////////////
        if(empty($this->cpf)){ //verificar se está vazio
            return [
              'result'  => false,
              'msg' => "Não permitido o campo CPF ficar VAZIO."                
            ];
        }
        
        if(!empty($this->cpf) AND (substr($this->cpf, 0, 1)==" " OR substr($this->cpf, -1) === " ")){
            //SE CPF FOR DIFERENTE DE VAZIO E O PRIMEIRO OU ÚLTIMO CARACTERE FOR ESPAÇO
            return [
                'result' => false,
                'msg' => "Não é permitido espaço como primeiro e/ou último caractere do CPF!"
            ];
        }
        
        if(strlen($this->cpf)!==11){
            //SE QUANTIDADE DE DIGITOS DO CPF FOR DIFERENTE DE 11
            return [
                'result' => false,
                'msg' => "O campo CPF deve ter obrigatóriamente 11 dígitos."
            ];
        }
        
        //////////////////////////////
        //DATA NASCIMENTO////////////
        //////////////////////////////
        if(empty($this->datanasc)){ //verificar se está vazio
            return [
              'result'  => false,
              'msg' => "Não permitido o campo DATA DE NASCIMENTO ficar VAZIO."                
            ];
        }
        
        if(!empty($this->datanasc) AND (substr($this->datanasc, 0, 1)==" " OR substr($this->datanasc, -1) === " ")){
            //SE FOR DIFERENTE DE VAZIO E O PRIMEIRO OU ÚLTIMO CARACTERE FOR ESPAÇO
            return [
                'result' => false,
                'msg' => "Não é permitido espaço como primeiro e/ou último caractere do DATA DE NASCIMENTO!"
            ];
        }
        
        if(strlen($this->datanasc)!==10){
            //SE QUANTIDADE DE DIGITOS FOR DIFERENTE DE 10
            return [
                'result' => false,
                'msg' => "O campo DATA DE NASCIMENTO deve ter obrigatóriamente 10 dígitos."
            ];
        }    
        
        //////////////////////////////////
        //CONTATO1////////////////////////
        //////////////////////////////////
        
        if(!empty($this->contato1) AND strlen($this->contato1)<10){
             return [
                'result' => false,
                'msg' => "Número informado no campo CONTATO 1 inválido."
            ];
        }
        
        //////////////////////////////////
        //EMAIL///////////////////////////
        //////////////////////////////////
        
        if(!empty($this->email) AND !filter_var($this->email, FILTER_VALIDATE_EMAIL)){
             return [
                'result' => false,
                'msg' => "EMAIL informado inválido."
            ];
        }
        
        /////////////////////////////////
        //USUARIO////////////////////////
        ////////////////////////////////
        
        if(empty($this->usuario)){ //verificar se está vazio
            return [
              'result'  => false,
              'msg' => "Não permitido o campo USUÁRIO ficar VAZIO."                
            ];
        }
        
        if(strpos($this->usuario, ' ')){
            return [
              'result'  => false,
              'msg' => "Não permitido digitar espaço no campo USUÁRIO."                
            ];
        }
        
        ////////////////////////////////
        //SEXO//////////////////////////
        ////////////////////////////////
        if($this->sexo!=="M" AND $this->sexo!=="F"){
            return [
              'result'  => false,
              'msg' => "SEXO informado inválido."
            ];
        }
        
        //CASO ESTEJA CERTO
        return [
            'result' => true,
            'msg' => "Validado com sucesso!"
        ];
        
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getDatanasc() {
        return $this->datanasc;
    }

    public function getContato1() {
        return $this->contato1;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setCpf($cpf): void {
        $this->cpf = $cpf;
    }

    public function setDatanasc($datanasc): void {
        $this->datanasc = $datanasc;
    }

    public function setContato1($contato1): void {
        $this->contato1 = $contato1;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    }

    public function setSexo($sexo): void {
        $this->sexo = $sexo;
    }
}