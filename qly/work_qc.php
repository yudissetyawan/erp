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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE a_crf_schedulle SET itpprogress=%s, file_itp=%s WHERE crf=%s",
                       GetSQLValueString($_POST['dateitp'], "text"),
                       GetSQLValueString($_POST['nama_fileitp'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form7")) {
  $updateSQL = sprintf("UPDATE a_crf_schedulle SET file_test=%s WHERE crf=%s",
                       GetSQLValueString($_POST['nama_filende'], "text"),
                       GetSQLValueString($_POST['idmsnde'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form8")) {
  $updateSQL = sprintf("UPDATE pr_progress_core_scopework SET progress_qly=%s, idms_qly=%s WHERE id_progress_header=%s",
                       GetSQLValueString($_POST['progress'], "int"),
                       GetSQLValueString($_POST['idms'], "int"),
                       GetSQLValueString($_POST['id_progress_header'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form5")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsnde'], "text"),
                       GetSQLValueString($_POST['id_department6'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"),
                       GetSQLValueString($_POST['inisialnde'], "text"),
                       GetSQLValueString($_POST['datende'], "text"),
                       GetSQLValueString($_POST['nama_filende'], "text"),
                       GetSQLValueString($_POST['keterangannde'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmscb'], "text"),
                       GetSQLValueString($_POST['id_department4'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"),
                       GetSQLValueString($_POST['inisialcb'], "text"),
                       GetSQLValueString($_POST['datecb'], "text"),
                       GetSQLValueString($_POST['nama_filecb'], "text"),
                       GetSQLValueString($_POST['keterangancb'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsqi'], "text"),
                       GetSQLValueString($_POST['id_department3'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"),
                       GetSQLValueString($_POST['inisialqp'], "text"),
                       GetSQLValueString($_POST['dateqp'], "text"),
                       GetSQLValueString($_POST['nama_fileqp'], "text"),
                       GetSQLValueString($_POST['keteranganqi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsdh'], "text"),
                       GetSQLValueString($_POST['id_department'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"),
                       GetSQLValueString($_POST['inisialitp'], "text"),
                       GetSQLValueString($_POST['dateitp'], "text"),
                       GetSQLValueString($_POST['nama_fileitp'], "text"),
                       GetSQLValueString($_POST['keteranganitp'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}


mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM inisial_pekerjaan";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM dms WHERE idms = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT a_crf.*, a_production_code.id AS ids FROM a_crf, a_production_code WHERE a_crf.nocrf = %s AND a_crf.productioncode = a_production_code.productioncode", GetSQLValueString($colname_Recordset1, "text"));
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
  <title>Work Quality</title>
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
    <td width="625" align="right" valign="bottom">
    	<table width="420" border="0" align="right" cellpadding="1" cellspacing="1">
          <tr>
            <td width="8" align="right" valign="middle">|</td>
            <td width="307" align="right" valign="middle" class="demoHeaders">Your Logged as <a href="../hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
            <td width="8" class="demoHeaders">|</a></td>
            <td width="106" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
            <td width="8" class="demoHeaders">|</td>
            <td width="90" class="demoHeaders"><a href="../logout.php">Logout</a></td>
            <td align="right" width="8" class="demoHeaders">|</td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="right" valign="bottom"><?php { require_once "../menu_notification.php"; } ?></td>
  </tr>
  
  
  <tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root">Quality</td>
        
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
               <li class='tab'><a href="#tabs1-itp">ITP</a></li>
               <li class='tab'><a href="#tabs1-qi">Quality Inspection</a></li>
                <li class='tab'><a href="#tabs1-cb">Calibration</a></li>
                <li class='tab'><a href="#tabs1-nde">MDR</a></li>
            </ul>
             <div class='panel-container'>
           <div id="tabs1-itp">
                 <h2>ITP</h2>
                 <?php {include "uploaditp.php";}?>
                 <form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
                   Attachment File:
                   <input name="fileitp" type="file" style="cursor:pointer;" />
                   <input type="submit" name="submit1" value="Upload" />
                 </form>
                 <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
                   <p>
                     <input type="hidden" name="nocrf" id="nocrf" value="<?php echo $row_Recordset1['nocrf']; ?>" />
                     <label for="idms"></label>
                     <input name="nama_fileitp" type="hidden" id="nama_fileitp" value="<?php echo $nama_file;?>"/>
                     <input name="dateitp" type="hidden" id="dateitp" value="<?php echo $tanggal;?>"/>
                     <input name="inisialitp" type="hidden" id="inisialitp" value="ITP"/>
                     <input type="hidden" name="id_department" id="id_department" value="qc" />
                   </p>
                   <p>
                     Remark : 
                     <textarea name="keteranganitp" id="keteranganitp" cols="45" rows="5"></textarea>
                     <input name="idmsdh" type="hidden" id="idmsdh" value="<?php echo $row_Recordset1['idms']; ?>" />
                     <input name="id_progress_header7" type="hidden" id="id_progress_header7" value="<?php echo $row_Recordset1['id_a_production_code']; ?>" />
                   </p>
                   <p>
                     <label for="inisial_pekerjaan"></label>
                     <input type="submit" name="submit5" id="submit" value="Submit" />
                     <input type="hidden" name="MM_update2" value="form1" />
                     <input type="hidden" name="MM_insert3" value="form1" />
                   </p>
                   <input type="hidden" name="MM_update" value="form1" />
                   <input type="hidden" name="MM_insert" value="form1" />
                 </form>
                 
              </div>
              <div id="tabs1-qi">
               <h2>Quality Inspection</h2>
               <?php {include "uploadqi.php";}?>
               <form method="post" enctype="multipart/form-data" name="form5" class="General" id="form6">
               Attachment File:
                 <input name="fileqp" type="file" style="cursor:pointer;" />
                 <input type="submit" name="submit3" value="Upload" />
               </form>
               <p>&nbsp;</p>
               <form action="<?php echo $editFormAction; ?>" id="form6" name="form6" method="POST">
                 <input type="hidden" name="nocrf" id="nocrf" value="<?php echo $row_Recordset1['nocrf']; ?>" />
                 <input name="nama_fileqp" type="hidden" id="nama_fileqp" value="<?php echo $nama_file;?>"/>
                   <input name="dateqp" type="hidden" id="dateqp" value="<?php echo $tanggal;?>"/>
                   <input name="inisialqp" type="hidden" id="inisialqp" value="QI"/>
                   <input type="hidden" name="id_department3" id="id_department3" value="qc" />
                   <p>Remark : 
                     <textarea name="keteranganqi" id="keteranganqi" cols="45" rows="5"></textarea>
                     <input name="idmsqi" type="hidden" id="idmsqi" value="<?php echo $row_Recordset1['idms']; ?>" />
                     <input name="id_progress_header3" type="hidden" id="id_progress_header3" value="<?php echo $row_Recordset1['id_a_production_code']; ?>" />
                   </p>
            <input type="submit" name="submit6" id="submit2" value="Submit" />
            <input type="hidden" name="MM_insert" value="form6" />
               </form>
              </div>
              <div id="tabs1-cb">
               <h2>Calibration</h2>
               <?php {include "uploadcb.php";}?>
               <form method="post" enctype="multipart/form-data" name="form5" class="General" id="form6">
               Attachment File:
                 <input name="filecb" type="file" style="cursor:pointer;" />
                 <input type="submit" name="submit" value="Upload" />
               </form>
               <form id="form6" name="form6" method="POST" action="<?php echo $editFormAction; ?>">
                 <input type="hidden" name="nocrf" id="nocrf" value="<?php echo $row_Recordset1['nocrf']; ?>" />
                 <input name="nama_filecb" type="hidden" id="nama_filecb" value="<?php echo $nama_file;?>"/>
                   <input name="datecb" type="hidden" id="datecb" value="<?php echo $tanggal;?>"/>
                   <input name="inisialcb" type="hidden" id="inisialcb" value="CB"/>
                   <input type="hidden" name="id_department4" id="id_department4" value="qc" />
                   <p>
                     Remark : 
                     <textarea name="keterangancb" id="keterangancb" cols="45" rows="5"></textarea>
                     <input name="idmscb" type="hidden" id="idmscb" value="<?php echo $row_Recordset1['idms']; ?>" />
                     <input name="id_progress_header4" type="hidden" id="id_progress_header4" value="<?php echo $row_Recordset1['id_a_production_code']; ?>" />
                   </p>
                   <input type="submit" name="submit6" id="submit2" value="Submit" />
            <input type="hidden" name="MM_insert" value="form6" />
               </form>
              </div>
              <div id="tabs1-nde">
                <h2>MANUFACTURING DATA REPORT</h2>
                <?php {include "uploadnde.php";}?>
                <form method="post" enctype="multipart/form-data" name="form5" class="General" id="form5">
                  Attachment File:
                  <input name="filende" type="file" style="cursor:pointer;" />
                  <input type="submit" name="submit7" value="Upload" />
                </form>
                <form id="form5" name="form5" method="POST" action="<?php echo $editFormAction; ?>">
                  <input type="hidden" name="nocrf" id="nocrf" value="<?php echo $row_Recordset1['nocrf']; ?>" />
                  <input name="nama_filende" type="hidden" id="nama_filende" value="<?php echo $nama_file;?>"/>
                  <input name="inisialnde" type="hidden" id="inisialnde" value="NDE"/>
                  <input name="datende" type="hidden" id="datende" value="<?php echo $tanggal;?>"/>
                  <input type="hidden" name="id_department6" id="id_department6" value="qc" />
                  <p>
                    Remark : 
                    <textarea name="keterangannde" id="keterangannde" cols="45" rows="5"></textarea>
                    <input name="idmsnde" type="hidden" id="idmsnde" value="<?php echo $row_Recordset1['idms']; ?>" />
                    <input name="id_progress_header6" type="hidden" id="id_progress_header6" value="<?php echo $row_Recordset1['id_a_production_code']; ?>" />
                  </p>
            <input type="submit" name="submit7" id="submit4" value="Submit" />
            <input type="hidden" name="MM_update" value="form7" />
            <input type="hidden" name="MM_insert" value="form5" />
                </form>
              </div>
               </div>
             
            </div></td>
              </tr>
              <tr>
                <td colspan="4"><form class="hidentext" action="<?php echo $editFormAction; ?>" id="form8" name="form8" method="POST">
                  <h3>
                    Progress :
                    <input type="text" name="progress" id="progress" size="12" /> 
                    %
                    <input type="submit" name="submit8" id="submit5" value="Submit" />
                    <input name="idms" type="hidden" id="idms" value="<?php echo $row_Recordset1['idms']; ?>" />
                    <input name="id_progress_header" type="hidden" id="id_progress_header" value="<?php echo $row_Recordset4['id']; ?>" />
                    <input type="hidden" name="MM_update" value="form8" />
                  </h3>
                </form>
    	<?php } ?> 
    </td>
  </tr>
  <tr>
    <td width="594">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
</body>
</html>
<?php
	mysql_free_result($Recordset2);
	mysql_free_result($Recordset3);
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset4);
?>