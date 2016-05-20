<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrator,commercial";
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
  $insertSQL = sprintf("INSERT INTO dms (idms, inisial_pekerjaan, `date`, fileupload) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmspg'], "text"),
                       GetSQLValueString($_POST['inisialpg'], "text"),
                       GetSQLValueString($_POST['datepg'], "text"),
                       GetSQLValueString($_POST['nama_filepg'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
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

mysql_select_db($database_core, $core);
$query_pg = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'pg'";
$pg = mysql_query($query_pg, $core) or die(mysql_error());
$row_pg = mysql_fetch_assoc($pg);
$totalRows_pg = mysql_num_rows($pg);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$tanggal=date("d M Y");
$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Work Commercial</title>
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
    <td width="594" height="64" rowspan="2"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
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
    <td colspan="2" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root">Commercial</td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="484" align="left" class="root"><strong><strong><?php echo $row_Recordset1['nocrf']; ?></strong></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="left" class="General" id="font">
    <?php
		if ($_GET[modul]=='unapproved'){
			echo '<iframe src="/tm/unapproved_crf.php" width="1200" height="550" style="border:thin"></iframe>';
		} elseif ($_GET[modul]=='notif'){
			?><iframe src="/prj/bacanotif.php?data=<?php echo $usrid; ?>" width="1200" height="550" style="border:thin"></iframe><?php
		} else { ?>
        
    	<div id="tab-container" class='tab-container'>
         <ul class='etabs'>
           <li class='tab'><a href="#tabs1-pg">Progress</a></li>
           <li class='tab'><a href="#tabs1-es">Estimation</a></li>
           <li class='tab'><a href="#tabs1-bg">Budgeting</a></li>
           <li class='tab'><a href="#tabs1-ce">Contract Expenditure</a></li>
           </ul>
         <div class='panel-container'>
          <div id="tabs1-pg">
             <h2>Progress</h2>
             <?php {include "uploadprogress.php";}?>
             <form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
               Attachment File:
               <input name="filepg" type="file" style="cursor:pointer;" />
               <input type="submit" name="submit" value="Upload" />
             </form>
             <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
               <input type="hidden" name="idmspg" id="idmspg" value="<?php echo $row_recordset1['idms'];?>" />
               <input name="nama_filepg" type="text" id="nama_filepg" value="<?php echo $nama_file;?>"/>
               <input name="datepg" type="text" id="datepg" value="<?php echo $tanggal;?>"/>
               <input name="inisialpg" type="text" id="inisialpg" value="pg"/>
               <label>
                 <input name="idms" type="text" id="idms" value="<?php echo $row_Recordset1['idms']; ?>" />
               </label>
               <input type="submit" name="submit5" id="submit" value="Submit" />
               <input type="hidden" name="MM_insert" value="form1" />
             </form>
           <p></p>  
           <table width="200" border="1" class="hidentext">
             <tr class="tabel_header">
               <td>No</td>
               <td>Tanggal Upload</td>
               <td>Nama File</td>
             </tr>
             <tr class="tabel_body"><?php $a=$a+1 ?>
               <td><?php echo $a ?></td>
               <td><?php echo $row_pg['date']; ?></td>
               <td><a href=../com/upload_comm/pg/<?php echo $row_pg['fileupload']; ?> target="_blank"><?php echo $row_pg['fileupload']; ?></a></td>
             </tr>
           </table>
          </div>
          <div id="tabs1-es">
           <h2>Estimation</h2>
           <?php {include "uploades.php";}?>
           <form method="post" enctype="multipart/form-data" name="form" class="General" id="form2">
           Attachment File:
             <input name="filees" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit2" value="Upload" />
           </form>
           <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
               <input type="hidden" name="idmsse" id="idmsse" value="<?php echo $row_recordset1['idms'];?>" />
               <input name="nama_filees" type="text" class="hidentext" id="nama_filees" value="<?php echo $nama_file;?>"/>
               <input name="datees" type="text" class="hidentext" id="datees" value="<?php echo $tanggal;?>"/>
               <input name="inisiales" type="text" class="hidentext" id="inisiales" value="es"/>
               <input type="submit" name="submit6" id="submit2" value="Submit" />
           </form>
          </div>
          <div id="tabs1-bg">
           <h2>Budgeting</h2>
           <?php {include "uploadbg.php";}?>
           <form method="post" enctype="multipart/form-data" name="form" class="General" id="form3">
             Attachment File:
             <input name="filebg" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit3" value="Upload" />
           </form>
           <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
               <input type="hidden" name="idmsbg" id="idmsbg" value="<?php echo $row_recordset1['idms'];?>" />
               <input name="nama_filebg" type="text" class="hidentext" id="nama_filebg" value="<?php echo $nama_file;?>"/>
               <input name="datebg" type="text" class="hidentext" id="datebg" value="<?php echo $tanggal;?>"/>
               <input name="inisialbg" type="text" class="hidentext" id="inisialbg" value="bg"/>
               <input type="submit" name="submit8" id="submit2" value="Submit" />
           </form>
          </div>
          <div id="tabs1-ce">
           <h2>Contract Expenditure</h2>
           <?php {include "uploadce.php";}?>
           
           <form method="post" enctype="multipart/form-data" name="form" class="General" id="form4">
             Attachment File:
             <input name="filece" type="file" style="cursor:pointer;" />
             <input type="submit" name="submit4" value="Upload" />
           </form>
           <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
             <input type="hidden" name="idmsce" id="idmsce" value="<?php echo $row_recordset1['idms'];?>" />
             <input name="nama_filece" type="text" class="hidentext" id="nama_filece" value="<?php echo $nama_file;?>"/>
             <input name="datece" type="text" class="hidentext" id="datece" value="<?php echo $tanggal;?>"/>
               <input name="inisialce" type="text" class="hidentext" id="inisialce" value="ce"/>
               <input type="submit" name="submit7" id="submit3" value="Submit" />
           </form>
          </div>
         </div>
         
        </div>
      <?php } ?>
      </td>
  </tr>
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" id="form5" name="form1" method="post">
      <p>
        <input name="drawingprogress" type="text" id="drawingprogress" value="<?php echo $tanggal;?>" />
        <input name="nocrfdrawing" type="text" id="nocrfdrawing" value="<?php echo $row_Recordset1['nocrf']; ?>" />
        <input name="file_drawing" type="text" id="file_drawing" value="<?php echo $nama_file;?>" />
        <label for="productioncode"></label>
        <input name="productioncode" type="text" id="productioncode" value="<?php echo $row_Recordset1['projectcode']."-".$row_Recordset1['productioncode']; ?>" />
        <input type="text" name="id_department4" id="id_department4" value="eng" />
        <br />
        <input name="progress_eng" type="text" value="100" size="10" />
        %
        <input type="checkbox" name="drawingc" id="drawingc" />
        Complete
        <input type="submit" name="submit9" id="submit4" value="Submit" />
        <input type="hidden" name="MM_update" value="form1" />
        </p>
    </form></td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($pg);

mysql_free_result($Recordset1);
?>
