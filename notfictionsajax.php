<?php
ob_start();
session_start();

include "connect.php";



if(isset($_GET["id"])){ 

$stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$row =$stmt->fetch();

$stmt = $con->prepare("SELECT COUNT(visiblity) from con2 where User_ID2 = ? and visiblity = 0 ");
$stmt->execute(array($row["UserID"]));
$not = $stmt->fetch();

if($not[0] === "0"){

}else{

  echo '<span class="not-chat">';
  echo $not[0];
 echo '</span>';
 

}


}
 if(isset($_GET["id2"])){

  $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$row =$stmt->fetch();

$stmt = $con->prepare("SELECT COUNT(comments.CommentPhoto) FROM posts 
INNER JOIN comments ON comments.Post_ID = posts.Post_ID
where UserID =? AND comments.User_ID != ? AND comments.visible = 0;
");
$stmt->execute(array($row["UserID"],$row["UserID"]));
$not = $stmt->fetch();

if($not[0] === "0"){

}else{

  echo '<span class="not-chat2 ">';
  echo $not[0];
 echo '</span>';
 

}


}else if(isset($_GET["id3"])){
  
  $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
  $stmt->execute(array($_SESSION['user']));
  $row =$stmt->fetch();




  $stmt = $con->prepare("SELECT posts.* , comments.Comments ,comments.CommentPhoto, comments.User_ID FROM posts
   INNER JOIN comments ON comments.Post_ID = posts.Post_ID
    where UserID =? AND comments.User_ID != ? AND comments.visible = 0
    order by comments.Comments desc
  ");

  //$stmt-> bind_param( );
  $stmt->execute(array($row["UserID"],$row["UserID"]));
  $nots =$stmt->fetchAll();



  echo '<div class="card pops">';
  echo '<div class="card-header ">';

  echo '<span>Notifictions</span>';

  echo '</div>';
  echo '<div class="card-bodys ">';
  echo '<ul class="list-unstyled latest-users ">';
 
foreach($nots as $not){
  
    $stmt = $con->prepare("SELECT Username FROM users Where UserID = ?");
  $stmt->execute(array($not["User_ID"]));
  $row =$stmt->fetch();

if(empty($not["Comments"])){


  $pathomguploads = "uploads/Comments/" . $not["CommentPhoto"];
             
  echo '<li class="li-not" data-postid='.$not["Post_ID"].'   data-photo="'.$pathomguploads.'"     >';
  echo '<span>'.$row["Username"].' leave comment to </span>';
  echo "<img src=".$pathomguploads." id='imgcomment' class='img-comment' width='75px' height='75px' >";
  echo '<br>';
  echo '<span> on your post</span>';
  echo '</li>';
}else{

  echo '<li class="li-not" data-postid='.$not["Post_ID"].'   data-comment="'.$row["Username"] .' '. $not["Comments"].'"     >';
  echo '<span>'.$row["Username"].' leave comment "'.$not["Comments"].'" on</span>';
  echo '<br>';
  echo '<span>your post</span>';
  echo '</li>';

}




};



echo '</ul>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';


/*$stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$row =$stmt->fetch();


$stmt = $con->prepare("UPDATE comments
INNER JOIN posts ON posts.Post_ID = comments.Post_ID 
SET comments.visible = 1
 where posts.UserID =? AND comments.User_ID != ? ");

//$stmt-> bind_param( );
$stmt->execute(array($row["UserID"],$row["UserID"]));*/

}
?>

