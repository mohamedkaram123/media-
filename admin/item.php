<?php
ob_start();
session_start();
$pageTitle="Items";
if(isset($_SESSION["username"])){

   include "ini.php";

$do = isset($_GET['do']) ? $_GET['do']:'Manage';

if($do === "Manage"){

    $stmt = $con->prepare("SELECT items.*,catagrous.Name as Cat_Name,users.Username as  user_Name FROM items
    INNER JOIN catagrous ON catagrous.ID = items.Cat_ID
    INNER JOIN users ON users.UserID = items.Member_ID ");
    $stmt->execute();
    $rows = $stmt->fetchAll();
if(! empty($rows)){ 

    ?>

    <h1 class='text-center h1'>Manage Items</h1>
    <div class='container'>
        <div class="text-center table table-bordered">
            <table class="table">
                <tr>
                    <td>#ID</td>
                    <td>#Name</td>
                    <td>#Description</td>
                    <td>#Price</td>
                    <td>#Adding Date</td>
                    <td>#Catagory</td>
                    <td>#UserName</td>
                    <td>#Control</td>
               </tr>
               <?php
    
              
    
    
    
    //if($colm === 1){ 
    
   
    
    
               foreach ($rows as $row) {
                
               // print_r($row);
               
    
                echo "<tr>";
    
               echo "<td>". $row['Item_ID']."</td>";
               echo "<td>". $row['Name']."</td>";
               echo "<td>". $row['Description']."</td>";
               echo "<td>". $row['Price']."</td>";
               echo "<td>". $row['Add_Date']."</td>";
               echo "<td>". $row['Cat_Name']."</td>";
               echo "<td>". $row['user_Name']."</td>";
             echo  "<td>".
                       "<a href='?do=Edit&userid=". $row['Item_ID'] . "' class='btn btn-success'><i class = 'fa fa-edit'></i> Edit</a>".
                       "<a href='?do=Delete&id=" .$row['Item_ID'] ."' class='btn btn-danger dele'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a>";
                       if($row['Approve'] == 0){
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
    
    <a class='btn btn-primary' href ='item.php?do=Add' ><i class="fa fa-plus"></i> New items</a>
    
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
     echo  "<a class='btn btn-primary' href ='item.php?do=Add' ><i class='fa fa-plus'></i> New items</a>"; 
     echo "</div>"; 
 
     echo "</div>";
}

}else if($do === "Add"){

    ?>

<h1 class='text-center h1'>Add New Item</h1>
<div class='container'>
  
    <form  id="form1" class='form-horizontal' action="?do=Insert" method = "POST">
        
<div class='form-group  row'>
<label class="col-sm-2  control-label">Name</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <input id='inp' type="text" name="name" class="form-control form-control-lg"  placeholder="Name of the Item"  required = "required"/>
</div> 

</div>

<div class='form-group  row'>
<label class="col-sm-2  control-label">Description</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <input id='inp' type="text" name="description" class="form-control form-control-lg"  placeholder="description of the Item"  required = "required"/>
</div> 

</div>

<div class='form-group  row'>
<label class="col-sm-2  control-label">Price</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <input id='inp' type="text" name="price" class="form-control form-control-lg"  placeholder="100$"  required = "required"/>
</div> 

</div>


<div class='form-group  row'>
<label class="col-sm-2  control-label">Country Made</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <input id='inp' type="text" name="country" class="form-control form-control-lg"  placeholder="country of made"  required = "required"/>
</div> 

</div>


<div class='form-group  row'>
<label class="col-sm-2  control-label">Statues</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <select class="" name ="statues">

    <option value="0">...</option>
    <option value="1">New</option>
    <option value="2">Like New</option>
    <option value="3">Used</option>
    <option value="4">Very Old</option>
    </select>
</div> 

</div>


<div class='form-group  row'>
<label class="col-sm-2  control-label">Member Name</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <select class="" name ="member_id">
    <option value="0">...</option>
<?php $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
$stmt->execute();
$rows = $stmt->fetchAll();
foreach ($rows as $row) {

    echo "<option value=".$row['UserID'].">".$row["Username"] ."</option>";
}

?>
   
   
    </select>
</div> 

</div>



<div class='form-group  row'>
<label class="col-sm-2  control-label">Catagory Name</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <select class="" name ="cat_id">
    <option value="0">...</option>
<?php $stmt = $con->prepare("SELECT * FROM catagrous ");
$stmt->execute();
$rows = $stmt->fetchAll();  
foreach ($rows as $row) {

    echo "<option value=".$row['ID'].">".$row["Name"] ."</option>";
}

?>
   
   
    </select>
</div> 

</div>


<div class='form-group row'>    
<div class= 'offset-sm-2 col-sm-10'>
    <input type="submit" value="Add Item" class=" btn btn-primary"/>
</div> 

</div>

</form>

</div>

 <?php

}else if($do == 'Insert'){

  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        echo "<h1 class='text-center'>Add Items</h1>";
        echo "<div class='container'>";

        $name =$_POST['name'];
        $desc =$_POST['description'];
        $price =$_POST['price'];
        $country =$_POST['country'];
        $statues =$_POST['statues'];
        $Cat_id =$_POST['cat_id'];
        $member_id =$_POST['member_id'];
        
    $eroroarray = array();
   
    if(empty($name)){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed name to be empty</div>" ;
    }
    if(empty($desc)){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed description to be empty</div>" ;
    }
     if(empty($price)){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed full price to be empty</div>" ;
    }
    if(empty($country)){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed full country to be empty</div>" ;
    }
    if($statues  === "0"){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed full statues to be not values</div>" ;
    }
    if($Cat_id  === "0"){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed full Cat_id to be not values</div>" ;
    }
    if($member_id  === "0"){
        $eroroarray[] =  "<div class='alert alert-danger'> not allowed full member_id to be not values</div>" ;
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

            $stmt = $con->prepare("INSERT INTO items (Name, Description, Price, Country_Made,Statues,Cat_ID,Member_ID,Add_Date)
            VALUES (?, ?, ?, ?,?,?,?,now()); ");
            $stmt->execute(array($name,$desc,$price,$country,$statues,$Cat_id,$member_id));
        
           // header("Location: dashboard.php");
         //  echo $row[0];
         $sucss = "<div class='alert alert-success'> " . $stmt->rowCount() . 'Record add </div>' ;
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
         redirctHome($sucss,"item.php?do=Manage");
        
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
   
    
}else if($do === "Edit"){
    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "" ){ 

$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) :  0 ;
$memberid = isset($_GET['memberid']) && is_numeric($_GET['memberid']) ?  intval($_GET['memberid']) :  0 ;
$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) :  0 ;

echo $catid;

    $stmt = $con->prepare("SELECT items.*,catagrous.Name as Cat_Name,users.Username as  user_Name FROM items
    INNER JOIN catagrous ON catagrous.ID = items.Cat_ID
    INNER JOIN users ON users.UserID = items.Member_ID WHERE Item_ID = ?");
$stmt->execute(array($userid));
$item = $stmt->fetch();
$count  = $stmt->rowCount();

if($count > 0){


    ?>

    <h1 class='text-center h1'>Edit New Item</h1>
    <div class='container'>
      
        <form  id="form1" class='form-horizontal' action="?do=Update" method = "POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>" />
    <div class='form-group  row'>
    <label class="col-sm-2  control-label">Name</label>
    <div id="dd" class='col-sm-10 col-md-4 '>
        <input id='inp' type="text" name="name" class="form-control form-control-lg"  value="<?php echo $item['Name']; ?>"   placeholder="Name of the Item"  required = "required"/>
    </div> 
    
    </div>
    
    <div class='form-group  row'>
    <label class="col-sm-2  control-label">Description</label>
    <div id="dd" class='col-sm-10 col-md-4 '>
        <input id='inp' type="text" name="description" class="form-control form-control-lg"  value="<?php echo $item['Description']; ?>"   placeholder="description of the Item"  required = "required"/>
    </div> 
    
    </div>
    
    <div class='form-group  row'>
    <label class="col-sm-2  control-label">Price</label>
    <div id="dd" class='col-sm-10 col-md-4 '>
        <input id='inp' type="text" name="price" class="form-control form-control-lg" value="<?php echo $item['Price']; ?>"   placeholder="100$"  required = "required"/>
    </div> 
    
    </div>
    
    
    <div class='form-group  row'>
    <label class="col-sm-2  control-label">Country Made</label>
    <div id="dd" class='col-sm-10 col-md-4 '>
        <input id='inp' type="text" name="country" class="form-control form-control-lg" value="<?php echo $item['Country_Made']; ?>"   placeholder="country of made"  required = "required"/>
    </div> 
    
    </div>
    
    
    <div class='form-group  row'>
    <label class="col-sm-2  control-label">Statues</label>
    <div id="dd" class='col-sm-10 col-md-4 '>
        <select class="" name ="statues">
    
        <option value="0" <?php if($item[7] == 0){echo "selected";}?> >...</option>
        <option value="1" <?php if($item[7] == 1){echo "selected";}?>>New</option>
        <option value="2" <?php if($item[7] == 2){echo "selected";}?>>Like New</option>
        <option value="3" <?php if($item[7] == 3){echo "selected";}?>>Used</option>
        <option value="4" <?php if($item[7] == 4){echo "selected";}?>>Very Old</option>
        </select>
    </div> 
    
    </div>
    
     
    <div class='form-group  row'>
    <label class="col-sm-2  control-label">Member Name</label>
    <div id="dd" class='col-sm-10 col-md-4 '>
        <select class="" name ="member_id">
        
    <?php 
    
  
    $stmt = $con->prepare("SELECT * FROM users");
    
    $stmt->execute(array($userid));
    $rows = $stmt->fetchAll();

    foreach ($rows as $row) {
       
     ?>
             <option value=<?php echo $row['UserID']?>  <?php if($item['Member_ID'] == $row['UserID']){echo "selected";}?> ><?php echo $row["Username"] ?></option>

             <?php
        }
 
       
    
    
    ?>
       
       
        </select>
  
    </div> 
    
    </div>
    
    
    
    <div class='form-group  row'>
    <label class="col-sm-2  control-label">Catagory Name</label>
    <div id="dd" class='col-sm-10 col-md-4 '>
        <select class="" name ="cat_id">
        <?php 
    
  
    $stmt = $con->prepare("SELECT * FROM catagrous");
    
    $stmt->execute(array($userid));
    $rows = $stmt->fetchAll();

    foreach ($rows as $row) {
       
     ?>
             <option value=<?php echo $row['ID']?>  <?php if($item['Cat_ID'] == $row['ID']){echo "selected";}?> ><?php echo $row["Name"] ?></option>

             <?php
        }
 
       
    
    
    ?>
       
       
        </select>
    </div> 
    
    </div>
    
    
    <div class='form-group row'>    
    <div class= 'offset-sm-2 col-sm-10'>
        <input type="submit" value="Edit Item" class=" btn btn-primary"/>
    </div> 
    
    </div>
    

    
    </form>
    <?php
    $stmt = $con->prepare("SELECT comments.*,users.Username as  user_Name FROM comments
INNER JOIN users ON users.UserID = comments.User_ID
where Item_ID = ? ");
$stmt->execute(array($userid));
$rows = $stmt->fetchAll();

if(! empty($rows)){ ?>

<h1 class='text-center h1'>Manage <?php echo $item['Name']; ?> Member</h1>
<div class='container'>
    <div class="text-center table table-bordered">
        <table class="table">
            <tr>
                <td>#Comment</td>
                <td>#User Name</td>
                <td>#Add Date</td>
                <td>#Control</td>
           </tr>
           <?php

          



//if($colm === 1){ 


           foreach ($rows as $row) {
            
           // print_r($row);
           

            echo "<tr>";

           echo "<td>". $row['Comments']."</td>";
           echo "<td>". $row['user_Name']."</td>";
           echo "<td>". $row['c_Date']."</td>";
         echo  "<td>".
                   "<a href='comments.php?do=Edit&userid=". $row['C_ID'] . "' class='btn btn-success'><i class = 'fa fa-edit'></i> Edit</a>".
                   "<a href='comments.php?do=Delete&id=" .$row[0] ."' class='btn btn-danger dele'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a>";
                   if($row['Statues'] == 0){
                 echo "<a href='comments.php?do=Approve&id=$row[0]' class='btn btn-info '><i class='fas fa-angle-double-right'></i> Approve</a>";

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
    <?php }?>
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


    
    </div>
    
     <?php 
     }else{
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
}else if($do === "Update"){
    
   
    echo "<h1 class='text-center'>Update Member</h1>";
echo "<div class='container'>";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $userid =$_POST['userid'];
    $name =$_POST['name'];
    $desc =$_POST['description'];
    $price =$_POST['price'];
    $country =$_POST['country'];
    $statues =$_POST['statues'];
    $member_id =$_POST['member_id'];
    $cat_id =$_POST['cat_id'];
 
echo $userid;
$eroroarray = array();

if(empty($name)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed user name to be empty</div>" ;
}
if(empty($desc)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed description to be empty</div>" ;
}
 if(empty($price)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed price to be empty</div>" ;
}
if(empty($country)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed country to be empty</div>" ;
}
if(empty($statues)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed statues to be empty</div>" ;
}
 if(empty($member_id)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed membername to be empty</div>" ;
}
if(empty($cat_id)){
    $eroroarray[] =  "<div class='alert alert-danger'> not allowed catname to be empty</div>" ;
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

   /* $name =$_POST['name'];
    $desc =$_POST['description'];
    $price =$_POST['price'];
    $country =$_POST['country'];
    $statues =$_POST['statues'];
    $member_id =$_POST['member_id'];
    $cat_id =$_POST['cat_id'];*/

if(empty($eroroarray)){
  echo $userid;
    $stmt = $con->prepare("UPDATE items SET Name = ? , Description =? ,Price=? ,Country_Made =?, Statues =? ,Member_ID=? ,Cat_ID =? WHERE Item_ID =? ");
    $stmt->execute(array($name,$desc,$price,$country,$statues,$member_id,$cat_id,$userid));

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
}

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


}else if($do === "Delete"){
    

    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != ""){
        $id = $_GET["id"];
       
        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = ?");
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
        redirctHome($sucess,"items.php?do=Manage");
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

}else if($do === "Approve"){
    $id = $_GET["id"];


    $stmt = $con->prepare(" UPDATE items
    SET Approve = 1
    WHERE Item_ID = $id;");
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


    include $tpl . "footer.php";
}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();
?>