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
$query_Recordset1 = "SELECT * FROM h_recruitment";
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
<style type="text/css">
<!--
a:link {
	text-decoration: none;
	color: #000;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: none;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body class="General">

<?php {include "../date.php";}?>
<p><a href="input_cv.php" class="General"><strong>Add New Applicant</strong></a></p>
<form id="form1" name="form1" method="post" action="">
  <table width="483" border="0" cellspacing="2" cellpadding="0">
    <tr class="tabel_header">
      <td width="59" class="tabel_header">No</td>
      <td width="150">Name</td>
      <td width="91">Status</td>
      <td>View</td>
      <td width="104">Date of Entry</td>
    </tr>
    <?php do { ?>
      <tr class="tabel_body">
        <td align="center"><?php echo $row_Recordset1[no_pelamar] . ' '; ?></td>
        <td ><?php echo $row_Recordset1[firstname] . ' ' .$row_Recordset1[midlename] . ' '. $row_Recordset1[lastname]; ?></td>
        <td align="center"><?php if ($row_Recordset1['status']==1) {echo "Baru";} else {echo "Pernah Dipanggil";} ?></td>
        <td align="center" width="67" onclick="MM_openBrWindow('vcd.php?data=<?php echo $row_Recordset1['id']; ?>','detailcv','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes')"><a href="#"><strong>Detail</strong></a></td>
        <td align="center"><?php echo $row_Recordset1['date']; ?></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
</form>
<form id="form2" name="form2" method="post" action="">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
