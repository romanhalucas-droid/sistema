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
           size: "small",
           message: "Deseja remover esse registro?",
           buttons:{
               confirm: {
                   label: "<i class='bi bi-check-circle me-1'></i>Sim",
                   className: 'btn-success'
               },
               cancel: {
                   label: "<i class='bi bi-x-circle me-1'></i>Não",
                   className: 'btn-danger'
               }
           },
           callback: function(result){
               //SE HOUVER RESULTADO, EXECUTAR OPERAÇÃO
               if(result){                                      
                   $(document).ajaxStart(loading()).ajaxStop($.unblockUI); //BLOQUEAR TELA ENQUANTO OCORRE A EXCLUSÃO
                   let form = $("#formcadastrarconvidados");                   
                   $.post('/html/sistema/validacao/convidados/excluir.php', form.serialize(), function(retorno){
                        let resultado = retorno.indexOf('success') != 1;
                        retornoToast(retorno, getDateHour());
                        
                        if(resultado > 0){ //VERIFICAR SE RESULTADO FOI POSITIVO
                            window.location.href = "/html/sistema/view/convidados/listar.php";
                        }                        
                   });
               }
           }
        });
    });
    
});