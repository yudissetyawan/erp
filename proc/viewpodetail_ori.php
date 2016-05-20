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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c.*, o.materialname, d.unit FROM c_po_core c, c_material o, c_unit d where c.itemno=o.id and c.qty=d.id and poheader = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM c_po_header WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);


$tmpg = "select sum(totalprice) as total from c_po_core where poheader=%s"; // Cari jumlah
$hasil = mysql_query($tmpg); // execute query
$vrb=mysql_fetch_array($hasil); // execute jd array
$panjang = ($vrb["total"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="../js/javauni.min.js"></script>
<link type="text/css" href="../css/jquiuni.css" rel="stylesheet" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<p>PO No	: <?php echo $row_Recordset2['pono']; ?>
</p>
<p>MR No	: <?php echo $row_Recordset2['mrno']; ?></p>
<p>&nbsp;</p>
<p><a href="inputpodetail.php?data=<?php echo $row_Recordset2['id']; ?>&amp;datas=<?php echo $row_Recordset2['mrno']; ?>">add Item PO</a></p>
<p>&nbsp;</p>
<table width="862" border="0">
  <tr class="tabel_header">
    <td width="156">Item Name</td>
    <td width="115">Description</td>
    <td width="210">QTY</td>
    <td width="137">Price / Unit</td>
    <td width="222">Sub Total Price</td>
  </tr>
  <?php do { ?>
  <form id="form1" name="form1" method="post" action="">
  <tr class="tabel_body">
    <td><?php echo $row_Recordset1['materialname']; ?></td>
    <td><?php echo $row_Recordset1['desc']; ?></td>
    <td><?php echo $row_Recordset1['qty']; ?> <?php echo $row_Recordset1['unit']; ?></td>
    <td><?php echo $row_Recordset1['unitprice']; ?></td>
    <td><?php echo $row_Recordset1['totalprice']; ?></td>
  </tr>
  
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="tabel_body">Sum Sub Total Price<?php echo $panjang;?></span></td>
  </tr>
</table>

<div id="dialog" title="Input"><?php /* Div Input */ ?>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
