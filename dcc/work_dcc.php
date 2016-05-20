<?php require_once('../Connections/core.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsas'], "text"),
                       GetSQLValueString($_POST['id_department'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"),
                       GetSQLValueString($_POST['inisialas'], "text"),
                       GetSQLValueString($_POST['dateas'], "text"),
                       GetSQLValueString($_POST['nama_fileas'], "text"),
                       GetSQLValueString($_POST['keteranganas'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmspn'], "text"),
                       GetSQLValueString($_POST['id_department2'], "text"),
                       GetSQLValueString($_POST['nocrf2'], "text"),
                       GetSQLValueString($_POST['inisialpn'], "text"),
                       GetSQLValueString($_POST['datepn'], "text"),
                       GetSQLValueString($_POST['nama_filepn'], "text"),
                       GetSQLValueString($_POST['keteranganpn'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmscl'], "text"),
                       GetSQLValueString($_POST['id_department3'], "text"),
                       GetSQLValueString($_POST['nocrf3'], "text"),
                       GetSQLValueString($_POST['inisialcl'], "text"),
                       GetSQLValueString($_POST['datecl'], "text"),
                       GetSQLValueString($_POST['nama_filecl'], "text"),
                       GetSQLValueString($_POST['keterangancl'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsiv'], "text"),
                       GetSQLValueString($_POST['id_department4'], "text"),
                       GetSQLValueString($_POST['nocrf4'], "text"),
                       GetSQLValueString($_POST['id_department4'], "text"),
                       GetSQLValueString($_POST['dateiv'], "text"),
                       GetSQLValueString($_POST['nama_fileiv'], "text"),
                       GetSQLValueString($_POST['keteranganiv'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmssk'], "text"),
                       GetSQLValueString($_POST['id_department4'], "text"),
                       GetSQLValueString($_POST['nocrf4'], "text"),
                       GetSQLValueString($_POST['id_department4'], "text"),
                       GetSQLValueString($_POST['datesk'], "text"),
                       GetSQLValueString($_POST['nama_filesk'], "text"),
                       GetSQLValueString($_POST['keterangansk'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form8")) {
  $updateSQL = sprintf("UPDATE pr_progress_core_scopework SET progress_ppic=%s, idms_ppic=%s WHERE id_progress_header=%s",
                       GetSQLValueString($_POST['progress'], "int"),
                       GetSQLValueString($_POST['idms'], "int"),
                       GetSQLValueString($_POST['id_progress_header'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}


$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE idms = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT a_crf.*, a_production_code.id FROM a_crf, a_production_code WHERE a_crf.nocrf = %s AND a_crf.productioncode = a_production_code.productioncode", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$tanggal = date("d M Y");

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Work DCC</title>
  <script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script> 
  <script src="../js/jquery.hashchange.min.js" type="text/javascript"></script>
  <script src="../library/jquery.easytabs.min.js" type="text/javascript"></script>

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
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
    <td width="594" height="64" colspan="3" rowspan="2"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="625" align="right" valign="middle">
        <table width="420" border="0" align="right" cellpadding="1" cellspacing="1">
          <tr>
            <td width="10" align="right" valign="middle" class="demoHeaders">|</td>
            <td width="315" align="right" valign="middle" class="demoHeaders">Your Logged as <a href="../hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
            <td width="8" class="demoHeaders">|</a></td>
            <td width="106" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
            <td width="8" class="demoHeaders">|</td>
            <td width="90" class="demoHeaders"><a href="../logout.php">Logout</a></td>
            <td align="right" width="8">|</td>
          </tr>
        </table>
      </td>
  </tr>
  <tr>
    <td align="right" valign="bottom">
    	<?php { include "../menu_notification.php"; } ?>
    </td>
  </tr>
  
  
  <tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root">DCC</td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="484" align="left" class="root"><strong><?php echo $row_Recordset1['nocrf']; ?></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="left" class="General" id="font">
    <?php
		if ($_GET[modul]=='unapproved'){
			echo '<iframe src="/tm/unapproved_crf.php" width="1200" height="550" style="border:thin"></iframe>';
		} elseif ($_GET[modul]=='notif'){
			?><iframe src="/prj/bacanotif.php?data=<?php echo $usrid; ?>" width="1200" height="550" style="border:thin"></iframe><?php
		} else { ?>
    	
        <div id="tab-container" class='tab-container'>
		<ul class='etabs'>
			<li class='tab'><a href="#tabs1-au">Audit</a></li>
            <li class='tab'><a href="#tabs1-ax">Audit Eksternal</a></li>
            <li class='tab'><a href="#tabs1-mr">Management Review</a></li>
            <li class='tab'><a href="#tabs1-dc">Document</a></li>
            <li class='tab'><a href="#tabs1-sk">Surat Keluar</a></li> 
        </ul>
   
		<div class='panel-container'>
        
          <div id="tabs1-au">
             <h2>Audit</h2>
             <?php { include "uploadau.php"; }?>
             <form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
               Attachment File:
               <input name="fileas" type="file" style="cursor:pointer;" />
               <input type="submit" name="submit" value="Upload" />
             </form>
             <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
               <input type="hidden" name="nocrf" id="nocrf" value="<?php echo $row_Recordset1['nocrf']; ?>" />
               <input name="nama_fileas" type="hidden" id="nama_fileas" value="<?php echo $nama_file;?>"/>
               <input name="dateas" type="hidden" id="dateas" value="<?php echo $tanggal;?>"/>
               <input name="inisialas" type="hidden" id="inisialas" value="AU"/>
               <input type="hidden" name="id_department" id="id_department" value="dcc" />
               <p>
                 <textarea name="keteranganas" id="keteranganas" cols="45" rows="5"></textarea>
                 <input name="idmsas" type="hidden" id="idmsas" value="<?php echo $row_Recordset1['idms']; ?>" />
               </p>
                <input type="submit" name="submit5" id="submit" value="Submit" />
                <input type="hidden" name="MM_insert" value="form1" />
             </form>  
          </div>
          
          <div id="tabs1-ax">
           <h2>Audit Eksternal</h2>
           <?php { include "uploadax.php"; }?>
           <form method="post" enctype="multipart/form-data" name="form3" class="General" id="form3">
           Attachment File:
             <input name="filepn" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit2" value="Upload" />
           </form>
           <form action="<?php echo $editFormAction; ?>" id="form4" name="form4" method="POST">
             <input type="hidden" name="nocrf2" id="nocrf2" value="<?php echo $row_Recordset1['nocrf']; ?>" />
             <input name="nama_filepn" type="hidden" id="nama_filepn" value="<?php echo $nama_file;?>"/>
               <input name="datepn" type="hidden" id="datepn" value="<?php echo $tanggal;?>"/>
               <input name="inisialpn" type="hidden" id="inisialpn" value="AX"/>
               <input type="hidden" name="id_department2" id="id_department2" value="dcc" />
               <p>
                 <textarea name="keteranganpn" id="keteranganpn" cols="45" rows="5"></textarea>
                 <input name="idmspn" type="hidden" id="idmspn" value="<?php echo $row_Recordset1['idms']; ?>" />
               </p>
                <input type="submit" name="submit6" id="submit2" value="Submit" />
                <input type="hidden" name="MM_insert" value="form4" />
           </form>
          </div>
          
          <div id="tabs1-mr">
           <h2>Management Review</h2>
           <?php { include "uploadmr.php"; } ?>
           <form method="post" enctype="multipart/form-data" name="form5" class="General" id="form6">
           Attachment File:
             <input name="filecl" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit3" value="Upload" />
           </form>
           <form action="<?php echo $editFormAction; ?>" id="form6" name="form6" method="POST">
             <input type="hidden" name="nocrf3" id="nocrf3" value="<?php echo $row_Recordset1['nocrf']; ?>" />
             <input name="nama_filecl" type="hidden" id="nama_filecl" value="<?php echo $nama_file;?>"/>
               <input name="datecl" type="hidden" id="datecl" value="<?php echo $tanggal;?>"/>
               <input name="inisialcl" type="hidden" id="inisialcl" value="MR"/>
               <input type="hidden" name="id_department3" id="id_department3" value="dcc" />
               <p>
                 <textarea name="keterangancl" id="keterangancl" cols="45" rows="5"></textarea>
                 <input name="idmscl" type="hidden" id="idmscl" value="<?php echo $row_Recordset1['idms']; ?>" />
               </p>
                <input type="submit" name="submit6" id="submit2" value="Submit" />
                <input type="hidden" name="MM_insert" value="form6" />
           </form>
          </div>
          
          <div id="tabs1-dc">
           <h2>Document</h2>
           <?php { include "uploaddc.php"; }?>
           <form method="post" enctype="multipart/form-data" name="form5" class="General" id="form6">
           Attachment File:
             <input name="fileiv" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit4" value="Upload" />
           </form>
           <form id="form6" name="form6" method="POST" action="<?php echo $editFormAction; ?>">
             <input type="hidden" name="nocrf4" id="nocrf4" value="<?php echo $row_Recordset1['nocrf']; ?>" />
             <input name="nama_fileiv" type="hidden" id="nama_fileiv" value="<?php echo $nama_file;?>"/>
               <input name="dateiv" type="hidden" id="dateiv" value="<?php echo $tanggal;?>"/>
               <input name="inisialiv" type="hidden" id="inisialiv" value="DC"/>
               <input type="hidden" name="id_department4" id="id_department4" value="dcc" />
               <p>
                 <textarea name="keteranganiv" id="keteranganiv" cols="45" rows="5"></textarea>
                 <input name="idmsiv" type="hidden" id="idmsiv" value="<?php echo $row_Recordset1['idms']; ?>" />
               </p>
				<input type="submit" name="submit6" id="submit2" value="Submit" />
               <input type="hidden" name="MM_insert" value="form6" />
           </form>
          </div>
        
          <div id="tabs1-sk">
           <h2>Surat Keluar</h2>
           <?php { include "uploadsk.php"; }?>
           <form method="post" enctype="multipart/form-data" name="form5" class="General" id="form6">
           Attachment File:
             <input name="filesk" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit4" value="Upload" />
           </form>
           <form id="form6" name="form6" method="POST" action="<?php echo $editFormAction; ?>">
             <input type="hidden" name="nocrf4" id="nocrf4" value="<?php echo $row_Recordset1['nocrf']; ?>" />
             <input name="nama_filesk" type="hidden" id="nama_filesk" value="<?php echo $nama_file;?>"/>
               <input name="datesk" type="hidden" id="datesk" value="<?php echo $tanggal;?>"/>
               <input name="inisialsk" type="hidden" id="inisialsk" value="SK"/>
               <input type="hidden" name="id_department4" id="id_department4" value="dcc" />
               <p>
                 <textarea name="keterangansk" id="keterangansk" cols="45" rows="5"></textarea>
                 <input name="idmssk" type="hidden" id="idmssk" value="<?php echo $row_Recordset1['idms']; ?>" />
               </p>
				<input type="submit" name="submit6" id="submit2" value="Submit" />
               <input type="hidden" name="MM_insert" value="form6" />
           </form>
          </div>
          
		 </div>
        </div>
        </td>
      </tr>
      
      <tr>
        <td>
        <form action="<?php echo $editFormAction; ?>" id="form8" name="form8" method="POST">
          Progress :
          <input type="text" name="progress" id="progress" value="100" size="12" />
          %
      <input type="submit" name="submit8" id="submit5" value="Submit" />
      <input name="idms" type="hidden" id="idms" value="<?php echo $row_Recordset1['idms']; ?>" />
      <input name="id_progress_header" type="hidden" id="id_progress_header" value="<?php echo $row_Recordset4['id']; ?>" />
      <input type="hidden" name="MM_update" value="form8" />
        </form>
      <?php } ?>
    </td>
    <td colspan="2">&nbsp;</td>
    <td align="right" class="General" id="font2">&nbsp;</td>
  </tr>
  <tr>
    <td width="29">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>

</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset4);
?>