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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO c_mrsr_monitoring_status (id_requestor, `description`, qty, unit, request_date, mrsr_no, prod_code, wo, target_date, po_date, po_no, inc_date, id_supplier, status, remark) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['requestor'], "int"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['qty'], "double"),
                       GetSQLValueString($_POST['unit'], "int"),
                       GetSQLValueString($_POST['rqsdate'], "date"),
                       GetSQLValueString($_POST['mrsrno'], "text"),
                       GetSQLValueString($_POST['procode'], "text"),
                       GetSQLValueString($_POST['wo'], "text"),
                       GetSQLValueString($_POST['targetdate'], "date"),
                       GetSQLValueString($_POST['podate'], "date"),
                       GetSQLValueString($_POST['pono'], "text"),
                       GetSQLValueString($_POST['incdate'], "date"),
                       GetSQLValueString($_POST['suplier'], "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString($_POST['remark'], "text"));
					   
  $insertSQL00 = mysql_query("INSERT INTO z_mrsr_monitoring_status (`action`, `table`) VALUES ('insert', 'c_mrsr_monitoring_status')");

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewmrmonitoring.php";
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT h_employee.id, h_employee.firstname FROM h_employee ORDER BY h_employee.firstname";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT c_unit.id, c_unit.unit FROM c_unit";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT c_vendor.id, c_vendor.vendorname FROM c_vendor ORDER BY c_vendor.vendorname";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
<script type="text/javascript"><!--
$(document).ready(function() {
		$(function(){
				$('#datepicker').datepicker({dateFormat: 'yy-mm-dd'});
				$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
		});
});
-->
</script>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

<form name="form" action="<?php echo $editFormAction; ?>" method="POST"><table width="476" border="0">
    <tr>
      <td width="129">Requestor</td>
      <td width="337">        
        <select name="requestor" id="requestor2">
          <option value=""></option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['firstname']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Description</td>
      <td>        
        <textarea name="description" id="description" cols="45" rows="5"></textarea>
      </td>
    </tr>
    <tr>
      <td>Qty</td>
      <td>        
        <input type="text" name="qty" id="qty" />
      </td>
    </tr>
    <tr>
      <td>Unit</td>
      <td>        
        <select name="unit" id="qty">
          <option value=""></option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['id']?>"><?php echo $row_Recordset3['unit']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Request Date</td>
      <td>
        <input type="text" name="rqsdate" class="datepicker" />
      </td>
    </tr>
    <tr>
      <td>MR/SR No.</td>
      <td>        
        <input type="text" name="mrsrno" id="mrsrno" />
      </td>
    </tr>
    <tr>
      <td>Prod.Code</td>
      <td>        
        <input type="text" name="procode" id="procode" />
      </td>
    </tr>
    <tr>
      <td>WO</td>
      <td>        
        <input type="text" name="wo" id="wo" />
      </td>
    </tr>
    <tr>
      <td>Target Date</td>
      <td>        
        <input type="text" name="targetdate" class="datepicker" />
      </td>
    </tr>
    <tr>
      <td>PO Date</td>
      <td>        
        <input type="text" name="podate" class="datepicker" />
      </td>
    </tr>
    <tr>
      <td>PO No.</td>
      <td>        
        <input type="text" name="pono" id="pono" />
      </td>
    </tr>
    <tr>
      <td>Inc. Date</td>
      <td>        
        <input type="text" name="incdate" class="datepicker" />
      </td>
    </tr>
    <tr>
      <td>Suplier</td>
      <td>        
        <select name="suplier" id="suplier">
          <option value=""></option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset4['id']?>"><?php echo $row_Recordset4['vendorname']?></option>
          <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Remark</td>
      <td>        
        <input type="text" name="remark" id="remark" />
      </td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td>
        <input type="submit" name="submit" id="submit" value="Submit" />
      </td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="form" />
</form>
  <?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
