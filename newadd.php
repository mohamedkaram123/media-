<?php
ob_start();
session_start();
$pageTitle = "Create New Item";
if(isset($_SESSION['user'])){



include "ini.php";



?>
<div id="div" class="fixed-top"></div>

<div class="create-ad block">
<div class ="container">

<div class="card card-default">
<div class="card-header bg-danger"><?php echo $pageTitle; ?></div>
<div class="card-body">
<div class="row">
<div class="col-md-8">



<div class="form-horizontal">
        
        <div class='form-group  row'>
        <label class="col-sm-2  control-label">Name</label>
        <div id="dd" class='col-sm-10 col-md-9 '>
            <input id='name' data-class = ".name" type="text" name="name" class="form-control form-control-lg inp1"  placeholder="Name of the Item"  required = "required"/>
        </div> 
        
        </div>
        
        <div class='form-group  row'>
        <label class="col-sm-2  control-label">Description</label>
        <div id="dd" class='col-sm-10 col-md-9 '>
            <input id='desc'  data-class = ".desc" type="text" name="description" class="form-control form-control-lg inp1"  placeholder="description of the Item"  required = "required"/>
        </div> 
        
        </div>
        
        <div class='form-group  row'>
        <label class="col-sm-2  control-label">Price</label>
        <div id="dd" class='col-sm-10 col-md-9 '>
            <input id='price'  data-class = ".price" type="text" name="price" class="form-control form-control-lg inp1"  placeholder="100$"  required = "required"/>
        </div> 
        
        </div>
        
        
        <div class='form-group  row'>
        <label class="col-sm-2  control-label">Country Made</label>
        <div id="dd" class='col-sm-10 col-md-9 '>
            <input id='country' type="text" name="country" class="form-control form-control-lg"  placeholder="country of made"  required = "required"/>
        </div> 
        
        </div>
        


        
        
        <div class='form-group  row'>
        <label class="col-sm-2  control-label">Statues</label>
        <div id="dd" class='col-sm-10 col-md-9 '>
            <select id="statues"  name ="statues">
        
            <option value="0">...</option>
            <option value="1">New</option>
            <option value="2">Like New</option>
            <option value="3">Used</option>
            <option value="4">Very Old</option>
            </select>
        </div> 
        
        </div>
        
       
        
        
        
        <div class='form-group  row'>
        <label class="col-sm-2  control-label">Catagory Name</label>
        <div id="dd" class='col-sm-10 col-md-9 '>
            <select id="catagory" name ="cat_id">
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
            <input id="btn" type="submit" value="Add Item" class=" btn btn-primary"/>
        </div> 
        
        </div>
        
        </div>




</div>

<div class="col-md-4">
<div class='img-thumbnail item-box'>
    <span id="span" class='price-tag '>$<span class="price"></span></span>
<img src='img.png' class='img-fluid ' />
<div class='caption'>
<h3 class="name">Title</h3>
<p class="desc">Discription</p>
</div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>




<script src="<?php echo $js?>jquery-3.4.1.min.js" ></script>
<script>
$(document).ready(function(){


  

$("#btn").click(function(){

    console.log("ds");

    let name1=$("#name").val();
    let desc1=$("#desc").val();
    let price1=$("#price").val();
    let country1=$("#country").val();
    let statues1=$("#statues").val();
    let category1=$("#catagory").val();
    $("#div").css({'display':'block'});
if(name1 === "" || desc1 === "" || price1 === "" || country1 === "" || statues1 === "0" || category1 === "0" ){

    $("#div").addClass("alert alert-danger");
  $("#div").html("plese enter the falids").fadeOut(3000);
 


}else{

    $("#div").removeClass("alert alert-danger");
    $.ajax({
     "url":"add.php",
     "method":"post",
     "data":{
        name:name1,
        description:desc1,
        price:price1,
        country:country1,
        statues:statues1,
        cat_id:category1},

        success:function(respons){
$("#div").html(respons).fadeOut(3000);
        }
    });
}

});

});





    let inpu = document.getElementsByClassName("inp1");
  


for (let i = 0; i < inpu.length; i++) {
   
    
    //console.log(inpu[i].dataset.class);

    inpu[i].addEventListener('input',()=>{
       // 
       let classes = document.querySelector(inpu[i].dataset.class);
     // let data =   inpu[i].dataset.class;
     console.log();
     classes.textContent = inpu[i].value;
      

});
}
/*

inpu[1].addEventListener('input',()=>{

p.textContent = inpu[1].value;


});
inpu[2].addEventListener('input',()=>{

span.textContent = "$" + inpu[2].value;

});*/



</script>

<?php
    include $tpl . "footer.php";

}else{

    header('Location: index.php');
    exist();
}

ob_end_flush();

?>