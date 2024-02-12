<?php 
require_once('Connections/conx.php');
require_once('pgaccess.php');

// Add New Field
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// Insert New User
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmnewadd")) {
    $qry2 = sprintf("INSERT INTO ".$dbprefix."users (`username`, `password`, `fullname`, `mobile`, `email`,   `roleid`) 
                VALUES ( %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['UserName'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['FullName'], "text"),
                       GetSQLValueString($_POST['Mobile'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['roleid'], "text"));
    
	mysqli_select_db($conx, $database_conx);
    $qry = "SELECT * FROM ".$dbprefix."users WHERE username = '".$_POST['UserName']."'";
    $rsfound = mysqli_query($conx, $qry);
    $found = mysqli_num_rows($rsfound);
    
    if($found == 0):
        $Result1 = mysqli_query($conx, $qry2) or die(mysqli_error($conx));

        header(sprintf("Location: %s", $current_page));
    else:
        header(sprintf("Location: %s?exists=yes&fld=username", $current_page));    
    endif;    

}

// Edit 
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "frmedit")) {

  $qry = sprintf("UPDATE ".$dbprefix."users SET `username`=%s, `password`=%s, `fullname`=%s, 
                `mobile`=%s, `email`=%s WHERE userid=%s",
                       GetSQLValueString($_POST['UserName2'], "text"),
                       GetSQLValueString($_POST['Password2'], "text"),
                       GetSQLValueString($_POST['FullName2'], "text"),
                       GetSQLValueString($_POST['Mobile2'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['UserID2'], "double"));

	mysqli_select_db($conx, $database_conx);
    $chkqry = "SELECT * FROM ".$dbprefix."users WHERE username = '".$_POST['UserName']."' AND userid != '".$_POST['UserID2']."'";
    $rsfound = mysqli_query($conx, $chkqry);
    $found = mysqli_num_rows($rsfound);
    
    if($found == 0):
          $Result1 = mysqli_query($conx, $qry) or die(mysqli_error($conx));

          header(sprintf("Location: %s", $current_page));
    else:
        header(sprintf("Location: %s?exists=yes&fld=username", $current_page));    
    endif;
}

// Delete User
if ((isset($_POST["MM_insert3"])) && ($_POST["MM_insert3"] == "frmdel")) {
  $qry = sprintf("DELETE FROM ".$dbprefix."users WHERE userid=%s",
                       GetSQLValueString($_POST['UserID3'], "double"));

  mysqli_select_db($conx, $database_conx);
  $Result1 = mysqli_query($conx, $qry) or die(mysqli_error($conx));

  header(sprintf("Location: %s", $current_page));
}

// Get All users information
mysqli_select_db($conx, $database_conx);
$qry = "SELECT * FROM ".$dbprefix."userroles";
$rso = mysqli_query($conx, $qry) or die(mysqli_error($conx));
$GrpAry = array();
while($rw = mysqli_fetch_object($rso)) array_push($GrpAry, $rw);

// Get All users information
mysqli_select_db($conx, $database_conx);
$qry = "SELECT * FROM ".$dbprefix."users";
$rso = mysqli_query($conx, $qry) or die(mysqli_error($conx));
$UserAry = array();
while($rw = mysqli_fetch_object($rso)) array_push($UserAry, $rw);

// Get Selected user information
$UserID = '';
if(isset($_GET['UserID'])):
	$UserID = $_GET['UserID'];	// selected id
	mysqli_select_db($conx, $database_conx);
	$qry = "SELECT * FROM ".$dbprefix."users WHERE userid='$UserID'";
	$rso = mysqli_query($conx, $qry) or die(mysqli_error($conx));
	$OneRecord = array();
	while($rw = mysqli_fetch_object($rso)) array_push($OneRecord, $rw);
endif;

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
<?php require_once('metadata.php') ?>
<script type="text/javascript">
$().ready(function(){
	$('.edit').click(function(){
		var id = $(this).attr("id").split("_");
		window.open('<?php echo $current_page ?>?act=edit&UserID=' + id[1],'_self');
	});
	$('.del').click(function(){
		var id = $(this).attr("id").split("_");
		window.open('<?php echo $current_page ?>?act=del&UserID=' + id[1],'_self');
	});
	
	$('.cancel').click(function(){
		window.open('<?php echo $current_page ?>','_self');
	});
	$('#userimg2').change(function(){
		$('#changepic').val("ok");
	});	
});
</script>

</head>

<body>
<?php require_once('header.php'); ?>
<div class="container-xxl">
	<div class="row-xl">
        <div class="container" style="margin-top:10px; margin-bottom:10px;min-height: 300px;">
          <div class="row justify-content-center">
              <div class="alert alert-secondary"><a href="dashboard.php">Dashboard</a> > Manage users </div>
              <div class="card">
                <div class="card-body">
<?php if($act == ""): ?>
    <fieldset>
<legend>Users List</legend>
      <button class="addnew btn btn-primary btn-sm" onClick="window.open('<?php echo $current_page ?>?act=addnew','_self')">
          <i class="fa fa-plus"></i> Add New
        </button>
    <?php if(count($UserAry) > 0): ?>
      <table width="100%" cellpadding="0" cellspacing="0" class="table table-stripped">
        <tr>
          <td align="center" width="436"><strong>Username </strong></td>
            <td width="594"><strong>User role</strong></td>
          <td align="center" width="106"><strong>Action</strong></td>
        </tr>
        <?php foreach($UserAry as $row): ?>
        <tr>
          <td><?php echo $row->username ?></td>
          <td><?php foreach($GrpAry as $Grp) if($Grp->roleid == $row->roleid) echo $Grp->rolename ?></td>
          <td><a href="#" id="edit_<?php echo $row->userid ?>" class="edit btn"><i class="fa fa-edit"></i></a> 
            <a href="#" id="del_<?php echo $row->userid ?>" title="Delete" class="del btn"><i class="fa fa-trash"></i></a></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
      <div>No records exists</div>
      <?php endif; ?>
    </fieldset>

    <?php endif; if($act == "addnew"): ?>
    <fieldset>
    <legend>New User</legend>
        <?php if(isset($_GET['exists']) && $_GET['exists'] == "yes"): ?>
        <div style="color: #F00"><?php echo $_GET['fld'] ?>already exists</div>
        <?php endif; ?>
    <form id="frmnewadd" name="frmnewadd" method="POST" enctype="multipart/form-data" >
      <table align="center" cellpadding="0" cellspacing="0" class="table">
        <tr>
          <td width="115">Username:</td>
          <td width="247"><input type="text" name="UserName" id="UserName" class="form-control" /></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="Password" id="Password" class="form-control" /></td>
        </tr>
        <tr>
          <td>Fullname</td>
          <td><input type="text" name="FullName" id="FullName" class="form-control" /></td>
        </tr>
        <tr>
          <td>Mobile</td>
          <td><input type="text" name="Mobile" id="Mobile" class="form-control" /></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><input type="text" name="Email" id="Email" class="form-control" /></td>
        </tr>
        <tr>
          <td>User role</td>
          <td><select id="roleid" name="roleid" class="form-control">
              <?php foreach($GrpAry as $Grp): ?>
              <option value="<?php echo $Grp->roleid ?>"><?php echo $Grp->rolename ?></option>
              <?php endforeach; ?>
              </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" id="button" value="Save" class="btn btn-primary" />
            <input type="button" name="cancel" id="cancel" value="Cancel" class="btn btn-secondary cancel" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="frmnewadd" />
    </form>
    </fieldset>

    <?php endif; if($act == "edit"): ?>
    <fieldset>
    <legend>Update user
    </legend><form id="frmedit" name="frmedit" method="post" enctype="multipart/form-data" >
        <?php if(isset($_GET['exists']) && $_GET['exists'] == "yes"): ?>
        <div style="color: #F00"><?php echo $_GET['fld']; ?> already exists</div>
        <?php endif; ?>
    <?php foreach($OneRecord as $row): ?>
      <table align="center" cellpadding="0" cellspacing="0" class="table">
        <tr>
          <td>Username :</td>
          <td><input type="text" name="UserName2" id="UserName2" value="<?php echo $row->username ?>" class="form-control" /></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="Password2" id="Password2" value="<?php echo $row->password ?>" class="form-control" /></td>
        </tr>
        <tr>
          <td>Fullname</td>
          <td><input type="text" name="FullName2" id="FullName2" value="<?php echo $row->fullname ?>" class="form-control" /></td>
        </tr>
        <tr>
          <td>Mobile</td>
          <td><input type="text" name="Mobile2" id="Mobile2" value="<?php echo $row->mobile ?>" class="form-control" /></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><input type="text" name="Email2" id="Email2" value="<?php echo $row->email ?>" class="form-control" /></td>
        </tr>
        <tr>
          <td>User role</td>
          <td><select name="roleid2" id="roleid2" class="form-control">
          <?php foreach($GrpAry as $Grp): ?>
          <option value="<?php echo $Grp->roleid ?>" <?php if($Grp->roleid == $row->roleid) echo 'selected="selected"'; ?>><?php echo $Grp->rolename ?></option>
          <?php endforeach; ?>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
         <td>&nbsp;</td>
         <td><input type="submit" name="Submit" id="button3" value="Update" class="btn btn-primary" />
           <input type="button" name="cancel" id="cancel" value="Cancel" class="btn btn-secondary cancel" /></td>
       </tr>
      </table>
      <input type="hidden" name="UserID2" value="<?php echo $row->userid ?>" />
      <input type="hidden" name="MM_insert2" value="frmedit" />
      <?php endforeach; ?>
    </form>
    </fieldset>

    <?php endif; 
        if($act == "del"): ?>
    <fieldset>
    <legend>Delete User</legend>
    <?php foreach($OneRecord as $row): ?>
    <form id="frmdel" name="frmdel" method="post">
    <table align="center" cellpadding="0" cellspacing="0" class="table">
      <col width="64" span="2" />
      <tr>
        <td>Username:</td>
        <td><?php echo $row->username ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="button3" id="button5" value="Confirm delete" class="btn btn-danger" />
          <input type="button" name="cancel" id="cancel" value="Cancel" class="btn btn-secondary cancel" /></td>
      </tr>
    </table>
      <input type="hidden" name="UserID3" value="<?php echo $row->userid ?>" />
      <input type="hidden" name="MM_insert3" value="frmdel" />
    </form>    
    <?php endforeach; ?>
    </fieldset>
    <?php endif; ?>
                </div>
          </div>
        </div>
    </div>
</div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>