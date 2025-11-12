<?php
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/conexao/inicio_conexao.php";
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/Funcoes.php";
require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/dao/ConvidadosDAO.php";

$id = empty($_GET['id']) ? 0 : $_GET['id'];
$convidado = null;

if (!empty($id)){
    try{
        
        $convidado = ConvidadosDAO::selectIndex(['conn' => $conn_db, 'id' => $id])[0];
        $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, false); //desativando save automático
        $conn_db->beginTransaction(); //iniciar conexão manualmente
        
        $convidado->setVistoPorUltimo(getDatetimeNow());
        
        $timeHoje = strtotime(date('Y-m-d')); //convertendo data para formato numérico
        $timeDtExp = strtotime($convidado->getDtExpiracao()); //convertendo data para formato numérico
        
        if(ConvidadosDAO::save(['conn' => $conn_db, 'obj' => $convidado])){
            $conn_db->commit();//salvar alteração (visto por ultimo)
        }else{
            $conn_db->rollBack();//desfazer alteração
        }
                
        
    } catch (Exception $e) {
        $conn_db->rollBack();    
        echo $e->getMessage();
    } catch (SQLException $e) {
        $conn_db->rollBack();    
        echo $e->getMessage();
    }finally{
        $conn_db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Convite Especial | Confraternização de Final de Ano 🎉</title>
    <?php require_once $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/estrutura/cabecalho.php"; ?>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #f9d65c;
            --dark: #0f172a;
            --light: #f9fafb;
            --accent: #d90429;
            --success: #06d6a0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b, #0f172a);
            color: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .convite-container {
            width: 95%;
            max-width: 750px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
            overflow: hidden;
            animation: fadeIn 1s ease forwards;
        }

        header {
            background: linear-gradient(135deg, #ffd166, #fcbf49, #f77f00);
            color: #0f172a;
            text-align: center;
            padding: 2.5rem 1rem;
            position: relative;
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            margin: 0;
            letter-spacing: 1px;
        }

        header span {
            display: block;
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .convite-body {
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .convite-body h2 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--gold);
        }

        .convite-body p {
            line-height: 1.7;
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
            color: #f8fafc;
        }

        .convite-info {
            margin: 2rem 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 1.5rem 0;
        }

        .convite-info strong {
            color: var(--gold);
        }

        .convite-info a {
            color: var(--gold);
            text-decoration: none;
        }

        .convite-info a:hover {
            text-decoration: underline;
        }

        .btn-group {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-convite {
            display: inline-block;
            font-weight: 600;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-size: 1rem;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-confirmar {
            background: linear-gradient(135deg, #06d6a0, #059669);
            color: #fff;
        }

        .btn-confirmar:hover {
            background: linear-gradient(135deg, #04b486, #06d6a0);
            transform: scale(1.05);
        }

        .btn-negar {
            background: linear-gradient(135deg, #ef476f, #d62839);
            color: #fff;
        }

        .btn-negar:hover {
            background: linear-gradient(135deg, #d62839, #ef476f);
            transform: scale(1.05);
        }

        .assinatura {
            margin-top: 2.5rem;
            font-style: italic;
            color: rgba(255,255,255,0.7);
        }

        footer {
            text-align: center;
            font-size: 0.85rem;
            opacity: 0.6;
            padding: 1rem 0 1.5rem;
        }

        /* ANIMAÇÕES */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes sparkle {
            0%,100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        .sparkles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0; left: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .sparkle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            animation: sparkle 3s infinite;
        }

        /* responsivo */
        @media (max-width: 600px) {
            header h1 { font-size: 1.9rem; }
            .convite-body { padding: 2rem 1rem; }
            .btn-convite { width: 100%; }
        }
    </style>
</head>

<body>
    <div class="convite-container">
        <header>
            <h1>Confraternização de Final de Ano</h1>
            <span>Um brinde às conquistas e à amizade!</span>
            <div class="sparkles">
                <?php for ($i = 0; $i < 15; $i++): ?>
                    <div class="sparkle" style="
                        top: <?=rand(0,100)?>%;
                        left: <?=rand(0,100)?>%;
                        animation-delay: <?=rand(0,3)?>s;
                    "></div>
                <?php endfor; ?>
            </div>
        </header>

        <div class="convite-body">
            <?php if(!empty($convidado) AND !empty($convidado->getId())): ?>
                
                <h2><?=saudacao()?>, <strong><?=$convidado->getNome() ?></strong>!</h2>

                <?php if($convidado->getConfirmado()==2): ?>
                    <p>Você já informou que não poderá comparecer 😢<br>
                    Caso queira mudar sua resposta, fale conosco — será uma alegria recebê-lo!</p>

                <?php elseif ($timeHoje <= $timeDtExp OR $convidado->getConfirmado()<>1): ?>

                    <p>Será uma honra ter sua presença em nossa celebração de encerramento de ano!
                    Vamos juntos brindar às vitórias e fortalecer os laços que construímos. 🥂</p>

                    <div class="convite-info">
                        <p><strong>📍 Local:</strong><br>
                            <a href="https://maps.app.goo.gl/w85uoMyjpTB91u5V9" target="_blank">
                                SENAC (Colatina)<br>Av. Adauto Barcelos de Carvalho, 400 - Esplanada, Colatina/ES
                            </a>
                        </p>
                        <p><strong>🗓 Data e Hora:</strong><br>12 de Dezembro de 2025 - 19h</p>
                    </div>

                    <?php if($convidado->getConfirmado()==3): ?>
                        <p>✅ Sua presença já foi confirmada! Mal podemos esperar para celebrar com você! 🎉</p>
                    <?php endif ?>

                    <?php if($timeHoje <= $timeDtExp AND $convidado->getConfirmado()==1): ?>
                        <p>Por favor, confirme sua presença até <strong><?= dtSqlToBrasil($convidado->getDtExpiracao()) ?></strong>:</p>
                        <div class="btn-group">
                            <a href="/html/sistema/validacao/convite/confirmar_convite.php?id=<?=$convidado->getId()?>&confirmado=3"
                               class="btn-convite btn-confirmar">Sim, estarei presente! 🎊</a>

                            <a href="/html/sistema/validacao/convite/confirmar_convite.php?id=<?=$convidado->getId()?>&confirmado=2"
                               class="btn-convite btn-negar">Infelizmente não poderei comparecer 😔</a>
                        </div>
                    <?php endif ?>

                <?php else: ?>
                    <p>O prazo para confirmação foi encerrado 😞<br>
                    Esperamos que compreenda e saiba que estará conosco em pensamento!</p>
                <?php endif ?>

                <div class="assinatura">
                    Com carinho,<br>
                    <strong>Turma de Desenvolvimento de Sistemas 💻</strong>
                </div>

            <?php else: ?>
                <h2>Convidado não encontrado 😕</h2>
            <?php endif ?>
        </div>

        <footer>
            © <?=date('Y')?> - Confraternização da Turma DS | Todos os direitos reservados
        </footer>
    </div>

    <script nonce='<?= uniqid()?>'>
        document.addEventListener('DOMContentLoaded', function(){
            $(".btn-convite").on("click", function (e){
                e.preventDefault();
                const confirmar = $(this).hasClass('btn-confirmar');
                bootbox.confirm({
                    title: "Confirmação de Presença",
                    message: confirmar ? 
                        "Você confirma que estará presente na confraternização? 🎉" :
                        "Você confirma que NÃO estará presente? 😢",
                    buttons:{
                        confirm:{ label: "Sim", className: "btn-success" },
                        cancel:{ label: "Não", className: "btn-danger" }
                    },
                    callback: function(result){
                        if(result){ window.location.href = e.target.href; }
                    }
                });
            });
        });
    </script>

    <?php $_SERVER['DOCUMENT_ROOT']."/html/sistema/util/estrutura/rodape.php" ?>
</body>
</html>
