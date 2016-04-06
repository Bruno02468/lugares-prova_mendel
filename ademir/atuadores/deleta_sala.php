<?php

include("../../sistema/banco.php");
require_login();

$sala = req_get("sala");

removeSala($sala);

redir("..");
?>