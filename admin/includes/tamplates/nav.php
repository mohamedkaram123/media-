<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item"><a class="nav-link" href="catagerous.php"><?php echo lang("CATAGRIES")?></a></li>
      <li class="nav-item"><a class="nav-link" href="item.php"><?php echo lang("ITEMS")?></a></li>
      <li class="nav-item"><a class="nav-link" href="member.php?do=Manage"><?php echo lang("MEMBERS")?></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><?php echo lang("STATISTICS")?></a></li>
      <li class="nav-item"><a class="nav-link" href="comments.php"><?php echo lang("COMMENTS")?></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><?php echo lang("LOGS")?></a></li>
      
   
    </ul>
    </div>
    
    <li class="nav-item dropdown ml-auto">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../index.php">Visit shop</a>
          <a class="dropdown-item" href="member.php?do=Edit&userid=<?php echo $_SESSION['ID']?>">Edit profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="logout.php">logout</a>
        </div>
      </li>
    
  


  
 
</nav>