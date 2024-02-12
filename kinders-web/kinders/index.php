<?php require_once('Connections/conx.php'); ?>
<?php
if ( isset( $_POST[ 'username' ] ) ) {
  $username = $_POST[ 'username' ];
  $password = $_POST[ 'password' ];

  mysqli_select_db( $conx, $database_conx ) or die(mysqli_error($conx));
  $qry = "SELECT * FROM " . $dbprefix . "users WHERE username='" . $username . "' AND password='" . $password . "'";
  $rs = mysqli_query( $conx, $qry ) or die(mysqli_error($conx));
  $found = mysqli_num_rows( $rs );
  $row = mysqli_fetch_object( $rs );

  if ( $found > 0 ) {
    $_SESSION[ 'MM_Username' ] = $username;
    $_SESSION[ 'MM_UserGroup' ] = $row->usertypeid;
    $redirect_url = "dashboard.php";
  } else {
    $redirect_url = $current_page . "?log=fail";
  }
  header( "Location: " . $redirect_url );
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
    <?php require_once('metadata.php'); ?>
<script type="text/javascript">
$().ready(function(){
   
});        
</script>
</head>

<body>
<?php require_once('header.php'); ?>
<div class="container-xxl">
	<div class="row-xl">
        <div class="container" style="margin-top:10px; margin-bottom:10px;min-height: 500px;">
          <div class="row justify-content-start">
            <div class="col-md-12">
                <div class="alert alert-secondary">Login</div>
                <div class="row justify-content-center">

<div class="card mb-3" style="max-width: 500px;">
  <div class="row g-0">
    <div class="col-12" align="center">
      <div class="card-body" align="center">
        <h6 class="card-title" >Administrators Login</h6>
        <p class="card-text" align="center">
          <table>
            <tr>
              <td>
              <img src="images/login.jpg"  class="img-fluid rounded-start"  align="center" style="border-radius:20px">
              </td>
              <td>
              <form id="loginform" name="loginform" method="post">
                            <p class="card-text">
                            <?php if(isset($_GET['log']) && $_GET['log'] == "fail"){ ?>
                          <div class="err">Invalid username/password</div>
                          <?php } ?>
                          <div class="input-group mb-3"> <span class="input-group-text" id="basic-addon3">Username</span>
                            <input type="text" class="form-control" id="username" name="username" required>
                          </div>
                          <div class="input-group mb-3"> <span class="input-group-text" id="basic-addon3">Password</span>
                            <input type="password" class="form-control" id="password" name="password" required>
                          </div>
                          </p>
                          <div class="col-auto">
                          <button style="background-color: #009 ; color: white; border: none; padding: 4px 35px; border-radius: 20px;">login</button>

                          </div>
                          </form>          
              </td>
            </tr>
          </table>

                        </p>
      </div>
    </div>
  </div>
</div>                    
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<?php require_once('footer.php') ?>
</body>
</html>