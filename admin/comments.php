<?php
ob_start();
session_start();
$pageTitle="Comments";
if(isset($_SESSION["username"])){

   include "ini.php";

$do = isset($_GET['do']) ? $_GET['do']:'Manage';

if($do == "Manage"){
    $stmt = $con->prepare("SELECT comments.*,items.Name as item_Name,users.Username as  user_Name FROM comments
    INNER JOIN items ON items.Item_ID = comments.Item_ID
    INNER JOIN users ON users.UserID = comments.User_ID ");
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
                <td>#Comment</td>
                <td>#Item Name</td>
                <td>#User Name</td>
                <td>#Add Date</td>
                <td>#Control</td>
           </tr>
           <?php

          



//if($colm === 1){ 



           foreach ($rows as $row) {
            
           // print_r($row);
           

            echo "<tr>";

           echo "<td>". $row['C_ID']."</td>";
           echo "<td>". $row['Comments']."</td>";
           echo "<td>". $row['item_Name']."</td>";
           echo "<td>". $row['user_Name']."</td>";
           echo "<td>". $row['c_Date']."</td>";
         echo  "<td>".
                   "<a href='?do=Edit&userid=". $row['C_ID'] . "' class='btn btn-success'><i class = 'fa fa-edit'></i> Edit</a>".
                   "<a href='?do=Delete&id=" .$row[0] ."' class='btn btn-danger dele'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a>";
                   if($row['Statues'] == 0){
                 echo "<a href='?do=Approve&id=$row[0]' class='btn btn-info '><i class='fas fa-angle-double-right'></i> Approve</a>";

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
<?php }else{
       echo "<div class='container'>";
       echo "<div class='row'>";
       echo "<div class='col-sm-12 empt'>";
       echo "Ther's No ".$pageTitle." To Show";
       echo "</div>";
    
       echo "</div>";  
       echo "</div>";   
}

}else if($do == "Approve"){

    $id = $_GET["id"];


    $stmt = $con->prepare(" UPDATE comments
    SET Statues = 1
    WHERE C_ID = $id;");
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
   
    $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = ?");
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




else if($do == "Edit"){
    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "" ){ 
    
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) :  0 ;

echo $userid;

$stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ? Limit 1");
$stmt->execute(array($userid));
$row = $stmt->fetch();
$count  = $stmt->rowCount();

if($count > 0){





    /*if(isset($_GET['userid'])  && is_numeric($_GET['userid'])){


        echo intval($_GET['userid']);
    }else{
        echo 0 ;
    }*/
    
    
    ?>

<h1 class='text-center h1'>Edit Comment</h1>
<div class='container'>
  
    <form  id="form1" class='form-horizontal' action="?do=Update" method = "POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>" />
<div class='form-group  row'>
<label class="col-sm-2  control-label">Comment</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <textarea name="comment"><?php echo $row['Comments'];?></textarea>
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
    $comment =$_POST['comment'];
  
   
    $stmt = $con->prepare("UPDATE comments SET Comments = ?  WHERE C_ID =? ");
    $stmt->execute(array($comment,$id));

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

