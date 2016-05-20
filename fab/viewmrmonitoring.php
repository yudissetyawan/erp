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
$query_Recordset1 = "SELECT c_mrsr_monitoring_status.id, c_mrsr_monitoring_status.`description`, c_mrsr_monitoring_status.qty, c_mrsr_monitoring_status.request_date, c_mrsr_monitoring_status.mrsr_no, c_mrsr_monitoring_status.prod_code, c_mrsr_monitoring_status.wo, c_mrsr_monitoring_status.target_date, c_mrsr_monitoring_status.po_date, c_mrsr_monitoring_status.po_no, c_mrsr_monitoring_status.inc_date, c_mrsr_monitoring_status.status, h_employee.firstname AS employename, c_unit.unit AS unitname, c_vendor.vendorname FROM c_mrsr_monitoring_status LEFT JOIN h_employee ON c_mrsr_monitoring_status.id_requestor=h_employee.id LEFT JOIN c_unit ON c_mrsr_monitoring_status.unit=c_unit.id LEFT JOIN c_vendor ON c_mrsr_monitoring_status.id_supplier=c_vendor.id  ORDER BY c_mrsr_monitoring_status.id";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$(function(){
			$('#dialog').dialog({
					autoOpen: false,
			});
			$('.ButtonWin').click(function(){
					$('#dialog').dialog('open');
					return false;
			});
			// Datepicker
			$('#datepicker').datepicker({dateFormat: 'yy-mm-dd'});
			$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});		
	});
});
	function addMrMonitoring(){
	$("#dialog").dialog({
			title: 'ADD DATA',
			width: 600,
	});
	$.ajax({url:"inputmrmonitoring.php",success:function(result){
    	$("#dialog").html(result);
	}});	
	};
	
	function editMrMonitoring(idForm){
	$("#dialog").dialog('close');
	$("#dialog").dialog({
				title: 'EDIT DATA',
				width: 600,
	});
	$.ajax({url:"editmrmonitoring.php?id="+idForm,success:function(result){
    	$("#dialog").html(result);
	}});
	};
</script>
<link type="text/css" href="../css/jquiuni.css" rel="stylesheet" />
<title>Untitled Document</title>
<style type="text/css">
.headerdate {	text-align: left;
}
.headertable {
	text-align: center;
	color: #FFF;
	font-weight: 900;
}
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>
  <input type="button" class="ButtonWin" onclick="addMrMonitoring()" value="Add" />
<div id="dialog"></div>
<?php if($totalRows_Recordset1 <= 0){echo "<h4>Record Kosong</h4><!--";}?>
  <table border="0">
  <tr class="tabel_header">
    <td width="20">No. </td>
    <td width="139">Requestor</td>
    <td width="159">Description</td>
    <td width="85">Qty</td>
    <td width="125">Unit</td>
    <td width="139">MR/SR No.</td>
    <td width="145">Request Date</td>
    <td width="104">Status</td>
    <td width="69">&nbsp;</td>
  </tr>
  <?php do { ?>
  <?php $n++; if(($n % 2)==0)?>
    <tr class="tabel_body">
<td><?php echo $n; ?></td>
      <td><?php echo $row_Recordset1['employename']; ?>[<a href="viewdetailmrmonitoring.php?id=<?php echo $row_Recordset1['id']; ?>">Detail</a>]</td>
      <td><?php echo $row_Recordset1['description']; ?></td>
      <td><?php echo $row_Recordset1['qty']; ?></td>
      <td><?php echo $row_Recordset1['unitname']; ?></td>
<td><?php echo $row_Recordset1['mrsr_no']; ?></td>
<td><?php echo $row_Recordset1['request_date']; ?></td>
<td><?php if($row_Recordset1['status'] == 1){echo "Closed";}else{echo "active";}?></td>
<td><?php if($row_Recordset1['status'] == 1){echo "<!--";} ?><a href="delmrmonitoring.php?id=<?php echo $row_Recordset1['id']; ?>">Closed</a><?php if($row_Recordset1['status'] == 1){echo "-->";} ?><input type="button" class="ButtonWin" onclick="editMrMonitoring('<?php echo $row_Recordset1['id'] ?>')" value="Revisi" /></td>
</tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<?php if($totalRows_Recordset1 <= 0){echo "-->";} ?> 
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
