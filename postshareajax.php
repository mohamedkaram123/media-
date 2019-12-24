<?php
session_start();

include "connect.php";


 
include "includes/functions/function.php";


$stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row = $stmt->fetch();


if(isset($_GET["img_post"]) && isset($_GET["text"])  &&  isset($_GET["idfrined"])){


    
$stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$row =$stmt->fetch();


$stmt = $con->prepare("INSERT INTO posts (Post,imges,UserID,UserID2,Date_Post)
        VALUES (?, ?, ?,?,now());");
        $stmt->execute(array($_GET["text"],$_GET["img_post"],$row["UserID"],$_GET["idfrined"]));
     $count = $stmt->rowCount();

if($count > 0){ 



$stmt = $con->prepare("SELECT posts.*,users.avatar ,users.Username FROM posts
INNER JOIN users ON users.UserID = posts.UserID where posts.UserID = ? and posts.UserID2 = ? and imges = ? and Post = ? order by Post_ID desc ");
$stmt->execute(array($row["UserID"],$_GET["idfrined"],$_GET["img_post"],$_GET["text"]));
$rows =$stmt->fetchAll();


foreach($rows as $row){   


echo  '<div class="card box-border" >';

echo '<div class="card-body ">';
echo '<div class=" conimg-box  conimg-pos">';


$pathomguploads1 = "uploads/avatars/" . $row["avatar"];




echo "<img src=".$pathomguploads1." id='imge' class='img-box'  data-delete=".$pathomguploads1.">";

echo '</div>';
                 if(isset($_GET["idfrined"])){
                    $stmt = $con->prepare("SELECT Username FROM users WHERE UserID = ?");
                    $stmt->execute(array($_GET["idfrined"]));
                    $frind = $stmt->fetch();
echo '<h5 class="card-title ">'.$row["Username"].'<br> with '.$frind["Username"].'</h5>';
                 }else{
                    echo '<h5 class="card-title ">'.$row["Username"].'</h5>';
                 }
 
 echo "<span class='date_span'>".timeago($row["Date_Post"])."</span>";
echo  '<p class="card-text ">'.$row["Post"].'</p>';
 echo  '</div>';

 $pathomguploads2 = "uploads/avatars/" . $row["imges"];          
                       
            
                     
                     
echo "<img src=".$pathomguploads2." id='imge' class='card-img-bottom'  data-delete=".$pathomguploads2.">";
                      

$stmt = $con->prepare("SELECT avatar,UserID FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$rowe =$stmt->fetch();             
             


$stmt = $con->prepare("SELECT COUNT(Like_ID) FROM actions where actions.Post_ID = ?");
$stmt->execute(array($row["Post_ID"]));
$rowx =$stmt->fetch(); 


?>
<div class="icons">
<span id="likes" class="likes"><?php echo $rowx["0"]; ?></span> <i class="fas fa-heart iconopacityhid lik"></i>
<span id="comments" class="commentsw coms"><?php
$stmt = $con->prepare("SELECT COUNT(Comments) FROM comments 
INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
where posts.Post_ID  = ?;");
$stmt->execute(array($row["Post_ID"]));
$rowf =$stmt->fetch();  

echo $rowf[0];

?></span><i class="fas fa-comment-alt coms"></i>
</div>


<div class="comments-button ">




<button id="btncomment"  class="btn-comment" data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"]; ?>">Comment <i class="far fa-comment-alt"></i></button>
<button  id="btnlike"  class="btn-like"  data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"];?>"   >Like <i class="far fa-heart"></i></button>

</div>

<div class="none">
<div class="  conimg-comment">
                       <?php


$pathomguploads = "uploads/avatars/" . $rowe["avatar"];


                echo "<img src=".$pathomguploads." id='imge' class='img-comment'  data-delete=".$pathomguploads.">";
   
   ?></div>
    
    <textarea id="tt" name="commentt" placeholder="write comment suitable" class="text-comment" data-userid="<?php echo $rowe["UserID"];?>"  data-postid="<?php echo $row["Post_ID"]; ?>" rows="1"></textarea>



</div>



<div class="comm">
</div>




<?php

echo "</div>";
}

}
}else if(isset($_GET["text"])  &&  isset($_GET["idfrined"])){


    
    $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();
    
    
    $stmt = $con->prepare("INSERT INTO posts (Post,imges,UserID,UserID2,Date_Post)
            VALUES (?, ?, ?,?,now());");
            $stmt->execute(array($_GET["text"],$_GET["img_post"],$row["UserID"],$_GET["idfrined"]));
         $count = $stmt->rowCount();
    
    if($count > 0){ 
    
    
    
    $stmt = $con->prepare("SELECT posts.*,users.avatar ,users.Username FROM posts
    INNER JOIN users ON users.UserID = posts.UserID where posts.UserID = ? and posts.UserID2 = ? and imges = ? and Post = ? order by Post_ID desc ");
    $stmt->execute(array($row["UserID"],$_GET["idfrined"],$_GET["img_post"],$_GET["text"]));
    $rows =$stmt->fetchAll();
    
    
    foreach($rows as $row){   
    
    
    echo  '<div class="card box-border" >';
    
    echo '<div class="card-body ">';
    echo '<div class=" conimg-box  conimg-pos">';
    
    
    $pathomguploads1 = "uploads/avatars/" . $row["avatar"];
    
    
    
    
    echo "<img src=".$pathomguploads1." id='imge' class='img-box'  data-delete=".$pathomguploads1.">";
    
    echo '</div>';
                     if(isset($_GET["idfrined"])){
                        $stmt = $con->prepare("SELECT Username FROM users WHERE UserID = ?");
                        $stmt->execute(array($_GET["idfrined"]));
                        $frind = $stmt->fetch();
    echo '<h5 class="card-title ">'.$row["Username"].'<br> with '.$frind["Username"].'</h5>';
                     }else{
                        echo '<h5 class="card-title ">'.$row["Username"].'</h5>';
                     }
     
     echo "<span class='date_span'>".timeago($row["Date_Post"])."</span>";

     echo  '</div>';

     echo  '<p class="card-text post-text">'.$row["Post"].'</p>';               
    
    $stmt = $con->prepare("SELECT avatar,UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $rowe =$stmt->fetch();             
                 
    
    
    $stmt = $con->prepare("SELECT COUNT(Like_ID) FROM actions where actions.Post_ID = ?");
    $stmt->execute(array($row["Post_ID"]));
    $rowx =$stmt->fetch(); 
    
    
    ?>
    <div class="icons">
    <span id="likes" class="likes"><?php echo $rowx["0"]; ?></span> <i class="fas fa-heart iconopacityhid lik"></i>
    <span id="comments" class="commentsw coms"><?php
    $stmt = $con->prepare("SELECT COUNT(Comments) FROM comments 
    INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
    where posts.Post_ID  = ?;");
    $stmt->execute(array($row["Post_ID"]));
    $rowf =$stmt->fetch();  
    
    echo $rowf[0];
    
    ?></span><i class="fas fa-comment-alt coms"></i>
    </div>
    
    
    <div class="comments-button ">
    
    
    
    
    <button id="btncomment"  class="btn-comment" data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"]; ?>">Comment <i class="far fa-comment-alt"></i></button>
    <button  id="btnlike"  class="btn-like"  data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"];?>"   >Like <i class="far fa-heart"></i></button>
    
    </div>
    
    <div class="none">
    <div class="  conimg-comment">
                           <?php
    
    
    $pathomguploads = "uploads/avatars/" . $rowe["avatar"];
    
    
                    echo "<img src=".$pathomguploads." id='imge' class='img-comment'  data-delete=".$pathomguploads.">";
       
       ?></div>
        
        <textarea id="tt" name="commentt" placeholder="write comment suitable" class="text-comment" data-userid="<?php echo $rowe["UserID"];?>"  data-postid="<?php echo $row["Post_ID"]; ?>" rows="1"></textarea>
    
    
    
    </div>
    
    
    
    <div class="comm">
    </div>
    
    
    
    
    <?php
    
    echo "</div>";
    }
    
    }
    }