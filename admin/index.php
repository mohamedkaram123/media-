<?php 
session_start();
$navbar = "";
$pageTitle="login";
if(isset($_SESSION['username'])){
    header("Location: dashboard.php");
    exist();    
}


include "ini.php";



if($_SERVER['REQUEST_METHOD'] == "POST"){

    $username = $_POST['user'];
    $pass = $_POST['pass'];

    $hashpass = sha1($pass);

   $sql = "SELECT UserID , Username , Password FROM users WHERE Username = ? AND Password = ? AND GroupID Limit 1";
  $stmt = $con->prepare($sql);
   $stmt->execute(array($username,$hashpass));
   $row = $stmt->fetch();
   $count = $stmt->rowCount();
  
if($count > 0){

    $_SESSION['username']= $username;
    $_SESSION['ID']= $row["UserID"];
    header("Location: dashboard.php");
    exist();
}

 
}


?>


<form class="login" action="/eCommerce/admin/index.php"   method="POST" >
<h4 class="text-center">Admin Login</h4>
<input id="input1" class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
<input id="input2" class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
<input class="btn btn-lg btn-primary btn-block" type="submit" value="Login"/>

</form>
<?php 




include $tpl . "footer.php";

?>