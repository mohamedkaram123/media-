 <?php
include "connect.php";
include "includes/functions/function.php";

if(isset($_POST['Siguser'])){ 


  $SigUser = $_POST['Siguser'];
  $SigPass1 = $_POST['Sigpass1'];
  
  $SigPass2 = $_POST['Sigpass2'];
  

  $SigEmail = $_POST['Sigemail'];
$hashpass = sha1($SigPass2);


$stmt = $con->prepare("SELECT Username FROM users");
$stmt->execute();
$meta = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$row1= checkItem("Username","users",$SigUser);
if($row1 > 0){

    echo "<div class ='alert alert-info'>the name :" . $SigUser ." is recorded plese enter another name Seconds</div>";
}else{ 

$stmt = $con->prepare("SELECT MAX(UserID)+1 as id FROM users");
$stmt->execute();
$row = $stmt->fetch();
$rowCount = $stmt->rowCount();

  
 

    $formerrors  = [];

    if(isset($_POST['Siguser'])){
        $filteruser = filter_var($_POST['Siguser'],FILTER_SANITIZE_STRING);
        if(strlen($filteruser) < 4){
         
            $formerrors[] = "<div class ='alert alert-danger'>user name Must be larger than 4 characters</div>";
        }

    }
    if(isset($_POST['Sigemail'])){

        $filteremail = filter_var($_POST['Sigemail'],FILTER_SANITIZE_EMAIL);
    }

    if(isset($SigPass1) &&  isset($SigPass2) ){
if($SigPass1 !== $SigPass2){
  

    $formerrors[] = "<div class ='alert alert-danger'>password not idntical</div>";
}


    }else{
        $formerrors[] = "<div class ='alert alert-danger'>password not exist</div>";
    }

    if(empty($formerrors)){ 
    
        $stmt2 = $con->prepare("INSERT INTO users (Username , Password , Email ,Date,UserID )  VALUES(?,?,?,now(),?);");
        $stmt2->execute(array($filteruser,$hashpass,$filteremail,$row[0]));
       
        
        
    ?>
    <script>
   
    console.log("Ds");
     let settime = ()=>{
      let time =  document.getElementById("time");
      if(time.textContent > 0){
       time.textContent = time.textContent-1;
       
      }else if(time.textContent = 1 ){

        location.href="http://localhost/eCommerce/login.php";
      }
     }

   setInterval(settime,1000);

    </script>
    <?php
  echo "<div class ='alert alert-success'>this data saved You Will be Redirect to  After <span id = time>10</span> Seconds</div>";


    }else{

        foreach($formerrors as $eror){

            echo $eror;
        }


    }
  
  
  
  
  }
}

