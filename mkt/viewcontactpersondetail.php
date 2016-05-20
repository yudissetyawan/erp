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
$query_Recordset1 = sprintf("SELECT * FROM a_contactperson WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM masterkey WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
<table width="200" border="0">
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>Departemen</td>
    <td>No. Telepon </td>
    <td>Email</td>
    <td>Alamat</td>
  </tr>
  <tr><?php $a = $a+1 ?>
    <td><?php $a ?></td>
    <td><?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
    <td><?php echo $row_Recordset1['department']; ?></td>
    <td><?php echo $row_Recordset1['phone1']; ?> / <?php echo $row_Recordset1['phone2']; ?></td>
    <td><?php echo $row_Recordset1['email']; ?></td>
    <td><?php echo $row_Recordset1['address']; ?></td>
  </tr>
</table>
<a href="<?php echo $row_Recordset2['../location']; ?>?data=1">back</a> 