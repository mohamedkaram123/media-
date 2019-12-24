<?php


function getCat(){
    global $con;
    
    $cats = $con->prepare("SELECT * FROM catagrous ORDER BY ID ASC ");
    $cats->execute();
    return $cats->fetchAll();}
  
        

    function getItem($wheer,$value){
        global $con;
        
        $items = $con->prepare("SELECT * FROM items WHERE $wheer = ? ORDER BY Item_ID DESC  ");
        $items->execute(array($value));
        return $items->fetchAll();
    }
      
      
    function checkstatues($name){ 
        global $con;
$stmt = $con->prepare("SELECT * FROM users WHERE Username = ? AND RegStatus =0 ");
$stmt->execute(array($name));
 return $stmt->rowCount();


    }



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


date_default_timezone_set("Africa/Cairo");






function timeago($datatime , $full=false){
    $now = new DateTime();
    $ago = new DateTime($datatime);

    $diff = $now->diff($ago);


    $diff->w = floor($diff->d / 7);
    $diff->d = $diff->w * 7;
    $string = [
        "y" => "year",
        "m" => "month",
        "w" => "week",
        "d" => "day",
        "h" => "hour",
        "i" =>  "minute",
        "s" => "second",
    ];

    foreach($string  as $k => &$v) {
        if($diff->$k) {
            $v = $diff->$k .' '.$v.($diff->$k > 1 ? 's' : '');
        }else{
            unset($string[$k]);
        }
    }

    if(!$full) $string = array_slice($string,0,1);
    return $string ? implode(', ',$string).' ago' : 'just now';
}


?>