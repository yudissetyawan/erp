<?php require_once('../../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrator";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/index.php?pesan=Sorry Youre not allowed to view this page,Please Contact our administrator";
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

$dataexp= explode("-",$_GET['data']);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form10")) {
  $updateSQL = sprintf("UPDATE a_crf_schedulle SET designprogress=%s WHERE crf=%s",
                       GetSQLValueString($_POST['designprogress'], "text"),
                       GetSQLValueString($_POST['crf'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form9")) {
  $updateSQL = sprintf("UPDATE a_crf_schedulle SET drawingprogress=%s WHERE crf=%s",
                       GetSQLValueString($_POST['drawingprogress2'], "text"),
                       GetSQLValueString($_POST['crf2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_department4'], "text"),
                       GetSQLValueString($_POST['nocrfdrawing'], "text"),
                       GetSQLValueString($_POST['inisialdw'], "text"),
                       GetSQLValueString($_POST['drawingprogress'], "text"),
                       GetSQLValueString($_POST['file_drawing'], "text"),
                       GetSQLValueString($_POST['keterangandw'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_department7'], "text"),
                       GetSQLValueString($_POST['idmsdh'], "text"),
                       GetSQLValueString($_POST['inisialdh'], "text"),
                       GetSQLValueString($_POST['datedh'], "text"),
                       GetSQLValueString($_POST['nama_filedh'], "text"),
                       GetSQLValueString($_POST['keterangandh'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form5")) {
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_department6'], "text"),
                       GetSQLValueString($_POST['idmsdd'], "text"),
                       GetSQLValueString($_POST['inisialdd'], "text"),
                       GetSQLValueString($_POST['datedd'], "text"),
                       GetSQLValueString($_POST['nama_filedd'], "text"),
                       GetSQLValueString($_POST['keterangandd'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_department5'], "text"),
                       GetSQLValueString($_POST['idmsdv'], "text"),
                       GetSQLValueString($_POST['inisialdv'], "text"),
                       GetSQLValueString($_POST['datedv'], "text"),
                       GetSQLValueString($_POST['nama_filedv'], "text"),
                       GetSQLValueString($_POST['keterangandv'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_department3'], "text"),
                       GetSQLValueString($_POST['idmsdr'], "text"),
                       GetSQLValueString($_POST['inisialdr'], "text"),
                       GetSQLValueString($_POST['datedr'], "text"),
                       GetSQLValueString($_POST['nama_filedr'], "text"),
                       GetSQLValueString($_POST['keterangandr'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_department2'], "text"),
                       GetSQLValueString($_POST['idmsdc'], "text"),
                       GetSQLValueString($_POST['inisialdc'], "text"),
                       GetSQLValueString($_POST['datedc'], "text"),
                       GetSQLValueString($_POST['nama_filedc'], "text"),
                       GetSQLValueString($_POST['keterangandc'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_department'], "text"),
                       GetSQLValueString($_POST['idmsps'], "text"),
                       GetSQLValueString($_POST['inisialps'], "text"),
                       GetSQLValueString($_POST['dateas'], "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"),
                       GetSQLValueString($_POST['keterangandi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_di = "-1";
if (isset($_GET['data'])) {
  $colname_di = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_di = sprintf("SELECT a_crf.id, a_crf.nocrf, dms.inisial_pekerjaan, dms.fileupload FROM a_crf, dms WHERE a_crf.nocrf = %s AND dms.nocrf = a_crf.nocrf AND dms.inisial_pekerjaan = 'DI'", GetSQLValueString($colname_di, "text"));
$di = mysql_query($query_di, $core) or die(mysql_error());
$row_di = mysql_fetch_assoc($di);
$totalRows_di = mysql_num_rows($di);

$colname_dc = "-1";
if (isset($_GET['data'])) {
  $colname_dc = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dc = sprintf("SELECT a_crf.id, a_crf.nocrf, dms.inisial_pekerjaan, dms.fileupload FROM a_crf, dms WHERE a_crf.nocrf = %s AND dms.nocrf = a_crf.nocrf AND dms.inisial_pekerjaan = 'DC'", GetSQLValueString($colname_dc, "text"));
$dc = mysql_query($query_dc, $core) or die(mysql_error());
$row_dc = mysql_fetch_assoc($dc);
$totalRows_dc = mysql_num_rows($dc);

$colname_dr = "-1";
if (isset($_GET['data'])) {
  $colname_dr = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dr = sprintf("SELECT a_crf.id, a_crf.nocrf, dms.inisial_pekerjaan, dms.fileupload FROM a_crf, dms WHERE a_crf.nocrf = %s AND dms.nocrf = a_crf.nocrf AND dms.inisial_pekerjaan = 'DI'", GetSQLValueString($colname_dr, "text"));
$dr = mysql_query($query_dr, $core) or die(mysql_error());
$row_dr = mysql_fetch_assoc($dr);
$totalRows_dr = mysql_num_rows($dr);

$colname_dv = "-1";
if (isset($_GET['data'])) {
  $colname_dv = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dv = sprintf("SELECT a_crf.id, a_crf.nocrf, dms.inisial_pekerjaan, dms.fileupload FROM a_crf, dms WHERE a_crf.nocrf = %s AND dms.nocrf = a_crf.nocrf AND dms.inisial_pekerjaan = 'DV'", GetSQLValueString($colname_dv, "text"));
$dv = mysql_query($query_dv, $core) or die(mysql_error());
$row_dv = mysql_fetch_assoc($dv);
$totalRows_dv = mysql_num_rows($dv);

$colname_dd = "-1";
if (isset($_GET['data'])) {
  $colname_dd = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dd = sprintf("SELECT a_crf.id, a_crf.nocrf, dms.inisial_pekerjaan, dms.fileupload FROM a_crf, dms WHERE a_crf.nocrf = %s AND dms.nocrf = a_crf.nocrf AND dms.inisial_pekerjaan = 'DD'", GetSQLValueString($colname_dd, "text"));
$dd = mysql_query($query_dd, $core) or die(mysql_error());
$row_dd = mysql_fetch_assoc($dd);
$totalRows_dd = mysql_num_rows($dd);

$colname_dh = "-1";
if (isset($_GET['data'])) {
  $colname_dh = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dh = sprintf("SELECT a_crf.id, a_crf.nocrf, dms.inisial_pekerjaan, dms.fileupload FROM a_crf, dms WHERE a_crf.nocrf = %s AND dms.nocrf = a_crf.nocrf AND dms.inisial_pekerjaan = 'DH'", GetSQLValueString($colname_dh, "text"));
$dh = mysql_query($query_dh, $core) or die(mysql_error());
$row_dh = mysql_fetch_assoc($dh);
$totalRows_dh = mysql_num_rows($dh);

$colname_dw = "-1";
if (isset($_GET['data'])) {
  $colname_dw = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dw = sprintf("SELECT a_crf.id, a_crf.nocrf, dms.inisial_pekerjaan, dms.fileupload FROM a_crf, dms WHERE a_crf.nocrf = %s AND dms.nocrf = a_crf.nocrf AND dms.inisial_pekerjaan = 'DW'", GetSQLValueString($colname_dw, "text"));
$dw = mysql_query($query_dw, $core) or die(mysql_error());
$row_dw = mysql_fetch_assoc($dw);
$totalRows_dw = mysql_num_rows($dw);

$tanggal=date("d M Y");
$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Work Engineering</title>
  <script src="../../js/jquery-1.7.1.min.js" type="text/javascript"></script> 
  <script src="../../js/jquery.hashchange.min.js" type="text/javascript"></script>
  <script src="../../library/jquery.easytabs.min.js" type="text/javascript"></script>

  <style>
    /* Example Styles for Demo */
    .etabs { margin: 0; padding: 0; }
    .tab { display: inline-block; zoom:1; *display:inline; background: #eee; border: solid 1px #999; border-bottom: none; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; }
    .tab a { font-size: 14px; line-height: 2em; display: block; padding: 0 10px; outline: none; }
    .tab a:hover { text-decoration: underline; }
    .tab.active { background: #fff; padding-top: 6px; position: relative; top: 1px; border-color: #666; }
    .tab a.active { font-weight: bold; }
    .tab-container .panel-container { background: #fff; border: solid #666 1px; padding: 10px; -moz-border-radius: 0 4px 4px 4px; -webkit-border-radius: 0 4px 4px 4px; }
    .panel-container { margin-bottom: 10px; }
  </style>
  
  <script type="text/javascript">
    $(document).ready( function() {
      $('#tab-container').easytabs();
    });
  </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
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
<table width="1270" border="0" align="center">
  <tr>
    <td width="594" height="64" colspan="3" rowspan="2"><img src="../../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="625" align="right" valign="middle">
  <table width="410" border="0" align="right" cellpadding="1" cellspacing="1">
          <tr>
            <td width="10" align="right" valign="middle" class="demoHeaders">|</td>
            <td width="307" align="right" valign="middle" class="demoHeaders">Your Logged as <a href="../../hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
            <td width="8" class="demoHeaders">|</a></td>
            <td width="106" class="demoHeaders"><a href="../../contact.php">Contact Us</a></td>
            <td width="8" class="demoHeaders">|</td>
            <td width="90" class="demoHeaders"><a href="../../logout.php">Logout</a></td>
            <td width="8" class="demoHeaders">|</td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom"><?php { require_once "../../menu_notification.php"; } ?></td>
  </tr>
  
  
  <tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root"><a href="home_engineering.php">Engineering</a></td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="484" align="left" class="root"><strong><strong><?php echo $row_Recordset1['nocrf']; ?></strong></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="left" class="General" id="font">
    
    <?php
		if ($_GET[modul]=='unapproved'){
			echo '<iframe src="../../tm/unapproved_crf.php" width="1200" height="550" style="border:thin"></iframe>';
		} elseif ($_GET[modul]=='notif'){
			?><iframe src="../../prj/bacanotif.php?data=<?php echo $usrid; ?>" width="1200" height="550" style="border:thin"></iframe><?php
		} else { ?>
           
           <div id="tab-container" class='tab-container'>
             <ul class='etabs'>
               <li class='tab'><a href="#tabs1-dinput">Design Input</a></li>
               <li class='tab'><a href="#tabs1-dcalculation">Design Calculation</a></li>
               <li class='tab'><a href="#tabs1-dreview">Design Review</a></li>
               <li class='tab'><a href="#tabs1-drawing">Drawing</a></li>
               <li class='tab'><a href="#tabs1-bom">BOM</a></li>
               <li class='tab'><a href="#tabs1-dverification">Design Verification</a></li>
               <li class='tab'><a href="#tabs1-dvalidation">Design Validation</a></li>
               <li class='tab'><a href="#tabs1-dchange">Design Change</a></li>
             </ul>
         <div class='panel-container'>
         
          <div id="tabs1-dinput">
           <link href="../../css/induk.css" rel="stylesheet" type="text/css" />
                <h2>Design Input</h2>
                <h2>
               <?php {include "upload_di.php";}?>
             </h2>
                <table width="1200" border="0">
                  <tr>
                    <td><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
                      Attachment File:
                      <input name="fileps" type="file" style="cursor:pointer;" />
                      <input type="submit" name="submit" value="Upload" />
                    </form></td>
                    <td rowspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><form action="<?php echo $editFormAction; ?>" id="form7" name="form7" method="POST">
                      <p>
                        <input name="idmsps" type="hidden" class="hidentext" id="idmsps" value="<?php echo $row_Recordset1['nocrf']; ?> <?php echo $row_Recordset1['nocrf']; ?>" />
                        <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
                        <input name="dateas" type="hidden" class="hidentext" id="dateas" value="<?php echo $tanggal;?>"/>
                        <input name="inisialps" type="hidden" class="hidentext" id="inisialps" value="DI"/>
                        <input type="hidden" name="id_department" id="id_department" value="eng" />
                      </p>
                      <p>
                        <label>
                          Remark : 
                          </label>
                          <textarea name="keterangandi" id="keterangan" cols="45" rows="5"></textarea>
                        </p>
                      <p>
                        <input type="submit" name="submit9" id="submit4" value="Submit" />
                        <input type="hidden" name="MM_insert2" value="form1" />
                        <input type="hidden" name="MM_insert2" value="form1" />
                        </p>
                      <input type="hidden" name="MM_insert" value="form1" />
                    </form></td>
                    </tr>
                </table>
          </div>
                  
           <div id="tabs1-dcalculation">
           <h2>Design Calculating</h2>
           <p><?php {include "upload_dc.php";}?>
           <form method="post" enctype="multipart/form-data" name="form" class="General" id="form2">
           Attachment File:
             <input name="filedc" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit2" value="Upload" />
           </form>
           <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
             <p>
               <input type="hidden" name="idmsdc" id="idmsdc" value="<?php echo $row_Recordset1['nocrf']; ?>" />
               <input name="nama_filedc" type="hidden" class="hidentext" id="nama_filedc" value="<?php echo $nama_file;?>"/>
               <input name="datedc" type="hidden" class="hidentext" id="datedc" value="<?php echo $tanggal;?>"/>
               <input name="inisialdc" type="hidden" class="hidentext" id="inisialdc" value="DC"/>
               <input type="hidden" name="id_department2" id="id_department2" value="eng" />
             </p>
             <p>
               <label>
                 Remark :
               </label><textarea name="keterangandc" id="keterangandc" cols="45" rows="5"></textarea>
               </p>
             <p>
               <input type="submit" name="submit6" id="submit2" value="Submit" />
               <input type="hidden" name="MM_insert" value="form2" />
             </p>
           </form>
           </div>
          <div id="tabs1-dreview">
          <h2>Design Review</h2>
        <p><?php {include "upload_dr.php";}?>
           <form method="post" enctype="multipart/form-data" name="form" class="General" id="form3">
             Attachment File:
             <input name="filedr" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit3" value="Upload" />
           </form>
           <form id="form3" name="form3" method="POST" action="<?php echo $editFormAction; ?>">
             <p>
               <input type="hidden" name="idmsdr" id="idmsdr" value="<?php echo $row_Recordset1['nocrf']; ?>" />
               <input name="nama_filedr" type="hidden" class="hidentext" id="nama_filedr" value="<?php echo $nama_file;?>"/>
               <input name="datedr" type="hidden" class="hidentext" id="datedr" value="<?php echo $tanggal;?>"/>
               <input name="inisialdr" type="hidden" class="hidentext" id="inisialdr" value="DR"/>
               <input type="hidden" name="id_department3" id="id_department3" value="eng" />
             </p>
             <p>
               <label>
                 Remark :
               </label><textarea name="keterangandr" id="keterangandr" cols="45" rows="5"></textarea>
             </p>
             <p>
               <input type="submit" name="submit8" id="submit2" value="Submit" />
               <input type="hidden" name="MM_insert" value="form3" />
             </p>
           </form></p>
          </div>
           <div id="tabs1-drawing">
             <h2>Drawing</h2>
             <p>
               <?php {include "upload_dw.php";}?>
             </p>
             <form method="post" enctype="multipart/form-data" name="form" class="General" id="form8">
               Attachment File:
               <input name="filedw" type="file" style="cursor:pointer;" />
               <input type="submit" name="submit0" value="Upload" />
             </form>
             <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
               <p>
                 <input name="drawingprogress" type="hidden" class="hidentext" id="drawingprogress" value="<?php echo $tanggal;?>" />
                 <input name="nocrfdrawing" type="hidden" class="hidentext" id="nocrfdrawing" value="<?php echo $row_Recordset1['nocrf']; ?>" />
                 <input name="inisialdw" type="hidden" class="hidentext" id="inisialdw" value="DW"/>
                 <input name="file_drawing" type="hidden" class="hidentext" id="file_drawing" value="<?php echo $nama_file;?>" />
                 <label for="productioncode"></label>
                 <input name="productioncode" type="hidden" class="hidentext" id="productioncode" value="<?php echo $row_Recordset1['projectcode']."-".$row_Recordset1['productioncode']; ?>" />
                 <input type="hidden" name="id_department4" id="id_department4" value="eng" />
               </p>
               <p>Remark : 
                 <textarea name="keterangandw" id="keterangandw" cols="45" rows="5"></textarea>
                 <br />
                 <!--<input name="progress_eng" type="text" value="100" size="10" />
                 %
                 <input type="checkbox" name="drawingc" id="drawingc" />
                 Complete-->
                 <input type="submit" name="submit3" id="submit" value="Submit" />
               </p>
               <input type="hidden" name="MM_insert" value="form1" />
             </form>
             <form id="form9" name="form9" method="POST" action="<?php echo $editFormAction; ?>">
               Drawing Complete for CRF : 
               <input type="text" name="drawingprogress2" id="drawingprogress2" />
               <input name="crf2" type="text" id="crf2" value="<?php echo $row_Recordset1['nocrf']; ?>" />
               <input type="submit" name="Submit" id="Submit" value="Finish" />
               <input type="hidden" name="MM_update" value="form9" />
             </form>
             <p>&nbsp;</p>
           </div>
          <div id="tabs1-bom">
          <h2>Bill Of Material (BOM)</h2>
          <input type="button" value="List BOM" onclick="listbom();" />
<script> 
            function listbom(){
                document.getElementById("bomform").setAttribute('src','../viewheaderbom.php?data=<?php echo $_GET['data']; ?>');
            }
          </script>
          <p><iframe id="bomform" src="../viewheaderbom.php?data=<?php echo $_GET['data']; ?>" width="100%" height="700" frameborder="0"></iframe>
          </div>
          <div id="tabs1-dverification">
          <h2>Design Verification</h2>
            <p> <?php {include "upload_dv.php";}?>
           
           <form method="post" enctype="multipart/form-data" name="form" class="General" id="form4">
             Attachment File:
             <input name="filedv" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit4" value="Upload" />
           </form>
           <form id="form4" name="form4" method="POST" action="<?php echo $editFormAction; ?>">
             <p>
               <input type="hidden" name="idmsdv" id="idmsdv" value="<?php echo $row_Recordset1['nocrf']; ?>" />
               <input name="nama_filedv" type="hidden" class="hidentext" id="nama_filedv" value="<?php echo $nama_file;?>"/>
               <input name="datedv" type="hidden" class="hidentext" id="datedv" value="<?php echo $tanggal;?>"/>
               <input name="inisialdv" type="hidden" class="hidentext" id="inisialdv" value="DV"/>
               <input type="hidden" name="id_department5" id="id_department5" value="eng" />
             </p>
             <p>
               <label>
                 Remark :
               </label><textarea name="keterangandv" id="keterangandv" cols="45" rows="5"></textarea>
             </p>
             <p>
               <input type="submit" name="submit7" id="submit3" value="Submit" />
               <input type="hidden" name="MM_insert" value="form4" />
             </p>
           </form></p>
           <p>&nbsp;</p>
          </div>
          <div id="tabs1-dvalidation">
            <h2>Design Validation</h2>
            <p><?php {include "upload_dd.php";}?>
           
           <form method="post" enctype="multipart/form-data" name="form" class="General" id="form4">
             Attachment File:
             <input name="filedd" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit5" value="Upload" />
           </form>
           <form id="form5" name="form5" method="POST" action="<?php echo $editFormAction; ?>">
             <p>
               <input type="hidden" name="idmsdd" id="idmsdd" value="<?php echo $row_Recordset1['nocrf']; ?>" />
               <input name="nama_filedd" type="hidden" class="hidentext" id="nama_filedd" value="<?php echo $nama_file;?>"/>
               <input name="datedd" type="hidden" class="hidentext" id="datedd" value="<?php echo $tanggal;?>"/>
               <input name="inisialdd" type="hidden" class="hidentext" id="inisialdd" value="DD"/>
               <input type="hidden" name="id_department6" id="id_department6" value="eng" />
             </p>
             <p>
               <label>
                 Remark :
               </label><textarea name="keterangandd" id="keterangandd" cols="45" rows="5"></textarea>
              </p>
             <p>
               <input type="submit" name="submit7" id="submit3" value="Submit" />
               <input type="hidden" name="MM_insert" value="form5" />
             </p>
           </form></p>
           <p>&nbsp;</p>
          </div>
          <div id="tabs1-dchange">
          <h2>Design Change</h2>
          <p>
            <?php {include "upload_dh.php";}?>
          <form method="post" enctype="multipart/form-data" name="form" class="General" id="form4">
             Attachment File:
             <input name="filedh" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit6" value="Upload" />
           </form>
           <form id="form6" name="form6" method="POST" action="<?php echo $editFormAction; ?>">
             <p>
               <input type="hidden" name="idmsdh" id="idmsdh" value="<?php echo $row_Recordset1['nocrf']; ?>" />
               <input name="nama_filedh" type="hidden" class="hidentext" id="nama_filedh" value="<?php echo $nama_file;?>"/>
               <input name="datedh" type="hidden" class="hidentext" id="datedh" value="<?php echo $tanggal;?>"/>
               <input name="inisialdh" type="hidden" class="hidentext" id="inisialdh" value="DH"/>
               <input type="hidden" name="id_department7" id="id_department7" value="eng" />
             </p>
             <p>
               <label>
        Remark :
               </label><textarea name="keterangandh" id="keterangandh" cols="45" rows="5"></textarea>
             </p>
             <p>
               <input type="submit" name="submit7" id="submit3" value="Submit" />
               <input type="hidden" name="MM_insert" value="form6" />
             </p>
           </form></p>
          </div>
         </div>
        </div>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td width="594">&nbsp;</td>
    <td width="594" colspan="2">&nbsp;</td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
<form id="form10" name="form10" method="POST" action="<?php echo $editFormAction; ?>">
  <h4>Design Complete for CRF :
  <input name="designprogress" type="text" /> <input name="crf" type="hidden" value="<?php echo $row_Recordset1['nocrf']; ?>" /> <input name="submit" type="submit" value="Finish"/>
  <input type="hidden" name="MM_update" value="form10" />
  </h4>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($dc);

mysql_free_result($Recordset1);

mysql_free_result($di);

mysql_free_result($dc);

mysql_free_result($dr);

mysql_free_result($dv);

mysql_free_result($dd);

mysql_free_result($dh);

mysql_free_result($dw);

mysql_free_result($Recordset1);
?>
