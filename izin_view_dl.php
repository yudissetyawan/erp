<?php require_once('Connections/core.php'); ?>
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

$colname_h_dinasluar = "-1";
if (isset($_GET['data'])) {
  $colname_h_dinasluar = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_dinasluar = sprintf("SELECT h_dinasluar.*, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_dinasluar, h_employee WHERE h_dinasluar.id_employee = %s AND h_dinasluar.id_employee = h_employee.id", GetSQLValueString($colname_h_dinasluar, "int"));
$h_dinasluar = mysql_query($query_h_dinasluar, $core) or die(mysql_error());
$row_h_dinasluar = mysql_fetch_assoc($h_dinasluar);
$totalRows_h_dinasluar = mysql_num_rows($h_dinasluar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<h3><a href="#" onclick="MM_openBrWindow('izin_input_dl.php','Form Dinas Luar','scrollbars=yes,width=500,height=465')">Dinas Luar</a></h3>
<table width="" border="0">
  <tr class="tabel_header">
    <td colspan="7"><?php echo $row_h_dinasluar['nik']; ?> - <?php echo $row_h_dinasluar['firstname']; ?> <?php echo $row_h_dinasluar['midlename']; ?> <?php echo $row_h_dinasluar['lastname']; ?></td>
  </tr>
  <tr class="tabel_header">
    <td width="17">No</td>
    
    <td width="139">Tanggal</td>
    <td width="373">Keperluan</td>
    <td width="">&nbsp;</td>
    
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1; ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><?php echo $row_h_dinasluar['tanggal']; ?></td>
      <td><?php echo $row_h_dinasluar['keperluan']; ?></td>
      <td><a href="#" onclick="MM_openBrWindow('izin_edit_dl.php?data=<?php echo $row_h_dinasluar['id']; ?>','Edit Dinas Luar','scrollbars=yes,width=500,height=476')">EDIT</a></td>
    </tr>
    <?php } while ($row_h_dinasluar = mysql_fetch_assoc($h_dinasluar)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($h_dinasluar);
?>
