<html>
    <head>
        <title>Lugares de Prova</title>
        <link rel="stylesheet" href="sistema/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <?php include_once("sistema/analytics.php") ?>
        <h1>Lugares de Prova</h1>
        <a class="buttonlink btnorange" href="//licoes.com/licao">Lições</a><br>
        <br>
        <a class="buttonlink btnorange" href="//licoes.com/resumos">Resumos</a><br>
        <br>
        <a class="buttonlink btnblue smallbtn" href="ademir/">Administrar</a><br>
        <br>
        Mais uma criação maluca do <a target="_blank" href="//licoes.com/licao/contato.html">Borginhos</a> (2º F)<br>
        <br>
        <big><big>
            <?php
                if (isset($_GET["errou"])) {
                    echo "<span class=\"errou\">Parece que algo de errado não deu certo.<br>Tente novamente.</span><br>";
                }
            ?>
            <br>
            <form action="iraluno.php" method="POST">
                Sua sala: <input class="selano" type="number" min="1" max="3" value="" id="ano" name="ano">º
                <input type="text" name="letra" class="seletra" id="letra" autocomplete="off" value=""><br>
                Seu número: <input class="selnum" id="numero" type="number" min="1" max="40" value="" name="numero"><br>
                <input type="submit" class="buttonlink" value="Só vai">
            </form>
            Já sabe a sua sala?<br>
            <form onsubmit="return vaisala();">
                Sala: <input type="number" class="selsala" autocomplete="off" min="203" max="312" value="" name="sala" id="sala"><br>
                <input type="submit" class="buttonlink" value="Só vai">
            </form>
        </big></big>
        <script>
            function vaisala() {
                location.href = "sala/" + document.getElementById("sala").value;
                return false;
            }
            if (localStorage) {
                if (localStorage["sala"].length == 2) {
                    document.getElementById("ano").value = localStorage["sala"][0];
                    document.getElementById("letra").value = localStorage["sala"][1];
                }
                if (localStorage["numero"]) {
                    document.getElementById("numero").value = localStorage["numero"];
                }
                if (localStorage["salaprova"]) {
                    document.getElementById("sala").value = localStorage["salaprova"];
                }
            }
        </script>
    </body>
</html>