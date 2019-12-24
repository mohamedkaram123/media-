<?php
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


echo '<div class="page-header header-filter" data-parallax="true" style="background-image:url('.$pathomguploads.');">';

            //   echo '<i id="i"></i>';
              //          echo '<div id="popo">';
                        
    
               //         echo '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
              //          echo '</div>';


}

?>