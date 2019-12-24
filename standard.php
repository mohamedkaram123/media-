<?php
ob_start();
session_start();
$pageTitle = "Login";
if(isset($_SESSION['user'])){


include "ini.php";




    include $tpl . "footer.php";

}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();

?>