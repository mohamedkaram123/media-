let input1 = document.getElementById("input1");
let input2 = document.getElementById("input2");
let body1 =  document.querySelector("body");
let form =  document.querySelector("form");
let input = document.querySelector("input")
   // document.querySelector("h1").style.color = "red";

   // Calls the selectBoxIt method on your HTML select box
   $("select").selectBoxIt({
     
   });
              

input1.addEventListener("focus",()=>{

    input1.setAttribute("placeholder","")
});

input1.addEventListener("blur",()=>{

    input1.setAttribute("placeholder","Username")
});

input2.addEventListener("focus",()=>{

    input2.setAttribute("placeholder","")
});

input2.addEventListener("blur",()=>{

    input2.setAttribute("placeholder","Password")
});


