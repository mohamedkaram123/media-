<?php
ob_start();
session_start();

include "includes/functions/function.php";

include "connect.php";

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
 

 
if(empty($eroroarray)){



    
$random =  rand(1,1000000);

$avatar =  $random . $avatarName;

//echo $avatar;

$pathomguploads = "uploads/Comments/" . $avatar;

move_uploaded_file($avatarTmpName,$pathomguploads); 


//echo   '<input type="hidden" id="imgupload"  data-avatar='.$avatar.'>';


echo '<div  class="photor">';

echo '<a><i id="icon"></i></a>';
 echo "<img src=".$pathomguploads." id='im' class='img-photor' data-img=".$avatar." data-delete=".$pathomguploads.">";
 echo   '<input type="submit" id="send" class="sendphoto" value="send" data-avatar='.$avatar.'>';

 echo '</div>';




}





}else if(isset($_POST['pathdelete'])){


    unlink($_POST['pathdelete']); 
}

else if(isset($_POST["dataavatar"])){
    ?>
<?php

    $stmt = $con->prepare("SELECT UserID FROM users WHERE Username = ?");
    $stmt->execute(array( $_SESSION['user']));
    $rowid = $stmt->fetch();

    $stmt = $con->prepare("INSERT INTO comments (CommentPhoto,Post_ID,User_ID,Date_Comment)
            VALUES (?, ?, ?,now());");
            $stmt->execute(array($_POST["dataavatar"],$_POST["postid"],$rowid["UserID"]));
         $count = $stmt->rowCount();

         if($count > 0){ 

    
    
         
            
             
            $stmt = $con->prepare("SELECT comments.*,users.avatar,users.Username ,posts.Post_ID  FROM comments 
            INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
            INNER JOIN users ON users.UserID = comments.User_ID 
            where posts.Post_ID  = ? and users.UserID = ? and  comments.CommentPhoto = ?
           LIMIT 1");
            $stmt->execute(array($_POST["postid"],$rowid["UserID"],$_POST["dataavatar"]));
            $rows =$stmt->fetchAll();
            foreach($rows as $row){ 
             
             echo  '<div class="comment-text">';
            
             echo '<div class="  conimg-text">';
                           
             $stmt = $con->prepare("SELECT avatar ,Username FROM users Where UserID = ?");
             $stmt->execute(array($rowid["UserID"]));
             $rowe =$stmt->fetch();
             
             
             $pathomguploads = "uploads/avatars/" . $rowe["avatar"];
             
             
                       echo "<img src=".$pathomguploads." id='imge' class='img-text'  data-delete=".$pathomguploads.">" ;
                       echo "<span class='namephoto'>".$rowe["Username"] ."</span>" ;


             echo   '</div>';
             echo '<div class="commentsphoto">';
             
            
             $pathomguploads = "uploads/Comments/" . $_POST["dataavatar"];
             
             
             echo "<img src=".$pathomguploads." id='imgcomment' class='img-comment' width='370px' height='300px' >";


             echo '</div>';
             
             echo '</div>';
             echo "<span class='date_span2'>".timeago($row["Date_Comment"])."</span>";
            
            }
            
            }
        
        
}

/*else if(isset($_POST['id']) &&  isset($_POST['dataavatar']) ){
     
   // echo $_POST['dataavatar'];

    $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();
    
    
    
    
    $sessionid = $row[0];
    
    
 //   echo $_POST['dataavatar'];
    $stmt1 = $con->prepare("INSERT INTO con2 (MsgUpload, User_ID, User_ID2) VALUES (?,?,?);");
$stmt1->execute(array($_POST['dataavatar'],$sessionid,$_POST['id']));
$count = $stmt1->rowCount();


$pathomguploads = "uploads/MsgPhoto/" . $_POST['dataavatar'];

$stmt = $con->prepare("SELECT con2.*,users.Username as user_Name FROM con2 INNER JOIN users ON users.UserID = ?");
$stmt->execute(array($_POST['id']));
$name = $stmt->fetch();


$stmt = $con->prepare("SELECT * from con2 where User_ID = ? AND  User_ID2=? or  User_ID = ? AND  User_ID2=?  ORDER BY C_ID2 ASC ;");
        $stmt->execute(array($row[0],$_POST['id'],$_POST['id'],$sessionid));
        $rows =$stmt->fetchAll();
        echo   '<input type="hidden" id="custId" name="getid" value='.$_POST['id'].'>';
        
        echo   '<div class="top"><span><span class="name">From: '.$_SESSION['user'].' To: '.$name['user_Name'].'</span></span></div>';
      
        echo "<div class='edit'>";
 
    foreach($rows as $row){ 
   
if($row['User_ID'] === $sessionid){

    echo  '<div class="bubble me "> me:';


}else{
    echo  '<div class="bubble you "> you:';
}
        
$pathomguploads = "uploads/MsgPhoto/" . $row["MsgUpload"];
if($row["MsgUpload"]){ 
        echo '<img src='.$pathomguploads.' width="300px" height="200px" />';  
     }
         if($row["Msg"]){
            echo $row['Msg'];
        }
       echo '</div>';
       
    };
       
        echo  "</div>";
         echo  "</div>";
}*/

 
  


?>