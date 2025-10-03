<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/sistema/util/login/logado.php';

use Dompdf\Dompdf;
use Dompdf\Options;

//INICIAR O DOMPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

//SIMULAR DADOS DO FUNCIONÁRIO (OU BUSCAR DO BANCO)
$funcionario = (object) [
    'nome' => 'João da Silva',
    'cpf' => '123.456.789-00',
    'data_assinatura' => date('d/m/Y')
];

//CSS SIMPLES PARA O PDF
$css = "
    body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.3; }
    h3 { font-size: 13.5pt; font-weight: bold; margin: 14pt 0 7pt 0; }
    p { margin: 7pt 0; }
    ul { margin: 0 0 14pt 20pt; padding: 0; }
    li { margin-bottom: 7pt; }
    strong { font-weight: bold; }
    .employee-info { margin-top: 7pt; }
    .employee-info p { margin: 3pt 0; }
";

//MONTAR HTML
$html = "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Termo de Sigilo</title>
    <style>{$css}</style>
</head>
<body>

<p><strong>TERMO DE SIGILO E CONFIDENCIALIDADE</strong></p>
<p><strong>[Nome do Site/Empresa]</strong>, inscrita no CNPJ sob n° [número], com sede em [endereço], por meio deste Termo, informa aos seus usuários que respeita a privacidade e a proteção dos dados pessoais, em conformidade com a LGPD (Lei n° 13.709/2018).</p>

<h3>1. DO OBJETO</h3>
<p>Este Termo tem como objetivo garantir o sigilo, a proteção e o uso responsável das informações pessoais coletadas no site [endereço do site], bem como preservar a confidencialidade dos dados fornecidos pelos usuários.</p>

<h3>2. DAS INFORMAÇÕES COLETADAS</h3>
<p>Podemos coletar dados pessoais como nome, e-mail, telefone, endereço IP, entre outros, necessários para a prestação dos serviços oferecidos pelo site.</p>

<h3>3. DA CONFIDENCIALIDADE E USO DOS DADOS</h3>
<ul>
    <li>Os dados coletados serão utilizados exclusivamente para as finalidades informadas no site, como cadastro, envio de informações e melhorias no serviço.</li>
    <li>Os dados não serão compartilhados com terceiros sem autorização prévia do usuário, exceto em casos previstos por lei.</li>
    <li>Adotamos medidas técnicas e administrativas para proteger os dados contra acessos não autorizados, perda ou divulgação indevida.</li>
</ul>

<h3>4. DOS DIREITOS DOS USUÁRIOS</h3>
<p>O usuário pode, a qualquer momento, solicitar acesso, correção, exclusão ou portabilidade de seus dados pessoais, conforme previsto na LGPD.</p>

<h3>5. DO PRAZO DE ARMAZENAMENTO</h3>
<p>Os dados serão armazenados pelo tempo necessário para cumprir as finalidades do tratamento ou para atender obrigações legais.</p>

<h3>6. DA RESPONSABILIDADE</h3>
<p>O usuário compromete-se a fornecer informações verdadeiras e atualizadas, bem como a respeitar as condições deste Termo.</p>

<h3>7. CONTATO</h3>
<p>Para dúvidas ou solicitações relacionadas a este Termo e à proteção de dados, entre em contato pelo e-mail: [e-mail de contato].</p>

<h3>8. INFORMAÇÕES DO FUNCIONÁRIO</h3>
<div class='employee-info'>
    <p><strong>Nome:</strong> {$funcionario->nome}</p>
    <p><strong>CPF:</strong> {$funcionario->cpf}</p>
    <p><strong>Data:</strong> {$funcionario->data_assinatura}</p>
</div>

<p style='margin-top:30pt;'><strong>Assinatura do Funcionário:</strong> _________________________________________</p>

</body>
</html>
";

//GERAR PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('termo_sigilo.pdf', ["Attachment" => 0]);
