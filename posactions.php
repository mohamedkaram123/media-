<?php 
session_start();

include "connect.php";

if(isset($_POST["post_id"]) && isset($_POST["data_userid"])){
    $stmt =$con->prepare("SELECT Likes,Like_ID from actions where Post_ID = ? and UserID =? and Likes = ?; ");
    $stmt->execute(array($_POST["post_id"],$_POST["data_userid"],1));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

  
    if($count > 0){

    //    echo $row["Like_ID"];
        $stmt =$con->prepare("DELETE FROM actions WHERE Like_ID = ?;");
        $stmt->execute(array($row["Like_ID"]));
        $count1 = $stmt->rowCount();
     
       if($count1 > 0){

        echo -1;
       }


    }
    
    else{ 


  $stmt =$con->prepare("INSERT INTO actions (Likes,Post_ID,UserID) VALUES(?,?,?);");
$stmt->execute(array(1,$_POST["post_id"],$_POST["data_userid"]));
$count2 = $stmt->rowCount();
if($count2 > 0){

 echo 1;
}

}
 


}












?>