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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include "../dateformat_funct.php";
	if (functyyyymmdd($_POST['expired_date']) <= date("Y-m-d")) {
		$status_eqp = "0";
	} else if (functyyyymmdd($_POST['expired_date']) > date("Y-m-d")) {
		$status_eqp = "1";
	}
	
  $insertSQL = sprintf("INSERT INTO p_certificate_product (id_category_product, name_of_equipment, tag_serial_number, brand, type, WLL_tons, inspection_date, expired_date, location, issued_by, exist_date, issued_user, no_certificate, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_category_product'], "int"),
                       GetSQLValueString($_POST['name_of_equipment'], "text"),
                       GetSQLValueString($_POST['tag_serial_number'], "text"),
                       GetSQLValueString($_POST['brand'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['WLL_tons'], "double"),
                       GetSQLValueString(functyyyymmdd($_POST['inspection_date']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['expired_date']), "text"),
					   GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['issued_by'], "text"),
					   GetSQLValueString(date("Y-m-d"), "text"),
					   GetSQLValueString($_SESSION['empID'], "text"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
					   GetSQLValueString($status_eqp, "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewcertificateproductCB.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, inisial_pekerjaan, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idms'], "text"),
                       GetSQLValueString($_POST['id_departemen'], "text"),
                       GetSQLValueString($_POST['id_category_product'], "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"),
                       GetSQLValueString($_POST['name_of_equipment'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}
$year=date(y);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM p_certificate_product ORDER BY id_certificate DESC LIMIT 1"));
$cekQ=$ceknomor[id_certificate];
$next=$cekQ+1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Certificate of Chain Block</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body onLoad="document.form1.no_certificate.focus();" class="General">
<?php
	$vidcat = $_GET['data'];
	{ include "../date.php"; include "uploads.php"; } 
?>
<b>Entry Certificate of Chain Block</b>
<br><br>

<form action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table>
    <tr valign="middle">
      <td colspan="3" align="left">
      	<input name="id_category_product" type="hidden" value="<?php echo $vidcat; ?>" />
      </td>
    </tr>
    <tr valign="middle">
      <td align="left">Certificate No.</td>
      <td align="left">:</td>
      <td><input type="text" name="no_certificate" value="" size="32" /></td>
    </tr>
    <tr valign="middle">
      <td>Name of Equipment</td>
      <td>:</td>
      <td><textarea name="name_of_equipment" cols="40"></textarea></td>
    </tr>
    <tr valign="middle">
      <td>Tag Serial Number</td>
      <td>:</td>
      <td><textarea name="tag_serial_number" cols="40"></textarea></td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="left">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="left"><b>Specification</b></td>
    </tr>
    <tr valign="middle">
      <td align="left">Brand</td>
      <td align="left">:</td>
      <td><input type="text" name="brand" value="" size="20" /></td>
    </tr>
    <tr valign="middle">
      <td align="left">Type</td>
      <td align="left">:</td>
      <td><input type="text" name="type" value="" size="20" /></td>
    </tr>
    <tr valign="middle">
      <td align="left">WLL (tons)</td>
      <td align="left">:</td>
      <td><input type="text" name="WLL_tons" value="" size="8" /></td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="left">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="left"><b>Validation Date</b></td>
    </tr>
    <tr valign="middle">
      <td align="left">Inspection Date</td>
      <td align="left">:</td>
      <td><input type="text" name="inspection_date" value="" size="20" id="tanggal8" /></td>
    </tr>
    <tr valign="middle">
      <td align="left">Expired Date</td>
      <td align="left">:</td>
      <td><input type="text" name="expired_date" value="" size="20" id="tanggal9" /></td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="left">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td align="left">Issued By</td>
      <td align="left">:</td>
      <td><input type="text" name="issued_by" value="" size="40" /></td>
    </tr>
    <tr valign="middle">
      <td align="left">Location</td>
      <td align="left">:</td>
      <td><input type="text" name="location" value="" size="40" /></td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="right" nowrap="nowrap">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="center" nowrap="nowrap"><input type="submit" value="Save" style="cursor:pointer" /></td>
    </tr>
  </table>
  <p>
    <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_departemen" type="hidden" id="id_departemen" value="QC"/>
    <input type="hidden" name="idms" id="idms" value="<?php echo $next; ?>" />
  </p>
<input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>