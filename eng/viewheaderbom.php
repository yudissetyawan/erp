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
$data="";
if(isset($_GET['data'])) $data=$_GET['data'];
$dataexp=explode("-",$data);
mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT e_header_bom.id, e_drawing_file.drawingno, maker.firstname AS makername, a_customer.customername, e_header_bom.status, e_header_bom.location,  e_header_bom.productioncode, e_header_bom.projectcode, e_header_bom.revision, e_header_bom.date, checked.firstname AS checkedby, approve.firstname AS approvedby, e_header_bom.status FROM e_header_bom LEFT JOIN e_drawing_file ON e_header_bom.drawingno=e_drawing_file.id LEFT JOIN  h_employee AS maker ON e_header_bom.createdby=maker.id LEFT JOIN a_customer ON e_header_bom.customer=a_customer.id LEFT JOIN h_employee AS checked ON e_header_bom.checkedby=checked.id LEFT JOIN h_employee AS approve ON e_header_bom.approvedby = approve.id WHERE e_header_bom.projectcode = '".$dataexp[1]."' AND e_header_bom.productioncode = '".$dataexp[2]."'"	;
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_actv = "SELECT * FROM e_header_bom WHERE e_header_bom.projectcode = '".$dataexp[1]."' AND e_header_bom.productioncode = '".$dataexp[2]."' AND status='Active'";
$recAct = mysql_query($query_actv, $core) or die(mysql_error());
$totalRowsAct = mysql_num_rows($recAct);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body class="General">

<p><?php if($totalRowsAct<1) {?><a href="inputheaderbom.php?data=<?php echo $data; ?>">input BOM</a><?php } ?></p>
<table border="0">
  <tr>
    <td width="199" bgcolor="#CCCCCC">Drawing Number</td>
    <td width="163" bgcolor="#CCCCCC">Created By</td>
    <td width="152" bgcolor="#CCCCCC">Location</td>
    <td width="219" bgcolor="#CCCCCC">Customer</td>
    <td width="320" bgcolor="#CCCCCC">Project And Production Code</td>
    <td width="137" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
<?php if($totalRows_Recordset1 <1 )echo "<td align='left'> Tidak Ada BOM </td>"; else do { ?>
  <form id="form1" name="form1" method="post" action="">
  <tr>
    <td><?php echo $row_Recordset1['drawingno']; ?><a href="viewdetailbom.php?data=<?php echo $row_Recordset1['id']; ?>">Detail</a></td>
    <td><?php echo $row_Recordset1['makername']; ?></td>
    <td><?php echo $row_Recordset1['location']; ?></td>
    <td><?php echo $row_Recordset1['customername']; ?></td>
    <td><?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['productioncode']; ?></td>
    <td><?php echo $row_Recordset1['status']; ?></td>
    </tr>

  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
    <td>&nbsp;</td>
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
