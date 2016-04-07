<?php

include("sistema/banco.php");

if (!isset($_POST["ano"]) || !isset($_POST["letra"]) || !isset($_POST["numero"])) {
    redir("./?errou");
}

$ano = req_post("ano");
$letra = strtoupper(req_post("letra"));
$numero = req_post("numero");

if (empty($ano) || empty($letra) || empty($numero)) {
    error_log("empty");
    redir("./?errou");
}

if (strlen($numero) == 1) $numero = "0$numero";

$ideal = "$numero$letra";

$salas = getFullJSON();

foreach ($salas as $sala => $arr) {
    $fileiras = $arr["fileiras"];
    $anos = $arr["anos"];
    for ($fileira = 1; $fileira <= 6; $fileira++) {
        if ($anos[$fileira-1] != $ano) continue;
        if (in_array($ideal, $fileiras[$fileira-1])) {
            redir("./sala/${sala}_$fileira-$ideal");
            break;
        }
    }
}

redir("./?errou");

?>