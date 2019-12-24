<?php
ob_start();
session_start();

include "connect.php";



$stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$roww =$stmt->fetch();

 


$sessionid = $roww[0];

$stmt = $con->prepare("SELECT COUNT(C_ID2) from con2 where User_ID = User_ID AND  User_ID2= ? AND visiblity = 0;");
    $stmt->execute(array($sessionid));
    $countsMsg =$stmt->fetch();
  
if($countsMsg[0] > 0){
    $fo = "(".$countsMsg[0].")";
}else{
    $fo ="";
}



$pageTitle =$fo."Chat";

if(isset($_SESSION['user'])){

 

include "ini.php";




$stmt = $con->prepare("SELECT UserID FROM users Where Username = ?");
$stmt->execute(array($_SESSION['user']));
$roww =$stmt->fetch();




$sessionid = $roww[0];







?>
<link rel="stylesheet" href="chat.css"/>  
<div class="wrapper">
    <div id="imguploads"></div>
    <div class="containe">
        <div class="left" id="style-2">

            <div class="top">
                <input type="text" placeholder="Search" />
                <a href="javascript:;" class="search"></a>
            </div>
            <ul class="people" >
    
                    <?php

$stmt = $con->prepare("SELECT * from users");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
   
 
    
foreach ($rows as $row) { ?>


 <?php if($row['Username'] === $_SESSION['user']){  }else{?><li class="person list-unstyled" >
               
   <a class="link liks" data-id='<?php echo  $row['UserID'];?>' href="#" > <?php  if($row['Username'] === $_SESSION['user']){
      
   }else{
       
    $pathomguploads = "uploads/avatars/" . $row["avatar"];
  echo  '<img src='. $pathomguploads.' alt="" />';
  echo "<span id='Username'>". $row['Username']."<span>";
  $stmt = $con->prepare("SELECT COUNT(C_ID2) from con2 where User_ID = ? AND  User_ID2= ? AND visiblity = 0;");
  $stmt->execute(array($row['UserID'], $sessionid));
  $countsMsg =$stmt->fetch();
if($countsMsg[0] === "0"){

}else{ 
  echo  "<span id='not' class='not'>".$countsMsg[0]."<span>";}

   
   };?>
   <?php

  echo "</a>"; if($row['Username'] === $_SESSION['user']){  }else{
    echo   "<br />";
  }
?>
   </li>  <?php } }; ?>
               
               
            </ul>
        </div>
<div class="right" >
        <img class="loader" src="loader.gif"/>
        <div class="chat" id="style-2">
        <div id="soso" class="soso">
      
     
            <div class="top"><span><?php echo '<span class="name">hi '.$_SESSION['user'].' happy day....</span>'; ?></span></div>
           
          
              <h1 class="center-text">Who Will Converstion Today We Hope Good Night...<h1>
           
          
 
      
            </div>


            </div>

            <div id="tampphoto">

</div>
            <div class="write"  id="write">
 <input type="text" id="massege" name="massege" placeholder="send"  />
    <a href="#" id="btn" class="send"><i  class="fab fa-atlassian "></i></a>
    <i class="fas fa-camera iconcamera"></i>
    <input type="file" id="fileimg" name="file" class="imgupload" />
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




<script src="jquery-3.4.1.min.js"></script>
    <script type="text/javascript">  
 


 let input = document.getElementById("massege");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {

    if(input.value === ""){

    }else{
        document.getElementById("btn").click();
    }
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
   
  };


});

 let button =  document.querySelector("#btn");
 let massege =  document.querySelector("#massege");
 let write =  document.querySelector("#write");
 button.style.display = "none";
 write.style.display = "none";
 
 massege.addEventListener("input",()=>{
     if(massege.value === ""){
        button.style.display = "none";
     }else{
        button.style.display = "block";
     }
    

});



