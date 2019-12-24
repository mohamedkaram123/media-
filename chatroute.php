<?php
session_start();



include "connect.php";


//INSERT INTO `con2` (`C_ID2`, `Msg`, `User_ID`, `User_ID2`) VALUES ('5', 'hello ahmed how are you', '1', '15');



    if (isset($_GET['id'])) {


sleep(2);



        $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
        $stmt->execute(array($_SESSION['user']));
        $row =$stmt->fetch();



        
        $sessionid = $row[0];
       $getid = $_GET['id'];
      /*  $stmt = $con->prepare("SELECT * from cons1 WHERE User_ID1 =?  AND User_ID2 = ?  limit 1;");
        $stmt->execute(array($row[0],$_GET['id']));
        $rel  = $stmt->fetch(); 
        $count = $stmt->rowCount();


        
*/





$stmt = $con->prepare(" UPDATE con2 SET visiblity = 1 WHERE User_ID = ? AND  User_ID2 = ?  ;");
$stmt->execute(array($_GET['id'],$sessionid));


echo   '<input type="hidden" id="custId" name="getid" value='.$getid.'>';


$stmt = $con->prepare("SELECT COUNT(C_ID2) from con2 where User_ID = User_ID AND  User_ID2= ? AND visiblity = 0;");
    $stmt->execute(array($sessionid));
    $countsMsg =$stmt->fetch();
  
if($countsMsg[0] > 0){
    $fo = "(".$countsMsg[0].")";
}else{
    $fo ="";
}


$pageTitle =$fo."Chat";



echo   '<input type="hidden" id="tit" name="getid" value='.$pageTitle.'>';





$stmt = $con->prepare("SELECT con2.*,users.Username as user_Name FROM con2 INNER JOIN users ON users.UserID = $getid");
$stmt->execute();
$name = $stmt->fetch();


$stmt = $con->prepare("SELECT * from con2 where User_ID = ? AND  User_ID2=? or  User_ID = ? AND  User_ID2=?  ORDER BY C_ID2 ASC ;");
        $stmt->execute(array($row[0],$_GET['id'],$_GET['id'],$sessionid));
        $rows =$stmt->fetchAll();

      


        echo   '<div class="top"><span><span class="name ">From: '.$_SESSION['user'].' To: '.$name['user_Name'].'</span></span></div>';
        echo "<div class='edit'>";
        
    foreach ($rows as $row) { 
    
   
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

       
   /* $stmt = $con->prepare("SELECT Msg from con2 where User_ID = ? AND  User_ID2=? ;");
        $stmt->execute(array($row[0],$_GET['id']));
        $rows =$stmt->fetchAll();


        
    foreach ($rows as $row) { 
    
        echo  '<div> me:'.$row['Msg'].'</div>';
    
       
        };
        
        $stmt = $con->prepare("SELECT Msg from con2  where User_ID = ? AND  User_ID2=?  ORDER BY C_ID2 ASC;");
        $stmt->execute(array($_GET['id'],$sessionid));
        $rows =$stmt->fetchAll();


        
    foreach ($rows as $row) { 
    
        echo  '<div> you:'.$row['Msg'].'</div>';
    
       
        }; */
    








    }else{

            
    if(isset($_POST['massege']) && isset($_POST['getid'])){


        $getid = $_POST['getid'];

      
        //echo $_POST['getid'];

        $stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
        $stmt->execute(array($_SESSION['user']));
        $row =$stmt->fetch();



        
        $sessionid = $row[0];




      $stmt = $con->prepare("INSERT INTO con2 (Msg, User_ID, User_ID2) VALUES (?,?,?);");
            $stmt->execute(array($_POST['massege'],$sessionid,$getid));
            $count =$stmt->rowCount();
         
             if($count > 0){
    
       
$stmt = $con->prepare("SELECT con2.*,users.Username as user_Name FROM con2 INNER JOIN users ON users.UserID = ?");
$stmt->execute(array($getid));
$name = $stmt->fetch();


$stmt = $con->prepare("SELECT * from con2 where User_ID = ? AND  User_ID2=? or  User_ID = ? AND  User_ID2=?  ORDER BY C_ID2 ASC ;");
        $stmt->execute(array($row[0],$getid,$getid,$sessionid));
        $rows =$stmt->fetchAll();
        echo   '<input type="hidden" id="custId" name="getid" value='.$getid.'>';
        
        echo   '<div class="top"><span><span class="name">From: '.$_SESSION['user'].' To: '.$name['user_Name'].'</span></span></div>';
      
        echo "<div class='edit'>";
    foreach ($rows as $row) { 
    
   
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
  
             }
    
    
    
        }





        }
    
 
   ?>

<script src="jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
 

$(document).ready(function(){  



})
</script>
  


    <?php

    
  





?>
    