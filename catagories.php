<?php
session_start();
$pageTitle = "Catagoties";
include "ini.php";


?>
  

<h1 class="text-center"><?php echo str_replace("-"," ",$_GET["name"]); ?></h1>

<div class="container">
<div class='row'>
<?php
foreach(getItem("Cat_ID",$_GET["id"]) as $item){

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
}

?>
</div>
</div>


<?php

include $tpl . "footer.php";?>