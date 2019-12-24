<?php

ob_start();
session_start();
$pageTitle="dashboard";
if(isset($_SESSION["username"])){

   include "ini.php";

$nomicusers = 5;
   $theusers = getLateast("*","users","UserID",$nomicusers); 

   $nomicitems = 5;
   $theitems = getLateast("*","items","Item_ID",$nomicitems);

   $nomicomments=5;
  
?>
<section>
<div class="container home-stats text-center">
<h1>Dahboard</h1>
<div class="row">
   <div class="col-md-3">
   <a href="member.php?do=Manage"><div class ="stat Members">
   <i class="fas fa-users"></i> 
   <div class="info">
        <em>Total Members</em>
      <span class="nomricusers"><?php echo countItems("UserName","users"); ?></span>
      </div>
      </div></a>
</div> 
<div class="col-md-3">
<a href="member.php?active=pendening"><div class ="stat Pending">
<i class="fas fa-user-plus"></i> 
<div class="info">
        <em> Pending Members</em>
         <span class="nomricusers"><?php echo countItems("RegStatus","users",0); ?></span>
       </div>
      </div></a>
</div> 
<div class="col-md-3">
      <a href="item.php?do=Manage"><div class ="stat Items">
      <i class="fas fa-tags"></i>
      <div class="info">
         <em>Total Items</em>
         <span class="nomricusers"><?php echo countItems("Item_ID","items"); ?></span>
      </div>
      </div></a>
</div> 
<div class="col-md-3">
<a href="comments.php"><div class ="stat Comments">
<i class="fas fa-comments"></i>
<div class="info">
         <em>Total Comments</em>
         <span class="nomricusers"><?php echo countItems("C_ID","comments"); ?></span>
      </div>
      </div></a>
</div>   
</div>
</div>
</section>
<!--======================================================================================================================================!-->
<section>
<div class="container latest">
<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-header">
  
      <span class="plus">
<i class = "fa fa-plus"></i> 

</span>


<i class = "fa fa-users"></i> Latest <?php echo $nomicusers;?> Registred Users

</div>
<div class="card-body">
   <ul class="list-unstyled latest-users">
<?php
if(! empty($theusers)){ 
foreach ($theusers as $value) {
echo "<li><span class='sp'>" . $value["Username"] ."</span> ";
echo " <a  class = 'btn btn-success float-right' href='member.php?do=Edit&userid=". $value['UserID'] . "' class='btn btn-success'><i class = 'fa fa-edit'></i> Edit</a>";
if($value['RegStatus'] == 0){
   echo "<a href='member.php?do=active&id=$value[0]' class='btn btn-info float-right'><i class='fas fa-angle-double-right'></i> Active</a>";
   echo "</li>";
     }
}
}else {
   echo "There No Record To Show";
   
   }
?>
</ul>
</div>

</div>
</div>


<div class="col-sm-6">
<div class="card">
<div class="card-header">
<span class="plus">
<i class = "fa fa-plus "></i> 

</span>

<i class = "fa fa-tag"></i> Latest <?php echo $nomicitems; ?> Items
</div>
<div class="card-body">
<ul class="list-unstyled latest-users">
<?php
if(! empty($theitems)){ 
foreach ($theitems as $value) {
echo "<li><span class='sp'>" . $value["Name"] ."</span> ";
echo " <a  class = 'btn btn-success float-right' href='item.php?do=Edit&userid=". $value['Item_ID'] . "' class='btn btn-success'><i class = 'fa fa-edit'></i> Edit</a>";
if($value['Approve'] == 0){
   echo "<a href='item.php?do=Approve&id=$value[0]' class='btn btn-info float-right'><i class='fas fa-angle-double-right'></i> Approve</a>";
   echo "</li>";
     }
}
}else{
   echo "There No Record To Show";
}
?>
</ul>
</div>
</div>
</div>
</div>



<div class="row">
<div class="col-sm-6">
<div class="card">
<div class="card-header">
  
      <span class="plus">
<i class = "fa fa-plus"></i> 

</span>


<i class = "fa fa-users"></i> Latest <?php echo $nomicusers;?> Latest <?php echo $nomicomments ?> Comments

</div>
<div class="card-body">
   <ul class="list-unstyled latest-users">
   <?php
   $stmt = $con->prepare("SELECT comments.*,users.Username as  user_Name FROM comments
INNER JOIN users ON users.UserID = comments.User_ID WHERE Statues = 1  ORDER BY C_ID DESC LIMIT $nomicomments");
$stmt->execute();
$comments = $stmt->fetchAll();


if(! empty($comments) ){ 
foreach( $comments as $comment){
   echo "<div class='comment-box'>";
echo "<a href='member.php?do=Edit&userid=".$comment["User_ID"]."' <span class='member-n'>" . $comment["user_Name"] . "</span></a>";
echo "<p class='member-c'>" . $comment["Comments"] . "</p>";
   echo "</div>";
} }else{
   echo "There No Record To Show";
}
?> 
</ul>
</div>
</div>
</div>


<script src="<?php echo $js?>jquery-3.4.1.min.js" ></script>
<script>
$(document).ready(function(){

   $(".plus").click(function(){
      console.log("Sasa");
      $(this).toggleClass("activet").parent().next('.card-body').slideToggle();
/*if($(".plus").hasClass("activet")){
   $(".m").css({'display':'block'})
   $(".p").css({'display':'none'})
}else{
   $(".p").css({'display':'block'})
   $(".m").css({'display':'none'})
}*/
if($(this).hasClass("activet")){
   $(this).html("<i class='fas fa-minus'></i>");
}else{
   $(this).html("<i class='fas fa-plus'></i>");
}
     
   })
})

</script>

</div>


</div>




</section>
<!--==============================================================================================================!-->
<?php


   include $tpl . "footer.php";
}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();

?>



