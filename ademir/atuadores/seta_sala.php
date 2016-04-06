<?php

include("../../sistema/banco.php");
require_login();

$sala = req_post("sala");

$anos = array();
$fileiras = array();
for ($fileira = 1; $fileira <= 6; $fileira++) {
    array_push($anos, req_post("a$fileira"));
    $fileirarr = array();
    for ($linha = 1; $linha <= 8; $linha++) {
        array_push($fileirarr, req_post("f${fileira}c${linha}"));
    }
    array_push($fileiras, $fileirarr);
}

setSala($sala, $anos, $fileiras, isset($_POST["portacima"]));

if (isset($_POST["editando"])) {
    redir("..");
} else {
    redir("../adicionar_sala.php");
}
?>