$(document).ready(function(){  





  /*  $(".popup").click(function () {
    $(document).scrollTop(700);
       var $src = $("#soso").children("img").attr("src");
       $(".show").fadeIn();
       $(".img-show img").attr("src", $src);
       $(".conimg").hide();
       $("body").css("overflow","hidden")
   });*/

function popup(){ 

    $("img").each(function () {
    
$(this).click(function () {
    ///$(document).scrollTop(700);
       var $src = $(this).attr("src");
       $(".show").fadeIn();
       $(".img-show img").attr("src", $src);
       $(".conimg").hide();
       $("body").css("overflow","hidden")
   });
});
   
   $(".overlay").click(function () {
       $(document).scrollTop(0);
       $(".show").fadeOut();
       $(".conimg").show();
       $("body").css("overflow","auto")
   });
   






}


$(".iconcamera").click(function(){
    $("#fileimg").trigger( "click" );
})



$("#fileimg").change(function(){
    console.log("good");
    let   getid = $("#custId").val();

       let files = new FormData();
     files.append('file', $('#fileimg')[0].files[0]);

//console.log( $('#fileimg')[0].files[0]);
if($('#fileimg')[0].files[0] === undefined){
   console.log("good");
}else{


    $.ajax({
         "url":"chatajaxphoto.php",
         "method":"post",
         "data":files,
         processData: false,
         contentType:false,
         cache:false,
         //"type"
         success:function(response){
           
        //   $("#imguploads").html(response);
        $("#tampphoto").html(response);
      //  
      let dataavatar = $("#im").attr("data-img");
  let pathdelete = $("#im").attr("data-delete");


        $(".photor").mouseenter(function(){
    $("#icon").addClass("fas fa-times");

})

$(".photor").mouseleave(function(){


$("#icon").removeClass("fas fa-times");
})


$("#icon").click(function(){
    $(".box-border").css("height","auto");
    $.ajax({
         "url":"chatajaxphoto.php",
         "method":"post",
         "data":{
            pathdelete:pathdelete,
             id:getid
         },
    
         //"type"
         success:function(response){
          
            $("#tampphoto").html("");
        //   $("#soso"+getid).html(response);
        console.log(response);
     

         }
     })
  

})

$("#send").click(function(){
  $.ajax({
         "url":"chatajaxphoto.php",
         "method":"post",
         "data":{
             dataavatar:dataavatar,
             id:getid
         },
    
         //"type"
         success:function(response){
          
 
          $("#soso"+getid).html(response);
          $("#tampphoto").html("");
        console.log(response);
     

         }
     })

    })


         }
     })
}
  

})

/*let sosoclass = $("#soso").children("h1.center-text").attr("class");

if(sosoclass === "center-text"){
   $(".write").css({
       "opacity":"0"
   })
}*/

    setInterval(()=>{
            user();

}, 5000);

    
      //  var test = $('.chat'not).height();
    
        $(".chat").scrollTop(11900);
   
//console.log($(this).scrollTop());


    $("#btn").click(function(e){
     
        e.preventDefault();
  let   getid = $("#custId").val();
      

     $.ajax({
         "url":"chatroute.php",
         "method":"post",
         "data":{massege:$("#massege").val(),
            getid:$("#custId").val()
        },
         //"type"
         success:function(response){

         
        
            massege.value = "";

       
             $("#soso"+getid).html(response);
        
           
             button.style.display = "none";
             
$(".me").siblings(".me").next(".you").css('margin-top',30);

$(".me").siblings(".me").prev(".you").css('margin-bottom',30);


$(".me").each(function(){
        if($(this).width() > "395" ){
       $(this).addClass("warp");}
    });

    $(".you").each(function(){
        if($(this).width() > "395" ){
       $(this).addClass("warp");}
    });

$(".chat").scrollTop(11900);
        



}


     });
     
     
       });
   
      

       $('.link').click(function(e){

       /* $(".write").css({
       "opacity":"1"
   })*/

        if(! $(this).hasClass("actives")){
        let  ids =  $("#custId").val();

  $("#soso"+ids).attr('id',"soso");

       }
       
    })


  
        $('.link').click(function(e){
         //   $(".loader").show();

        
     
        
         let not = $(this).children().last().children().last();
     let active =    $(this).parent();
     let link =    $(this);
       
let  iduser = $(this).attr('data-id');
         active.addClass("actives");
                
            e.preventDefault();
        //  console.log($(this).attr('data-id'));
        console.log( $("#soso").attr('id'))
          let geid = $(this).attr('data-id');
          $("#soso").attr('id',"soso"+geid);
         

            $.ajax({
                type: "GET",
                url: "chatroute.php",
                data: "id="+$(this).attr('data-id'),
                beforeSend:function(){
                    $(".loader").show();
                    $('#soso'+geid).html("");
                    write.style.display = "none";
                    if(active.siblings().hasClass("actives")){
                   //     $("#soso").attr('id',"soso"+geid);
                        active.siblings().removeClass("actives");
                    }
                },
                success:function(data) {


                    setInterval(()=>{

                        $.ajax({
                type: "GET",
                url: "updatechat.php",
                data: "iduser="+iduser,
                success:function(data){
                console.log("1");
                
                }
                        })

                  }, 3000);

                    console.log()
                    $(".write").css({
       "display":"block"
   })
                 
                   // active.removeClass("person");

                  
             if(not.text() !== "0"){
                 not.hide();
             }


                    $(".loader").hide();
                 //   setInterval(() => {
                    $('#soso'+geid).html(data);
                   
              //  }, 1000);
                    write.style.display = "block";
                    button.style.display = "none";

                    
                

                     $("#title").text($("#tit").val()); 


$(".me").siblings(".me").next(".you").css('margin-top',30);

$(".me").siblings(".me").prev(".you").css('margin-bottom',30);


 /*  if($(this).width() > "395" ){
       $(this).addClass("warp");
   }*/

   
    $(".me").each(function(){
        if($(this).width() > "395" ){
       $(this).addClass("warp");}
    });

    $(".you").each(function(){
        if($(this).width() > "395" ){
       $(this).addClass("warp");}
    });


//console.log($(".me").siblings(".me").prev(".you"));




$(".chat").scrollTop(11900);


                }
            });
          
        });




           
          
        
 


 function update_data(id){
  

        $.ajax({
                type: "GET",
                url: "updatechat.php",
                data: "id="+id,
                success:function(data){
                
                    $(".chat").scrollTop(11900);
                  
       
                    popup()

                    $(".loader").hide();
                 //   setInterval(() => {
                    $('#soso'+id).html(data);
              //  }, 1000);

              
   /* $("#massege").keyup(function(){
  
        if( $("#massege").val() === ""){
           
            $("#btn").css("display","none");
        }else{
            console.log($("#btn"));
            $("#btn").css("display","block");
        }
    })
                    write.style.display = "block";*/
                  
                    
             

                     $("#title").text($("#tit").val()); 


$(".me").siblings(".me").next(".you").css('margin-top',30);

$(".me").siblings(".me").prev(".you").css('margin-bottom',30);


 /*  if($(this).width() > "395" ){
       $(this).addClass("warp");
   }*/

   
    $(".me").each(function(){
        if($(this).width() > "395" ){
       $(this).addClass("warp");}
    });

    $(".you").each(function(){
        if($(this).width() > "395" ){
       $(this).addClass("warp");}
    });


                }
            });
  

    
};


function user(){

$(".link").each(function(){
    let userid = $(this).attr('data-id');
    update_data(userid);
    $(".chat").scrollTop(11900);
})

        }





       
 
})




</script>



<?php
    include $tpl . "footer.php";

}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();

?>