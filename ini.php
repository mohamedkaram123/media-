<?php

ini_set('display_errors','on');
error_reporting(E_ALL);

include "admin/connect.php";

$sessionUser = "";
if(isset($_SESSION["user"])){
    $sessionUser = $_SESSION["user"];
}

$tpl ="includes/tamplates/";

$js = "layout/js/";
$css = "layout/css/";
$func = "includes/functions/";
$lang = "includes/langues/";


include $func . "function.php";
include  $lang . "english.php";
include $tpl  . "header.php";






