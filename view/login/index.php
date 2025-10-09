<!doctype html>
<html>
    <head>
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/cabecalho.php"; ?>
        <title>LOGIN | SISTEMA</title>        
    </head>
    <body>        
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh">   
            <div class="card bg-light mt-1 w-100" style="max-width: 30rem">
                <div class="card-body">
                    <div class="resultado"></div>                    
                    <form id="formlogin" name="formlogin" method="post" action="/html/sistema/validacao/login/login.php">
                        
                        <div class="form-floating">
                            <input 
                                type="text" 
                                placeholder="Usuário..." 
                                class="form-control" 
                                id="usuario" 
                                name="usuario"
                                autocomplete="username"
                                autofocus
                                required                                
                            />
                            <label for="usuario"><i class="bi bi-person-circle" aria-hidden="true"></i> Digite o usuário...</label>
                        </div>
                        
                        <div class="form-floating mt-1 mb-3">
                            <input
                                type="password"
                                placeholder="Senha..."
                                class="form-control"
                                id="senha"
                                name="senha"
                                autocomplete="current-password" 
                                required
                            />
                            <label for="senha"><i class="bi bi-shield-lock" aria-hidden="true"></i> Digite a senha...</label>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <button 
                                    type="submit"
                                    id="btnlogar"
                                    name="btnlogar"
                                    class="btn btn-lg w-100 btn-primary"
                                >
                                    <i class="bi bi-door-open-fill"></i> Entrar
                                </button>                                 
                            </div>
                        </div>
                        
                    </form>         
                </div>
            </div>
        </div>
        
        <script nonce="<?= uniqid()?>">
            $('#formlogin').submit(function (e) {
                e.preventDefault();
                $(document).ajaxStart(loading()).ajaxStop($.unblockUI);
                let form = $('#formlogin');
                $.post(form.attr('action'), form.serialize(), function(retorno){
                   $('.resultado').html(retorno);
                });
            });
        </script>        
        
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/html/sistema/util/estrutura/rodape.php"; ?>
    </body>
</html>