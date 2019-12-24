<?php 





ob_start();
session_start();



$pageTitle = $_SESSION["user"];





include "ini.php";
if(isset($_SESSION['user'])){

    $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->execute(array( $sessionUser));
    $row = $stmt->fetch();

   







?>



<head>
    <link href="homes.css" rel="stylesheet">
</head>

<body class="profile-page">



                        <!--===================================section post profile=====================================================================!-->
<div class="container">

<div class="row rows">
<div class="offset-lg-3 offset-md-1">
 <!--===================================section post profile=====================================================================!-->

<div class="box-border bac">
    <div class="box-top">
        

<span>write comment</span>
</div>


<div class="counte">

    <textarea id="textarea" name="text" placeholder="<?php echo $_SESSION["user"];?> What you Think" class="text-box" rows="1"></textarea>
  </div>

  <div class=" conimg-box ">
                           <?php
                           
    $stmt = $con->prepare("SELECT avatar,UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $row =$stmt->fetch();

    $pathomguploads = "uploads/avatars/" . $row["avatar"];


                    echo "<img src=".$pathomguploads." id='imge' class='img-box'  data-delete=".$pathomguploads.">";
       
       ?></div>

       <div id="photo">

</div>



<div class="uploadphoto">

    <div class="chosephoto">
  
        <span class="spanphoto">Photo <i class="fas fa-file-image"></i></span>
    <input class="filechose" id="fils2" type="file" name="file"   placeholder="Full Name" autocomplete="off" required = "required"/>
  
        </div>
</div>



<div class="button-posts">
  <input type="button" id="btnpost" value="POST" class="btn-post btn btn-primary" />
</div>


</div>
<?php
$stmt = $con->prepare("SELECT Post_ID FROM actions where UserID = ? ");
    $stmt->execute(array($row["UserID"]));
    $rows =$stmt->fetchAll(); 


    echo '<div id="div">';

foreach($rows as $row){
    
    echo '<input type="hidden" class="datapost" data-post='.$row["Post_ID"].' />';

   
}
echo "</div>";
?>
      

    <!--===================================section post profile=====================================================================!-->

        <!--===================================section posts=====================================================================!-->
        <?php
      

$stmt = $con->prepare("SELECT posts.*,users.avatar,users.Username  FROM posts
INNER JOIN users ON users.UserID = posts.UserID 
order by Post_ID desc ");
$stmt->execute(array());
$rows =$stmt->fetchAll();
?>

<div class="pos">
    <?php





foreach($rows as $row){   

    if($row["imges"]){ 


    echo  '<div class="card box-border" >';

    echo '<div class="card-body ">';
    echo '<div class=" conimg-box  conimg-pos">';


    $pathomguploads1 = "uploads/avatars/" . $row["avatar"];




echo "<img src=".$pathomguploads1." id='imge' class='img-box'  data-delete=".$pathomguploads1.">";

 echo '</div>';
 if($row["Username"] === $_SESSION['user']){
    if(isset($row["UserID2"])){
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmt->execute(array($row["UserID2"]));
    $frind = $stmt->fetch();
    echo '<h5 class="card-title ">'.$_SESSION["user"].'<br> with <a href="profilefrinds.php?id='.$row["UserID2"].'" >'.$frind["Username"].'</a></h5>';

    }else if(empty($row["UserID2"])){
    
        echo '<h5 class="card-title ">'.$row["Username"].'</h5>';
    
    }
}else{
    if(isset($row["UserID2"])){
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmt->execute(array($row["UserID2"]));
    $frind = $stmt->fetch();
    echo '<h5 class="card-title "><a href="profilefrinds.php?id='.$row["UserID"].'" >'.$row["Username"].'</a><br> with <a href="profilefrinds.php?id='.$row["UserID2"].'" >'.$frind["Username"].'</a></h5>';
    }else if(empty($row["UserID2"])){
    
        echo '<h5 class="card-title "><a href="profilefrinds.php?id='.$row["UserID"].'" >'.$row["Username"].'</a></h5>';
    
    }
   
}
 
 
   
     echo "<span class='date_span'>".timeago($row["Date_Post"])."</span>";
    echo  '<p class="card-text ">'.$row["Post"].'</p>';
     echo  '</div>';
    
     $pathomguploads2 = "uploads/avatars/" . $row["imges"];          
                           
                
                         
                         
    echo "<img src=".$pathomguploads2." id='imge' class='card-img-bottom'  data-delete=".$pathomguploads2.">";
                          
    
    $stmt = $con->prepare("SELECT avatar,UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $rowe =$stmt->fetch();             
                 


    $stmt = $con->prepare("SELECT COUNT(Like_ID) FROM actions where actions.Post_ID = ?");
    $stmt->execute(array($row["Post_ID"]));
    $rowx =$stmt->fetch(); 


    ?>
    <div class="icons">
   <span id="likes" class="likes"><?php echo $rowx["0"]; ?></span> <i class="fas fa-heart iconopacityhid lik"></i>
   <span id="comments" class="commentsw coms"><?php
    $stmt = $con->prepare("SELECT COUNT(CommentPhoto)  FROM comments 
    INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
    where posts.Post_ID  = ?;");
    $stmt->execute(array($row["Post_ID"]));
    $rowf =$stmt->fetch();  

    echo $rowf[0];

   ?></span><i class="fas fa-comment-alt coms"></i>
</div>
 
    
<div class="comments-button ">




<button id="btncomment"  class="btn-comment" data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"]; ?>">Comment <i class="far fa-comment-alt"></i></button>

     <?php 



    $stmt = $con->prepare("SELECT Post_ID FROM actions where actions.UserID = ?   ");
    $stmt->execute(array($rowe["UserID"]));
    $rowss =$stmt->fetchAll(); 
foreach($rowss as $rows){ 
    if($rows["Post_ID"] === $row["Post_ID"]){ 
   // $rows =$stmt->fetchAll(); 
    
    ?>

<button  id="btnlike"  class="btn-like  btn-likecolor"  data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"];?>"   >Like <i class="far fa-heart"></i></button>

  <?php  
}


}
?>
<button  id="btnlike"  class="btn-like "  data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"];?>"   >Like <i class="far fa-heart"></i></button>

</div>

<div class="none">
<div class="  conimg-comment">
                           <?php
 

    $pathomguploads = "uploads/avatars/" . $rowe["avatar"];


                    echo "<img src=".$pathomguploads." id='imge' class='img-comment'  data-delete=".$pathomguploads.">";
       
       ?></div>
        
        <textarea id="tt" name="commentt" placeholder="write comment suitable" class="text-comment" data-userid="<?php echo $rowe["UserID"];?>"  data-postid="<?php echo $row["Post_ID"]; ?>" rows="1"></textarea>
        <i class="fas fa-camera cameratext"></i>
    <input type="file" id="fileimg" name="file" class="uploadtext" />
   

    <div class="photoComment">
</div>
    
</div>



<div class="comm">
</div>



<div class="co">
</div>


<div id="alot" class="alot none">
<a class='alot-a' href='#' >Alot of Comments</a>
</div>


<?php

 echo "</div>";

  }else{

    echo  '<div class="card box-border" >';

    echo '<div class="card-body ">';
    echo '<div class=" conimg-box  conimg-pos">';


    $pathomguploads1 = "uploads/avatars/" . $row["avatar"];




echo "<img src=".$pathomguploads1." id='imge' class='img-box'  data-delete=".$pathomguploads1.">";

 echo '</div>';

 if($row["Username"] === $_SESSION['user']){
    if(isset($row["UserID2"])){
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmt->execute(array($row["UserID2"]));
    $frind = $stmt->fetch();
    echo '<h5 class="card-title ">'.$_SESSION["user"].'<br> with <a href="profilefrinds.php?id='.$row["UserID2"].'" >'.$frind["Username"].'</a></h5>';

    }else if(empty($row["UserID2"])){
    
        echo '<h5 class="card-title ">'.$row["Username"].'</h5>';
    
    }
}else{
    if(isset($row["UserID2"])){
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmt->execute(array($row["UserID2"]));
    $frind = $stmt->fetch();
    echo '<h5 class="card-title "><a href="profilefrinds.php?id='.$row["UserID"].'" >'.$row["Username"].'</a><br> with <a href="profilefrinds.php?id='.$row["UserID2"].'" >'.$frind["Username"].'</a></h5>';
    }else if(empty($row["UserID2"])){
    
        echo '<h5 class="card-title "><a href="profilefrinds.php?id='.$row["UserID"].'" >'.$row["Username"].'</a></h5>';
    
    }
   
}
 
 
     echo "<span class='date_span'>".timeago($row["Date_Post"])."</span>";
   
     echo  '</div>';

     echo  '<p class="card-text post-text"  >'.$row["Post"].'</p>';
    
    $stmt = $con->prepare("SELECT avatar,UserID FROM users Where Username = ?");
    $stmt->execute(array($_SESSION['user']));
    $rowe =$stmt->fetch();             
                 


    $stmt = $con->prepare("SELECT COUNT(Like_ID) FROM actions where actions.Post_ID = ?");
    $stmt->execute(array($row["Post_ID"]));
    $rowx =$stmt->fetch(); 


    ?>
    <div class="icons">
   <span id="likes" class="likes"><?php echo $rowx["0"]; ?></span> <i class="fas fa-heart iconopacityhid lik"></i>
   <span id="comments" class="commentsw coms"><?php
    $stmt = $con->prepare("SELECT COUNT(CommentPhoto)  FROM comments 
    INNER JOIN posts ON  posts.Post_ID = comments.Post_ID 
    where posts.Post_ID  = ?;");
    $stmt->execute(array($row["Post_ID"]));
    $rowf =$stmt->fetch();  

    echo $rowf[0];

   ?></span><i class="fas fa-comment-alt coms"></i>
</div>
 
    
<div class="comments-button ">




<button id="btncomment"  class="btn-comment" data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"]; ?>">Comment <i class="far fa-comment-alt"></i></button>

     <?php 



    $stmt = $con->prepare("SELECT Post_ID FROM actions where actions.UserID = ?   ");
    $stmt->execute(array($rowe["UserID"]));
    $rowss =$stmt->fetchAll(); 
foreach($rowss as $rows){ 
    if($rows["Post_ID"] === $row["Post_ID"]){ 
   // $rows =$stmt->fetchAll(); 
    
    ?>

<button  id="btnlike"  class="btn-like  btn-likecolor"  data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"];?>"   >Like <i class="far fa-heart"></i></button>

  <?php  
}


}
?>
<button  id="btnlike"  class="btn-like "  data-userid="<?php echo $rowe["UserID"];?>" data-postid="<?php echo $row["Post_ID"];?>"   >Like <i class="far fa-heart"></i></button>

</div>

<div class="none">
<div class="  conimg-comment">
                           <?php
 

    $pathomguploads = "uploads/avatars/" . $rowe["avatar"];


                    echo "<img src=".$pathomguploads." id='imge' class='img-comment'  data-delete=".$pathomguploads.">";
       
       ?></div>
        
        <textarea id="tt" name="commentt" placeholder="write comment suitable" class="text-comment" data-userid="<?php echo $rowe["UserID"];?>"  data-postid="<?php echo $row["Post_ID"]; ?>" rows="1"></textarea>
        <i class="fas fa-camera cameratext"></i>
    <input type="file" id="fileimg" name="file" class="uploadtext" />


    <div class="photoComment">
</div>
    
</div>



<div class="comm">
</div>



<div class="co">
</div>


<div id="alot" class="alot none">
<a class='alot-a' href='#' >Alot of Comments</a>
</div>


<?php

 echo "</div>";


  }

















}

  /*$stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
  $stmt->execute(array($_SESSION['user']));
  $row =$stmt->fetch();
  
      
  $stmt = $con->prepare("SELECT comments.Comments,posts.Post FROM comments 
  INNER JOIN posts ON posts.Post_ID = comments.Post_ID where posts.UserID = ?
  ");
  $stmt->execute(array($row["UserID"]));
  $rows =$stmt->fetchAll();
  
  foreach($rows as $row){   

echo  '<div class="comment-text">';

echo '<div class="  conimg-text">';
              
$stmt = $con->prepare("SELECT avatar FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$rowe =$stmt->fetch();


$pathomguploads = "uploads/avatars/" . $rowe["avatar"];


          echo "<img src=".$pathomguploads." id='imge' class='img-text'  data-delete=".$pathomguploads.">";

echo   '</div>';
echo '<div class="comments">';

echo $_SESSION["user"] ." ". $row["Comments"];
echo '</div>';

echo '</div>';

}*/
?>
</div>
            <!--===================================section posts=====================================================================!-->

                </div>

                
            </div>


        </div>
    </div>
    
</div>
</div>
    <div class="show">
       <div class="overlay"></div>
         <div class="img-show">
          <img src="">
               </div>
              </div>
   

</body>




<script src="jquery-3.4.1.min.js"></script>
    <script type="text/javascript">

    
 
 var textarea = document.querySelector('#textarea');
 var textcomment = document.querySelectorAll('.text-comment');
 var boxBorder = document.querySelector('.box-border');




textarea.addEventListener('input', autosize);
             
function autosize(){
  var el = this;
  el.height = "30px";
  setTimeout(function(){
    el.style.cssText = 'height:auto;';

    el.style.cssText = 'height:' + el.scrollHeight + 'px';
  },0);
}






textarea.classList.add("fontsize");






textarea.addEventListener('input', ()=>{


 
    if(textarea.value.length > 128){    
        textarea.classList.remove("fontsize");
        textarea.classList.add("lineheight");

    }else{
        textarea.classList.add("fontsize");
    }
});

$(document).ready(function(){  



$(".btn-like").each(function(){
    $(this).click(function(){
    console.log($(document).scrollTop());
})

})



    function triggerUploadComment(){
    $(".cameratext").each(function(){
       $(this).click(function(){
        $(this).next().trigger( "click" );
  
})
    })


}

triggerUploadComment();


function uploadetext(){ 
$(".uploadtext").each(function(){

$(this).change(function(){

 //   let   getid = $("#custId").val();
 let iconcomment = $(this).parent().prev().prev().children(".coms ")
let commentw = $(this).parent().prev().prev().children(".commentsw ");
let commentwtext =$(this).parent().prev().prev().children(".commentsw ").text();
if(commentwtext === ""){

    commentw.text("0");
  
  commentw.hide();
   }



let commentwint =parseInt(commentw.text());
       let files = new FormData();
     files.append('file', $(this)[0].files[0]);


if($(this)[0].files[0] === undefined){

}else{

let data = $(this).next();
//let data = $(this).next();
let comm = $(this).parent().next();

    $.ajax({
         "url":"commentphoto.php",
         "method":"post",
         "data":files,
         processData: false,
         contentType:false,
         cache:false,
         //"type"
         success:function(response){
          
            data.html(response);
    



let postid = data.parent().children("textarea").attr("data-postid");

let icon = data.children().children().children("#icon");
let photor = data.children(".photor");

let dataavatar = data.children().children("#im").attr("data-img");
  let pathdelete = data.children().children("#im").attr("data-delete");
  let send = photor.children("#send");

  photor.mouseenter(function(){
            icon.addClass("fas fa-times");

})

  /* photor.mouseleave(function(){


    icon.removeClass("fas fa-times");
})*/




icon.click(function(){
 
    $.ajax({
         "url":"commentphoto.php",
         "method":"post",
         "data":{
            pathdelete:pathdelete
        
         },
    
         //"type"
         success:function(response){
          
            data.html("");
        //   $("#soso"+getid).html(response);
        
     

         }
     })
  

})


let count = commentwint + 1;
 

send.click(function(){
  $.ajax({
         "url":"commentphoto.php",
         "method":"post",
         "data":{
             dataavatar:dataavatar,
             postid:postid
             
         },
    
         //"type"
         success:function(response){
  
iconcomment.removeClass("iconopacityhid");
          comm.html(response+comm.html());
          commentw.text(count);
          commentw.show();
          data.html("");
 
     

         }
     })

    })


         }
     })
}
  

})
})}


uploadetext();


function posttext(){ 

    $("p.post-text").each(function(){

    if($(this).height() < 70){
        $(this).addClass("fontpostsizebig");
        $(this).removeClass("fontpostsizesmall");
    }else{
        $(this).addClass("fontpostsizesmall");
        $(this).removeClass("fontpostsizebig");
    }
    })

}
posttext();



    $("img").each(function () {
    
    $(this).click(function () {
        $(document).scrollTop(50);
           var $src = $(this).attr("src");
           $(".show").fadeIn();
           $(".img-show img").attr("src", $src);
        //   $(".conimg").hide();
           $("body").css("overflow","hidden")
       });
    });
       
       $(".overlay").click(function () {
           $(document).scrollTop(0);
           $(".show").fadeOut();
        //   $(".conimg").show();
           $("body").css("overflow","auto")
       });
       






   $(".btn-likecolor").each(function(){
    let next =  $(this).next();
    next.remove();


})

$(".commentsw").each(function(){

if($(this).text() === "0")  {
    $(this).text(""); 
    $(this).next().addClass("iconopacityhid");
}else if($(this).text() !== "0" || ""){
    $(this).next().addClass("iconopacityshow");
    
}

                })

   
    $(".likes").each(function(){

        if($(this).text() === "0")  {
            $(this).text(""); 
        }else if($(this).text() !== "0" || ""){
            $(this).next().addClass("opacity");
          
            
        }

                        })

                        $(".btn-like").each(function(){
$(this).click(function(){
    
    let iconheart = $(this).parent().prev().children("i.lik");

    let str = $(this).parent().prev().children("span.likes");
  
    let iconheart2 =$(this).children("i");

    let btncolor = $(this);

    
  //  $iconheart.css('opacity','1');

    $.ajax({
         "url":"posactions.php",
         "method":"post",
         "data":{ post_id:$(this).attr('data-postid'),
         data_userid:$(this).attr('data-userid')
         },
         
         success:function(data){
         

            if(data === "-1"){
                btncolor.css("color","black");
            }
         
            if(data === "1"){
                btncolor.css("color","red");
            }


      

           if(str.text() === ""){
            str.text("0"); 
            iconheart.removeClass("opacity");
           }
                    
                          
            let int = parseInt(data);
             str2 = str.text();
            let int2 = parseInt(str2);
        
     
    let calc = int +int2;

    str.html(calc);

    if(str.text() !== "0" || ""){
        iconheart.addClass("opacity");
  
    }

    if(str.text() === "0"){
            str.text(""); 
            iconheart.removeClass("opacity");
           
           }
              


         } })
        
})
  
  })






    $(".btn-comment").each(function(){
        $(this).click(function(event){ 
         

let none = $(this).parent().next();
let comm =$(this).parent().next().next();
let postid = $(this).attr('data-postid');
let userid = $(this).attr('data-userid');
let co =$(this).parent().next().next().next();
let addcomments = co.next();
 let iconcomment =  $(this).parent().prev().children("i.coms");


      
       $.ajax({
         "url":"postsajax.php",
         "method":"post",
         "data":{ post_id:$(this).attr('data-postid'),
         data_userid:$(this).attr('data-userid')
       
         },
         
         success:function(response){
            none.css("display","block");    
            comm.html(response);
           

            if(response === '<div class="comn"></div>'){
              
            }else{
                
                if(comm.children().length <= 5){

                }else{
                addcomments.css("display","block"); 
            
            let commentCount = 1;
            event.preventDefault();
          
   
            $(".alot").each(function(){
              
              $(this).click(function(event){
              
             
                commentCount =commentCount+2;
                  event.preventDefault();

                 
                  $.ajax({
         "url":"ajaxcomment.php",
         "method":"post",
         "data":{ post_id:postid,
         data_userid:userid,
         commentnewCount:commentCount
         },
         beforeSend:function(){
           
         },
         success:function(data){
           //  let commenttext = comm.children(".comment-text");
           //  commenttext.html("");
        
            co.html(data) ;


                  }
                
                })
            
               


                  
    
                }) })}}



         } })

 
})

})

/*====================================================================================================================== */


let textcomment =$(".text-comment");
   
   for (let i = 0; i < textcomment.length; i++) {

         
            textcomment[i].addEventListener('input', autosize);
             
             function autosize(){
               var el = this;
               el.height = "30px";
               setTimeout(function(){
                 el.style.cssText = 'height:auto;';
             
                 el.style.cssText = 'height:' + el.scrollHeight + 'px';
               },0);
             }}




             $(".text-comment").each(function(){

            
              
                
$(this).keypress(function(event){ 
    let iconcomment = $(this).parent().prev().prev().children("i.coms");
  //  

  let commenttext = $(this).parent().prev().prev().children("span.commentsw").text();
let comnt = $(this).parent().prev().prev().children("span.commentsw");
let iconcomments = $(this).parent().prev().prev().children("i.coms");


// $(this).scrollTop(232332);
 $text =  $(this);
let  comm =$(this).parent().next();
if (event.keyCode === 13) {
    event.preventDefault();
  
    if(commenttext === ""){
    comnt.text("0");
   }
   let comenttextint = parseInt($(this).parent().prev().prev().children("span.commentsw").text());

    let count = comenttextint +1;

$.ajax({
"url":"postsajax.php",
"method":"post",
"data":{commentt:$(this).val(),
    post_id:$(this).attr('data-postid'),
},
   

success:function(data){
    iconcomment.removeClass("iconopacityhid");
    comnt.text(count);
  
//  $(this).val("");
comm.html(data + comm.html());
//iconcomment.css("display","block");

$text.val("");


// $(this).val("");

//comn.prev().val("");


}

})


}




})

})



/*====================================================================================================================== */


    $(".cover").mouseenter(function(){
    
    $("#popo").addClass("popo");
    $("#i").addClass("fas fa-camera");
})


$(".cover").mouseleave(function(){

$("#popo").removeClass("popo");
$("#i").removeClass("fas fa-camera");
})











    $(function () {
    "use strict";
    
    $(".popup").click(function () {
        $(document).scrollTop(400);
        var $src = $("#soso").children("img").attr("src");
        $(".show").fadeIn();
        $(".img-show img").attr("src", $src);
        $(".conimg").hide();
    });
    
    $(".overlay").click(function () {
        $(document).scrollTop(0);
        $(".show").fadeOut();
        $(".conimg").show();
    });
    
});
    $("#file").change(function(){
       
        let files = new FormData();
      files.append('file', $('#file')[0].files[0]);


if($('#file')[0].files[0] === undefined){
   
}else{
      
      
      $.ajax({
         "url":"avatarajaxprofile.php",
         "method":"post",
         "data":files,
         processData: false,
         contentType:false,
         cache:false,
         //"type"
         success:function(response){

             
             $("#soso").html(response);
             
             $("#soso").append("<buttn id='save' class='btn btn-success'>Save</buttn>");
             $("#soso").append("<buttn id='delete' class='btn btn-danger'>Cancel</buttn>");
           
             $("#save").click(function(){


                $.ajax({
                type: "GET",
                url: "avatarajaxprofile.php",
                data: "avatar="+$("#imge").attr('data-img'),
                success:function(data) {
               //   $(".box-border").css("height","395px");
              
            
                    $("#soso").html(data);
                

                }
            })
            // $("#form1").append("<input name ='avatar' value="+$("#imge").attr("data-img")+" type='hidden'>");

             $("#save").remove();
             $("#delete").remove();
                   })

                   $("#delete").click(function(){
                   
                   $.ajax({
                type: "GET",
                url: "avatarajaxprofile.php",
                data: "delete="+$("#imge").attr('data-delete'),
                success:function(data) {
                  
                    $('#soso').html(data);



                }
            })

                   })
         }
     })
     }




    })



    $("#fils2").change(function(){
       
       let files = new FormData();
     files.append('file', $('#fils2')[0].files[0]);


if($('#fils2')[0].files[0] === undefined){
  
}else{


    $.ajax({
         "url":"postsajax.php",
         "method":"post",
         "data":files,
         processData: false,
         contentType:false,
         cache:false,
         //"type"
         success:function(response){
             

            $(".box-border").css("height","auto");

$("#photo").html(response);

$(".photo").mouseenter(function(){
    $("#icon").addClass("fas fa-times");

})

$(".photo").mouseleave(function(){


$("#icon").removeClass("fas fa-times");
})


$("#icon").click(function(){
    $(".box-border").css("height","auto");

    $("#photo").html("");

})
                 
         }
     })
}
  

})




$("#btnpost").click(function(){


    
    $.ajax({
                type: "GET",
                url: "postsajax.php",
                data: {img_post:$("#im").attr('data-img'),
                       text:$("#textarea").val()}
                ,
                success:function(data) {
                    
                    $(".pos").html(data + $(".pos").html());
                    posttext();
                    $("#photo").html("");
                    $("#textarea").val("");


                    triggerUploadComment();
                    uploadetext();
                    $(".btn-likecolor").each(function(){
    let next =  $(this).next();
    next.remove();
  

})


$(".commentsw").each(function(){
   
if($(this).text() === "0")  {
    $(this).text(""); 
    $(this).next().addClass("iconopacityhid");
}else if($(this).text() !== "0" || ""){
    $(this).next().addClass("iconopacityshow");
    
}

                })

    $(".likes").each(function(){

        if($(this).text() === "0")  {
            $(this).text(""); 
        }else if($(this).text() !== "0" || ""){

          
            
        }

                        })

  $(".btn-like").each(function(){
$(this).click(function(){
    
    let iconheart = $(this).parent().prev().children("i.lik");

    let str = $(this).parent().prev().children("span.likes");
  
    let iconheart2 =$(this).children("i");

    
    let btncolor = $(this);


   
  //  $iconheart.css('opacity','1');

    $.ajax({
         "url":"posactions.php",
         "method":"post",
         "data":{ post_id:$(this).attr('data-postid'),
         data_userid:$(this).attr('data-userid')
         },
         
         success:function(data){



            if(data === "-1"){
                btncolor.css("color","black");
            }
         
            if(data === "1"){
                btncolor.css("color","red");
            }




           if(str.text() === ""){
            str.text("0"); 
            iconheart.removeClass("opacity");
           }
                    
                          
            let int = parseInt(data);
             str2 = str.text();
            let int2 = parseInt(str2);
        
     
    let calc = int +int2;

    str.html(calc);

    if(str.text() !== "0" || ""){
        iconheart.addClass("opacity");
  
    }

    if(str.text() === "0"){
            str.text(""); 
            iconheart.removeClass("opacity");
           
           }
              


         } })
        
})
  
  })



                    
    $(".btn-comment").each(function(){
        $(this).click(function(){ 
          

let none = $(this).parent().next();
let comm =$(this).parent().next().next();
        //  let  comm =$(this).parent().next();
        

       $.ajax({
         "url":"postsajax.php",
         "method":"post",
         "data":{ post_id:$(this).attr('data-postid')
         },
         
         success:function(response){
            none.css("display","block");    
           
            comm.html(response);

         
       $(".alot").each(function(){
              
              $(this).click(function(event){
              
             
                commentCount =commentCount+2;
                  event.preventDefault();

                 
                  $.ajax({
         "url":"ajaxcomment.php",
         "method":"post",
         "data":{ post_id:postid,
         data_userid:userid,
         commentnewCount:commentCount
         },
         beforeSend:function(){
           
         },
         success:function(data){
           //  let commenttext = comm.children(".comment-text");
           //  commenttext.html("");
          
            co.html(data) ;


                  }
                
                })
               


                  
    
                }) })

         } })

    
})

})

/*====================================================================================================================== */


let textcomment =$(".text-comment");
   
   for (let i = 0; i < textcomment.length; i++) {

          
            textcomment[i].addEventListener('input', autosize);
             
             function autosize(){
               var el = this;
               el.height = "30px";
               setTimeout(function(){
                 el.style.cssText = 'height:auto;';
             
                 el.style.cssText = 'height:' + el.scrollHeight + 'px';
               },0);
             }}




             $(".text-comment").each(function(){

            
              
                $(this).keypress(function(event){ 
    let iconcomment = $(this).parent().prev().prev().children("i.coms");
  //  

  let commenttext = $(this).parent().prev().prev().children("span.commentsw").text();
let comnt = $(this).parent().prev().prev().children("span.commentsw");
let iconcomments = $(this).parent().prev().prev().children("i.coms");


// $(this).scrollTop(232332);
 $text =  $(this);
let  comm =$(this).parent().next();
if (event.keyCode === 13) {
    event.preventDefault();
  
    if(commenttext === ""){
    comnt.text("0");
   }
   let comenttextint = parseInt($(this).parent().prev().prev().children("span.commentsw").text());

    let count = comenttextint +1;

$.ajax({
"url":"postsajax.php",
"method":"post",
"data":{commentt:$(this).val(),
    post_id:$(this).attr('data-postid'),
},
   

success:function(data){
    iconcomment.removeClass("iconopacityhid");
    comnt.text(count);
  
//  $(this).val("");
comm.html(data + comm.html());
//iconcomment.css("display","block");

$text.val("");
// $(this).val("");

//comn.prev().val("");


}

})


}




})

})


                }
            })



            /*===================================================================================================*/



             

})



















})

</script>





<!-- ================================================================================================================ !-->
<!--<section>

<h1 class="text-center">Welcom < //echo $_SESSION["user"]; ?></h1>

<div class="information block">
<div class ="container">

<div class="card ">
<div class="card-header bg-danger">My Information</div>
<div class="card-body">
                  <ul class="list-unstyled">
                       <li>
                           <i class="fa fa-unlock-alt fa-fw"></i>
                           <span>name</span> :< echo $row["Username"]; ?><br/>
                        </li>
                       <li>
                       <i class="fas fa-envelope"></i>
                           <span>Email</span> :< echo $row["Email"]; ?><br/>
                        </li>
                       <li>
                       <i class="fa fa-user-alt fa-fw"></i>
                           <span>Full Name</span> :< echo $row["FullName"]; ?><br/>
                        </li>
                       <li>
                       <i class="fa fa-calendar fa-fw"></i>
                           <span>Register Date</span> :< echo $row["Date"]; ?><br/>
                        </li>
                       <li>
                       <i class="fa fa-tags fa-fw"></i>
                       <span>fav Categries</span> :< echo $row["Username"]; ?>
                    </li>
                     </ul>
</div>
</div>
</div>
</div>


<div class="my_ads block">
<div class ="container">

<div class="card card-default">
<div class="card-header bg-danger">Latest Ads</div>
<div class="card-body">

<
$items = getItem("Member_ID",$row["UserID"]) ;
if(! empty($rows)){
foreach($items as $item){
echo "<div class='row'>";
    echo "<div class='col-md-3 col-sm-6 col-12'>";
    echo "<div class='img-thumbnail item-box'>";
echo "<span class='price-tag'>".$item["Price"]."</span>";
echo "<img src='img.png' class='img-fluid ' />";
echo "<div class='caption'>";
echo "<h3>".$item["Name"]."</h3>";
echo "<p>".$item['Description']."</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}}else{

    echo "NO Adventers Create <a href='newadd.php'>NewAdd</a>";
}

?>

</div>
</div>
</div>
</div>

<div class="my_coms block">
<div class ="container">

<div class="card card-default">
<div class="card-header bg-danger">Latest Comments</div>
<div class="card-body">
<

       $stmt = $con->prepare("SELECT comments.*,items.Name as item_Name,items.Price,users.Username as  user_Name FROM comments
         INNER JOIN items ON items.Item_ID = comments.Item_ID
        INNER JOIN users ON users.UserID = comments.User_ID Where User_ID = ?");
        $stmt->execute(array($row["UserID"]));
        $rows = $stmt->fetchAll();
        if(! empty($rows)){

            foreach($rows as $comment){
                echo "<div class='row'>";
                echo "<div class='col-md-3 col-sm-6 col-12'>";
                echo "<h3>".$comment["item_Name"]."</h3>";
                echo "<div class='img-thumbnail item-box'>";
            echo "<span class='price-tag'>".$comment["Price"]."</span>";
            echo "<img src='img.png' class='img-fluid ' />";
           
               
                echo "</div>";
                echo "<p> comments: ".$comment['Comments']."</p>";
                echo "</div>";
                echo "</div>";
       
        }}else{ 
            echo "NO COMMENTS";
        }
    
    ?>
   
</div>
</div>
</div>
</div>



</section>!-->

<!-- ================================================================================================================ !-->
<?php

    include $tpl . "footer.php";

}else{

    header('Location: login.php');
    exist();
}

ob_end_flush();

?>

