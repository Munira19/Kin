<?php require_once('Connections/conx.php'); ?>
<?php require_once('pgaccess.php'); 

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
<?php require_once('metadata.php') ?>
<style type="text/css">
  .fa{font-size: 40px; text-align: center;}
</style>
</head>

<body>
<?php require_once('header.php'); ?>
<div class="container-xxl">
	<div class="row-xl">
        <div class="container" style="margin-top:10px; margin-bottom:10px;min-height: 500px;">
          <div class="row justify-content-center">
              <div class="alert alert-secondary">Dashboard</div>
              <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                      <div class="card">
                      <i class="fa fa-user"></i> 
                        <div class="card-body">
                          <div align="center"><a href="profile.php" class="btnx">My Profile</a></div>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card">
                      <i class="fa fa-users"></i> 
                        <div class="card-body">
                        <div align="center"><a href="user_model.php" class="btnx">Manage Users</a></div>
                        </div>
                      </div>
                    </div>
                   
                    <div class="col">
                      <div class="card">
                      <i class="fa fa-sign-out"></i> 
                        <div class="card-body">
                        <div align="center"><a href="dashboard.php?doLogout=true" class="btnx">Logout</a></div>
                        </div>
                      </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>