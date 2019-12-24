<?php
ob_start();
session_start();
$pageTitle="Members";
if(isset($_SESSION["username"])){

   include "ini.php";

$do = isset($_GET['do']) ? $_GET['do']:'Manage';

if($do == "Manage"){
$query = "";
if(isset($_GET['active']) && isset($_GET['active']) == "pendening"){

    $query = "and RegStatus = 0";
}


if(isset($_GET['q']) && isset($_GET['q']) == "active"){
    $id = $_GET["id"];
    $stmt = $con->prepare(" UPDATE users
    SET RegStatus = 1
    WHERE UserID = $id;");
    $stmt->execute();
   
}
 if(isset($_GET['d']) && isset($_GET['d']) == "Delete"){

    $id = $_GET["id"];
   
    $stmt = $con->prepare("DELETE FROM users WHERE UserID = ?");
    $stmt->execute(array($id));
  
}

$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
$stmt->execute();
$rows = $stmt->fetchAll();

if(! empty($rows)){ 

?>


<h1 class='text-center h1'>Manage Member</h1>
<div class='container'>
    <div class="text-center table table-bordered">
        <table class="table">
            <tr>
                <td>#ID</td>
                <td>#UserName</td>
                <td>#Email</td>
                <td>#Full Name</td>
                <td>#Registred Date</td>
                <td>#Control</td>
           </tr>
           <?php

          



//if($colm === 1){ 



           foreach ($rows as $row) {
            
           // print_r($row);
           

            echo "<tr>";

           echo "<td>". $row['UserID']."</td>";
           echo "<td>". $row['Username']."</td>";
           echo "<td>". $row[3]."</td>";
           echo "<td>". $row[4]."</td>";
           echo "<td>". $row[8]."</td>";
         echo  "<td>".
                   "<a href='?do=Edit&userid=". $row['UserID'] . "' class='btn btn-success'><i class = 'fa fa-edit'></i> Edit</a>".
                   "<a href='?do=Manage&id=$row[0]&d=Delete' class='btn btn-danger dele'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a>";
                   if($row['RegStatus'] == 0){
                 echo "<a href='?do=Manage&id=$row[0]&q=active' class='btn btn-info '><i class='fas fa-angle-double-right'></i> Active</a>";

                   }
        echo  "</td>";
           
            echo "</tr>";
           
            
           // echo $userid;


            
        }


    //}
       /* else if($colm === 0){

        }*/
      

          
           ?>
       
</table>


</div>

<a class='btn btn-primary' href ='member.php?do=Add' ><i class="fa fa-plus"></i> New member</a>

</diV>

<script>

let dele = document.querySelectorAll(".dele");

for (let i=0; i < dele.length ; i++){ 
  

dele[i].onclick = ()=>{
   
 
        if(confirm("Are You Sure?") === true){

           return true;

        }else{
            
            return false;
        
    }}}
   




</script>
<?php
}else{
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<div class='col-sm-12 empt'>";
    echo "Ther's No ".$pageTitle." To Show";
    echo "</div>";
    echo  "<a class='btn btn-primary' href ='member.php?do=Add' ><i class='fa fa-plus'></i> New member</a>"; 
    echo "</div>";  
    echo "</div>";

  
}

}else if($do == "active"){

    $id = $_GET["id"];


    $stmt = $con->prepare(" UPDATE users
    SET RegStatus = 1
    WHERE UserID = $id;");
    $stmt->execute();
   

 $sucess =  "<div class='alert alert-sucess' > " . $stmt->rowCount() . 'Record delete </div>' ;
    ?>
    <script>
   
    console.log("Ds");
     let settime = ()=>{
      let time =  document.getElementById("time");
      if(time.textContent > 0){
       time.textContent = time.textContent-1;
       
      }
     }

   setInterval(settime,1000);
    </script>
    <?php
    redirctHome($sucess,"member.php?do=Manage");
   

}


else if($do == "Delete"){
    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != ""){
    $id = $_GET["id"];
   
    $stmt = $con->prepare("DELETE FROM users WHERE UserID = ?");
    $stmt->execute(array($id));
  

    $sucess =  "<div class='alert alert-danger' style = margin-Top = 100px> " . $stmt->rowCount() . 'Record delete </div>' ;
    ?>
    <script>
   
    console.log("Ds");
     let settime = ()=>{
      let time =  document.getElementById("time");
      if(time.textContent > 0){
       time.textContent = time.textContent-1;
       
      }
     }

   setInterval(settime,1000);
    </script>
    <?php
    redirctHome($sucess,"member.php?do=Manage");
 }
 else{

    $error =  "<div class='alert alert-danger'> you can enter the page  direct </div>' ";
    ?>
    <script>
   
    console.log("Ds");
     let settime = ()=>{
      let time =  document.getElementById("time");
      if(time.textContent > 0){
       time.textContent = time.textContent-1;
       
      }
     }

   setInterval(settime,1000)
    </script>
    <?php
    redirctHome($error);}
 } 



else if($do == 'Add'){
  
   

?>

<h1 class='text-center h1'>Add New Member</h1>


<div class=" conimg" id="soso">
<i class="fas fa-camera"></i>
<div id="popo"></div>
    <input class="imgProfile" id="file" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>
    
    
</div>


<script src="jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
$("#soso").mouseenter(function(){

    $("#popo").addClass("popo");
})


$("#soso").mouseleave(function(){

$("#popo").removeClass("popo");
})

 </script>

<div class='container'>
  
    <form  id="form1" class='form-horizontal' action="?do=Insert" method = "POST" enctype="multipart/form-data">
        


<div class='form-group  row'>
<label class="col-sm-2  control-label">Username</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <input id='inp' type="text" name="username" class="form-control form-control-lg" autocomplete="off" placeholder="User Name"  required = "required"/>
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Password</label>
<div class="col-sm-10 col-md-4 ">
<input type="hidden" name="oldpassword" value=""/> 
    <input id="input-pass" type="password" name="newpassword" class="form-control form-control-lg" placeholder="Password"  autocomplete="new-password" />
    <i id="icon-pass-show" class="show-pass fa fa-eye fa2x sh"></i>
    <i id="icon-pass-hide" class="fa fa-eye-slash sh" aria-hidden="true"></i>

</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Email</label>
<div class='col-sm-10 col-md-4 '>
    <input type="email" name="email" class="form-control form-control-lg"  placeholder="Email" autocomplete="off" required = "required"/>
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Full Name</label>
<div class='col-sm-10 col-md-4 '>
    <input type="text" name="full" class="form-control form-control-lg"  placeholder="Full Name" autocomplete="off" required = "required"/>
</div> 

</div>








<div class='form-group row'>    
<div class= 'offset-sm-2 col-sm-10'>
    <input type="submit" value="Add Member" class=" btn btn-primary form-control-lg"/>
   
</div> 

</div>


<button id="btn" class="btn btn-primary">show photo</button>
</form>


</div>


<script src="jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
 

$(document).ready(function(){  

    $(document).on("change","#file",function(){
       
        let files = new FormData();
      files.append('file', $('#file')[0].files[0]);
      
      $.ajax({
         "url":"avatarajax.php",
         "method":"post",
         "data":files,
         processData: false,
         contentType:false,
         cache:false,
         //"type"
         success:function(response){

             
             $("#soso").html(response);
             
             $("#soso").append("<buttn id='save' class='btn btn-success'>Save</buttn>");
             $("#soso").append("<buttn id='delete' class='btn btn-danger'>Delete</buttn>");
             console.log($("#imge").attr("data-img"));
             $("#save").click(function(){

             $("#form1").append("<input name ='avatar' value="+$("#imge").attr("data-img")+" type='hidden'>");

             $("#save").remove();
             $("#delete").remove();
                   })

                   $("#delete").click(function(){
                    console.log($("#imge").attr("data-delete"));
                   $.ajax({
                type: "GET",
                url: "avatarajax.php",
                data: "delete="+$("#imge").attr('data-delete'),
                success:function(data) {
                  
                    $('#soso').html(data);



                }
            })

                   })
         }
     })
    })



       


   /* $("#form1").submit(function(e){
      
        let files = new FormData();
      //files.append('fileName[]', $('#avatar')[0].files[0]);
      files.append('fileName', $('#avatar')[0].files[0]);
      //files.append('age', "25");
/*let xhr = new XMLHttpRequest();
xhr.open("POST","avatarajax.php",true);
xhr.send(files);*/


    /* $.ajax({
         "url":"avatarajax.php",
         "method":"post",
         "data":files,
         processData: false,
         //"type"
         success:function(response){
             $("#soso").html(response);
         }
     })
     e.preventDefault();
     
       });
  
/*        $('.link').click(function(){
          console.log($(this).attr('data-id'));
            $.ajax({
                type: "GET",
                url: "hrefajax2.php",
                data: "id="+$(this).attr('data-id'),
                success:function(data) {
                    $('#soso').html(data);
                }
            })
          
        });*/

})

</script>
<?php


}else if($do == 'Insert'){

  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        echo "<h1 class='text-center'>Add Member</h1>";
        echo "<div class='container'>";


   /*    if(in_array($avatarExetention,$avatarAllowExetention)){
           echo "good";
       }else{
           echo "no good";
       }*/

      //  echo $avatarTmpName;






      $avatar =$_POST['avatar'];
        $name =$_POST['username'];
        $email =$_POST['email'];
        $full =$_POST['full'];
    $pass ="";
    
    $eroroarray = array();
    if(strlen($name) < 4){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed user name to be length small than 4</div>" ;
    }
    if(empty($name)){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed user name to be empty</div>" ;
    }
    if(empty($email)){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed email to be empty</div>" ;
    }
     if(empty($full)){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed full name to be empty</div>" ;
    }
    
    if(empty($_POST['newpassword'])){
        $pass = $_POST["oldpassword"];
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed password to be empty</div>" ;
    }else{
        $pass =sha1($_POST["newpassword"]);
    }
    /*else{
    
        $stmt = $con->prepare("UPDATE users SET Username = ? , Email =? ,FullName=? ,Password =? WHERE UserID =? ");
        $stmt->execute(array($name,$email,$full,$pass,$id));
    
        echo $stmt->rowCount() . 'Record Update';
    
    }*/
    
    
    foreach ($eroroarray as $error) {
       echo $error ;
    
    };
    
        /**/
    
  if(empty($eroroarray)){


 $stmt = $con->prepare("SELECT Username FROM users");
$stmt->execute();
$meta = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$row1= checkItem("Username","users",$name);

//foreach ($meta as $value) {
  
//}
echo $row1;
if($row1 === 1) { 
    //else{ 
        //echo $rows;
        $error =  "<div class='alert alert-danger'> sorry your name entering please change name " . $name . '  </div>' ;
        ?>
        <script>
       
        console.log("Ds");
         let settime = ()=>{
          let time =  document.getElementById("time");
          if(time.textContent > 0){
           time.textContent = time.textContent-1;
           
          }
         }

       setInterval(settime,1000)
        </script>
        <?php
        redirctHome($error,"member.php?do=Add");}

        else{ 
    
          
            $stmt = $con->prepare("SELECT MAX(UserID)+1 as id FROM users");
            $stmt->execute();
            $row = $stmt->fetch();
            $rowCount = $stmt->rowCount();
        
            $stmt = $con->prepare("INSERT INTO users (UserName, Password, Email, FullName,RegStatus,Date,UserID,avatar)
            VALUES (?, ?, ?, ?,1,now(),?,?); ");
            $stmt->execute(array($name,$pass,$email,$full,$row[0],$avatar));
        
           // header("Location: dashboard.php");
         //  echo $row[0];
         $sucss = "<div class='alert alert-success'> " . $stmt->rowCount() . 'Record Update </div>' ;
         ?>
         <script>
        
         console.log("Ds");
          let settime = ()=>{
           let time =  document.getElementById("time");
           if(time.textContent > 0){
            time.textContent = time.textContent-1;
            
           }
          }
 
        setInterval(settime,1000)
         </script>
         <?php
         redirctHome($sucss,"member.php?do=Manage");
        }
    }

}
    

    else{

       
        $eror = "<div class='alert alert-danger'>Sorry YOU Cant Browse This Page Direct</div>";
        ?>
        <script>
       
        console.log("Ds");
         let settime = ()=>{
          let time =  document.getElementById("time");
          if(time.textContent > 0){
           time.textContent = time.textContent-1;
           
          }
         }

       setInterval(settime,1000)
        </script>
        <?php
        redirctHome($eror);
      
     
        
    }
   
  
}

else if($do == "Edit"){
    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "" ){ 
    
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) :  0 ;

echo $userid;

$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? Limit 1");
$stmt->execute(array($userid));
$row = $stmt->fetch();
$count  = $stmt->rowCount();

if($count > 0){
echo $row['Username'];




    /*if(isset($_GET['userid'])  && is_numeric($_GET['userid'])){


        echo intval($_GET['userid']);
    }else{
        echo 0 ;
    }*/
    
    
    ?>

<h1 class='text-center h1'>Edit Member</h1>
<div class='container'>
  
    <form  id="form1" class='form-horizontal' action="?do=Update" method = "POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>" />
<div class='form-group  row'>
<label class="col-sm-2  control-label">Username</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <input id='inp' type="text" name="username" class="form-control form-control-lg" autocomplete="off" value="<?php echo $row['Username'] ?>"  required = "required"/>
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Password</label>
<div class="col-sm-10 col-md-4 ">
<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>"/> 
    <input type="password" name="newpassword" class="form-control form-control-lg" autocomplete="new-password"/>
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Email</label>
<div class='col-sm-10 col-md-4 '>
    <input type="email" name="email" class="form-control form-control-lg"  value="<?php echo $row['Email'] ?>" required = "required"/>
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Full Name</label>
<div class='col-sm-10 col-md-4 '>
    <input type="text" name="full" class="form-control form-control-lg"  value="<?php echo $row['FullName'] ?>" required = "required"/>
</div> 

</div>

<div class='form-group row'>    
<div class= 'offset-sm-2 col-sm-10'>
    <input type="submit" value="save" class=" btn btn-primary form-control-lg"/>
</div> 

</div>

</form>

</div>
<?php }else{
    $edit =  "Tres Not Such Id";
    ?>
    <script>
   
    console.log("Ds");
     let settime = ()=>{
      let time =  document.getElementById("time");
      if(time.textContent > 0){
       time.textContent = time.textContent-1;
       
      }
     }

   setInterval(settime,1000)
    </script>
    <?php
    redirctHome($edit);


}}else{

    $eror = "<div class = 'alert alert-danger'>you not entered Direct</div>";

    ?>
        <script>
       
        console.log("Ds");
         let settime = ()=>{
          let time =  document.getElementById("time");
          if(time.textContent > 0){
           time.textContent = time.textContent-1;
           
          }
         }

       setInterval(settime,1000)
        </script>
        <?php
        redirctHome($eror);
}

}else if($do == 'Update'){
    
    echo "<h1 class='text-center'>Update Member</h1>";
echo "<div class='container'>";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id =$_POST['userid'];
    $name =$_POST['username'];
    $email =$_POST['email'];
    $full =$_POST['full'];
$pass ="";

$eroroarray = array();
if(strlen($name) < 4){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed user name to be length small than 4</div>" ;
}
if(empty($name)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed user name to be empty</div>" ;
}
if(empty($email)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed email to be empty</div>" ;
}
 if(empty($full)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed full name to be empty</div>" ;
}

if(empty($_POST['newpassword'])){
    $pass = $_POST["oldpassword"];
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed password to be empty</div>" ;
}else{
    $pass =sha1($_POST["newpassword"]);
}


/*else{

    $stmt = $con->prepare("UPDATE users SET Username = ? , Email =? ,FullName=? ,Password =? WHERE UserID =? ");
    $stmt->execute(array($name,$email,$full,$pass,$id));

    echo $stmt->rowCount() . 'Record Update';

}*/


foreach ($eroroarray as $error) {
   echo $error ;

};

    /**/

if(empty($eroroarray)){
 
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID != ? AND Username = ?");
    $stmt->execute(array($id, $name));
    $row1 = $stmt->rowCount();
  
//$row1= checkItem("Username","users",$name);


//foreach ($meta as $value) { 
  
//}

if($row1 ===  1) { 
    //else{ 
        //echo $rows;
        $error =  "<div class='alert alert-danger'> sorry your name entering please change name " . $name . '  </div>' ;
        ?>
        <script>
       
        console.log("Ds");
         let settime = ()=>{
          let time =  document.getElementById("time");
          if(time.textContent > 0){
           time.textContent = time.textContent-1;
           
          }
         }

       setInterval(settime,1000)
        </script>
        <?php
        redirctHome($error,"member.php?do=Add");
    }else{ 
  
    $stmt = $con->prepare("UPDATE users SET Username = ? , Email =? ,FullName=? ,Password =? WHERE UserID =? ");
    $stmt->execute(array($name,$email,$full,$pass,$id));

    $update= "<div class='alert alert-success'> " . $stmt->rowCount() . 'Record Update </div>' ;
    ?>
    <script>
   
    console.log("Ds");
     let settime = ()=>{
      let time =  document.getElementById("time");
      if(time.textContent > 0){
       time.textContent = time.textContent-1;
       
      }
     }

   setInterval(settime,1000)
    </script>
    <?php
    redirctHome($update,$_SERVER["HTTP_REFERER"]);
}}

echo "</div>";
    
}else{

    $error =  '<div alert alert_danger>Sorry YOU Cant Browse This Page Direct</div>';
    ?>
    <script>
   
    console.log("Ds");
     let settime = ()=>{
      let time =  document.getElementById("time");
      if(time.textContent > 0){
       time.textContent = time.textContent-1;
       
      }
     }

   setInterval(settime,1000)
    </script>
    <?php
redirctHome($error);
   
}



}?>

