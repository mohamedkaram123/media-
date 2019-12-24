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

            //   echo '<i id="i"></i>';
              //          echo '<div id="popo">';
                        
    
               //         echo '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
              //          echo '</div>';


}





}
 else if(isset($_GET["delete"])){
     

   unlink($_GET["delete"]); 
//echo $_GET["delete"];

$stmt = $con->prepare("SELECT avatar FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$row =$stmt->fetch();

$pathomguploads = "uploads/avatars/" . $row["avatar"];


echo "<img src=".$pathomguploads." id='imge' class='img'  data-delete=".$pathomguploads.">";

//echo '<i id="i"></i>';
//echo '<div id="popo">';
//echo '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
//echo '</div>';


 }else if(isset($_GET["avatar"])){
     

    $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();
    
    
    
    
    $sessionid = $row[0];
    
    
    
    
    $stmt = $con->prepare("UPDATE users SET avatar = ? WHERE UserID =?  ");
    $stmt->execute(array($_GET["avatar"],$row[0]));
    $count = $stmt->rowCount();

    $pathomguploads = "uploads/avatars/" . $_GET["avatar"];

    echo "<img src=".$pathomguploads." id='imge' class='img' data-delete=".$pathomguploads.">";

  //  echo   '<i class="fas fa-camera"></i>';
    //echo '<div id="popo"></div>';
   //echo  '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
 
 
 
  }else if(isset($_FILES['file3']['name'])){




    $avatarName =$_FILES['file3']['name'];
    $avatarSize =$_FILES['file3']['size'];
    $avatarType =$_FILES['file3']['type'];
    $avatarTmpName =$_FILES['file3']['tmp_name'];
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
    
    $pathomguploads = "uploads/covers/" . $avatar;
    
    move_uploaded_file($avatarTmpName,$pathomguploads); 
    
    echo '<div class="page-header header-filter" id="img_cover" data-deletecover='.$pathomguploads.' data-parallax="true" data-src='.$avatar.' style="background-image:url('.$pathomguploads.');">';
    echo '<i class="fas fa-camera iconcamera"></i>';
    echo '<input type="file" id="file3" class="covering" name="cover" />'; 
    echo '<input type="submit" class="save-cover" name="save_cover" value="save"/>';
    echo '<input type="submit" class="delete-cover" name="delete_cover" value="cancel"/>'; 
    echo '</div>';

    
                //   echo '<i id="i"></i>';
                  //          echo '<div id="popo">';
                            
        
                   //         echo '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
                  //          echo '</div>';
    
    
    }
  }  
  else if(isset($_GET["save_cover"])){
     

    $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();
    
    
    
    
    $sessionid = $row[0];
    
    
    
    
    $stmt = $con->prepare("UPDATE users SET cover = ? WHERE UserID =?  ");
    $stmt->execute(array($_GET["save_cover"],$row[0]));
    $count = $stmt->rowCount();

    $pathomguploads = "uploads/covers/" . $_GET["save_cover"];

    echo '<div class="page-header header-filter" data-src='. $_GET["save_cover"].' data-deletecover='.$pathomguploads.' data-parallax="true" style="background-image:url('.$pathomguploads.');">';
    echo '<i class="fas fa-camera iconcamera"></i>';
    echo '<input type="file" id="file3" class="covering" name="cover" />'; 
  //  echo   '<i class="fas fa-camera"></i>';
    //echo '<div id="popo"></div>';
   //echo  '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
 
 
 
  } else if(isset($_GET["delete_cover"])){
     

    unlink($_GET["delete_cover"]); 
 //echo $_GET["delete"];
 
 $stmt = $con->prepare("SELECT cover FROM users Where Username = ?");
 $stmt->execute(array($_SESSION['user']));
 $row =$stmt->fetch();
 
 $pathomguploads = "uploads/covers/" . $row["cover"];
 

 echo '<div class="page-header header-filter" data-src='.$row["cover"].' data-deletecover='.$pathomguploads.' data-parallax="true" style="background-image:url('.$pathomguploads.');">';
 echo '<i class="fas fa-camera iconcamera"></i>';
 echo '<input type="file" id="file3" class="covering" name="cover" />'; 
 
 //echo '<i id="i"></i>';
 //echo '<div id="popo">';
 //echo '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
 //echo '</div>';
 
 
  }

?>