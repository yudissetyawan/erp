<?php require_once('../Connections/core.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_employee";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_jenis_training ORDER BY jenis_training ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM h_datapribadi WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM h_mcu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM h_experiences WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset5, "text"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM h_penghargaan WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset6, "text"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM h_sim WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset7, "text"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_datakeluarga WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset8, "text"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM h_dataortu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset9, "text"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_Recordset10 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset10 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset10 = sprintf("SELECT * FROM h_bahasa WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset10, "text"));
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT * FROM h_training WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset11, "text"));
$Recordset11 = mysql_query($query_Recordset11, $core) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);

$colname_Recordset12 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset12 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset12 = sprintf("SELECT * FROM h_job_position WHERE id = %s", GetSQLValueString($colname_Recordset12, "int"));
$Recordset12 = mysql_query($query_Recordset12, $core) or die(mysql_error());
$row_Recordset12 = mysql_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysql_num_rows($Recordset12);

$colname_Recordset13 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset13 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset13 = sprintf("SELECT * FROM dms WHERE idms = %s", GetSQLValueString($colname_Recordset13, "text"));
$Recordset13 = mysql_query($query_Recordset13, $core) or die(mysql_error());
$row_Recordset13 = mysql_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysql_num_rows($Recordset13);
$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manpower Allocation</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function datediff($tgl1, $tgl2){
	 $tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	 $tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
 	  $diff_secs = abs($tgl1 - $tgl2);
	 $base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	 $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	 return array( "years" => date("Y", $diff) - $base_year,
	"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	"months" => date("n", $diff) - 1,
	"days_total" => floor($diff_secs / (3600 * 24)),
	"days" => date("j", $diff) - 1 ),
	 "hours_total" => floor($diff_secs / 3600),
	"hours" => date("G", $diff),
	"minutes_total" => floor($diff_secs / 60),
	"minutes" => (int) date("i", $diff),
	"seconds_total" => $diff_secs,
	"seconds" => (int) date("s", $diff)  );
	 }
</script>

<style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: underline;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style>

</head>

	
<body>
<table width="1200" border="0" align="center">
<tr>
    <td height="64" colspan="2" rowspan="2"><a href="home.php"><img src="images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></a></td>
    <td width="628" align="right" valign="bottom">
        <table width="400" border="0" align="right" cellpadding="1" cellspacing="1">
          <tr>
            <td width="8" align="right" valign="middle">|</td>
            <td width="250" align="right" valign="middle" class="demoHeaders">Your Logged as <a href="hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
            <td width="8" class="demoHeaders">|</a></td>
            <td width="85" class="demoHeaders"><a href="contact.php">Contact Us</a></td>
            <td width="8" class="demoHeaders">|</td>
            <td width="60" class="demoHeaders"><a href="logout.php">Logout</a></td>
            <td align="right" width="10" class="demoHeaders">|</td>
          </tr>
        </table>
    </td>
<tr>
  <td align="right" valign="bottom"><?php { require_once "menu_notification.php"; } ?></td>
<tr>
    <td id="font" class="tabel_index">Manpower Allocation</td>
    <td colspan="2" align="right" class="tabel_index" id="font">
    	<table width="500" height="17" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="202" align="left" bgcolor="#EFEFEF" class="tabel_index"><?php echo "Date : " . date("d F Y");?></td>
            <td width="298" align="left" bgcolor="#EFEFEF" class="tabel_index"> Welcome <?php echo $_SESSION['MM_Username']?></td>
          </tr>
		</table>
    </td>
  <tr>
    <td colspan="4" align="left" class="General" id="font">
    <?php if ($_GET[modul]=='unapproved'){
							echo '<iframe style="border:thin" width="1300" height="600" src="tm/unapproved_crf.php"></iframe>';
						}
						elseif ($_GET[modul]=='notif'){
							echo '<iframe style="border:thin" width="1300" height="600" src="prj/bacanotif.php?data=$usrid"></iframe>';
						}
						else {
		?>    
        <div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Location</li>
            <li class="TabbedPanelsTab" tabindex="0">Manpower Allocation</li>
            <li class="TabbedPanelsTab" tabindex="0">Selection</li>
          </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent"><iframe style="border:thin" width="1300" height="600" src="fab/lokasi_home.php"></iframe></div>
            <div class="TabbedPanelsContent"><iframe style="border:thin" width="1300" height="600" src="fab/mpl_headerselection.php"></iframe></div>
            <div class="TabbedPanelsContent"><iframe style="border:thin" width="1300" height="600" src="fab/mpl_headerforselection.php"></iframe></div>
          </div>
    	</div>
        <?php } ?>
    </td>
    
  </tr>
  <tr>
    <td colspan="4" align="left" valign="top" id="font"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="209">&nbsp;</td>
    <td width="443">&nbsp;</td>
    <td width="640" align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);

mysql_free_result($Recordset9);

mysql_free_result($Recordset10);

mysql_free_result($Recordset11);

mysql_free_result($Recordset12);

mysql_free_result($Recordset13);
?>
