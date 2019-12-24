<?php
session_start();

include "connect.php";



    $count = $_POST["commentnewCount"];

  


    
    $statament = "SELECT comments.*,users.avatar,users.Username ,posts.Post_ID  FROM comments 
    INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
    INNER JOIN users ON users.UserID = comments.User_ID
    where posts.Post_ID  = ? 
    order by comments.C_ID desc limit 4,$count";
    $stmt = $con->prepare($statament);
    
    //$stmt-> bind_param( );
    $stmt->execute(array($_POST["post_id"]));
    $rows =$stmt->fetchAll();
    
    foreach($rows as $row){  
    
    
    
    echo  '<div class="comment-text ">';
    
    echo '<div class="  conimg-text">';
    
    
    
    
    
    $pathomguploads = "uploads/avatars/" . $row["avatar"];
    
    
    echo "<img src=".$pathomguploads." id='imge' class='img-text'  data-delete=".$pathomguploads.">";
    
    echo   '</div>';
    echo '<div class="comments">';
    
    echo $row["Username"] ." ". $row["Comments"];
    echo '</div>';
    
    echo '</div>';
    
    
    
    }
    
 

    
?>