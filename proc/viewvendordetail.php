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

$colname_rsvendor = "-1";
if (isset($_GET['data'])) {
  $colname_rsvendor = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsvendor = sprintf("SELECT c_vendor.*, c_vendorcatg.category FROM c_vendor, c_vendorcatg WHERE c_vendor.id = %s AND c_vendorcatg.id =c_vendor.vendorcategory", GetSQLValueString($colname_rsvendor, "int"));
$rsvendor = mysql_query($query_rsvendor, $core) or die(mysql_error());
$row_rsvendor = mysql_fetch_assoc($rsvendor);
$totalRows_rsvendor = mysql_num_rows($rsvendor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detail Data Vendor</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php require_once "../dateformat_funct.php"; ?>
<p><a href="editvendor.php?data=<?php echo $row_rsvendor['id']; ?>" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-pencil"></span>Edit Data Vendor</a></p>

<table width="500">
  <tr>
    <td colspan="3" align="center"><h2><?php echo $row_rsvendor['vendorname']; ?></h2></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="120">Address</td>
    <td width="20" align="center">:</td>
    <td><?php echo $row_rsvendor['vendoraddress']; ?></td>
  </tr>
  <tr>
    <td align="right">City</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['city']; ?></td>
  </tr>
  <tr>
    <td align="right">Zip</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['zip']; ?></td>
  </tr>
  <tr>
    <td align="right">State</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['state']; ?></td>
  </tr>
  <tr>
    <td align="right">Country</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['country']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Office / Mobile  Phone</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['officephone']; ?> / <?php echo $row_rsvendor['mobilephone']; ?></td>
  </tr>
  <tr>
    <td>Fax</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['fax']; ?></td>
  </tr>
  <tr>
    <td>Email</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['email']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $row_rsvendor['email_2']; ?></td>
  </tr>
  <tr>
    <td>Contact Person</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['contactperson']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $row_rsvendor['contactperson_2']; ?></td>
  </tr>
  <tr>
    <td>Company Profile</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['company_profile']; ?></td>
  </tr>
  <tr>
    <td>Registration Date</td>
    <td align="center">:</td>
    <td><?php echo functddmmmyyyy($row_rsvendor['registrationdate']); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Product / Service</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['product_service']; ?></td>
  </tr>
  <tr>
    <td>Evaluation Date</td>
    <td align="center">:</td>
    <td><?php echo functddmmmyyyy($row_rsvendor['evaluationdate']); ?></td>
  </tr>
  <tr>
    <td>Result</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['result']; ?></td>
  </tr>
  <tr>
    <td>Remark</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['remark']; ?></td>
  </tr>
  <tr>
    <td>NPWP No.</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['npwpno']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Vendor Class</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['vendorclass']; ?></td>
  </tr>
  <tr>
    <td>Vendor Category</td>
    <td align="center">:</td>
    <td><?php echo $row_rsvendor['category']; ?></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($rsvendor);
?>
