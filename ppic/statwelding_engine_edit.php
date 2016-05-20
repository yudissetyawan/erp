<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE p_statusengine SET merk=%s, thn_prod=%s, no_mesin=%s, serial_no=%s, skid_no=%s, lokasi=%s, owner=%s, engine_condition=%s, project=%s, kode_proyek=%s, keterangan=%s, status=%s, issued_user=%s, last_update=%s WHERE id=%s",
                       GetSQLValueString($_POST['merk'], "text"),
                       GetSQLValueString($_POST['thn_prod'], "int"),
                       GetSQLValueString($_POST['no_mesin'], "text"),
                       GetSQLValueString($_POST['sn'], "text"),
                       GetSQLValueString($_POST['skid_no'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['engine_condition'], "text"),
                       GetSQLValueString($_POST['project'], "text"),
                       GetSQLValueString($_POST['kd_project'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_SESSION['empID'], "text"),
					   GetSQLValueString(date("Y-m-d"), "text"),
					   GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "status_welding_engine.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rswldengine = "-1";
if (isset($_GET['data'])) {
  $colname_rswldengine = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rswldengine = sprintf("SELECT * FROM p_statusengine WHERE id = %s", GetSQLValueString($colname_rswldengine, "int"));
$rswldengine = mysql_query($query_rswldengine, $core) or die(mysql_error());
$row_rswldengine = mysql_fetch_assoc($rswldengine);
$totalRows_rswldengine = mysql_num_rows($rswldengine);

$vusr = $row_rswldengine['issued_user'];
mysql_select_db($database_core, $core);
$query_rsusr = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vusr'";
$rsusr = mysql_query($query_rsusr, $core) or die(mysql_error());
$row_rsusr = mysql_fetch_assoc($rsusr);
$totalRows_rsusr = mysql_num_rows($rsusr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Status of Welding Engine</title>
</head>

<body>
<?php { include "uploads.php"; } ?>
<b>Edit Status of Welding Engine</b><br><br>

<table border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3"><input type="hidden" name="idmsps" id="idmsps" value="<?php echo $row_recordset1['idms'];?>" />
  </tr>
  <tr>
    <td width="120"><b>Attachment File</b></td>
    <td width="20">:</td>
    <td width="336" ><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit1" value="Upload" />
    </form></td>
  </tr>
</table>
<br><br>

<form action="<?php echo $editFormAction; ?>"  method="POST" name="form1" class="General" id="form1">
  <table border="0">
    
    <tr>
      <td width="120" class="General">Brand</td>
      <td width="20">:</td>
      <td width="337"><label for="merk"></label>
      <input name="merk" type="text" id="merk" value="<?php echo $row_rswldengine['merk']; ?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $row_rswldengine['id']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Year of Production</td>
      <td>:</td>
      <td><input name="thn_prod" type="text" size="4" maxlength="4" id="thn_prod" value="<?php echo $row_rswldengine['thn_prod']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Engine No.</td>
      <td>:</td>
      <td><input name="no_mesin" type="text" id="no_mesin" value="<?php echo $row_rswldengine['no_mesin']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Serial No. </td>
      <td>:</td>
      <td><input name="sn" type="text" id="sn" value="<?php echo $row_rswldengine['serial_no']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">SKID No. </td>
      <td>:</td>
      <td><input name="skid_no" type="text" id="skid_no" value="<?php echo $row_rswldengine['skid_no']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td><input name="lokasi" type="text" id="lokasi" value="<?php echo $row_rswldengine['lokasi']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Owner</td>
      <td>:</td>
      <td><input name="owner" type="text" id="owner" value="<?php echo $row_rswldengine['owner']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Condition</td>
      <td>:</td>
      <td><input name="condition" type="text" id="condition" value="<?php echo $row_rswldengine['engine_condition']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Project</td>
      <td>:</td>
      <td><input name="project" type="text" id="project" value="<?php echo $row_rswldengine['project']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td><input name="kd_project" size="20" type="text" id="kd_project" value="<?php echo $row_rswldengine['kode_proyek']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Notes</td>
      <td>:</td>
      <td><textarea name="keterangan" id="keterangan" cols="40"><?php echo $row_rswldengine['keterangan']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Status</td>
      <td>:</td>
      <td>
      <?php if ($row_rswldengine['status'] == 'Rental') {
		  echo '<input type="radio" name="status" id="Rental" value="Rental" checked="checked" /><label for="Rental"><b>Rental</b></label>
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	<input type="radio" name="status" id="Bukaka Property" value="Bukaka Property" /><label for="Property"><b>Property of PT. Bukaka Teknik Utama</b></label>';
	  } else {
		  echo '<input type="radio" name="status" id="Rental" value="Rental" /><label for="Rental"><b>Rental</b></label>
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	<input type="radio" name="status" id="Bukaka Property" value="Bukaka Property" checked="checked" /><label for="Property"><b>Property of PT. Bukaka Teknik Utama</b></label>';
	  }?>
      </td>
    </tr>
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="right" class="General"><input type="submit" name="Save" id="Save" value="Save" /></td>
    </tr>
    <tr>
      <td><b><i>Last Entry/Updated</i></b></td>
      <td><b><i>on</i></b></td>
      <td><b><?php { include "../dateformat_funct.php"; } echo functddmmmyyyy($row_rswldengine['last_update']); ?></b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><b><i>by</i></b></td>
      <td><b><?php echo $row_rsusr['fname']; ?> <?php echo $row_rsusr['mname']; ?> <?php echo $row_rsusr['lname']; ?></b></td>
    </tr>
  </table>
  <p>
    <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_departemen" type="hidden" id="id_departemen" value="PPIC"/>
    <label for="idms"></label>
    <input type="hidden" name="idms" id="idms" value="<?php echo $nextpracode; ?>" />
  </p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($rswldengine);
	mysql_free_result($rsusr);
?>