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
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c_mrsr_monitoring_status.id, c_mrsr_monitoring_status.`description`, c_mrsr_monitoring_status.qty, c_mrsr_monitoring_status.request_date, c_mrsr_monitoring_status.mrsr_no, c_mrsr_monitoring_status.prod_code, c_mrsr_monitoring_status.wo, c_mrsr_monitoring_status.target_date, c_mrsr_monitoring_status.po_date, c_mrsr_monitoring_status.po_no, c_mrsr_monitoring_status.inc_date, c_mrsr_monitoring_status.status, h_employee.firstname AS employename, c_unit.unit AS unitname, c_vendor.vendorname, c_mrsr_monitoring_status.id_requestor, c_mrsr_monitoring_status.unit, c_mrsr_monitoring_status.id_supplier, c_unit.unit AS namaunit, c_vendor.vendorname, h_employee.firstname, c_mrsr_monitoring_status.remark FROM c_mrsr_monitoring_status LEFT JOIN h_employee ON c_mrsr_monitoring_status.id_requestor=h_employee.id LEFT JOIN c_unit ON c_mrsr_monitoring_status.unit=c_unit.id LEFT JOIN c_vendor ON c_mrsr_monitoring_status.id_supplier=c_vendor.id WHERE c_mrsr_monitoring_status.id= %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table border="0">
    <tr>
      <td width="103" class="root"  >Requestor</td>
      <td width="167" class="contenthdr" ><?php echo $row_Recordset1['firstname']; ?></td>
      <td width="111" class="root" >Suplier</td>
      <td width="165" class="contenthdr"><?php echo $row_Recordset1['vendorname']; ?></td>
      <td width="69" class="root" >Remark</td>
      <td width="180" class="contenthdr"><?php echo $row_Recordset1['remark']; ?></td>
    </tr>
    <tr>
      <td rowspan="3" class="root"  >Description</td>
      <td rowspan="3" class="contenthdr"><?php echo $row_Recordset1['description']; ?></td>
      <td class="root" >Pro.Code</td>
      <td class="contenthdr"><?php echo $row_Recordset1['prod_code']; ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td class="root" >WO</td>
      <td class="contenthdr"><?php echo $row_Recordset1['wo']; ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td class="root" >PO.No</td>
      <td class="contenthdr"><?php echo $row_Recordset1['po_no']; ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td class="root"  >Qty</td>
      <td class="contenthdr"><?php echo $row_Recordset1['qty']; ?></td>
      <td class="root" >PO.Date</td>
      <td class="contenthdr"><?php echo $row_Recordset1['po_date']; ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td class="root"  >Unit</td>
      <td class="contenthdr"><?php echo $row_Recordset1['namaunit']; ?></td>
      <td class="root" >Target Date</td>
      <td class="contenthdr"><?php echo $row_Recordset1['target_date']; ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td class="root"  >Request Date</td>
      <td class="contenthdr"><?php echo $row_Recordset1['request_date']; ?></td>
      <td class="root" >Inc.Date</td>
      <td class="contenthdr"><?php echo $row_Recordset1['inc_date']; ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td class="root"  >MR/SR No</td>
      <td class="contenthdr"><?php echo $row_Recordset1['mrsr_no']; ?></td>
      <td class="root" >Status</td>
      <td class="contenthdr"><?php echo $row_Recordset1['status']; ?></td>
      <td colspan="2" >        
        <input type="button" name="Back" id="Back" value="Back" onclick="history.back()"/>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
