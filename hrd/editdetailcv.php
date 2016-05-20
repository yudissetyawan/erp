<?php require_once('../Connections/core.php'); ?>
<?php require_once('../Connections/core.php'); ?>
<?php require_once('../Connections/core.php'); ?>
<?php require_once('../Connections/core.php'); ?>
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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrator,branchmanager,hrd";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/home.php?pesan=Sorry You re not Alowed to access HRD Section";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_datapribadi SET jk=%s, status=%s, noktp=%s, berlakuktp=%s, tempat_lahir=%s, tgl_lahir=%s, alamat=%s, poscode=%s, notlp=%s, nohp=%s, agama=%s, berat=%s, tinggi=%s, pendidikan=%s, jurusan=%s, namapend=%s, nokpj=%s, gol_darah=%s, no_npwp=%s, email=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['jk'], "text"),
                       GetSQLValueString($_POST['status2'], "text"),
                       GetSQLValueString($_POST['noktp'], "text"),
                       GetSQLValueString($_POST['berlakuktp'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tgl_lahir'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['kodepos'], "text"),
                       GetSQLValueString($_POST['notlp'], "text"),
                       GetSQLValueString($_POST['nohp'], "text"),
                       GetSQLValueString($_POST['agama2'], "text"),
                       GetSQLValueString($_POST['berat'], "text"),
                       GetSQLValueString($_POST['tinggi'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['jurusan'], "text"),
                       GetSQLValueString($_POST['namapend'], "text"),
                       GetSQLValueString($_POST['nokpj'], "text"),
                       GetSQLValueString($_POST['gol_darah'], "text"),
                       GetSQLValueString($_POST['nonpwp'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
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

$totalRows_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $totalRows_Recordset1 = $_GET['data'];
}
$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM h_datapribadi WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM h_training WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_mcu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset8, "text"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM h_experiences WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset7, "int"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM h_penghargaan WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset6, "int"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM h_sim WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM h_bahasa WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM h_job_position WHERE id_pelamar = %s", GetSQLValueString($colname_Recordset9, "text"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_Recordset10 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset10 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset10 = sprintf("SELECT * FROM dms WHERE idms = %s", GetSQLValueString($colname_Recordset10, "text"));
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRD - Detail Data Karyawan</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
</head>

	
<body>
<?php {
include "../../date.php";
  }
?>
<table width="1270" border="0" align="center">
<tr>
    <td height="64" colspan="3"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="649" align="right" valign="bottom"><table width="400" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>
        <td width="10" align="right" valign="bottom">|</td>
        <td width="307" align="right" valign="bottom" class="demoHeaders">Your Logged as <a href="#"><?php echo $_SESSION['MM_Username']?> </a></td>
        <td width="11" class="demoHeaders">|</a></td>
        <td width="106" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
        <td width="11" class="demoHeaders">|</td>
        <td width="107" class="demoHeaders"><a href="<?php echo $logoutAction ?>;">Logout</a></td>
        <td width="18">|</td>
      </tr>
    </table></td><tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root"><a href="../home_hrd.php">HRD / GAFF</a></td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="484" align="left" class="root"><strong>Employee</strong></td>
        </tr>
    </table></td>
      <tr>
  <tr>
    <td colspan="5" align="left" class="General" id="font"><div id="TabbedPanels1" class="VTabbedPanels">
      <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="0">Personal Data</li>
        <li class="TabbedPanelsTab" tabindex="0">Training</li>
        <li class="TabbedPanelsTab" tabindex="0">Healthy</li>
        <li class="TabbedPanelsTab" tabindex="0">Experiences</li>
        <li class="TabbedPanelsTab" tabindex="0">Appreciation</li>
		<li class="TabbedPanelsTab" tabindex="0">SIM</li>
        <li class="TabbedPanelsTab" tabindex="0">Languange</li>
        <li class="TabbedPanelsTab" tabindex="0">Job Position</li>
        <li class="TabbedPanelsTab" tabindex="0">Attachment</li>
        <li class="TabbedPanelsTab" tabindex="0">Skill test</li>
        <li class="TabbedPanelsTab" tabindex="0">Interviews</li>
        <li class="TabbedPanelsTab" tabindex="0">Psikotes &amp; MCU</li>
      
      </ul>
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
            <table width="708" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="id_datapribadi" type="text" class="hidentext" id="id_datapribadi" value="<?php echo $row_Recordset1['id']; ?>" size="10" readonly="readonly" /></td>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="155" class="General">No. Pelamar</td>
                <td width="12">:</td>
                <td width="276"><input name="no" type="text" id="no" value="<?php echo $row_Recordset1['no_pelamar']; ?>" size="7" readonly="readonly" /></td>
                <td>No. Telp</td>
                <td>:</td>
                <td><input name="notlp" type="text" id="notlp" value="<?php echo $row_Recordset3['notlp']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td>:</td>
                <td><input name="nama2" type="text" id="nama2" value="<?php echo $row_Recordset1['firstname'];  ?>"<?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?> size="30" readonly="readonly" /></td>
                <td>Agama</td>
                <td>:</td>
                <td><label for="agama"></label>
                  <input name="agama2" type="text" id="agama" value="<?php echo $row_Recordset3['agama']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Kelamin</td>
                <td>:</td>
                <td><input type="radio" name="jk" value="Pria" <?php echo ($row_Recordset3['jk']=='Pria')?'checked':'' ?> size="17" />
                  Pria
                  <input type="radio" name="jk" value="Wanita" <?php echo ($row_Recordset3['jk']=='Wanita')?'checked':'' ?> size="17" />
                  Wanita</td>
                <td width="110" class="General">Berat Badan</td>
                <td width="4">:</td>
                <td width="144"><input name="berat" type="text" id="berat" value="<?php echo $row_Recordset3['berat']; ?>" size="10" />
                  Kg</td>
              </tr>
              <tr>
                <td class="General">Status</td>
                <td>:</td>
                <td><label for="status"></label>
                  <input name="status2" type="text" id="status" value="<?php echo $row_Recordset3['status']; ?>" /></td>
                <td class="General">Tinggi Badan</td>
                <td>:</td>
                <td><input name="tinggi" type="text" id="tinggi" value="<?php echo $row_Recordset3['tinggi']; ?>" size="10" />
                  Cm</td>
              </tr>
              <tr>
                <td class="General">No. KTP</td>
                <td>:</td>
                <td><input name="noktp" type="text" id="noktp" value="<?php echo $row_Recordset3['noktp']; ?>" size="18" maxlength="16" /></td>
                <td class="General">Pendidikan Terakhir</td>
                <td>:</td>
                <td><label for="pendidikan"></label>
                  <input name="pendidikan" type="text" id="pendidikan" value="<?php echo $row_Recordset3['pendidikan']; ?>" /></td>
              </tr>
              <tr>
                <td class="General"> Berlaku KTP Sampai dengan</td>
                <td>:</td>
                <td><input name="berlakuktp" type="text" id="tanggal4" value="<?php echo $row_Recordset3['berlakuktp']; ?>" size="18" /></td>
                <td class="General">Nama Sekolah/PT</td>
                <td>:</td>
                <td><input name="namapend" type="text" class="huruf_besar" id="namapend" value="<?php echo $row_Recordset3['namapend']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td><input name="tempat_lahir" type="text" class="huruf_besar" id="tempat_lahir" value="<?php echo $row_Recordset3['tempat_lahir']; ?>" size="15" />
                  <strong>/</strong>
                  <input name="tgl_lahir" type="text" id="tanggal1" value="<?php echo $row_Recordset3['tgl_lahir']; ?>" size="15" /></td>
                <td class="General">Jurusan</td>
                <td>:</td>
                <td><input name="jurusan" type="text" class="huruf_besar" id="jurusan" value="<?php echo $row_Recordset3['jurusan']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Umur</td>
                <td>:</td>
                <td><input name="umur" type="text" id="umur" size="20"  />
                  Tahun</td>
                <td class="General">No. KPJ</td>
                <td>:</td>
                <td><input name="nokpj" type="text" id="nokpj" value="<?php echo $row_Recordset3['nokpj']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Alamat Rumah</td>
                <td>:</td>
                <td><textarea name="alamat" cols="30" rows="2" class="huruf_besar" id="alamat"><?php echo $row_Recordset3['alamat']; ?></textarea></td>
                <td class="General">Gol. Darah</td>
                <td>:</td>
                <td><label for="gol_darah"></label>
                  <input name="gol_darah" type="text" id="gol_darah" value="<?php echo $row_Recordset3['gol_darah']; ?>" /></td>
              </tr>
              <tr>
                <td>Kode Pos </td>
                <td>:</td>
                <td><input name="kodepos" type="text" id="kodepos" value="<?php echo $row_Recordset3['poscode']; ?>" size="10" /></td>
                <td class="General">No. NPWP</td>
                <td>:</td>
                <td><input name="nonpwp" type="text" id="nonpwp" value="<?php echo $row_Recordset3['no_npwp']; ?>" /></td>
              </tr>
              <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><input name="nohp" type="text" id="textfield2" value="<?php echo $row_Recordset3['nohp']; ?>" /></td>
                <td>Email</td>
                <td>:</td>
                <td><input name="email" type="text" id="email" value="<?php echo $row_Recordset3['email']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit3" id="submit2" value="Submit" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1" />
          </form>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          </div>
        <div class="TabbedPanelsContent">
          <table border="1">
            <tr class="tabel_header">
              <td>No</td>
              <td>Kategori</td>
              <td>Jenis Training</td>
              <td>Tanggal</td>
              <td>Tanggal Kadaluarsa</td>
              <td>No. Sertifikat </td>
              <td>Penyelenggara</td>
              <td>Catatan</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <?php $n=$n+1; ?>
              <td><?php echo $n ?></td>
              <td><?php echo $row_Recordset2['kategori']; ?></td>
              <td><?php echo $row_Recordset2['jenis_training']; ?></td>
              <td><?php echo $row_Recordset2['date']; ?></td>
              <td><?php echo $row_Recordset2['exp_date']; ?></td>
              <td><?php echo $row_Recordset2['no_certificate']; ?></td>
              <td><?php echo $row_Recordset2['provider']; ?></td>
              <td><?php echo $row_Recordset2['remark']; ?></td>
              <td><a href='deletetraining.php?id=<?php echo $row_Recordset2['id']; ?>'>Delete</a> | <a href='edit_training.php?data=<?php echo $row_Recordset2['id']; ?>'>Edit</a></td>
            </tr>
            <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
          </table>
        </div>
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form3" name="form3" method="post">
            <table width="600" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td colspan="2" class="General"><strong>Medical Check Up</strong></td>
                <td><input name="idmcu" type="text" class="hidentext" id="idmcu" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="152" class="General">Tanggal MCU</td>
                <td width="4">:</td>
                <td width="440"><input name="datemcu" type="text" id="tanggal6" value="<?php echo $row_Recordset8['date']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku</td>
                <td>:</td>
                <td><input name="exp_date" type="text" id="exp_date" value="<?php echo $row_Recordset8['exp_date']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Status</td>
                <td>:</td>
                <td><label for="statusmcu"></label>
                  <input name="statusmcu" type="text" id="statusmcu" value="<?php echo $row_Recordset8['status']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Kategori</td>
                <td>:</td>
                <td><label for="kategori"></label>
                  <input name="kategori2" type="text" id="kategori" value="<?php echo $row_Recordset8['kategori']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Remark</td>
                <td>:</td>
                <td><textarea name="remark" id="remark" cols="45" rows="2"><?php echo $row_Recordset8['remark']; ?></textarea></td>
              </tr>
              <tr>
                <td class="General">Saran</td>
                <td>:</td>
                <td><textarea name="saran" id="saran" cols="45" rows="4"><?php echo $row_Recordset8['saran']; ?></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit2" id="Submit2" value="Submit" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update3" value="form3" />
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <table border="1">
            <tr class="tabel_header">
              <td>No</td>
              <td>Pengalaman</td>
              <td>Nama Perusahaan</td>
              <td>Lokasi</td>
              <td>Bagian</td>
              <td>Jabatan</td>
              <td>Uraian</td>
              <td>Tanggal Masuk</td>
              <td>Tanggal Keluar</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td><?php echo $n ?></td>
              <td><?php echo $row_Recordset7['pengalaman']; ?></td>
              <td><?php echo $row_Recordset7['nama_instansi']; ?></td>
              <td><?php echo $row_Recordset7['lokasi']; ?></td>
              <td><?php echo $row_Recordset7['bagian']; ?></td>
              <td><?php echo $row_Recordset7['jabatan']; ?></td>
              <td><?php echo $row_Recordset7['uraian']; ?></td>
              <td><?php echo $row_Recordset7['tgl_masuk']; ?></td>
              <td><?php echo $row_Recordset7['tgl_keluar']; ?></td>
              <td><a href='deleteexperiences.php?id=<?php echo $row_Recordset7['id']; ?>'>Delete</a> | <a href='edit_experiences.php?data=<?php echo $row_Recordset7['id']; ?>'>Edit</a></td>
            </tr>
            <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
          </table>
        </div>
        <div class="TabbedPanelsContent">
          <table border="1">
            <tr class="tabel_header">
              <td>Nama Penghargaan</td>
              <td>Penyelenggara / Pemberi</td>
              <td>Tahun</td>
              <td>Catatan</td>
              <td>Tipe Penghargaan</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td><?php echo $row_Recordset6['nama_penghargaan']; ?></td>
              <td><?php echo $row_Recordset6['provider']; ?></td>
              <td><?php echo $row_Recordset6['tahun']; ?></td>
              <td><?php echo $row_Recordset6['remark']; ?></td>
              <td><?php echo $row_Recordset6['tipe_penghargaan']; ?></td>
              <td><a href='deleteapreciation.php?id=<?php echo $row_Recordset6['id']; ?>'>Delete</a> | <a href='edit_apreciation.php?data=<?php echo $row_Recordset6['id']; ?>'>Edit</a></td>
            </tr>
            <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
          </table>
        </div>
        <div class="TabbedPanelsContent">
          <p>
            <?php {include "../date.php";}?>
          </p>
          <table border="1">
            <tr class="tabel_header">
              <td>No</td>
              <td>Golongan S I M</td>
              <td>Masa Berlaku</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td><?php echo $n ?></td>
              <td><?php echo $row_Recordset4['sim_gol']; ?></td>
              <td><?php echo $row_Recordset4['masaberlaku']; ?></td>
              <td><a href='deletesim.php?id=<?php echo $row_Recordset4['id']; ?>'>Delete</a> | <a href='edit_sim.php?data=<?php echo $row_Recordset4['id']; ?>'>Edit</a></td>
            </tr>
            <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
          </table>
          <p>&nbsp;</p>
          <br />
        </div>
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form10" name="form10" method="post">
            <table width="710" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="158" class="General"><strong>Bahasa yang dikuasai</strong></td>
                <td width="12">&nbsp;</td>
                <td width="542"><input name="idbahasa" type="text" class="hidentext" id="idbahasa" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Bahasa yang dikuasai</td>
                <td>:</td>
                <td><input name="bahasa" type="text" class="huruf_besar" id="bahasa" value="<?php echo $row_Recordset5['bahasa']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Predikat</td>
                <td>:</td>
                <td><label for="predikat"></label>
                  <input name="predikat" type="text" id="predikat" value="<?php echo $row_Recordset5['predikat']; ?>" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit9" id="submit8" value="Submit" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_update7" value="form10" />
          </form>
        </div>
<div class="TabbedPanelsContent">
  <form action="<?php echo $editFormAction; ?>" id="form4" name="form2" method="post">
    <table width="600
          " border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="159" class="General"><strong>Job Position</strong></td>
        <td width="10">&nbsp;</td>
        <td width="538"><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" /></td>
      </tr>
      <tr>
        <td class="General"> Posisi yang dilamar</td>
        <td>:</td>
        <td><input name="posisi" type="text" class="huruf_besar" id="posisi" value="<?php echo $row_Recordset9['posisi']; ?>" /></td>
      </tr>
      <tr>
        <td class="General">Reference</td>
        <td>:</td>
        <td><input name="reference" type="text" class="huruf_besar" id="reference" value="<?php echo $row_Recordset9['reference']; ?>" /></td>
      </tr>
      <tr>
        <td class="General">&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit5" id="submit5" value="Submit" /></td>
      </tr>
      <tr>
        <td class="General">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_update8" value="form2" />
  </form>
</div>
        <div class="TabbedPanelsContent">
          <table width="284" border="1">
            <tr class="tabel_header">
              <td>NO</td>
              <td>Inisial Pekerjaan</td>
              <td>Tanggal</td>
              <td>Nama File</td>
              <td>Action</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <?php $t=$t+1; ?>
              <td><?php echo $t ?></td>
              <td><?php echo $row_Recordset10[inisial_pekerjaan]; ?></td>
              <td><?php echo $row_Recordset10[date]; ?></td>
              <td><a href="../hrd/upload/<?php echo $row_Recordset10['fileupload']; ?>" target="_blank"><?php echo $row_Recordset10[fileupload]; ?></a></td>
              <td><a href='deleteattachment.php?id=<?php echo $row_Recordset10['id']; ?>'>Delete</a></td>
            </tr>
            <?php } while ($row_Recordset10 = mysql_fetch_assoc($Recordset10)); ?>
          </table>
          <h1><a></a></h1>
        </div>
        <div class="TabbedPanelsContent">Content1 </div>
        <div class="TabbedPanelsContent">Content 2</div>
        <div class="TabbedPanelsContent">Content 3</div>
        <div class="TabbedPanelsContent">
          <form id="form12" name="form12" method="post" action="">
            <table width="454" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="148">&nbsp;</td>
                <td width="10">&nbsp;</td>
                <td width="296"><input name="idlamp" type="text" class="hidentext" id="idlamp" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Lampiran</td>
                <td>:</td>
                <td><select name="jenislampiran" id="jenislampiran">
                  <option value="MCU">MCU</option>
                  <option value="Sertifikat Organisasi">Sertifikat Organisasi</option>
                  <option value="Pengalaman Kerja">Pengalaman Kerja</option>
                  <option value="Piagam">Piagam</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Lampiran</td>
                <td>:</td>
                <td><input type="file" name="lampiran" id="lampiranmcu" />
                  <input type="submit" name="submit2" value="Upload" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">Content 14
          <form id="form13" name="form13" method="post" action="">
          </form>
        </div>
        <div class="TabbedPanelsContent">Content 15</div>
        <div class="TabbedPanelsContent">Content 16</div>
<div class="TabbedPanelsContent">Content 17</div>
      </div>
<p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top" id="font"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="594">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="625" colspan="2" align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
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

mysql_free_result($Recordset8);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset1);

mysql_free_result($Recordset3);

mysql_free_result($Recordset2);

mysql_free_result($Recordset8);

mysql_free_result($Recordset7);

mysql_free_result($Recordset6);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset9);

mysql_free_result($Recordset10);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
?>
