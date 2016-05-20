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

$colname_po_sebelumnya = "-1";
if (isset($_GET['data'])) {
  $colname_po_sebelumnya = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_po_sebelumnya = sprintf("SELECT c_po_header.* FROM c_po_header WHERE c_po_header.pono = %s AND c_po_header.activeornot='0'", GetSQLValueString($colname_po_sebelumnya, "text"));
$po_sebelumnya = mysql_query($query_po_sebelumnya, $core) or die(mysql_error());
$row_po_sebelumnya = mysql_fetch_assoc($po_sebelumnya);
$totalRows_po_sebelumnya = mysql_num_rows($po_sebelumnya);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<table width="450" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header">
    <td>No</td>
    <td>No. PO</td>
    <td>Revisi</td>
    <td>Tanggal Update</td>
  </tr>
</thead>
<tbody>  
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><a href="#" onclick="MM_openBrWindow('viewpodetail_ready.php?data=<?php echo $row_po_sebelumnya['id']; ?>','','toolbar=yes,scrollbars=yes,resizable=yes,width=1010,height=0')"><?php echo $row_po_sebelumnya['pono']; ?></a></td>
      <td align="center"><?php echo $row_po_sebelumnya['revisi']; ?></td>
      <td align="center"><?php echo $row_po_sebelumnya['tanggal_update']; ?></td>
    </tr>
    <?php } while ($row_po_sebelumnya = mysql_fetch_assoc($po_sebelumnya)); ?>
</tbody>    
</table>
</body>
</html>
<?php
mysql_free_result($po_sebelumnya);
?>
