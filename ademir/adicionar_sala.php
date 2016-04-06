<?php

include("../sistema/banco.php");
require_login();

?>

<html>
    <head>
        <title>Adicionar sala</title>
        <link rel="stylesheet" href="../sistema/estilo.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Adicionar sala</h1>
        <a class="buttonlink" href=".">Voltar ao Painel</a><br>
        <br>
        <br>
        <form method="POST" action="atuadores/seta_sala.php">
            Sala nº <input type="number" class="selsala" min="203" max="312" value="203" name="sala"><br>
            <br>
            Anos: <table id="sala" style="display: inline-block;"></table><br>
            <br>
            <input type="checkbox" name="portacima">A porta está do lado de cima<br>
            <br>
            <input class="buttonlink btnblue" type="submit" value="Adicionar sala">
        </form>

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
        </script>
    </body>
</html>