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
$query_Recordset1 = "SELECT a_wip_header.id, a_customer.customername, a_proj_code.contractno,  a_contactperson.firstname, a_contactperson.lastname, a_proj_code.projectvalue, a_proj_code.project_code FROM a_wip_header, a_customer, a_proj_code, a_contactperson WHERE a_customer.id = a_wip_header.customer AND a_proj_code.id = a_wip_header.contractno AND a_contactperson.id = a_wip_header.contractmanager";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 5px;
	margin-bottom: 5px;
}
-->
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<table width="800" border="0" cellpadding="3">
  <tr class="tabel_header">
    <td width="40" ><strong>No.</strong></td>
    <td width="150"><strong>Project Code</strong></td>
    <td width="200" ><strong>Project Value</strong></td>
    <td width="250" ><strong>Customer Name</strong></td>
    <td width="300" ><strong>Contract Manager</strong></td>
  </tr>
  <?php do { ?>
  <form id="form1" name="form1" method="post" action="">
    <tr class="tabel_body">
      <td><?php echo $row_Recordset1['id']; ?></td>
      <td><a href="viewwipdetail.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['project_code']; ?></a></td>
      <td><?php echo $row_Recordset1['projectvalue']; ?></td>
      <td><?php echo $row_Recordset1['customername']; ?></td>
      <td><?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
    </tr>
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<hr />

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
