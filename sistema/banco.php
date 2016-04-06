<?php
// Onde a mágica acontece.

date_default_timezone_set("America/Sao_Paulo");

// Executa um redirecionamento relativo à URL atual.
function redir($relative) {
    $host  = $_SERVER["HTTP_HOST"];
    $uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/$relative");
    die("Redirecionamento em progresso...");
}

// Exige uma variável GET 100% esperada (e.g. de um form)
// e cancela a execução caso ela não esteja presente.
function req_get($str) {
    if (!isset($_GET[$str])) {
        die("Variável GET \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_GET[$str];
    }
}

// Exige uma variável POST 100% esperada (e.g. de um form)
// e cancela a execução caso ela não esteja presente.
function req_post($str) {
    if (!isset($_POST[$str])) {
        die("Variável POST \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_POST[$str];
    }
}

function validar_nome($nome) {
  $permitido = array("-", "_");

  return ctype_alnum(str_replace($permitido, "", $nome));
}

function currentDir() {
    return realpath(dirname(__FILE__)) . "/";
}

function make_salt() {
    return uniqid(rand(), true);
}

function make_guid() {
    mt_srand((double)microtime()*10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);
    $uuid =
         substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);
    return $uuid;
}

function getFullJSON($arq = "banco.json") {
    return json_decode(file_get_contents(currentDir() . $arq), true);
}

function setNewJSON($new_json, $arq = "banco.json") {
    file_put_contents(currentDir() . $arq, json_encode($new_json, JSON_HEX_TAG
    | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function salaExists($num) {
    return isset(getFullJSON()[$num]);
}

function getSala($num) {
    return getFullJSON()[$num];
}

function setSala($sala, $anos, $fileiras, $portacima) {
    $json = getFullJSON();
    $json[$sala] = array(
        "anos" => $anos,
        "fileiras" => $fileiras,
        "portacima" => $portacima
    );
    setNewJSON($json);
}

function removeSala($num) {
    $json = getFullJSON();
    unset($json[$num]);
    setNewJSON($json);
}

function getCredenciais() {
    return getFullJSON("credenciais.json");
}

function userExists($nome) {
    $credenciais = getCredenciais();
    foreach ($credenciais as $credencial) {
        if ($credencial["nome"] == $nome) return true;
    }
    return false;
}

function getCredencial($nome) {
    $credenciais = getCredenciais();
    foreach ($credenciais as $credencial) {
        if ($credencial["nome"] === $nome) return $credencial;
    }
}

// Checa se um login consta no banco de dados.
function isright($user, $pass) {
    if (!userExists($user)) return false;
    $credencial = getCredencial($user);
    $opaque = $credencial["opaque"];
    $salt = $credencial["salt"];
    $newopaque = hash("sha512", "${pass}${salt}");
    return $opaque === $newopaque;
}

// Insere o header de login na resposta do servidor.
function headauth($msg) {
    header("WWW-Authenticate: Basic realm=\"$msg\"");
    header("HTTP/1.0 401 Unauthorized");
    echo $msg;
    die("<br><br>Eu disse que tinha que fazer login...");
}

// Exige um certo login para a exibição da página.
// Se $wanted == "", aceita qualquer login menos "borginhos".
function require_login($wanted = "") {
    $username = null;
    $password = null;

    if (isset($_SERVER["PHP_AUTH_USER"])) {
        $username = $_SERVER["PHP_AUTH_USER"];
        $password = $_SERVER["PHP_AUTH_PW"];
    }

    if (is_null($username)) {
        headauth("Voce precisa fazer login para continuar!");
    } else {
        if (!userExists($username)) {
            headauth("Esse usuario nao existe!");
        }
        if ($username !== $wanted && $wanted != "")  {
            headauth("Esse login nao e o correto!");
        }
        if (!isright($username, $password)) {
            headauth("Senha incorreta!");
        }
    }
}

?>