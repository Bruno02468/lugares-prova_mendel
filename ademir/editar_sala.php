<?php

include("../sistema/banco.php");
require_login();

$salanum = req_get("sala");
$sala = getSala($salanum);

$js = "";
function setVal($id, $val) {
    return "document.getElementById(\"$id\").value = \"$val\";";
}

for ($fileira = 1; $fileira <= 6; $fileira++) {
    $js .= setVal("a$fileira", $sala["anos"][$fileira-1]);
    for ($linha = 1; $linha <= 8; $linha++) {
        $js .= setVal("f${fileira}c${linha}", $sala["fileiras"][$fileira-1][$linha-1]);
    }
}

?>

<html>
    <head>
        <title>Editando sala</title>
        <link rel="stylesheet" href="../sistema/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Editando sala</h1>
        <a class="buttonlink" href=".">Voltar ao Painel</a><br>
        <br>
        <br>
        <form method="POST" action="atuadores/seta_sala.php">
            <input type="hidden" name="editando" value="sim">
            Sala nº <input type="number" class="selsala" min="203" max="312" value="203" name="sala"><br>
            <br>
            Anos: <table id="sala" style="display: inline-block;"></table><br>
            <br>
            <input type="checkbox" name="portacima"<?php if($sala["portacima"]) echo " checked"; ?>>A porta está do lado de cima<br>
            <br>
            <input class="buttonlink btnblue" type="submit" value="Salvar sala">
        </form>
        ou você pode <a class="buttonlink btnred" href="atuadores/deleta_sala.php?sala=<?php echo $salanum; ?>">deletar esta sala.</a>
        <script>
            var tabela = document.getElementById("sala");
            var anorow = document.createElement("tr");
            for (var fileira = 1; fileira <= 6; fileira++) {
                var anosel = document.createElement("td");
                var numimp = document.createElement("input");
                numimp.setAttribute("type", "number");
                numimp.setAttribute("min", "1");
                numimp.setAttribute("max", "3");
                numimp.setAttribute("value", (fileira-1)%3+1);
                numimp.setAttribute("class", "selano");
                numimp.setAttribute("id", "a" + fileira);
                numimp.setAttribute("name", "a" + fileira);
                anosel.appendChild(numimp);
                anorow.appendChild(anosel);
            }
            anorow.innerHTML += "<br>";
            tabela.appendChild(anorow);

            for (var linha = 1; linha <= 8; linha++) {
                var row = document.createElement("tr");
                for (var fileira = 1; fileira <= 6; fileira++) {
                    var td = document.createElement("td");
                    var inp = document.createElement("input");
                    inp.setAttribute("name", "f" + fileira + "c" + linha);
                    inp.setAttribute("id", "f" + fileira + "c" + linha);
                    inp.setAttribute("type", "text");
                    inp.setAttribute("autocomplete", "off");
                    inp.style.width = "2.5em";
                    td.appendChild(inp);
                    row.appendChild(td);
                }
                tabela.appendChild(row);
            }

            <?php echo $js; ?>
        </script>
    </body>
</html>