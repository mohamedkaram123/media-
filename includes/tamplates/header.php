
<!DOCTYPE html>
<head>
<meta charset="UTF-8"/>
<title id="title"><?php echo getTitle() ;?></title>    

<link rel="stylesheet" href="<?php echo $css?>all.css"/> 
<link rel="stylesheet" href="<?php echo $css?>bootstrap.css"/> 
<link rel="stylesheet" href="<?php echo $css?>jquery-ui.css"/> 
<link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css"/> 
<link rel="stylesheet" href="<?php echo $css?>front.css"/>   
</head>
<body>

<div class ="upper-bar ">
        <div class="container">
          <div class="row">
        <a href="logout.php">
            <span><i class="fas fa-sign-out-alt"></i></span>
            </a>
           <?php  if(isset($_SESSION['user'])){?>

        
            <div class="not3">

</div>
            <a  href="#" class=" offset-md-8 offset-sm-6 offset-4">
          
          <span class=" float-right"><i  id="not" class="fas fa-list"></i></span></a>

          <div class ="notms2"></div>
          


            <a  href="index.php">
          
          <span class="float-right"><i class="fas fa-home"></i></span></a>



            <a  href="chat.php">
          
          <span class="float-right "><i class="fab fa-facebook-messenger"></i></span></a>
     
         <span class ="notms"></span>

            <a  href="profile.php">
          
          <span class="float-right"><i class="fas fa-user-circle"></i></span></a>

            <a class="  newadd" href='newadd.php'><i class="fas fa-cart-plus"></i></a>
            
   


       


          
              <?php  }else{ ?>
                <a href="profile.php">
            <span class="float-right">Login/Signup</span></a>

            <?php  }?>
              </div>
            </div>

</div>



<script src="jquery-3.4.1.min.js"></script>
    <script type="text/javascript">  

$(document).ready(function(){
let nof = $(".notms");
let nof2 = $(".notms2");
  let id = 1;
  let id2 = 2;
  setInterval(() => {
    $.ajax({
   type: "GET",
   url: "notfictionsajax.php",
   data: "id="+id,
 success:function(data){
              
               nof.html(data);

   }
  });

  $.ajax({
   type: "GET",
   url: "notfictionsajax.php",
   data: "id2="+id2,
 success:function(data){
 
               nof2.html(data);

   }
  });
  }, 5000);


  let id3 = 3;
  $(".not3").hide();
  $("#not").click(function(){
   
   console.log($(".not3").css("display"));

   if($(".not3").css("display") === "none"){ 
   
    $.ajax({
   type: "GET",
   url: "notfictionsajax.php",
   data: "id3="+id3,
 
 success:function(data){
//console.log("da");

             $(".not3").html(data).toggle();
             nof2.html("");



             $(".li-not").each(function(){
 
$(this).click(function(){

 $(".not3").html(data).toggle(); 
  let coco = $(this).attr("data-postid");
  let comment = $(this).attr("data-comment");
  let commentphoto = $(this).attr("data-photo");
  ///if($(".btn-comment").attr("data-postid") === $(this).attr("data-postid")){
   // console.log($(".btn-comment"));
    $(".btn-comment").each(function(){
    
      if($(this).attr("data-postid") === coco){
  $(this).trigger("click");
  //


let th = $(this);


   
$.ajax({
         "url":"postsajax.php",
         "method":"post",
         "data":{ post_id:$(this).attr('data-postid'),
         data_userid:$(this).attr('data-userid')
       
         },
         
         success:function(response){
         
let comments = th.parent().next().next().children(".comment-text").children(".comments");
let commentsphoto = th.parent().next().next().children(".comment-text").children(".commentsphoto").children("img");



commentsphoto.each(function(){
if($(this).attr("src") === commentphoto ){
  let pos =  $(this).offset();
$(document).scrollTop(pos.top+($(document).scrollTop()-200));
}


});





//console.log(comments);
comments.each(function(){
 
if($(this).text() === comment){
  let pos =  $(this).offset();
$(document).scrollTop(pos.top+($(document).scrollTop()-300));





  
let time =  5;
let settime = ()=>{
    
      if(time > 0){
       time = time-1;

console.log(time);

  $(this).css("background","#ff0b0b");

setTimeout(() => {
  $(this).css("background","var(--blue)");
}, 250);

       
      }else{
        $(this).css("background","var(--blue)");
      }
     }

   setInterval(settime,500);


 
}

})

         }
        })
      


}


    })
//console.log($(".btn-comment").attr("data-postid"));

//  }
 


});




});

   }

  })}else{
    $(".not3").toggle();
  }

})



})

    </script>


