$(document).ready(function (){
    
    //////////////////////////
    //SALVAR
    //////////////////////////
    $('formcadastrarconvidados').submit(function(e){
        //garante que o formulário não vai ser enviado ao clicar em salvar
        e.preventDefault();
        
        //bloqueio temporário da tela (evitar duplo clique)
        $(document).ajaxStart(loading().ajaxStop($.unblockUI));
        
        //carregar informações do formulário
        let form = $(this);
        
        //requisição ajax (post)
        $.post(form.attr('action'), form.serialize(), function (retorno){
            //verificar se o retorno foi com sucesso
            let resultado = retorno.indexOf("success") != -1;
            
            //mostrar o resultado para o usuário
            retornoToast(retorno, getDateHour());
            
            //verificar se o resultado foi maior que 0 (sucesso)
            if(resultado > 0){
                window.location.href = "/html/sistema/view/convidados/listar.php";
            }
        });
        return false;
    });
    
    //////////////////////////
    //EXCLUIR
    //////////////////////////
    $('#btnExc').on('click', function(e){
        e.preventDefault();
        //CAIXA DE CONFIRMAÇÃO DE EXCLUSÃO
        bootbox.confirm({
            
        });
    });
    
});