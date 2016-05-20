<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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

$nama=$_SESSION['empID'];
mysql_select_db($database_core, $core);
$query_rscontact_us = "SELECT * FROM contact_us WHERE name = $nama";
$rscontact_us = mysql_query($query_rscontact_us, $core) or die(mysql_error());
$row_rscontact_us = mysql_fetch_assoc($rscontact_us);
$totalRows_rscontact_us = mysql_num_rows($rscontact_us);mysql_select_db($database_core, $core);
$query_rscontact_us = "SELECT * FROM contact_us WHERE empID = $nama";
$rscontact_us = mysql_query($query_rscontact_us, $core) or die(mysql_error());
$row_rscontact_us = mysql_fetch_assoc($rscontact_us);
$totalRows_rscontact_us = mysql_num_rows($rscontact_us);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0">
  <tr class="tabel_header">
    <td>No</td>
    <td>Email / Phone Number</td>
    <td>Type of Comment</td>
    <td>Time of Comment</td>
    <td>Time of Respond</td>
  </tr>
  <?php do { ?>
  <tr class="tabel_body">
    <?php $a=$a+1; ?>
    <td><?php echo $a; ?></td>
    <td><?php echo $row_rscontact_us['email']; ?> / <?php echo $row_rscontact_us['ph']; ?></td>
    <td align="center"><?php
if($row_rscontact_us['type']=='1'){
echo "Information";
}
elseif ($row_rscontact_us['type']=='2'){
echo "Suggestion";
}
elseif ($row_rscontact_us['type']=='3'){
echo "Complaints";
} 
?></td>
    <td><a href="#" onclick="MM_openBrWindow('contactus_viewcore.php?data=<?php echo $row_rscontact_us['id']; ?>','','scrollbars=yes,width=800,height=600')"><?php echo $row_rscontact_us['timeofcomment']; ?></a></td>
    <td><?php echo $row_rscontact_us['timeofrespond']; ?></td>
  </tr>
  <?php } while ($row_rscontact_us = mysql_fetch_assoc($rscontact_us)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rscontact_us);
?>
