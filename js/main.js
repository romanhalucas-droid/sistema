function loading() {
    $.blockUI({ 
        message: '<div class="spinner-border text-warning mr-1" role="status"></div>\n\
        <div class="align-items-center">Carregando...</div>'        
    });
}

$.blockUI.defaults.overlayCSS.zIndex = 1061; // Ajuste zIndex para o overlay
$.blockUI.defaults.css = { 
    padding: 0,
    margin: 0,
    width: '30%',
    top: '40%',
    left: '35%',
    textAlign: 'center',
    color: '#fff',
    cursor: 'wait',
    position: 'fixed', // Adicionado position: 'fixed'
    zIndex: 1061 // Ajuste zIndex para o bloco de mensagem
};

function getDateHour(){
    var d = new Date();
    datahora = (d.toLocaleString());
    return datahora;   
}

function retornoToast(retorno, datahora) {
    Cookies.set('retornoativo', 1, { secure: true });
    Cookies.set('retorno', retorno, { secure: true });
    Cookies.set('retornodatahora', datahora, { secure: true });
    var toastLiveExample = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastLiveExample);
    document.getElementById('dataToast').innerHTML = datahora;
    document.getElementById('conteudo-toast').innerHTML = retorno;
    toast.show();
}

$(document).ready(function () {
            
    window.addEventListener('readystatechange', function(e) {
        clearConsole();
        //console.log(window, e);
    });        
    
    if(Cookies.get('retornoativo')==1){
        retornoToast(Cookies.get('retorno'), Cookies.get('retornodatahora'));
    }
    
    $('#btnCloseToast').on('click', function () {                
       Cookies.remove('retornoativo');
       Cookies.remove('retorno');
       Cookies.remove('retornodatahora');
    });     
});
