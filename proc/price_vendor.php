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

mysql_select_db($database_core, $core);
$query_price_vendor = "SELECT id, itemno, unitprice FROM c_po_core";
$price_vendor = mysql_query($query_price_vendor, $core) or die(mysql_error());
$row_price_vendor = mysql_fetch_assoc($price_vendor);
$totalRows_price_vendor = mysql_num_rows($price_vendor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0">
  <tr class="tabel_header">
    <td>No</td>
    <td>Nama Barang</td>
    <td>Price</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body">
      <td><?php echo $row_price_vendor['id']; ?></td>
      <td><?php echo $row_price_vendor['itemno']; ?></td>
      <td><?php echo $row_price_vendor['unitprice']; ?></td>
    </tr>
    <?php } while ($row_price_vendor = mysql_fetch_assoc($price_vendor)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($price_vendor);
?>