<script>

(()=>{ 



let input =document.getElementsByTagName("input");
    for(let i = 0 ; i < input.length ; i++){ 

     console.log();
if(input[i].getAttribute('required') === 'required' ){

  //  let input = document.querySelector("input");
    //let div = document.querySelector("div");
    //let littrals  = `<span>*</span>`;
    let ele = document.createElement("span");
   ele.setAttribute('class','starisc');
  
    let text = document.createTextNode('*');
   ele.appendChild(text);
    

            
       input[i].parentNode.appendChild(ele);
  
            
       input[i].addEventListener('input',()=>{

        
                if(input[i].value === ""){
                    ele.style.display = "block";
                    input[i].style.border = "1px solid red";
                    input[i].style.boxShadow = "0 0 0 0.2rem #ff0d184f";
                }else{
                  ele.style.display = "none";
                  input[i].style.border = "1px solid #ced4da";
                  input[i].style.boxShadow = "0 0 0 0.2rem rgba(0, 123, 255, 0.25)";
                   
                }
           


       })


}
}

let inputpass = document.getElementById("input-pass");
let iconpasshide = document.getElementById("icon-pass-hide");
let iconpassshow = document.getElementById("icon-pass-show");

inputpass.addEventListener('input',()=>{

        
if(inputpass.value === ""){
    iconpasshide.style.display = "none";
    iconpassshow.style.display = "none";
    inputpass.type = "password";
}else{

    if(iconpasshide.style.display === "block" || iconpassshow.style.display === "block" ){


    }else{ 
          
    iconpasshide.style.display = "block";
    }


}})



iconpasshide.addEventListener('click',()=>{  


if (inputpass.type === "password") {

    //console.log(inputpass);
    inputpass.type = "text";
    iconpasshide.style.display = "none";
    iconpassshow.style.display = "block";

  } 
})
  
  iconpassshow.addEventListener('click',()=>{  
  
   if(inputpass.type === "text"){
    inputpass.type = "password";
  

    iconpasshide.style.display = "block";
    iconpassshow.style.display = "none";
  }

})




})();
</script>

<?php

include $tpl . "footer.php";
}else{

    header('Location: index.php');
    exist();
}
ob_end_flush();
?>

