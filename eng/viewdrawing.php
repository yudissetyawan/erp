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
$query_Recordset1 = "SELECT * FROM e_drawing_file";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<p>List Drawing file</p>
<p><a href="../inputdrawing.php">Upload New Drawing File</a></p>
<table width="686" border="0">
  <tr class="tabel_header">
    <td width="152">Drawing No</td>
    <td width="126">Title</td>
    <td width="120">Revisi</td>
    <td width="115">date</td>
    <td width="151">File</td>
  </tr>
<?php do { ?>
  <form id="form1" name="form1" method="post" action="">
  <tr>
    <td><span class="tabel_body"><?php echo $row_Recordset1['drawingno']; ?></span></td>
    <td><span class="tabel_body"><?php echo $row_Recordset1['title']; ?></span></td>
    <td><span class="tabel_body"><?php echo $row_Recordset1['revisi']; ?></span></td>
    <td><span class="tabel_body"><?php echo $row_Recordset1['date']; ?></span></td>
    <td><span class="tabel_body"><a href="upload/drawing/<?php echo $row_Recordset1['location']; ?>" class="tabel_body">View</a></span></td>
  </tr>
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

  <p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
