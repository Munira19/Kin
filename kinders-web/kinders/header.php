<header>

<div class="container-fluid" style="background:#FFF; width:100%; float:left; position:relative;">
    <div class="container">
    <div class="row">
        <div class="col-3">
          <img src="images/logo.png" width="100" height="80">
        <h4 style="margin-top: 10px;"><b>Kinders Finder</b></h4>
        </div>
        <div class="col-9">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php if(!$Logged){ ?>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
          <?php } ?>
          <li class="nav-item">
          <a class="nav-link" href="aboutus.php">About us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contactus.php">Contact us</a>
        </li>
      </ul>
        
            <?php if($Logged){ ?>
      <div class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            My Account
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
            <li><a class="dropdown-item" href="profile.php"><i class="fa fa-user"></i> My profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="dashboard.php?doLogout=true"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>
          </ul>
      </div>
            <?php } ?>
    </div>
  </div>
</nav>      
        </div>
</div>        
    </div>
</div>

</header>