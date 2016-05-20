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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO h_datapribadi (id_datapribadi, jk, status, noktp, berlakuktp, tempat_lahir, tgl_lahir, alamat, poscode, notlp, nohp, agama, berat, tinggi, pendidikan, jurusan, namapend, nokpj, gol_darah, no_npwp, email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_datapribadi'], "text"),
                       GetSQLValueString($_POST['jk'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['noktp'], "text"),
                       GetSQLValueString($_POST['berlakuktp'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tgl_lahir'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['kodepos'], "text"),
                       GetSQLValueString($_POST['notlp'], "text"),
                       GetSQLValueString($_POST['nohp'], "text"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['berat'], "text"),
                       GetSQLValueString($_POST['tinggi'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['jurusan'], "text"),
                       GetSQLValueString($_POST['namapend'], "text"),
                       GetSQLValueString($_POST['nokpj'], "text"),
                       GetSQLValueString($_POST['gol_darah'], "text"),
                       GetSQLValueString($_POST['nonpwp'], "text"),
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO h_training (id_datapribadi, kategori, jenis_training, `date`, exp_date, no_certificate, provider, remark) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_training'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['jenis_training'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['exp_date2'], "text"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['exp_date2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO h_mcu (id_datapribadi, `date`, exp_date, kategori, status, remark, saran) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmcu'], "text"),
                       GetSQLValueString($_POST['datemcu'], "text"),
                       GetSQLValueString($_POST['exp_date'], "text"),
                       GetSQLValueString($_POST['kategori2'], "text"),
                       GetSQLValueString($_POST['statusmcu'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['saran'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO h_experiences (id_datapribadi, pengalaman, nama_instansi, lokasi, bagian, jabatan, uraian, tgl_masuk, tgl_keluar) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idexp2'], "text"),
                       GetSQLValueString($_POST['pengalaman2'], "text"),
                       GetSQLValueString($_POST['lokasi2'], "text"),
                       GetSQLValueString($_POST['lokasi2'], "text"),
                       GetSQLValueString($_POST['bagian2'], "text"),
                       GetSQLValueString($_POST['jabatan2'], "text"),
                       GetSQLValueString($_POST['uraian2'], "text"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['tanggal'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form11")) {
  $insertSQL = sprintf("INSERT INTO h_penghargaan (id_datapribadi, nama_penghargaan, provider, tahun, remark, tipe_penghargaan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idapr2'], "text"),
                       GetSQLValueString($_POST['nama_penghargaan2'], "text"),
                       GetSQLValueString($_POST['pemberi2'], "text"),
                       GetSQLValueString($_POST['tahun2'], "text"),
                       GetSQLValueString($_POST['remarkap2'], "text"),
                       GetSQLValueString($_POST['tipe_penghargaan2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form10")) {
  $insertSQL = sprintf("INSERT INTO h_bahasa (id_datapribadi, bahasa, predikat) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['idbahasa2'], "text"),
                       GetSQLValueString($_POST['bahasa2'], "text"),
                       GetSQLValueString($_POST['predikat2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form9")) {
  $insertSQL = sprintf("INSERT INTO h_job_position (id_pelamar, posisi, reference) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_pelamar2'], "text"),
                       GetSQLValueString($_POST['posisi2'], "text"),
                       GetSQLValueString($_POST['reference2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form14")) {
  $insertSQL = sprintf("INSERT INTO h_sim (id_datapribadi, sim_gol, masaberlaku) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['idsim2'], "text"),
                       GetSQLValueString($_POST['sim_gol2'], "text"),
                       GetSQLValueString($_POST['tanggal2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO h_selection_skilltest (id_pelamar, testskill, kesimpulan, saran, `date`, pelaksana) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pelamar'], "text"),
                       GetSQLValueString($_POST['test_skill'], "text"),
                       GetSQLValueString($_POST['kesimpulan'], "text"),
                       GetSQLValueString($_POST['saran2'], "text"),
                       GetSQLValueString($_POST['tanggal3'], "text"),
                       GetSQLValueString($_POST['pelaksana'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
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

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_jenis_training";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
        <td width="484" align="left" class="root"><strong>Recruitment</strong></td>
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
                <td><input name="notlp" type="text" id="notlp" /></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td>:</td>
                <td><input name="nama2" type="text" id="nama2" value="<?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?>" size="30" readonly="readonly" /></td>
                <td>Agama</td>
                <td>:</td>
                <td><select name="agama" id="agama">
                  <option value="" selected="selected">-Agama-</option>
                  <option value="ISLAM">ISLAM</option>
                  <option value="PROTESTAN">PROTESTAN</option>
                  <option value="KHATOLIK">KHATOLIK</option>
                  <option value="HINDU">HINDU</option>
                  <option value="BUDHA">BUDHA</option>
                  <option value="KHONGHUCU">KHONGHUCU</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Jenis Kelamin</td>
                <td>:</td>
                <td><input type="radio" name="jk" id="jk_pria" value="Pria" />
                  Pria
                  <input type="radio" name="jk" id="jk_wanita" value="Wanita" />
                  Wanita </td>
                <td width="110" class="General">Berat Badan</td>
                <td width="4">:</td>
                <td width="144"><input name="berat" type="text" id="berat" size="10" />
                  Kg</td>
              </tr>
              <tr>
                <td class="General">Status</td>
                <td>:</td>
                <td><select name="status" id="status">
                  <option value="" selected="selected">-Status-</option>
                  <option value="TK/0">TK/O</option>
                  <option value="TK/1">TK/1</option>
                  <option value="TK/2">TK/2</option>
                  <option value="TK/3">TK/3</option>
                  <option value="K/0">K/0</option>
                  <option value="K/1">K/1</option>
                  <option value="K/2">K/2</option>
                  <option value="K/3">K/3</option>
                </select></td>
                <td class="General">Tinggi Badan</td>
                <td>:</td>
                <td><input name="tinggi" type="text" id="tinggi" size="10" />
                  Cm</td>
              </tr>
              <tr>
                <td class="General">No. KTP</td>
                <td>:</td>
                <td><input name="noktp" type="text" id="noktp" size="18" maxlength="16" /></td>
                <td class="General">Pendidikan Terakhir</td>
                <td>:</td>
                <td><select name="pendidikan" id="pendidikan">
                  <option value="" selected="selected">-Pendidikan-</option>
                  <option value="SD">SD</option>
                  <option value="SLTP">SLTP</option>
                  <option value="SLTA">SLTA</option>
                  <option value="DI/DII">DI/DII</option>
                  <option value="DIII">DIII</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                </select></td>
              </tr>
              <tr>
                <td class="General"> Berlaku KTP Sampai dengan</td>
                <td>:</td>
                <td><input name="berlakuktp" type="text" id="tanggal4" size="18" /></td>
                <td class="General">Nama Sekolah/PT</td>
                <td>:</td>
                <td><input name="namapend" type="text" class="huruf_besar" id="namapend" /></td>
              </tr>
              <tr>
                <td class="General">Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td><input name="tempat_lahir" type="text" class="huruf_besar" id="tempat_lahir" size="15" />
                  <strong>/</strong>
                  <input name="tgl_lahir" type="text" id="tanggal1" size="15" /></td>
                <td class="General">Jurusan</td>
                <td>:</td>
                <td><input name="jurusan" type="text" class="huruf_besar" id="jurusan" /></td>
              </tr>
              <tr>
                <td class="General">Umur</td>
                <td>:</td>
                <td><input name="umur" type="text" id="umur" size="20"  />
                  Tahun</td>
                <td class="General">No. KPJ</td>
                <td>:</td>
                <td><input name="nokpj" type="text" id="nokpj" /></td>
              </tr>
              <tr>
                <td class="General">Alamat Rumah</td>
                <td>:</td>
                <td><textarea name="alamat" cols="30" rows="2" class="huruf_besar" id="alamat"></textarea></td>
                <td class="General">Gol. Darah</td>
                <td>:</td>
                <td><select name="gol_darah" id="gol_darah">
                  <option value="">-Golongan-</option>
                  <option value="O">O</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="AB">AB</option>
                </select></td>
              </tr>
              <tr>
                <td>Kode Pos </td>
                <td>:</td>
                <td><input name="kodepos" type="text" id="kodepos" size="10" /></td>
                <td class="General">No. NPWP</td>
                <td>:</td>
                <td><input name="nonpwp" type="text" id="nonpwp" /></td>
              </tr>
              <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><input name="nohp" type="text" id="textfield2" /></td>
                <td>Email</td>
                <td>:</td>
                <td><input name="email" type="text" id="email" /></td>
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
            <input type="hidden" name="MM_insert" value="form1" />
          </form>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          </div>
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form6" name="form6" method="POST">
            <table width="707" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td width="113" class="General">&nbsp;</td>
                <td width="6">&nbsp;</td>
                <td width="212" class="General"><input name="id_training" type="text" class="hidentext" id="id_training" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
                <td width="109" class="General">&nbsp;</td>
                <td width="12" class="General">&nbsp;</td>
                <td width="234" class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kategori </td>
                <td>:</td>
                <td class="General"><input type="radio" name="kategori" id="radio" value="1" />
                  Management Training</td>
                <td class="General">No. Sertifikat</td>
                <td>:</td>
                <td><input type="text" name="no_certificate" id="no_certificate" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="General"><input type="radio" name="kategori" id="radio2" value="2" />
                  Skill Training</td>
                <td class="General">Penyelenggara</td>
                <td>:</td>
                <td><input name="provider" type="text" class="huruf_besar" id="provider" /></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td>:</td>
                <td class="General"><select name="jenis_training" id="jenis_training">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Recordset2['jenis_training']?>"<?php if (!(strcmp($row_Recordset2['jenis_training'], $row_Recordset2['jenis_training']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['jenis_training']?></option>
                  <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                </select><?php {include "popup.html";}?></td>
                <td class="General">Klasifikasi</td>
                <td>:</td>
                <td><select name="klasifikasi" id="klasifikasi">
                  <option value="" selected="selected">-Klasifikasi-</option>
                  <option value="Basic">Basic</option>
                  <option value="Advance">Advance</option>
                  <option value="Inspector">Inspector</option>
                  <option value="Migas A">Migas A</option>
                  <option value="Migas B">Migas B</option>
                  <option value="Migas C">Migas C</option>
                  <option value="Depnaker III">Depnaker III</option>
                  <option value="Depnaker II">Depnaker II</option>
                  <option value="Depnaker I">Depnaker I</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Tanggal </td>
                <td>:</td>
                <td><input type="text" name="date" id="tanggal2" /></td>
                <td class="General">Remark</td>
                <td>:</td>
                <td><textarea name="remark2" id="remark2" cols="25" rows="3"></textarea></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku</td>
                <td>:</td>
                <td><input type="text" name="exp_date2" id="exp_date2" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" id="submit4" value="Submit" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form6" />
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form3" name="form3" method="POST">
            <table width="600" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td colspan="2" class="General">&nbsp;</td>
                <td><input name="idmcu" type="text" class="hidentext" id="idmcu" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="152" class="General">Tanggal MCU</td>
                <td width="4">:</td>
                <td width="440"><input type="text" name="datemcu" id="tanggal6" /></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku </td>
                <td>:</td>
                <td><input type="text" name="exp_date" id="exp_date" /></td>
              </tr>
              <tr>
                <td class="General">Status</td>
                <td>:</td>
                <td><select name="statusmcu" id="statusmcu">
                  <option value="" selected="selected">-Status-</option>
                  <option value="Fit">Fit</option>
                  <option value="Unfit">Unfit</option>
                  <option value="Temporary Unfit">Temporary Unfit</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Kategori</td>
                <td>:</td>
                <td><select name="kategori2" id="kategori">
                  <option value="" selected="selected">-Kategori-</option>
                  <option value="M1.A">M1.A</option>
                  <option value="M1.B">M1.B</option>
                  <option value="M2">M2</option>
                  <option value="M3.A">M3.A</option>
                  <option value="M3.B">M3.B</option>
                  <option value="M4">M4</option>
                  <option value="M5">M5</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Remark</td>
                <td>:</td>
                <td><textarea name="remark" id="remark" cols="45" rows="2"></textarea></td>
              </tr>
              <tr>
                <td class="General">Saran</td>
                <td>:</td>
                <td><textarea name="saran" id="saran" cols="45" rows="4"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit2" id="Submit2" value="Submit" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form3" />
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="600" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td colspan="2" class="General">&nbsp;</td>
                <td class="General"><input name="idexp2" type="text" class="hidentext" id="idexp2" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="163" class="General">Kategori Experiences</td>
                <td width="4">:</td>
                <td width="454" class="General"><select name="pengalaman2" id="pengalaman2">
                  <option value="" selected="selected">-Kategori-</option>
                  <option value="Kerja">Kerja</option>
                  <option value="Organisasi">Organisasi</option>
                  <option value="Magang">Magang</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Nama Instansi / Organisasi</td>
                <td>:</td>
                <td class="General"><input name="nama_instansi2" type="text" class="huruf_besar" id="nama_instansi2" /></td>
              </tr>
              <tr>
                <td class="General">Lokasi</td>
                <td>:</td>
                <td class="General"><input name="lokasi2" type="text" class="huruf_besar" id="lokasi2" /></td>
              </tr>
              <tr>
                <td class="General">Bagian</td>
                <td>:</td>
                <td class="General"><input name="bagian2" type="text" class="huruf_besar" id="bagian2" /></td>
              </tr>
              <tr>
                <td class="General">Jabatan</td>
                <td>:</td>
                <td class="General"><input name="jabatan2" type="text" class="huruf_besar" id="jabatan2" /></td>
              </tr>
              <tr>
                <td class="General">Uraian Singkat</td>
                <td>:</td>
                <td class="General"><textarea name="uraian2" id="uraian2" cols="45" rows="2"></textarea></td>
              </tr>
              <tr>
                <td class="General">Tanggal Masuk</td>
                <td>:</td>
                <td class="General"><input type="text" name="tanggal" id="tanggal9" /></td>
              </tr>
              <tr>
                <td class="General">Sampai Dengan</td>
                <td>:</td>
                <td class="General"><input type="text" name="tanggal" id="tanggal10" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit7" id="submit6" value="Submit" /></td>
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
            <input type="hidden" name="MM_insert" value="form2" />
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form11" name="form11" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="708" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" class="General">&nbsp;</td>
                <td class="General"><input name="idapr2" type="text" class="hidentext" id="idapr2" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" />
                  <input name="tipe_penghargaan2" type="text" class="hidentext" id="tipe_penghargaan2" value="Reward" /></td>
              </tr>
              <tr>
                <td width="160" class="General">Nama Penghargaan</td>
                <td width="10" class="General">:</td>
                <td width="518" class="General"><input name="nama_penghargaan2" type="text" class="huruf_besar" id="nama_penghargaan2" /></td>
              </tr>
              <tr>
                <td class="General">Provider</td>
                <td class="General">:</td>
                <td class="General"><input name="pemberi2" type="text" class="huruf_besar" id="pemberi2" /></td>
              </tr>
              <tr>
                <td class="General">Tahun</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="tahun2" id="tahun2" /></td>
              </tr>
              <tr>
                <td class="General">Remark</td>
                <td class="General">:</td>
                <td class="General"><textarea name="remarkap2" id="remarkap2" cols="45" rows="2"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input type="submit" name="submit10" id="submit9" value="Submit" /></td>
              </tr>
            </table>
            <hr />
            <input type="hidden" name="MM_insert" value="form11" />
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <p>
            <?php {include "../date.php";}?>
          </p>
          <form id="form14" name="form14" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="709" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input name="idsim2" type="text" class="hidentext" id="idsim2" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="155" class="General">Golongan SIM</td>
                <td width="12" class="General">:</td>
                <td width="541" class="General"><select name="sim_gol2" id="sim_gol2">
                  <option value="" selected="selected">-Golongan SIM-</option>
                  <option value="A">A</option>
                  <option value="A Khusus">A Khusus</option>
                  <option value="B1">B1</option>
                  <option value="B1 Umum">B1 Umum</option>
                  <option value="B2">B2</option>
                  <option value="C">C</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="tanggal2" id="tanggal5" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input type="submit" name="submit4" id="submit3" value="Submit" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form9" />
            <input type="hidden" name="MM_insert" value="form14" />
          </form>
          <p>&nbsp;</p>
          <br />
        </div>
        <div class="TabbedPanelsContent">
          <form id="form4" name="form10" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="710" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="158" class="General">&nbsp;</td>
                <td width="12">&nbsp;</td>
                <td width="542"><input name="idbahasa2" type="text" class="hidentext" id="idbahasa2" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Bahasa yang dikuasai</td>
                <td>:</td>
                <td><input name="bahasa2" type="text" class="huruf_besar" id="bahasa2" /></td>
              </tr>
              <tr>
                <td class="General">Predikat</td>
                <td>:</td>
                <td><select name="predikat2" id="predikat2">
                  <option value="" selected="selected">---</option>
                  <option value="Sangat Baik">Sangat Baik</option>
                  <option value="Baik">Baik</option>
                  <option value="Cukup">Cukup</option>
                  <option value="Kurang">Kurang</option>
                </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit5" id="submit5" value="Submit" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form10" />
          </form>
        </div>
<div class="TabbedPanelsContent">
  <form action="<?php echo $editFormAction; ?>" id="form9" name="form9" method="POST">
    <table width="600
          " border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="159" class="General">&nbsp;</td>
        <td width="10">&nbsp;</td>
        <td width="538"><input name="id_pelamar2" type="text" class="hidentext" id="id_pelamar2" value="<?php echo $row_Recordset1['id']; ?>" /></td>
      </tr>
      <tr>
        <td class="General"> Posisi yang dilamar</td>
        <td>:</td>
        <td><input name="posisi2" type="text" class="huruf_besar" id="posisi2" /></td>
      </tr>
      <tr>
        <td class="General">Reference</td>
        <td>:</td>
        <td><input name="reference2" type="text" class="huruf_besar" id="reference2" /></td>
      </tr>
      <tr>
        <td class="General">&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit8" id="submit7" value="Submit" /></td>
      </tr>
      <tr>
        <td class="General">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form2" />
    <input type="hidden" name="MM_insert" value="form9" />
  </form>
</div>
        <div class="TabbedPanelsContent">
          <h1><a href="attachmentrecruitment.php?data=<?php echo $row_Recordset1['id']; ?>">UPLOAD FILES HERE !</a></h1>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form5" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="722" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="162" class="General">&nbsp;</td>
                <td width="9">&nbsp;</td>
                <td><input name="id_pelamar" type="hidden" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" /></td>
                <td width="57" class="General">&nbsp;</td>
                <td width="14">&nbsp;</td>
                <td width="175">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">No. Pelamar</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['no_pelamar']; ?></td>
                <td class="General">Date</td>
                <td>&nbsp;</td>
                <td><input type="text" name="tanggal3" id="tanggal3" /></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
                <td>Pelaksana</td>
                <td>&nbsp;</td>
                <td><input type="text" name="pelaksana" id="pelaksana" /></td>
              </tr>
              <tr>
                <td class="General">Hasil Test Skill </td>
                <td>:</td>
                <td width="305"><textarea name="test_skill" id="test_skill" cols="45" rows="3"></textarea></td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kesimpulan</td>
                <td>:</td>
                <td colspan="4"><textarea name="kesimpulan" id="kesimpulan" cols="45" rows="3"></textarea></td>
              </tr>
              <tr>
                <td class="General">Saran</td>
                <td>:</td>
                <td colspan="4"><textarea name="saran2" id="saran2" cols="45" rows="3"></textarea></td>
              </tr>
              <tr>
                <td colspan="6" class="General" align="center"><input type="submit" name="submit6" id="submit" value="Submit" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1" />
          </form>
        </div>
        <div class="TabbedPanelsContent"><a href="#" onclick="MM_openBrWindow('input_interview.php?data=<?php echo $row_Recordset1['id']; ?>','','scrollbars=yes,width=1200,height=700')">Mulai Interview</a> </div>
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

mysql_free_result($Recordset2);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
?>
