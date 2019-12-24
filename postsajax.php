<?php
session_start();

include "connect.php";

include "includes/functions/function.php";




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
    echo '<input type="hidden" name="img_post" value='.$avatar.'>'; 
   echo '<div  class="photo">';

echo '<a><i id="icon"></i></a>';
    echo "<img src=".$pathomguploads." id='im' class='img-photo' data-img=".$avatar." data-delete=".$pathomguploads.">";


    echo '</div>';
    
                //   echo '<i id="i"></i>';
                  //          echo '<div id="popo">';
                            
        
                   //         echo '<input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>';
                  //          echo '</div>';
    
    
    }
    

}else if(isset($_GET["img_post"]) && isset($_GET["text"])){


    
    $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();


    $stmt = $con->prepare("INSERT INTO posts (Post,imges,UserID,Date_Post)
            VALUES (?, ?, ?,now());");
            $stmt->execute(array($_GET["text"],$_GET["img_post"],$row["UserID"]));
         $count = $stmt->rowCount();

if($count > 0){ 

    
    
$stmt = $con->prepare("SELECT posts.*,users.avatar ,users.Username FROM posts
INNER JOIN users ON users.UserID = posts.UserID where posts.UserID = ? and imges = ? and Post = ? order by Post_ID desc ");
$stmt->execute(array($row["UserID"],$_GET["img_post"],$_GET["text"]));
$rows =$stmt->fetchAll();


foreach($rows as $row){   


    echo  '<div class="card box-border" >';

    echo '<div class="card-body ">';
    echo '<div class=" conimg-box  conimg-pos">';


    $pathomguploads1 = "uploads/avatars/" . $row["avatar"];




echo "<img src=".$pathomguploads1." id='imge' class='img-box'  data-delete=".$pathomguploads1.">";

 echo '</div>';

                   
                        echo '<h5 class="card-title ">'.$row["Username"].'</h5>';
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
        <i class="fas fa-camera cameratext"></i>
    <input type="file" id="fileimg" name="file" class="uploadtext" />


    <div class="photoComment">
</div>
   
    
</div>



<div class="comm">
</div>




<?php

 echo "</div>";
}

}
}

else if(isset($_POST["commentt"])){
    ?>
<?php

    $stmt = $con->prepare("SELECT UserID FROM users WHERE Username = ?");
    $stmt->execute(array( $_SESSION['user']));
    $rowid = $stmt->fetch();

    $stmt = $con->prepare("INSERT INTO comments (Comments,Post_ID,User_ID,Date_Comment)
            VALUES (?, ?, ?,now());");
            $stmt->execute(array($_POST["commentt"],$_POST["post_id"],$rowid["UserID"]));
         $count = $stmt->rowCount();

         if($count > 0){ 

    
    
         
            
             
            $stmt = $con->prepare("SELECT comments.*,users.avatar,users.Username ,posts.Post_ID  FROM comments 
            INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
            INNER JOIN users ON users.UserID = comments.User_ID 
            where posts.Post_ID  = ? and users.UserID = ? and  comments.Comments = ?
           LIMIT 1");
            $stmt->execute(array($_POST["post_id"],$rowid["UserID"],$_POST["commentt"]));
            $rows =$stmt->fetchAll();
            foreach($rows as $row){ 
             
             echo  '<div class="comment-text">';
            
             echo '<div class="  conimg-text">';
                           
             $stmt = $con->prepare("SELECT avatar ,Username FROM users Where UserID = ?");
             $stmt->execute(array($rowid["UserID"]));
             $rowe =$stmt->fetch();
             
             
             $pathomguploads = "uploads/avatars/" . $rowe["avatar"];
             
             
                       echo "<img src=".$pathomguploads." id='imge' class='img-text'  data-delete=".$pathomguploads.">";
             
             echo   '</div>';

         
               
                echo '<div class="comments">';
             
                echo $rowe["Username"] ." ". $row["Comments"];
   
                echo '</div>';
            
             
             echo '</div>';
             echo "<span class='date_span2'>".timeago($row["Date_Comment"])."</span>";
            
            }
            
            }
        
        
}

else if(isset($_POST["post_id"])){


    $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();


    $stmt = $con->prepare("UPDATE comments
     INNER JOIN posts ON posts.Post_ID = comments.Post_ID 
     SET comments.visible = 1
      where posts.UserID =? AND comments.User_ID != ? AND posts.Post_ID = ?");

    //$stmt-> bind_param( );
    $stmt->execute(array($row["UserID"],$row["UserID"],$_POST["post_id"]));
 


$statament = "SELECT comments.*,users.avatar,users.Username ,posts.Post_ID  FROM comments 
INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
INNER JOIN users ON users.UserID = comments.User_ID
where posts.Post_ID  = ? 
order by comments.C_ID desc limit 5";
$stmt = $con->prepare($statament);

//$stmt-> bind_param( );
$stmt->execute(array($_POST["post_id"]));
$rows =$stmt->fetchAll();

foreach($rows as $row){  



echo  '<div class="comment-text ">';

echo '<div class="  conimg-text">';







if(empty($row["Comments"])){ 

  
  $pathomguploads = "uploads/avatars/" . $row["avatar"];


echo "<img src=".$pathomguploads." id='imge' class='img-text'  data-delete=".$pathomguploads.">";
 echo "<span class='namephoto'>".$row["Username"] ."</span>" ;

echo   '</div>';

    echo '<div class="commentsphoto">';
 

    $pathomguploads = "uploads/Comments/" . $row["CommentPhoto"];
    
    
    echo "<img src=".$pathomguploads." id='imgcomment' class='img-comment' width='370px' height='300px' >";


    echo '</div>';


 }else{
     
  $pathomguploads = "uploads/avatars/" . $row["avatar"];


  echo "<img src=".$pathomguploads." id='imge' class='img-text'  data-delete=".$pathomguploads.">";

  echo   '</div>';
   
    echo '<div class="comments">';
 
    echo $row["Username"] ." ". $row["Comments"];

    echo '</div>';
 }


echo '</div>';
echo "<span class='date_span2'>".timeago($row["Date_Comment"])."</span>";


}



echo '<div class="comn">';

echo "</div>";
}else if(isset($_GET["text"])){


    
    $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();


    $stmt = $con->prepare("INSERT INTO posts (Post,UserID,Date_Post)
            VALUES (?,?,now());");
            $stmt->execute(array($_GET["text"],$row["UserID"]));
         $count = $stmt->rowCount();

if($count > 0){ 

    
    
$stmt = $con->prepare("SELECT posts.*,users.avatar ,users.Username FROM posts
INNER JOIN users ON users.UserID = posts.UserID where posts.UserID = ?  and Post = ? order by Post_ID desc ");
$stmt->execute(array($row["UserID"],$_GET["text"]));
$rows =$stmt->fetchAll();


foreach($rows as $row){   


    echo  '<div class="card box-border" >';

    echo '<div class="card-body ">';
    echo '<div class=" conimg-box  conimg-pos">';


    $pathomguploads1 = "uploads/avatars/" . $row["avatar"];




echo "<img src=".$pathomguploads1." id='imge' class='img-box'  data-delete=".$pathomguploads1.">";

 echo '</div>';

     echo '<h5 class="card-title ">'.$row["Username"].'</h5>';
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
        <i class="fas fa-camera cameratext"></i>
    <input type="file" id="fileimg" name="file" class="uploadtext" />


    <div class="photoComment">
</div>
   
    
</div>



<div class="comm">
</div>




<?php

 echo "</div>";
}

}
}



  else{

  
      echo "null";
    
  }








?>