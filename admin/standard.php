<?php
ob_start();
session_start();
$pageTitle="";
if(isset($_SESSION["username"])){

   include "ini.php";

$do = isset($_GET['do']) ? $_GET['do']:'Manage';




    include $tpl . "footer.php";
}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();
?>