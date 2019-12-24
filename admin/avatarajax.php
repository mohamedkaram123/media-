<?php
session_start();





//print_r($_POST);

include "connect.php";



//print_r($_POST);

if(isset($_FILES['file']['name'])){




$avatarName =$_FILES['file']['name'];
$avatarSize =$_FILES['file']['size'];
$avatarType =$_FILES['file']['type'];
$avatarTmpName =$_FILES['file']['tmp_name'];
$avatarAllowExetention = array("jpg","jpeg","png","gif");


$avatarExetention =  strtolower(end(explode(".","$avatarName")));

$eroroarray = array();

if(! empty($avatarName) && ! in_array($avatarExetention,$avatarAllowExetention)){

    $eroroarray[] =  "<div class='alert alert-danger'> not allowed type is image </div>" ;

}
if(empty($avatarName)){

    $eroroarray[] =  "<div class='alert alert-danger'> not allowed input impage empty</div>" ;

}
if($avatarSize > 4194304){

    $eroroarray[] =  "<div class='alert alert-danger'> Avatar Cant be larger than 4mB</div>" ;

}


foreach ($eroroarray as $error) {
    echo $error ;
 
 };
 
     /**/
 
if(empty($eroroarray)){



    
$random =  rand(1,1000000);

$avatar =  $random . $avatarName;

//echo $avatar;

$pathomguploads = "uploads/avatars/" . $avatar;

move_uploaded_file($avatarTmpName,$pathomguploads); 


echo "<img src=".$pathomguploads." id='imge' class='img' data-img=".$avatar." data-delete=".$pathomguploads.">";

/*$stmt = $con->prepare("INSERT INTO avatars (avatar)
VALUES (?); ");
$stmt->execute(array($avatar));
$count = $stmt->rowCount();

if($count > 0){
    
    $stmt = $con->prepare("SELECT avatar FROM avatars");
    $stmt->execute();
    $rows = $stmt->fetchAll();

foreach($rows as $row){

    echo "<img src=uploads/avatars/".$row[0]." height='150' width='200' class='img-thumbnail'>";
   // echo $row[0] ."<br>";
}


}*/





}
 }else if(isset($_GET["delete"])){
     

   unlink($_GET["delete"]); 
//echo $_GET["delete"];
   echo   '<i class="fas fa-camera"></i>';
   echo '<div id="popo"></div>';
  echo  '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';



 }

?>