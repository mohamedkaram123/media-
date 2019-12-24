<?php
include "connect.php";

$tpl ="includes/tamplates/";

$js = "layout/js/";
$css = "layout/css/";
$func = "includes/functions/";
$lang = "includes/langues/";


include $func . "function.php";
include  $lang . "english.php";
include $tpl  . "header.php";



if(!isset($navbar)){

    include $tpl  . "nav.php";

}


