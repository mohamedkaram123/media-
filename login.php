
  <?php 
session_start();
$pageTitle = "Login";
if(isset($_SESSION['user'])){

header("Location:index.php");
exist();

}

include "ini.php";

 
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
  if(isset($_POST['Login'])){ 
$name = $_POST['user'];
$pass = $_POST['pass'];

$shapass = sha1($pass);

$stmt = $con->prepare("SELECT * FROM users WHERE Username = ? AND Password = ?  ");
$stmt->execute(array($name,$shapass));
$count=$stmt->rowCount();
$row = $stmt->fetch();


if($count > 0){
  $_SESSION['user'] = $name;
  header("Location:index.php");
  exist();

}


}else{

  $errorarray = array();

if(isset($_POST['user'])){

  $fillteruser = filter_var($_POST['user'],FILTER_SANITIZE_STRING);

  echo $fillteruser;  
}

}


}

/*=================================================================================*/
  

?>
<div id="dd" class="fixed-top"></div>
<div class="container">

<h1 class="text-center loginpage"><span class="login selected">Login</span> | <span class="signup" id ="cl">Signup</span></h1>

<!--strart login form !-->
<form class="login-show" action='<?php echo $_SERVER['PHP_SELF'] ?>'  method="POST" >

<div class="input-container"><input  class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" required = "required" /></div>
<div class="input-container pass"><input id="pass1" class="form-control input-lg input-pass" type="password" name="pass" placeholder="Password" autocomplete="new-password" required = "required" /></div>

<input class="btn btn-lg btn-primary btn-block" name = "Login" type="submit" value="Login"/>
</form>



<!--strart Signup form !-->
<div class="Signup-show">


<div class="input-container"><input id="input1" class="form-control input-lg" type="text" name="Siguser" placeholder="Username" autocomplete="off" required = "required"/></div>
<div class="input-container pass"><input id="input22" class="form-control input-lg input-pass pass2" type="password" name="Sigpass1" placeholder="Password" autocomplete="password" required = "required" /></div>

    <div class="input-container pass"><input id="input2" class="form-control input-lg input-pass pass2" type="password" name="Sigpass2" placeholder="Password" autocomplete="new-password" required = "required" /></div>

<div class="input-container"><input id="input3" class="form-control input-lg" type="email" name="Sigemail" placeholder="valited email" required = "required"/>
<input class="btn btn-lg btn-success btn-block" id="btn" name = "Signup" type="submit" value="Signup"/>


</div>
</div>



<script src="<?php echo $js?>jquery-3.4.1.min.js" ></script>


<script>





let pass2 = document.getElementsByClassName("pass2");


let iconcheck = document.createElement("i");
   iconcheck.setAttribute('class','fas fa-check check hide');
       pass2[1].parentNode.appendChild(iconcheck);
for(let i = 0 ; i < pass2.length ; i++){ 
  pass2[i].addEventListener('input',()=>{

 
  

   
if(pass2[0].value === pass2[1].value){

 
   iconcheck.classList.remove("hide");
   iconcheck.classList.add("show");
   
}else if(pass2[0].value != pass2[1].value){ 
  iconcheck.classList.add("hide");
  iconcheck.classList.remove("show");

}

  

if(pass2[0].value === "" &&  pass2[1].value === ""){
  iconcheck.classList.add("hide");
  iconcheck.classList.remove("show");
}

  })
}


$(document).ready(function(){


    $(".login-show").show();
       $(".Signup-show").hide();
       $(".login").addClass("r");
$(".loginpage span").click(function(){
    
    $(this).addClass("selected").siblings("span").removeClass("selected");
    if($(".loginpage span.selected").text() === "Login"){
       $(".login-show").show();
       $(this).addClass("r").siblings("span").removeClass("b");
       $(".Signup-show").hide();
     console.log("Login");
    }else if($(".loginpage span.selected").text() === "Signup"){
       $(".Signup-show").show();
       $(this).addClass("b").siblings("span").removeClass("r");
       $(".login-show").hide();
        console.log("Signup");
    }
 
});

$(".cat h3").click(function(){

    $(this).next().slideToggle();
});


$("#btn").click(function(){
  let input1= $("#input1").val();
  let input2= $("#input2").val();
  let input3= $("#input3").val();
  $("#dd").css({'display':'block'});
if(input1 === "" || input2 === "" || input3 === "" ){


  
  $("#dd").addClass("alert alert-danger");
  $("#dd").html("plese enter the falids").fadeOut(2000);
 

}else{

  $("#dd").removeClass("alert alert-danger");
  $.ajax({
    "url":"Signup.php",
    "method":"post",
    "data":{Siguser:$("#input1").val(),
      Sigpass1:$("#input22").val(),
      Sigpass2:$("#input2").val(),
      Sigemail:$("#input3").val()
    },//result in data base Siguser->$post $("#input1").val()->falid send to data base
    //"type"
    success:function(response){

  
        $("#dd").html(response).fadeOut(3000);
     
         
    }
});
}


  



})






})

let input =document.getElementsByTagName("input");
    for(let i = 0 ; i < input.length ; i++){ 
       
     
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
        console.log("sdd");

        
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





let inputpass = document.getElementsByClassName("input-pass");
let div = document.getElementsByClassName("pass");

let iconpassshow = document.createElement("i");
iconpassshow.setAttribute('class','fa fa-eye fa2x sh');
  
   let iconpasshide = document.createElement("i");
   iconpasshide.setAttribute('class','fa fa-eye-slash sh');
  
   let span= document.getElementById("cl");


   for(let i = 0 ; i < input.length ; i++){ 

    inputpass[i].addEventListener('input',()=>{
  //console.log(inputpassword[i].classList);



if(inputpass[i].value === ""){

    inputpass[i].type = "password";
    iconpassshow.style.display = "none";
    iconpasshide.style.display = "none";
}else{

  //inputpass[i].addEventListener('input',()=>{})
    inputpass[i].parentNode.appendChild(iconpasshide);
    inputpass[i].parentNode.appendChild(iconpassshow);
  //  iconpasshide.style.display = "block";
  iconpassshow.style.display = "none";

    if(inputpass[i].type === "text"){

      iconpassshow.style.display = "block";
      iconpasshide.style.display = "none";
    }else{ 
          
      iconpassshow.style.display = "none";
    iconpasshide.style.display = "block";
    }

  
}



iconpasshide.addEventListener('click',()=>{  


if (inputpass[i].type === "password") {

   
    inputpass[i].type = "text";
   
    iconpassshow.style.display = "block";
    iconpasshide.style.display = "none";}


})
console.log();


iconpassshow.addEventListener('click',()=>{  
  
  if(inputpass[i].type === "text"){
   inputpass[i].type = "password";
 
   
   iconpassshow.style.display = "none";
   iconpasshide.style.display = "block";
  
  }






})


})


  
   }
   

  

</script>
  <?php include $tpl . "footer.php";?>

