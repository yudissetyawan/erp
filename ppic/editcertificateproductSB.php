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
	include "../dateformat_funct.php";
	if (functyyyymmdd($_POST['expired_date']) <= date("Y-m-d")) {
		$status_eqp = "0";
	} else if (functyyyymmdd($_POST['expired_date']) > date("Y-m-d")) {
		$status_eqp = "1";
	}
	
  $updateSQL = sprintf("UPDATE p_certificate_product SET id_category_product=%s, name_of_equipment=%s, tag_serial_number=%s, length_mm=%s, height_mm=%s, width_mm=%s, tare_weight_kg=%s, SWL_kg=%s, gross_weight_kg=%s, inspection_date=%s, expired_date=%s, location=%s, issued_by=%s, exist_date=%s, issued_user=%s, no_certificate=%s, status=%s WHERE id_certificate=%s",
                       GetSQLValueString($_POST['id_category_product'], "int"),
                       GetSQLValueString($_POST['name_of_equipment'], "text"),
                       GetSQLValueString($_POST['tag_serial_number'], "text"),
                       GetSQLValueString($_POST['length_mm'], "double"),
                       GetSQLValueString($_POST['height_mm'], "double"),
                       GetSQLValueString($_POST['width_mm'], "double"),
                       GetSQLValueString($_POST['tare_weight_kg'], "double"),
                       GetSQLValueString($_POST['SWL_kg'], "double"),
                       GetSQLValueString($_POST['gross_weight_kg'], "double"),
                       GetSQLValueString(functyyyymmdd($_POST['inspection_date']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['expired_date']), "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['issued_by'], "text"),
					   GetSQLValueString(date("Y-m-d"), "text"),
					   GetSQLValueString($_SESSION['empID'], "text"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
					   GetSQLValueString($status_eqp, "text"),
                       GetSQLValueString($_POST['id_certificate'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
  $updateGoTo = "viewcertificateproductSB.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if ($_POST['nama_fileps'] == '') {
		$nfile = $_POST['nama_fileps2'];
	} else {
		$nfile = $_POST['nama_fileps'];
	}
	/* echo "<script>alert(\"$nfile\");</script>"; */

  $updateSQL = sprintf("UPDATE dms SET fileupload=%s, keterangan=%s WHERE id=%s AND idms=%s AND id_departemen=%s",
                       GetSQLValueString($nfile, "text"),
                       GetSQLValueString($_POST['name_of_equipment'], "text"),
                       GetSQLValueString($_POST['idms'], "int"),
                       GetSQLValueString($_POST['id_certificate'], "text"),
                       GetSQLValueString($_POST['id_departemen'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT p_certificate_product.*, dms.idms, dms.fileupload, dms.id, dms.id_departemen FROM p_certificate_product, dms WHERE p_certificate_product.id_category_product='1' AND dms.keterangan=p_certificate_product.name_of_equipment AND dms.id_departemen = 'QC' AND dms.idms=p_certificate_product.id_certificate AND p_certificate_product.id_certificate = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$vusr = $row_Recordset1['issued_user'];
mysql_select_db($database_core, $core);
$query_rsusr = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vusr'";
$rsusr = mysql_query($query_rsusr, $core) or die(mysql_error());
$row_rsusr = mysql_fetch_assoc($rsusr);
$totalRows_rsusr = mysql_num_rows($rsusr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Certificate of Sand Basket</title>
</head>

<body>
<?php
	{ include "uploads.php"; include "../date.php"; include "../dateformat_funct.php"; }
	if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'qly') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'project')) {
		$vhidden = '';
		$vdisabled = '';
	} else {
		$vhidden = 'hidden';
		$vdisabled = 'disabled';
	}
?>

<label style="font-weight:bold" <?php echo $vhidden; ?> >Edit Certificate of Sand Basket</label>
<br /><br />

<table width="494" border="0" cellpadding="2" cellspacing="2" <?php echo $vhidden; ?>>
  <tr>
    <td colspan="3"><input type="hidden" name="idmsps" id="idmsps" value="<?php echo $row_recordset1['idms'];?>" /></td>
  </tr>
  <tr>
    <td width="100">Attachment File</td>
    <td width="3">:</td>
    <td width="366" >
    	<form method="post" enctype="multipart/form-data" name="form" class="General" id="form" >
          <input name="fileps" type="file" style="cursor:pointer;" />
          <input type="submit" name="submit1" value="Upload" />
        </form>
    </td>
  </tr>
</table>

<br />
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table>
    <tr valign="middle">
      <td colspan="6" align="left">
      	<input name="id_category_product" type="hidden" value="<?php echo $row_Recordset1['id_category_product']; ?>" />
   	    <input name="id_certificate" type="hidden" id="id_certificate" value="<?php echo $row_Recordset1['id_certificate']; ?>" />
      <input name="idms" type="hidden" id="idms" value="<?php echo $row_Recordset1['id']; ?>" /></td>
    </tr>
    <tr valign="middle">
      <td align="left">Certificate No.</td>
      <td align="left">:</td>
      <td><input type="text" name="no_certificate" value="<?php echo $row_Recordset1['no_certificate']; ?>" size="32" <?php echo $vdisabled; ?> /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td>Name of Equipment</td>
      <td>:</td>
      <td><textarea name="name_of_equipment" cols="40" <?php echo $vdisabled; ?> ><?php echo $row_Recordset1['name_of_equipment']; ?></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td>Tag Serial Number</td>
      <td>:</td>
      <td><textarea name="tag_serial_number" cols="40" <?php echo $vdisabled; ?> ><?php echo $row_Recordset1['tag_serial_number']; ?></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td colspan="6" align="left">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td align="left"><b>Specification</b></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><b>Validation Date</b></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td align="left">Length (mm)</td>
      <td align="left">:</td>
      <td><input type="text" name="length_mm" value="<?php echo $row_Recordset1['length_mm']; ?>" size="8" <?php echo $vdisabled; ?> /></td>
      <td align="left">Inspection Date</td>
      <td align="left">:</td>
      <td><input type="text" name="inspection_date" value="<?php echo functddmmmyyyy($row_Recordset1['inspection_date']); ?>" size="15" id="tanggal8" <?php echo $vdisabled; ?> /></td>
    </tr>
    <tr valign="middle">
      <td align="left">Height (mm)</td>
      <td align="left">:</td>
      <td><input type="text" name="height_mm" value="<?php echo $row_Recordset1['height_mm']; ?>" size="8" <?php echo $vdisabled; ?> /></td>
      <td align="left">Expired Date</td>
      <td align="left">:</td>
      <td><input type="text" name="expired_date" value="<?php echo functddmmmyyyy($row_Recordset1['expired_date']); ?>" size="15" id="tanggal9" <?php echo $vdisabled; ?> /></td>
    </tr>
    <tr valign="middle">
      <td align="left">Width (mm)</td>
      <td align="left">:</td>
      <td><input type="text" name="width_mm" value="<?php echo $row_Recordset1['width_mm']; ?>" size="8" <?php echo $vdisabled; ?> /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td align="left">Tare Weight (kg)</td>
      <td align="left">:</td>
      <td><input type="text" name="tare_weight_kg" value="<?php echo $row_Recordset1['tare_weight_kg']; ?>" size="8" <?php echo $vdisabled; ?> /></td>
      <td align="left">Issued By</td>
      <td align="left">:</td>
      <td><input type="text" name="issued_by" value="<?php echo $row_Recordset1['issued_by']; ?>" size="45" <?php echo $vdisabled; ?> /></td>
    </tr>
    <tr valign="middle">
      <td align="left">SWL (kg)</td>
      <td align="left">:</td>
      <td><input type="text" name="SWL_kg" value="<?php echo $row_Recordset1['SWL_kg']; ?>" size="8" <?php echo $vdisabled; ?> /></td>
      <td align="left">Location</td>
      <td align="left">:</td>
      <td><input type="text" name="location" value="<?php echo $row_Recordset1['location']; ?>" size="45" <?php echo $vdisabled; ?> /></td>
    </tr>
    <tr valign="middle">
      <td align="left">Gross Weight (kg)</td>
      <td align="left">:</td>
      <td><input type="text" name="gross_weight_kg" value="<?php echo $row_Recordset1['gross_weight_kg']; ?>" size="8" <?php echo $vdisabled; ?> /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td colspan="6" align="right"><input type="submit" value="Save" style="cursor:pointer" <?php echo $vhidden; ?> /></td>
    </tr>
    <tr valign="middle">
      <td colspan="6" align="right">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td align="left"><b><i>Last Entry/Modified</i></b></td>
      <td align="left"><b><i>on</i></b></td>
      <td colspan="4"><b><?php echo functddmmmyyyy($row_Recordset1['exist_date']); ?></b></td>
    </tr>
    <tr valign="middle">
      <td align="right">&nbsp;</td>
      <td align="left"><b><i>by</i></b></td>
      <td colspan="4"><b><?php echo $row_rsusr['fname']; ?> <?php echo $row_rsusr['mname']; ?> <?php echo $row_rsusr['lname']; ?></b></td>
    </tr>
  </table>
  <p>
    <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
        <input name="nama_fileps2" type="hidden" id="nama_fileps2" value="<?php echo $row_Recordset1['fileupload']; ?>"/>    
    <input name="id_departemen" type="hidden" id="id_departemen" value="<?php echo $row_Recordset1['id_departemen']; ?>"/>
  </p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($rsusr);
?>