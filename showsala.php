<?php

include("sistema/banco.php");

if (!isset($_GET["sala"])) {
    redir("./?errou");
}
$salaid = $_GET["sala"];

if (!salaExists($salaid)) {
    redir("./?errou");
}
$salarr = getSala($salaid);

$js = "";
$alunoideal = null;
if (isset($_GET["ideal"])) {
    $alunoideal = $_GET["ideal"];
    $js = "localStorage[\"numero\"] = " . $alunoideal[0] . $alunoideal[1] . ";
        localStorage[\"salaprova\"] = " . $salaid . ";";
}

$fileiraideal = null;
if (isset($_GET["fileira"])) {
    $fileiraideal = $_GET["fileira"];
}

function maketd($texto, $ano, $selec = false) {
    $class = "ano_$ano";
    if ($texto == "" || $texto === "º") $class .= " empty";
    if ($selec) $class .= " selec";
    return "<td class=\"$class\" align=\"center\">$texto</td>";
}
$tabela = "<tr class=\"anosrow\">";

for ($fileira = 1; $fileira <= 6; $fileira++) {
    $ano = $salarr["anos"][$fileira-1];
    $tabela .= maketd("${ano}º", $ano);
}
$tabela .= "</tr>";

$portacima = $salarr["portacima"];

$ultimoesq = 1;
for ($linha = 1; $linha <= 8; $linha++) {
    $pessoa = $salarr["fileiras"][0][$linha-1];
    if ($pessoa != "") $ultimoesq = $linha;
    else break;
}

for ($linha = 1; $linha <= 8; $linha++) {
    $tabela .= "<tr class=\"linhalugar\">";
    for ($fileira = 1; $fileira <= 6; $fileira++) {
        $pessoa = $salarr["fileiras"][$fileira-1][$linha-1];
        $selec = ($pessoa === $alunoideal && $fileira == $fileiraideal);
        $ano = $salarr["anos"][$fileira-1];
        if (($linha == 1 && $portacima) || ($linha == $ultimoesq && !$portacima)) {
            if ($fileira == 1) {
                $class = $portacima ? "upper" : "lower";
                $pessoa = "<div class=\"porta $class\">PORTA ➡</div>$pessoa";
            }
        }
        $tabela .= maketd($pessoa, $ano, $selec);
    }
    $tabela .= "</tr>";
}

?>

<html>
    <head>
        <title>Sala <?php echo $salaid; ?></title>
        <link rel="stylesheet" href="../sistema/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <?php include_once("sistema/analytics.php") ?>
        <h1>Sala de Prova nº <?php echo $salaid; ?></h1>
        Mais uma criação maluca do <a target="_blank" href="//licoes.com/licao/contato.html">Borginhos</a> (2º F)<br>
        <br>
        <a class="buttonlink" href="../">Pesquisar outras salas</a><br>
        <table class="lugares" style="display: inline-block;">
            <?php echo $tabela; ?>
        </table><br>
        <center class="lousa">L&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;U&nbsp;&nbsp;&nbsp;S&nbsp;&nbsp;&nbsp;A</center>
        <script>
            if (localStorage) {
                <?php echo $js; ?>
            }
        </script>
    </body>
</html>