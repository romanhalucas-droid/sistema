<?php
//BLOQUEAR ACESSO DIRETO AO ARQUIVO
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('location:/html/sistema/view/inicio/');
}

require_once $_SERVER['DOCUMENT_ROOT'] .'/html/sistema/util/login/logado.php';
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />       
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />                
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" type="text/css"/> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />         

<!-- DATATABLE -->       
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.css" rel="stylesheet" />                                  
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" />                       
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css" />                       
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css" />                       
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.0.3/css/colReorder.bootstrap5.min.css" /> 


<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.js"></script>                
<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/jquery-blockui@2.7.0/jquery.blockUI.js"></script>
<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.js"></script>        
<script nonce="<?= uniqid() ?>" src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>                
<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>        
<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>
<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>        

<!-- DATATABLE -->        
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>       
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>        
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.min.js"></script>        
<script nonce="<?= uniqid() ?>" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script nonce="<?= uniqid() ?>" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.0-beta.7/pdfmake.min.js"></script>
<script nonce="<?= uniqid() ?>" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.0-beta.7/vfs_fonts.min.js"></script>        
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>        
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>        
<script nonce="<?= uniqid() ?>" src="https://cdn.datatables.net/colreorder/2.0.3/js/dataTables.colReorder.min.js"></script>         

<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>        
<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>

<script nonce="<?= uniqid() ?>" src="https://cdn.jsdelivr.net/npm/bootbox@6.0.0/bootbox.js"></script>

<script nonce="<?= uniqid() ?>" src="/html/sistema/js/main.js"></script>

<style>
    input:required:invalid {
        border-color: red;
    }
</style>

