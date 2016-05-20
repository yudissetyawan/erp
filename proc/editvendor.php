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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	include "../dateformat_funct.php";
  $updateSQL = sprintf("UPDATE c_vendor SET vendorname=%s, vendoraddress=%s, city=%s, zip=%s, `state`=%s, country=%s, officephone=%s, mobilephone=%s, fax=%s, email=%s, email_2=%s, contactperson=%s, contactperson_2=%s, company_profile=%s, registrationdate=%s, product_service=%s, evaluationdate=%s, `result`=%s, remark=%s, npwpno=%s, vendorclass=%s, vendorcategory=%s WHERE id=%s",
                       GetSQLValueString($_POST['vendorname'], "text"),
                       GetSQLValueString($_POST['vendoraddress'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['officephone'], "text"),
                       GetSQLValueString($_POST['mobilephone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['email2'], "text"),
                       GetSQLValueString($_POST['contactperson'], "text"),
                       GetSQLValueString($_POST['contactperson2'], "text"),
                       GetSQLValueString($_POST['companyprofile'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['registrationdate']), "text"),
                       GetSQLValueString($_POST['product_service'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['evaluationdate']), "text"),
                       GetSQLValueString($_POST['result'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['npwpno'], "text"),
                       GetSQLValueString($_POST['vendorclasses'], "text"),
                       GetSQLValueString($_POST['vendorcategory'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "viewvendordetail.php?data=" . $row_Recordset1['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c_vendor.*, c_vendorcatg.category FROM c_vendor, c_vendorcatg WHERE c_vendor.id = %s AND c_vendor.vendorcategory=c_vendorcatg.id", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_rsvendorcatg = "SELECT * FROM c_vendorcatg";
$rsvendorcatg = mysql_query($query_rsvendorcatg, $core) or die(mysql_error());
$row_rsvendorcatg = mysql_fetch_assoc($rsvendorcatg);
$totalRows_rsvendorcatg = mysql_num_rows($rsvendorcatg);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Vendor</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>
</head>

<body class="General">
<h3>Edit Data Vendor</h3>

<?php {  include "../date.php"; include "../dateformat_funct.php"; } ?>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="1000" cellpadding="2" cellspacing="2">
    <tr>
      <td>Vendor Name</td>
      <td>:</td>
      <td>
      <input name="vendorname" type="text" id="vendorname" size="40" value="<?php echo $row_Recordset1['vendorname']; ?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="150">Address</td>
      <td width="8">:</td>
      <td width="350">
      	<textarea name="vendoraddress" id="vendoraddress" rows="3" cols="35"><?php echo $row_Recordset1['vendoraddress']; ?></textarea>
      </td>
      <td width="150">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="180">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">City</td>
      <td align="center">:</td>
      <td><input name="city" type="text" id="city" value="<?php echo $row_Recordset1['city']; ?>" /></td>
      <td>Company Profile</td>
      <td align="center">:</td>
      <td><label for="companyprofile"></label>
        <input name="companyprofile" type="text" id="companyprofile" value="<?php echo $row_Recordset1['company_profile']; ?>" /></td>
    </tr>
    <tr>
      <td align="right">Zip</td>
      <td align="center">:</td>
      <td><input name="zip" type="text" id="zip" value="<?php echo $row_Recordset1['zip']; ?>" /></td>
      <td>Registration Date</td>
      <td align="center">:</td>
      <td><label for="registrationdate"></label>
        <input name="registrationdate" type="text" id="tanggal8" value="<?php echo functddmmmyyyy($row_Recordset1['registrationdate']); ?>" /></td>
    </tr>
    <tr>
      <td align="right">State, Country</td>
      <td align="center">:</td>
      <td><input name="state" type="text" id="state" value="<?php echo $row_Recordset1['state']; ?>" />
      ,
        <input name="country" type="text" id="country" value="<?php echo $row_Recordset1['country']; ?>" /></td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Product / Service</td>
      <td align="center">:</td>
      <td><input name="product_service" type="text" id="product_service" size="30" value="<?php echo $row_Recordset1['product_service']; ?>" /></td>
    </tr>
    <tr>
      <td>Office / Mobile  Phone</td>
      <td>:</td>
      <td><label for="officephone"></label>
        <input name="officephone" type="text" id="officephone" value="<?php echo $row_Recordset1['officephone']; ?>" /> 
        / 
        <label for="mobilephone"></label>
      <input name="mobilephone" type="text" id="mobilephone" value="<?php echo $row_Recordset1['mobilephone']; ?>" /></td>
      <td>Evaluation Date</td>
      <td align="center">:</td>
      <td><input name="evaluationdate" type="text" id="tanggal9" value="<?php echo functddmmmyyyy($row_Recordset1['evaluationdate']); ?>" /></td>
    </tr>
    <tr>
      <td>Fax</td>
      <td align="center">:</td>
      <td><input name="fax" type="text" id="fax" value="<?php echo $row_Recordset1['fax']; ?>" /></td>
      <td>Result</td>
      <td align="center">:</td>
      <td><input name="result" type="text" id="result" value="<?php echo $row_Recordset1['result']; ?>" /></td>
    </tr>
    <tr>
      <td>Email 1</td>
      <td>:</td>
      <td><label for="email"></label>
      <input name="email" type="text" id="email" value="<?php echo $row_Recordset1['email']; ?>" /></td>
      <td>Remark</td>
      <td align="center">:</td>
      <td><label for="note"></label>
      <textarea name="remark" id="remark" rows="3" cols="30"><?php echo $row_Recordset1['remark']; ?></textarea></td>
    </tr>
    <tr>
      <td>Email 2</td>
      <td>&nbsp;</td>
      <td valign="top"><input name="email2" type="text" id="email2" value="<?php echo $row_Recordset1['email_2']; ?>" /></td>
      <td>NPWP No.</td>
      <td align="center">:</td>
      <td><label for="npwpno"></label>
        <input name="npwpno" type="text" id="npwpno" value="<?php echo $row_Recordset1['npwpno']; ?>" /></td>
    </tr>
    <tr>
      <td>Contact Person</td>
      <td>:</td>
      <td><label for="contactperson"></label>
        <input name="contactperson" type="text" id="contactperson" value="<?php echo $row_Recordset1['contactperson']; ?>" /></td>
      <td>Vendor Class</td>
      <td align="center">:</td>
      <td><select name="vendorclasses" id="vendorclasses" class="required" title="Pilih Vendor Class Terlebih Dahulu">
        <option value="<?php echo $row_Recordset1['vendorclass']; ?>"><?php echo $row_Recordset1['vendorclass']; ?></option>
        <option value="Supplier">Supplier</option>
        <option value="Sub Contractor">Sub Contractor</option>
      </select></td>
    </tr>
    <tr>
      <td>Contact Person 2</td>
      <td>&nbsp;</td>
      <td><input name="contactperson2" type="text" id="contactperson2" value="<?php echo $row_Recordset1['contactperson_2']; ?>" /></td>
      <td>Vendor Category</td>
      <td align="center">:</td>
      <td><select name="vendorcategory" id="vendorcategory">
        <option value="<?php echo $row_Recordset1['vendorcategory']; ?>"><?php echo $row_Recordset1['category']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsvendorcatg['id']?>"><?php echo $row_rsvendorcatg['category']?></option>
        <?php
} while ($row_rsvendorcatg = mysql_fetch_assoc($rsvendorcatg));
  $rows = mysql_num_rows($rsvendorcatg);
  if($rows > 0) {
      mysql_data_seek($rsvendorcatg, 0);
	  $row_rsvendorcatg = mysql_fetch_assoc($rsvendorcatg);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="right">
      <input type="hidden" name="id" id="id" value="<?php echo $_GET['data']; ?>" />
      <input type="submit" name="submit" id="submit" value="Update" /></td>
    </tr>
    
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsvendorcatg);
?>
