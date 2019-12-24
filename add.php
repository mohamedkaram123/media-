
<?php
ob_start();
session_start();
//$pageTitle = "Create New Item";
include "connect.php";
include "includes/functions/function.php";
if(isset($_SESSION['user'])){



    if($_SERVER["REQUEST_METHOD"] === "POST"){


        $name  = $_POST['name'];
        $description = $_POST['description'];
        $price  = $_POST['price'];
        $country = $_POST['country'];
         $category = $_POST['cat_id'];
         $statues = $_POST['statues'];
        
         $stmt2 = $con->prepare("SELECT * from users WHERE Username = ?");
              $stmt2->execute(array($_SESSION['user']));
        $row = $stmt2->fetch();
        
        
        $member = $row[0];
        
        
          $formerrors  = [];
        
          if(isset($name )){
              $filteritem = filter_var($name,FILTER_SANITIZE_STRING);
        
          }else{
            $formerrors [] = "<div class='alert alert-danger'> not allowed full item to be empty</div>" ;
          }
        
          if(isset($description )){
            $filterdesc = filter_var($description,FILTER_SANITIZE_STRING);
        
        }else{
            $formerrors [] = "<div class='alert alert-danger'> not allowed full description to be empty</div>" ;
        }
        
        if(isset($country )){
            $filtercountry = filter_var($country,FILTER_SANITIZE_STRING);
        
        }else{
            $formerrors [] = "<div class='alert alert-danger'> not allowed full country to be empty</div>" ;
        }
        if(isset($price)){
            $filterprice = filter_var($description,FILTER_SANITIZE_NUMBER_INT);
        
        }else{
            $formerrors [] = "<div class='alert alert-danger'> not allowed full price to be empty</div>" ;
        }
        
          if(empty($statues )){
           
            $formerrors [] = "<div class='alert alert-danger'> not allowed full statues to be empty</div>" ;
        }
        if(empty($category)){
           
            $formerrors [] = "<div class='alert alert-danger'> not allowed full category to be empty</div>" ;
        }
        
        
        
        
          if(empty($formerrors)){ 
          
              $stmt2 = $con->prepare("INSERT INTO items (Name , Description , Price ,Country_Made,Statues,Member_ID,Cat_ID,Add_Date )  VALUES(?,?,?,?,?,?,?,now());");
              $stmt2->execute(array($filteritem,$filterdesc,$filterprice,$filtercountry,$statues,$member,$category));
             
              
              
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
        echo "<div class ='alert alert-success'>this data saved You Will be Redirect to  After <span id = time>3</span> Seconds</div>";
        
        
          }else{
        
              foreach($formerrors as $eror){
        
                  echo $eror;
              }
        
        
          }
        
        
        
        
        
        
        
        
        
        
        }
}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();

 