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
$query_Recordset1 = sprintf("SELECT a_wip_header.id, a_proj_code.contractno, a_proj_code.projectvalue FROM a_wip_header, a_proj_code WHERE a_wip_header.id = %s AND a_proj_code.id = a_wip_header.contractno", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT a_wip_core.id, a_wip_core.`description`, a_wip_core.wipheader, a_wip_core.invoicesubtotal, a_wip_core.ballance, a_wip_core.workprogressvalue, a_wip_core.workprogresspercentage, a_wip_core.invoicepercentage, a_wip_core.wipvalue, a_wip_core.wippercentage, a_production_code.wrno, a_production_code.budget FROM a_wip_core, a_production_code WHERE wipheader = %s AND a_production_code.id = a_wip_core.wrno", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<p>Detail Work Status  for Contract <?php echo $row_Recordset1['contractno']; ?></p>
<p><a href="inputwipdetail.php?data=<?php echo $row_Recordset1['id']; ?>">Input New Detail Work Status</a></p>
    <table width="1617" border="0">
      <tr class="root">
        <td width="105">WR No</td>
        <td width="141">Description</td>
        <td width="120">WR Value</td>
        <td width="163">Invoice Subtotal</td>
        <td width="134">Ballance</td>
        <td width="306">Work Progress Value &amp; Percentage</td>
        <td width="259">Invoice Value &amp; Percentage</td>
        <td width="225">WIP Value &amp; Percentage</td>
        <td width="126">Action</td>
      </tr>
  <?php do { ?>
  <form id="form1" name="form1" method="post" action="">

      <tr class="tabel_body">
        <td><?php echo $row_Recordset2['wrno']; ?></td>
        <td><?php echo $row_Recordset2['description']; ?></td>
        <td><?php echo $row_Recordset2['budget'];  ?></td>
        <td><?php echo $row_Recordset2['invoicesubtotal']; ?></td>
        <td><?php echo $row_Recordset2['budget'] - $row_Recordset2['invoicesubtotal']; ?></td>
        <td><?php echo $row_Recordset2['workprogressvalue']; ?>~ <?php echo $row_Recordset2['workprogresspercentage']; ?> %</td>
        <td><?php echo $row_Recordset2['invoicesubtotal']; ?>~ <?php echo $row_Recordset2['invoicesubtotal'] / $row_Recordset2['budget'] * 100 ; ?> %</td>
        <td><?php echo $row_Recordset2['workprogressvalue'] - $row_Recordset2['invoicesubtotal']; ?> ~ <?php echo $row_Recordset2['workprogresspercentage'] - ($row_Recordset2['invoicesubtotal'] / $row_Recordset2['budget'] * 100) ; ?> %</td>
        <td>Edit | <a href="../viewwipinvoice.php?data=<?php echo $row_Recordset1['id']; ?>&amp;datas=<?php echo $row_Recordset2['id']; ?>">Invoice</a></td>
      </tr>
  </form>
  <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>

      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="tabel_body">sum of detail invoice</td>
        <td class="tabel_body">wr value - invoice subtotal</td>
        <td>&nbsp;</td>
        <td class="tabel_body">sum of detail invoice / wr value for %</td>
        <td class="tabel_body">work progress - invoice</td>
        <td>&nbsp;</td>
      </tr>
    </table>
<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
