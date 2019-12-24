<?php
ob_start();
session_start();
$pageTitle="catagerous";
if(isset($_SESSION["username"])){

   include "ini.php";

  
$do = isset($_GET['do']) ? $_GET['do']:'Manage';

if($do === 'Manage' ){
  
    $sort = "ASC";
    if(isset($_GET['sort']) && $_GET['sort'] === 'ASC' ){
        $sort = "ASC";
    }else if( isset($_GET['sort']) && $_GET['sort'] === 'DESC'){
        $sort = "DESC";
    }
$stmt2 = $con->prepare("SELECT * FROM catagrous ORDER BY Oredering $sort");
$stmt2->execute();
$rows = $stmt2->fetchAll();
if(! empty($rows)){ 

?>



<h1 class = "text-center h1">Manage Categries</h1>
<div class="container">

<div class="card catagory">
    <div class="card-header"><i class='fa fa-edit'></i> Manage Categries
    <div class="ordering float-right">
   <i class="fa fa-sort"></i> Ordering:
[<a class="<?php if($sort == "ASC"){echo "Active";}?>" href='?sort=ASC'>ASC</a>
|
<a class="<?php if($sort == "DESC"){echo "Active";}?>" href='?sort=DESC'>DESCC</a>]
&nbsp;
<i class="fa fa-eye"></i> View:
[<span class="Active">Full</span>
|
<span class="">Classic</span>]
    </div>
    </div>
   
    <div class="card-body">
<?php

foreach ($rows as $row) {
    echo "<div class='cat'>";
    echo "<div class ='hidden-buttons'>";
    echo "<a href='?do=Edit&catid=".$row["ID"]." ' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i> Edit</a>";
    echo "<a href='?do=Delete&catid=".$row["ID"]."' class='btn btn-sm btn-danger dele'><i class='fa fa-trash '></i> Delete</a>";
    echo "</div>";
   echo "<h3>" . $row["Name"] . "</h3>";
   echo "<div class='full-view'>";
   echo "<p>" ; if( $row["Description"]  == ""){}else{echo $row["Description"];} ; echo "</p>";
   if($row["Visibilty"] == "1" ){echo "<span class='Visibilty'><i class='fa fa-eye'></i> Hidden</span>";};
   if($row["AlLow_Comment"] == "1" ){echo "<span class='comments'><i class='fas fa-times'></i> Comments disable</span>";};
   if($row["AlLow_Ads"] == "1" ){echo "<span class='adds'><i class='fas fa-times'></i> Ads disable</span>";};
   echo "</div>";
   echo "</div>";
   echo "<hr>";
}


?>
    </div>
</div>

<br>
<a href='?do=Add'  class=" btn btn-primary add-catagory"><i class ='fa fa-plus'></i> Add Categries</a>

</div>


<script src="<?php echo $js?>jquery-3.4.1.min.js" ></script>

<script >


$(document).ready(function(){

    console.log();
    $(".ordering span").click(function(){
        
        $(this).addClass("Active").siblings("span").removeClass("Active");
        if($(".ordering span.Active").text() === "Full"){
            $(".full-view").slideDown();
        }else if($(".ordering span.Active").text() === "Classic"){
            $(".full-view").slideUp();
        }
     
    });

    $(".cat h3").click(function(){

        $(this).next().slideToggle();
    });


})



let dele = document.querySelectorAll(".dele");

for (let i=0; i < dele.length ; i++){ 
  
    
dele[i].onclick = ()=>{
   
 if(confirm("Are You Sure?") === true){

           return true;

        }else{
            
            return false;
        
    }

}}
   


</script>

<?php } else{

echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col-sm-12 empt'>";
echo "Ther's No ".$pageTitle." To Show";
echo "</div>";
echo "<a href='?do=Add'  class='btn btn-primary add-catagory'><i class ='fa fa-plus'></i> Add Categries</a>";
echo "</div>";  
echo "</div>";
}



}else if($do === 'Add' ){
    ?>

<h1 class='text-center h1'>Add New Category</h1>
<div class='container'>
  
    <form  id="form1" class='form-horizontal' action="?do=Insert" method = "POST">
        
<div class='form-group  row'>
<label class="col-sm-2  control-label">Name</label>
<div id="dd" class='col-sm-10 col-md-4 '>
    <input id='inp' type="text" name="name" class="form-control form-control-lg" autocomplete="off" placeholder="Name of the Catogray"  required = "required"/>
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Description</label>
<div class="col-sm-10 col-md-4 ">

    <input type="text" name="description" class="form-control form-control-lg" placeholder="Description the Categores" />

</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Oredering</label>
<div class='col-sm-10 col-md-4 '>
    <input type="text" name="oredering" class="form-control form-control-lg"  placeholder="oredering to arrange categries" autocomplete="off" />
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Visible</label>
<div class='col-sm-10 col-md-4 '>
    <div>
<input id="vis-yes" type="radio" name="visiblility" value="0" checked/>
<label for="vis-yes">Yes</label> 
    </div>
    <div>
<input id="vis-no" type="radio" name="visiblility" value="1" />
<label for="vis-no">No</label> 
    </div>
</div> 

</div>
<div class='form-group row'>
<label class="col-sm-2  control-label">Allow Commenting</label>
<div class='col-sm-10 col-md-4 '>
    <div>
<input id="com-yes" type="radio" name="commenting" value="0" checked/>
<label for="com-yes">Yes</label> 
    </div>
    <div>
<input id="com-no" type="radio" name="commenting" value="1" />
<label for="com-no">No</label> 
    </div>
</div> 

</div>

<div class='form-group row'>
<label class="col-sm-2  control-label">Allow Add</label>
<div class='col-sm-10 col-md-4 '>
    <div>
<input id="add-yes" type="radio" name="add" value="0" checked/>
<label for="add-yes">Yes</label> 
    </div>
    <div>
<input id="add-no" type="radio" name="add" value="1" />
<label for="add-no">No</label> 
    </div>
</div> 

</div>


<div class='form-group row'>    
<div class= 'offset-sm-2 col-sm-10'>
    <input type="submit" value="Add Catageroy" class=" btn btn-primary form-control-lg"/>
</div> 

</div>

</form>

</div>
 <?php
}else if($do === 'Insert' ){
   


    if(  $_SERVER['REQUEST_METHOD'] == 'POST'){
    
        echo "<h1 class='text-center'>Add Catageroys</h1>";
        echo "<div class='container'>";

        $name =$_POST['name'];
        $desc =$_POST['description'];   
        $order =$_POST['oredering'];
        $vis =$_POST["visiblility"];
        $com =$_POST["commenting"];
        $add =$_POST["add"];
       
      
    
/*$stmt = $con->prepare("SELECT NAM FROM catagrous");
$stmt->execute();
$meta = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);*/

$row1= checkItem("Name","catagrous",$name);

//foreach ($meta as $value) {
  
//}
echo $row1;
if($row1 === 1) { 
    //else{ 
        //echo $rows;
        $error =  "<div class='alert alert-danger'> sorry your name is EXIST please change  " . $name . '  </div>' ;
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
    
          
            /*$stmt = $con->prepare("SELECT MAX(UserID)+1 as id FROM users");
            $stmt->execute();
            $row = $stmt->fetch();
            $rowCount = $stmt->rowCount();*/
        
            $stmt = $con->prepare("INSERT INTO catagrous (Name, Description, Oredering,Visibilty,AlLow_Comment,AlLow_Ads)
            VALUES (?, ?, ?,?,?,?);");
            $stmt->execute(array($name,$desc,$order,$vis,$com,$add));
        
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
         redirctHome($sucss);
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
else if($do === 'Edit' ){
    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "" ){ 
    
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) :  0 ;
        
        echo $catid;
        
        $stmt = $con->prepare("SELECT * FROM catagrous WHERE ID = ? Limit 1");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count  = $stmt->rowCount();
        
        if($count > 0){
?>
            <h1 class='text-center h1'>Edit Category</h1>
            <div class='container'>
              
                <form  id="form1" class='form-horizontal' action="?do=Update" method = "POST">
                <input type="hidden" name="catid" value="<?php echo $catid ?>" />
            <div class='form-group  row'>
            <label class="col-sm-2  control-label">Name</label>
            <div id="dd" class='col-sm-10 col-md-4 '>
                <input id='inp' type="text" name="name" value="<?php echo  $cat["Name"]; ?>" class="form-control form-control-lg" autocomplete="off" placeholder="Name of the Catogray"  required = "required"/>
            </div> 
            
            </div>
            
            <div class='form-group row'>
            <label class="col-sm-2  control-label">Description</label>
            <div class="col-sm-10 col-md-4 ">
            
                <input type="text" name="description" class="form-control form-control-lg" value="<?php echo  $cat["Description"]; ?>" placeholder="Description the Categores" />
            
            </div> 
            
            </div>
            
            <div class='form-group row'>
            <label class="col-sm-2  control-label">Oredering</label>
            <div class='col-sm-10 col-md-4 '>
                <input type="text" name="oredering" class="form-control form-control-lg" value="<?php echo  $cat["Oredering"]; ?>"  placeholder="oredering to arrange categries" autocomplete="off" />
            </div> 
            
            </div>
            
            <div class='form-group row'>
            <label class="col-sm-2  control-label">Visible</label>
            <div class='col-sm-10 col-md-4 '>
                <div>
            <input id="vis-yes" type="radio" name="visiblility" value='0' <?php if($cat["Visibilty"] === "0"){echo "checked" ;} ?>  />
            <label for="vis-yes">Yes</label>  
                </div>
                <div>
            <input id="vis-no" type="radio" name="visiblility" value="1" <?php if($cat["Visibilty"] === "1"){echo "checked" ;} ?>  />
            <label for="vis-no">No</label> 
                </div>
            </div> 
            
            </div>
            <div class='form-group row'>
            <label class="col-sm-2  control-label">Allow Commenting</label>
            <div class='col-sm-10 col-md-4 '>
                <div>
            <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat["AlLow_Comment"] === "0"){echo "checked" ;} ?>/>
            <label for="com-yes">Yes</label> 
                </div>
                <div>
            <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat["AlLow_Comment"] === "1"){echo "checked" ;} ?>/>
            <label for="com-no">No</label> 
                </div>
            </div> 
            
            </div>
            
            <div class='form-group row'>
            <label class="col-sm-2  control-label">Allow Add</label>
            <div class='col-sm-10 col-md-4 '>
                <div>
            <input id="add-yes" type="radio" name="add" value="0" <?php if($cat["AlLow_Ads"] === "0"){echo "checked" ;} ?>/>
            <label for="add-yes">Yes</label> 
                </div>
                <div>
            <input id="add-no" type="radio" name="add" value="1" <?php if($cat["AlLow_Ads"] === "1"){echo "checked" ;} ?> />
            <label for="add-no">No</label> 
                </div>
            </div> 
            
            </div>
            
            
            <div class='form-group row'>    
            <div class= 'offset-sm-2 col-sm-10'>
                <input type="submit" value="Edit Catageroy" class=" btn btn-primary form-control-lg"/>
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
}}else if($do === 'Update' ){
    echo "<h1 class='text-center'>Update Member</h1>";
echo "<div class='container'>";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  
    
    $id =$_POST['catid'];
    $name =$_POST['name'];
    $desc =$_POST['description'];   
    $order =$_POST['oredering'];
    $vis =$_POST["visiblility"];
    $com =$_POST["commenting"];
    $add =$_POST["add"];




  
    $stmt = $con->prepare("UPDATE catagrous SET Name = ? , Description =? ,Oredering=?,Visibilty=?,AlLow_Comment=?,AlLow_Ads=?  WHERE ID =? ");
    $stmt->execute(array($name,$desc,$order,$vis,$com,$add,$id));

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


}else if($do === 'Delete' ){
    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != ""){
        $id = $_GET["catid"];
       
        $stmt = $con->prepare("DELETE FROM catagrous WHERE ID = ?");
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
        redirctHome($sucess,"catagerous.php?do=Manage");
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


    include $tpl . "footer.php";
}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();
?>