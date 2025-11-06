<?php

class Convidados{
    private $id;
    private $nome;
    private $celular;
    private $confirmado;
    private $dtExpiracao;
    private $vistoPorUltimo;
    private $Usuarios;
    
    public function getUsuarios() {
        return $this->Usuarios;
    }

    public function setUsuarios($Usuarios): void {
        $this->Usuarios = $Usuarios;
    }

    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getConfirmado() {
        return $this->confirmado;
    }
    
    public function getConfirmadoAsString(){
        $confirmadoAsString = "";
        switch($this->confirmado){//ESCOLA CASO
            case 1:
                $confirmadoAsString = "Não respondeu";
                break; //sair do switch case
            case 2:
                $confirmadoAsString = "Não vai";
                break;
            case 3:
                $confirmadoAsString = "Confirmado";
                break;
            default:
                $confirmadoAsString = null;
                break;
        }
        
        return $confirmadoAsString;
    }

    public function getDtExpiracao() {
        return $this->dtExpiracao;
    }

    public function getVistoPorUltimo() {
        return $this->vistoPorUltimo;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setCelular($celular): void {
        $this->celular = $celular;
    }

    public function setConfirmado($confirmado): void {
        $this->confirmado = $confirmado;
    }

    public function setDtExpiracao($dtExpiracao): void {
        $this->dtExpiracao = $dtExpiracao;
    }

    public function setVistoPorUltimo($vistoPorUltimo): void {
        $this->vistoPorUltimo = $vistoPorUltimo;
    }

    public function validar() {
        //CARREGAR VARIÁVEIS A SEREM VALIDADAS
        $nome = $this->nome;
        $celular = $this->celular;
        $confirmado = $this->confirmado;
        $dtExpiracao = $this->dtExpiracao;
        
        ////////////////////////////////
        //NOME
        ///////////////////////////////
        if(empty($nome)){//verificar  se está vazio
            return [
                'result' => false,
                'msg' => "Não é permitido o campo NOME ficar VAZIO"
            ];
        }
        
        if(!empty($nome) AND (substr($nome, 0, 1) == " " OR substr($nome, -1) === " ")){
            //SE NOME FOR DIFERENTE DE VAZIO E O PRIMEIROU OU ÚLTIMO CARACTERE FOR ESPAÇO
            return [
                'result' => false,
                'msg' => "Não é permitido espaço como primeiro e/ou último caractere do NOME!"
            ];
        }
        
        //////////////////////////////////////////////////
        //CELULAR
        //////////////////////////////////////////////////
        if(empty($celular)){//verificar  se está vazio
            return [
                'result' => false,
                'msg' => "Não é permitido o campo CELULAR ficar VAZIO"
            ];
        }
        
        if(!empty($celular) AND strlen($celular)<10){//se celular for diferente de vazio e o tamanho da string for menor que 10
            return [
                'result' => false,
                'msg' => "Número informado no campo CELULAR inválido."
            ];
        }
        
        ////////////////////////////////////////////////////
        //CONFIRMADO
        ////////////////////////////////////////////////////
        if($confirmado<1 OR $confirmado>3){//se confirmado for menor que 1 OR confirmado maior que 3
            return [
                'result' => false,
                'msg' => "Opção selecionada no campo CONFIRMADO inválida."
            ];
        }    
        
        ////////////////////////////////////////////////////
        //DATA EXPIRAÇÃO
        ////////////////////////////////////////////////////
        if(empty($dtExpiracao)){//verificar  se está vazio
            return [
                'result' => false,
                'msg' => "Não é permitido o campo DATA DE EXPIRAÇÃO ficar VAZIO"
            ];
        }
        
        if(!empty($dtExpiracao) AND (substr($dtExpiracao, 0, 1) == " " OR substr($dtExpiracao, -1) === " ")){
            //SE data de expiração FOR DIFERENTE DE VAZIO E O PRIMEIROU OU ÚLTIMO CARACTERE FOR ESPAÇO
            return [
                'result' => false,
                'msg' => "Não é permitido espaço como primeiro e/ou último caractere da DATA DE EXPIRAÇÃO!"
            ];
        }
        
        if(strlen($dtExpiracao)!==10){
            //SE QUANTIDADE DE DÍGITOS FOR DIFERENTE DE 10
            return [
                'result' => false,
                'msg' => "O campo DATA DE EXPIRAÇÃO deve ter obrigatóriamente 10 dígitos."
            ];
        }
        
        //caso esteja certo
        return ['result' => true, 'msg'=> "Validado com sucesso!"];
    }

}
