<?php

function getTitle(){ 

global $pageTitle;
    if(isset($pageTitle)){

echo $pageTitle;

}else{

    echo "Default";
}


}

function redirctHome($errormsg ,$url =null , $seconds=3){
    echo $errormsg;
if($url === null){
    $url = "index.php";

    $link ="HomePage"; 
}
else if($url === "member.php?do=Manage"){

    $url = "member.php?do=Manage";
    $link ="Manage Page";
}
else{

   // $url = isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "" ?$url = $_SERVER["HTTP_REFERER"]:$url = "index.php";
    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "" ){
    $url = $_SERVER["HTTP_REFERER"];
    $link ="Previos Page";
}

else{
    $url = "index.php";
    $link ="HomePage";
}

}
echo "<div class ='alert alert-info'>You Will be Redirect to $link After <span id = time>$seconds</span> Seconds</div>";
header("refresh:$seconds; url=$url");
exit();
}


function checkItem($select,$from,$valeu){

    global $con;

    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select= ?");
    $stmt->execute(array($valeu));
    $row1 = $stmt->rowCount();
   return $row1;
}

//v1
/*function countItems($columncount,$table){
    global $con;
    $stmt = $con->prepare("SELECT count($columncount) from $table");
$stmt->execute();
return $stmt->fetchColumn();

}*/
//v2
function countItems($columncount,$table , $value=""){
    global $con;
    if($value === ""){
        $value =$columncount;
        
    }
    $stmt = $con->prepare("SELECT count($columncount) from $table Where $columncount =$value");
$stmt->execute();
return $stmt->fetchColumn();

}



function getLateast($select,$table,$oreder,$limit = 5 ,$where = "WHERE GroupID != 1"){
    global $con;
    if($table === "users"){ 
    $stmt = $con->prepare("SELECT $select FROM $table $where ORDER BY $oreder DESC  Limit $limit ");
    $stmt->execute();
    return $stmt->fetchAll();}
    else{

        $stmt = $con->prepare("SELECT $select FROM $table  ORDER BY $oreder DESC  Limit $limit ");
        $stmt->execute();
        return $stmt->fetchAll();}
    
}

?>