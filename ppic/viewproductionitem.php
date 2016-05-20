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
$query_Recordset1 = sprintf("SELECT * FROM a_production_item WHERE productioncode = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<p class="General">Production Item for Production <?php echo $row_Recordset2['productioncode']; ?></p>
<p class="General"><a href="inputproductionitem.php?data=<?php echo $row_Recordset2['id']; ?>">Input Production Item</a></p>

  <table width="624" border="0">
    <tr class="tabel_header">
      <td>Item Description
      </td>
      <td>QTY</td>
      <td>Amount</td>
    </tr>
<?php do { ?>
    <form id="form1" name="form1" method="post" action="">
      <tr class="tabel_body">
        <td class="tabel_body"><?php echo $row_Recordset1['itemdescription']; ?></td>
        <td class="tabel_body"><?php echo $row_Recordset1['qty']; ?><?php echo $row_Recordset1['satuan']; ?></td>
        <td class="tabel_body"><?php echo $row_Recordset1['amount']; ?></td>
      </tr>
    </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  
<p>&nbsp;</p>
<span class="General">
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
</span>