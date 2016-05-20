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

$colname_q_ccomplaint = "-1";
if (isset($_GET['data'])) {
  $colname_q_ccomplaint = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_q_ccomplaint = sprintf("SELECT * FROM q_ccomplaint WHERE id = %s", GetSQLValueString($colname_q_ccomplaint, "int"));
$q_ccomplaint = mysql_query($query_q_ccomplaint, $core) or die(mysql_error());
$row_q_ccomplaint = mysql_fetch_assoc($q_ccomplaint);
$totalRows_q_ccomplaint = mysql_num_rows($q_ccomplaint);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="444" border="0">
  <tr class="tabel_header">
    <td colspan="3">Costumer Complaint about <?php echo $row_q_ccomplaint['title_complaint']; ?></td>
  </tr>
  <tr>
    <td width="145">Date</td>
    <td width="13">:</td>
    <td width="222"><?php echo $row_q_ccomplaint['tanggal']; ?></td>
  </tr>
  <tr>
    <td>Complaint</td>
    <td>:</td>
    <td><?php echo $row_q_ccomplaint['complaint']; ?></td>
  </tr>
  <tr>
    <td>Complaint By</td>
    <td>:</td>
    <td><?php echo $row_q_ccomplaint['complaint_by']; ?></td>
  </tr>
  <tr>
    <td>Complaint Via</td>
    <td>:</td>
    <td><?php echo $row_q_ccomplaint['compalint_via']; ?></td>
  </tr>
  <tr>
    <td>Status CPAR</td>
    <td>:</td>
    <td><?php echo $row_q_ccomplaint['status_cpar']; ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($q_ccomplaint);
?>
