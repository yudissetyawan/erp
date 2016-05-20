<?php require_once('../Connections/core.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO dms (idms, inisial_pekerjaan, `date`, fileupload) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsps'], "text"),
                       GetSQLValueString($_POST['inisialps'], "text"),
                       GetSQLValueString($_POST['dateas'], "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, inisial_pekerjaan, `date`, fileupload) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsmc'], "text"),
                       GetSQLValueString($_POST['inisialmc'], "text"),
                       GetSQLValueString($_POST['datemc'], "text"),
                       GetSQLValueString($_POST['nama_filemc'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form6")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, inisial_pekerjaan, `date`, fileupload) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmssp'], "text"),
                       GetSQLValueString($_POST['inisialsp'], "text"),
                       GetSQLValueString($_POST['datesp'], "text"),
                       GetSQLValueString($_POST['nama_filesp'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form7")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, inisial_pekerjaan, `date`, fileupload) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsps'], "text"),
                       GetSQLValueString($_POST['inisialft'], "text"),
                       GetSQLValueString($_POST['dateas'], "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"));

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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE idms = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$tanggal=date("d M Y")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>HRD - Attachment</title>
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
    <td width="594" height="64" colspan="3"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="625" align="right" valign="bottom"><table width="400" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>
        <td width="10" align="right" valign="bottom">|</td>
        <td width="307" align="right" valign="bottom" class="demoHeaders">Your Logged as <a href="#"> </a></td>
        <td width="11" class="demoHeaders">|</a></td>
        <td width="106" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
        <td width="11" class="demoHeaders">|</td>
        <td width="107" class="demoHeaders">Logout</td>
        <td width="18">|</td>
      </tr>
    </table></td>
  </tr>
  
  
  <tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root">PROJECT</td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="484" align="left" class="root"><strong><strong><?php echo $row_Recordset1['nocrf']; ?></strong></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" align="left" class="General" id="font"><div id="tab-container" class='tab-container'>
 <ul class='etabs'>
   <li class='tab'><a href="#tabs1-ps">KTP &amp; KK</a></li>
   <li class='tab'><a href="#tabs1-mc">SERTIFIKAT</a></li>
   <li class='tab'><a href="#tabs1-sp">MCU</a></li>
   <li class='tab'><a href="#tabs1-ft">FOTO</a></li>
   </ul>
 <div class='panel-container'>
  <div id="tabs1-ps">
     <h2>KTP &amp; KK</h2>
     <?php {include "uploadps.php";}?>
     <form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
       Attachment File:
       <input name="fileps" type="file" style="cursor:pointer;" />
       <input type="submit" name="submit" value="Upload" />
     </form>
     <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
       <input name="idmsps" type="text" class="hidentext" id="idmsps" value="<?php echo $row_Recordset2['id']; ?>"  />
       <input name="nama_fileps" type="text" class="hidentext" id="nama_fileps" value="<?php echo $nama_file;?>"/>
       <input name="dateas" type="text" class="hidentext" id="dateas" value="<?php echo $tanggal;?>"/>
       <input name="inisialps" type="text" class="hidentext" id="inisialps" value="KTP-KK"/>
       <input type="submit" name="submit5" id="submit" value="Submit" />
       <input type="hidden" name="MM_insert" value="form1" />
     </form>
     
  </div>
  <div id="tabs1-mc">
   <h2>SERTIFIKAT</h2>
   <?php {include "uploadmc.php";}?>
   <form method="post" enctype="multipart/form-data" name="form3" class="General" id="form3">
   Attachment File:
     <input name="filemc" type="file" style="cursor:pointer;" />
     <input type="submit" name="submit2" value="Upload" />
   </form>
   <form id="form4" name="form4" method="POST" action="<?php echo $editFormAction; ?>">
     <input name="idmsmc" type="text" class="hidentext" id="idmsmc" value="<?php echo $row_Recordset2['id']; ?>" />
     <input name="nama_filemc" type="text" class="hidentext" id="nama_filemc" value="<?php echo $nama_file;?>"/>
       <input name="datemc" type="text" class="hidentext" id="datemc" value="<?php echo $tanggal;?>"/>
       <input name="inisialmc" type="text" class="hidentext" id="inisialmc" value="SERTIFIKAT"/>
       <input type="submit" name="submit6" id="submit2" value="Submit" />
       <input type="hidden" name="MM_insert" value="form4" />
   </form>
  </div>
  <div id="tabs1-sp">
   <h2>MCU</h2>
   <?php {include "uploadsp.php";}?>
   <form method="post" enctype="multipart/form-data" name="form5" class="General" id="form6">
   Attachment File:
     <input name="filesp" type="file" style="cursor:pointer;" />
     <input type="submit" name="submit3" value="Upload" />
   </form>
   <form id="form6" name="form6" method="POST" action="<?php echo $editFormAction; ?>">
       <input name="idmssp" type="text" class="hidentext" id="idmssp" value="<?php echo $row_Recordset2['id']; ?>" />
       <input name="nama_filesp" type="text" class="hidentext" id="nama_filesp" value="<?php echo $nama_file;?>"/>
       <input name="datesp" type="text" class="hidentext" id="datesp" value="<?php echo $tanggal;?>"/>
       <input name="inisialsp" type="text" class="hidentext" id="inisialsp" value="MCU"/>
       <input type="submit" name="submit6" id="submit2" value="Submit" />
       <input type="hidden" name="MM_insert" value="form6" />
   </form>
  </div>
  <div id="tabs1-ft">
     <h2>FOTO</h2>
     <?php {include "uploadft.php";}?>
     <form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
       Attachment File:
       <input name="fileft" type="file" style="cursor:pointer;" />
       <input type="submit" name="submit10" value="Upload" />
     </form>
     <form action="<?php echo $editFormAction; ?>" id="form7" name="form7" method="POST">
       <input name="idmsps" type="text" class="hidentext" id="idmsps" value="<?php echo $row_Recordset2['id']; ?>"  />
       <input name="nama_fileps" type="text" class="hidentext" id="nama_fileps" value="<?php echo $nama_file;?>"/>
       <input name="dateas" type="text" class="hidentext" id="dateas" value="<?php echo $tanggal;?>"/>
       <input name="inisialft" type="text" class="hidentext" id="inisialft" value="FOTO"/>
       <input type="submit" name="submit10" id="submit11" value="Submit" />
       <input type="hidden" name="MM_insert" value="form7" />
     </form>
     
  </div>
 </div>
 
</div></td>
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

mysql_free_result($Recordset2);

mysql_free_result($Recordset1);
?>
