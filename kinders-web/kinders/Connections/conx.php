<?php
if (!isset($_SESSION)) {
  session_start();
}
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
//error_reporting(0);
if($_SERVER['HTTP_HOST'] == "127.0.0.1" || $_SERVER['HTTP_HOST'] == "192.168.1.2" || $_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] = "10.10.172.222" ){
	$hostname_conx = "localhost";
	$database_conx = "db_kinders";
	$username_conx = "root";
	$password_conx = "mah1019";
}else{
	//error_reporting(0);

}
$conx = mysqli_connect($hostname_conx, $username_conx, $password_conx) or die("unable to connect"); 


mysqli_set_charset($conx,'utf8');

date_default_timezone_set('Asia/Riyadh');

$act = ''; if(isset($_GET['act'])) $act = $_GET['act'];
if(isset($_POST['act'])) $act = $_POST['act'];

// current page
$current_page = $_SERVER['PHP_SELF'];
$dbprefix = '';
$lang = 'en';
$Logged = false;
mysqli_select_db($conx, $database_conx);
$UserID = 0 ; $GrpID = 0;
if(isset($_SESSION['MM_Username']) && $_SESSION['MM_Username'] != ""): // check use logged or not
	$username = $_SESSION['MM_Username'];	// selected id
	mysqli_select_db($conx, $database_conx);
	$qry = "SELECT * FROM ".$dbprefix."users WHERE username='$username'";
	$rso = mysqli_query($conx, $qry) or die(mysqli_error($conx));
	$UserData = array();
	while($rw = mysqli_fetch_object($rso)) array_push($UserData, $rw);
	$Logged = true;
	foreach($UserData as $User):
		$UserID = $User->userid;
        $GrpID = $User->roleid;
	endforeach;
endif;


?>