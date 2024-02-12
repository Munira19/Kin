<?php require_once('Connections/conx.php'); ?>
<?php require_once('pgaccess.php'); ?>
<?php 
if(isset($_POST['updateprofile']) && $_POST['updateprofile'] == "ok"){
	$uploads_dir = 'users';
	$userimg = $_POST['userimg'];
	if(isset($_POST["changepic"]) && $_POST["changepic"] == "ok"){
		$oldfile = $uploads_dir.'/'.$_POST['userimg'];
		if(file_exists($oldfile) && $_POST['userimg']!="") unlink($oldfile);
		
		$tmp_name = $_FILES["userimg2"]["tmp_name"];
		$userimg = str_replace(" ", "_", basename($_FILES["userimg2"]["name"])); 
		move_uploaded_file($tmp_name, "$uploads_dir/$userimg");
	}
    
    $query = "Update ".$dbprefix."users SET  
                username='".$_POST['username']."', password='".$_POST['password']."', fullname='".$_POST['fullname']."',
                 email = '".$_POST['email']."', mobile = '".$_POST['mobile']."', 
                 WHERE userid = '$UserID'";
    mysqli_select_db($conx, $database_conx);
    $rs = mysqli_query($conx, $query) or die(mysqli_error($conx));
    header("Location: ".$current_page);
}

$username = "0";
if(isset($_SESSION['MM_Username'])) $username = $_SESSION['MM_Username'];

mysqli_select_db($conx, $database_conx);
$qry = "SELECT * FROM ".$dbprefix."users WHERE username='".$username."'";
$rs = mysqli_query($conx, $qry);
$row  = mysqli_fetch_object($rs);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
<?php require_once('metadata.php') ?>
<style type="text/css">
    
</style>
        <script type="text/javascript">
$().ready(function(){

  
});
</script>
</head>

<body>
<?php require_once('header.php'); ?>
<div class="container-xxl">
	<div class="row-xl">
        <div class="container" style="margin-top:10px; margin-bottom:10px;min-height: 300px;">
          <div class="row justify-content-center">
              <div class="alert alert-secondary"><a href="dashboard.php"><u>Dashboard</u></a> >My profile</div>
              <div class="card">
                <div class="card-body">
                    <?php if($act == ""){ ?>
                    <input type="button" class="btn btn-primary btn-sm" value="Edit" onClick="window.open('<?php echo $current_page.'?act=edit' ?>','_self')">
                    
                    <table class="table">
                      <tr><th>Username</th>
                          <td><?php echo $row->username ?></td></tr>
                      <tr><th>Password </th><td><?php echo $row->password ?></td></tr>
                      <tr><th>Fullname </th><td><?php echo $row->fullname ?></td></tr>
                      <tr><th>Email  </th>
                          <td><?php echo $row->email ?></td></tr>
                    </table>
                    <?php } ?>
                    <?php if($act == "edit"){ ?>
                    <form id="frmupdate" name="frmupdate" method="post">
                    <table class="table" width="80%">
                      <tr><th>Username <span class="required">*</span></th>
                          <td><input type="<?php if($GrpID != 1){ echo 'text'; }else{ echo 'hidden'; } ?>" class="form-control" id="username" name="username" value="<?php echo $row->username ?>" required>
                          <div class="invalid-feedback">
                              Please provide a username.
                            </div>
                          </td>
                          <th>Password  <span class="required">*</span></th>
                          <td><input type="<?php if($GrpID != 1){ echo 'password'; }else{ echo 'hidden'; } ?>" class="form-control" id="password" value="<?php echo $row->password ?>" name="password" required>
                          <div class="invalid-feedback">
                              Please provide a password.
                            </div>
                          </td></tr>
                      <tr><th>Fullname <span class="required">*</span></th>
                          <td colspan="3"><input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $row->fullname ?>" required>
                          <div class="invalid-feedback">
                              Please provide a  fullname.
                            </div>
                          </td></tr>
                      
                      <tr><th>Email  <span class="required">*</span></th>
                          <td><input type="text" class="form-control" id="email" name="email" value="<?php echo $row->email ?>" required>
                          <div class="invalid-feedback">
                              Please provide a Email.
                            </div>
                          </td></tr>
                        
                      <tr><td colspan="2">
                          <input type="submit" value="Update" class="btn btn-primary btn-sm">
                          <input type="button" value="Cancel" class="btn btn-primary btn-sm" onClick="window.open('<?php echo $current_page ?>','_self')">
                          </td></tr>
                </table>
                        <input type="hidden" id="updateprofile" name="updateprofile" value="ok">
                        </form>
                    <?php } ?>
                  </div>
                </div>
          </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>