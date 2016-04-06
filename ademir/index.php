<?php

include("../sistema/banco.php");
require_login();

$salalinks = "";

$salas = getFullJSON();

foreach ($salas as $sala => $arr) {
    $salalinks .= "<a class=\"buttonlink smallbtn btnblue\" href=\"editar_sala.php?sala=$sala\">$sala</a><br>";
}

?>
<html>
    <head>
        <title>Painel Administrativo</title>
        <link rel="stylesheet" href="../sistema/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>

    <body style="text-align: center;">
        <h1>Painel Administrativo</h1>
        <small>Tudo programado por Bruno Borges Paschoalinoto (2º F)</small>
        <br>
        <br>
        <br>
        <div class="h2">
            <a class="buttonlink bigbtn btnred" href="..">Voltar para a página inicial</a><br>
            <br>
            <a class="buttonlink bigbtn" href="adicionar_sala.php">Adicionar uma sala</a><br>
            <br>
            Editar sala:<br>
            <?php echo $salalinks; ?>
        </div>
    </body>
</html>