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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	include "../dateformat_funct.php";
	
  $updateSQL = sprintf("UPDATE p_mr_header SET nomr=%s, `date`=%s, note=%s, requestby=%s, requesterapprovaldate=%s, passedby=%s, parserapprovaldate=%s, approvedby=%s, approvaldate=%s, status=%s WHERE id_prodcode=%s",
                       GetSQLValueString($_POST['nomr'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "text"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['requestby'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['requesterapprovaldate']), "date"),
                       GetSQLValueString($_POST['passedby'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['parserapprovaldate']), "date"),
                       GetSQLValueString($_POST['approvedby'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['approvaldate']), "date"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id_prodcode'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM p_mr_header WHERE id_prodcode = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM p_mr_header WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_rsreqby = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE h_employee.code = 'K' ORDER BY firstname ASC";
$rsreqby = mysql_query($query_rsreqby, $core) or die(mysql_error());
$row_rsreqby = mysql_fetch_assoc($rsreqby);
$totalRows_rsreqby = mysql_num_rows($rsreqby);

mysql_select_db($database_core, $core);
$query_rsuserppic = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE h_employee.department = 'PPIC' AND h_employee.code = 'K' ORDER BY firstname ASC";
$rsuserppic = mysql_query($query_rsuserppic, $core) or die(mysql_error());
$row_rsuserppic = mysql_fetch_assoc($rsuserppic);
$totalRows_rsuserppic = mysql_num_rows($rsuserppic);

mysql_select_db($database_core, $core);
$query_rsapprover = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname  FROM h_employee WHERE userlevel = 'branchmanager' AND h_employee.code = 'K' ORDER BY firstname ASC";
$rsapprover = mysql_query($query_rsapprover, $core) or die(mysql_error());
$row_rsapprover = mysql_fetch_assoc($rsapprover);
$totalRows_rsapprover = mysql_num_rows($rsapprover);
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

</head>

<body>
<?php { include "../date.php"; include "../dateformat_funct.php"; } ?>
<b>Edit MR / SR </b>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="500">
    <tr>
      <td width="220">No. MR <input type="hidden" name="nomr" value="<?php echo $row_Recordset1['id_prodcode']; ?>" size="32" /></td>
      <td>:</td>
      <td><input type="text" name="nomr" value="<?php echo htmlentities($row_Recordset1['nomr'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td><input type="text" name="date" value="<?php echo functddmmmyyyy($row_Recordset1['date']); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Note</td>
      <td>:</td>
      <td><input type="text" name="note" value="<?php echo htmlentities($row_Recordset1['note'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Request by</td>
      <td>:</td>
      <td><select name="requestby" id="requestby" class="required" title="Please select Request by">
  <?php do {  ?>
        <option value="<?php echo $row_rsreqby['id']; ?>" <?php if ($row_rsreqby['id'] == $row_Recordset1['requestby']) { ?> selected="selected" <?php } ?>><?php echo $row_rsreqby['firstname'] ?> <?php echo $row_rsreqby['midlename']; ?> <?php echo $row_rsreqby['lastname']; ?></option>
        <?php
} while ($row_rsreqby = mysql_fetch_assoc($rsreqby));
  $rows = mysql_num_rows($rsreqby);
  if($rows > 0) {
      mysql_data_seek($rsreqby, 0);
	  $row_rsreqby = mysql_fetch_assoc($rsreqby);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Requester Date</td>
      <td>:</td>
      <td><input type="text" name="requesterapprovaldate" value="<?php echo functddmmmyyyy($row_Recordset1['requesterapprovaldate']); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Passed by</td>
      <td>:</td>
      <td><select name="passedby" id="passedby" class="required" title="Please select passed by">
        <?php
do {  
?>
        <option value="<?php echo $row_rsuserppic['id']?>" <?php if ($row_rsuserppic['id'] == $row_Recordset1['passedby']) { ?> selected="selected" <?php } ?>><?php echo $row_rsuserppic['firstname']?> <?php echo $row_rsuserppic['midlename']; ?> <?php echo $row_rsuserppic['lastname']; ?></option>
        <?php
} while ($row_rsuserppic = mysql_fetch_assoc($rsuserppic));
  $rows = mysql_num_rows($rsuserppic);
  if($rows > 0) {
      mysql_data_seek($rsuserppic, 0);
	  $row_rsuserppic = mysql_fetch_assoc($rsuserppic);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Passed Date</td>
      <td>:</td>
      <td><input type="text" name="parserapprovaldate" value="<?php echo functddmmmyyyy($row_Recordset1['parserapprovaldate']); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Approved by</td>
      <td>:</td>
      <td><select name="approvedby" id="approvedby" class="required" title="Please Approved by">
        <?php
do {  
?>
        <option value="<?php echo $row_rsapprover['id']?>" <?php if ($row_rsapprover['id'] == $row_Recordset1['approvedby']) { ?> selected="selected" <?php } ?>><?php echo $row_rsapprover['firstname']?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?></option>
        <?php
} while ($row_rsapprover = mysql_fetch_assoc($rsapprover));
  $rows = mysql_num_rows($rsapprover);
  if($rows > 0) {
      mysql_data_seek($rsapprover, 0);
	  $row_rsapprover = mysql_fetch_assoc($rsapprover);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Approval date</td>
      <td>:</td>
      <td><input type="text" name="approvaldate" value="<?php echo htmlentities($row_Recordset1['approvaldate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Status</td>
      <td>:</td>
      <td><input type="text" name="status" value="<?php echo htmlentities($row_Recordset1['status'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td class="General">Reference</td>
      <td>:</td>
      <td><input type="text" name="referencetype" id="referencetype" class="required" title="Reference is required" size="32" value="<?php echo $row_Recordset1['referencetype']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Note</td>
      <td>:</td>
      <td><textarea name="note2" id="note" cols="45" rows="3" class="required" title="Note is Required"><?php echo $row_Recordset1['note']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_prodcode" value="<?php echo $row_Recordset1['id_prodcode']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsreqby);

mysql_free_result($rsuserppic);

mysql_free_result($rsapprover);
?>
