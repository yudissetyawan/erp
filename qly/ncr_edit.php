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
  $updateSQL = sprintf("UPDATE q_ncr SET title_ncr=%s, dept=%s, supp=%s, req=%s, prod_code=%s, prod_code_other=%s, ncr_date=%s, apprv_det=%s, apprv_det_date=%s, dispositioner=%s, disp_date=%s, apprv_disp=%s, apprv_disp_date=%s, comp_date=%s, closed_by=%s, date_closed=%s, reviewed_by=%s, detail=%s, disp_correct=%s, disp_prevent=%s, `comment`=%s, cost=%s WHERE no_ncr=%s",
                       GetSQLValueString($_POST['ncr'], "text"),
                       GetSQLValueString($_POST['dept'], "int"),
                       GetSQLValueString($_POST['supp'], "text"),
                       GetSQLValueString($_POST['req'], "text"),
                       GetSQLValueString($_POST['prod_code'], "int"),
                       GetSQLValueString($_POST['prod_code'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['apprv_det'], "int"),
                       GetSQLValueString($_POST['apprv_det_date'], "date"),
                       GetSQLValueString($_POST['dispositioner'], "int"),
                       GetSQLValueString($_POST['disp_date'], "date"),
                       GetSQLValueString($_POST['apprv_disp'], "int"),
                       GetSQLValueString($_POST['apprv_disp_date'], "date"),
                       GetSQLValueString($_POST['comp_date'], "date"),
                       GetSQLValueString($_POST['closed_by'], "int"),
                       GetSQLValueString($_POST['tanggalclosed'], "date"),
                       GetSQLValueString($_POST['reviewed_by'], "int"),
                       GetSQLValueString($_POST['detail'], "text"),
                       GetSQLValueString($_POST['disp_corect'], "text"),
                       GetSQLValueString($_POST['disp_prevent'], "text"),
                       GetSQLValueString($_POST['comment'], "text"),
                       GetSQLValueString($_POST['cost'], "text"),
                       GetSQLValueString($_POST['no_ncr'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}
mysql_select_db($database_core, $core);
$query_h_dept = "SELECT h_department.department FROM h_department, q_ncr WHERE h_department.id = q_ncr.dept";
$h_dept = mysql_query($query_h_dept, $core) or die(mysql_error());
$row_h_dept = mysql_fetch_assoc($h_dept);
$totalRows_h_dept = mysql_num_rows($h_dept);

mysql_select_db($database_core, $core);
$query_a_prod_code_ncr_ncr = "SELECT a_production_code.id, a_production_code.productioncode FROM a_production_code, q_ncr WHERE q_ncr.prod_code = a_production_code.id";
$a_prod_code_ncr_ncr = mysql_query($query_a_prod_code_ncr_ncr, $core) or die(mysql_error());
$row_a_prod_code_ncr_ncr = mysql_fetch_assoc($a_prod_code_ncr_ncr);
$totalRows_a_prod_code_ncr_ncr = mysql_num_rows($a_prod_code_ncr_ncr);

mysql_select_db($database_core, $core);
$query_h_employee = "SELECT * FROM h_employee ORDER BY firstname ASC";
$h_employee = mysql_query($query_h_employee, $core) or die(mysql_error());
$row_h_employee = mysql_fetch_assoc($h_employee);
$totalRows_h_employee = mysql_num_rows($h_employee);

mysql_select_db($database_core, $core);
$query_h_employee_qly = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'quality'";
$h_employee_qly = mysql_query($query_h_employee_qly, $core) or die(mysql_error());
$row_h_employee_qly = mysql_fetch_assoc($h_employee_qly);
$totalRows_h_employee_qly = mysql_num_rows($h_employee_qly);

mysql_select_db($database_core, $core);
$query_q_ncr = "SELECT * FROM q_ncr";
$q_ncr = mysql_query($query_q_ncr, $core) or die(mysql_error());
$row_q_ncr = mysql_fetch_assoc($q_ncr);
$totalRows_q_ncr = mysql_num_rows($q_ncr);

mysql_select_db($database_core, $core);
$query_h_department = "SELECT id, department FROM h_department";
$h_department = mysql_query($query_h_department, $core) or die(mysql_error());
$row_h_department = mysql_fetch_assoc($h_department);
$totalRows_h_department = mysql_num_rows($h_department);

mysql_select_db($database_core, $core);
$query_a_prod_code = "SELECT id, productioncode FROM a_production_code";
$a_prod_code = mysql_query($query_a_prod_code, $core) or die(mysql_error());
$row_a_prod_code = mysql_fetch_assoc($a_prod_code);
$totalRows_a_prod_code = mysql_num_rows($a_prod_code);

$colname_approved_by = "-1";
if (isset($_GET['data'])) {
  $colname_approved_by = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_approved_by = sprintf("SELECT q_ncr.apprv_det, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_ncr, h_employee WHERE q_ncr.id = %s AND h_employee.id = q_ncr.apprv_det", GetSQLValueString($colname_approved_by, "int"));
$approved_by = mysql_query($query_approved_by, $core) or die(mysql_error());
$row_approved_by = mysql_fetch_assoc($approved_by);
$totalRows_approved_by = mysql_num_rows($approved_by);

$colname_dispositioner = "-1";
if (isset($_GET['data'])) {
  $colname_dispositioner = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dispositioner = sprintf("SELECT q_ncr.dispositioner, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_ncr, h_employee WHERE q_ncr.id = %s AND h_employee.id = q_ncr.dispositioner", GetSQLValueString($colname_dispositioner, "int"));
$dispositioner = mysql_query($query_dispositioner, $core) or die(mysql_error());
$row_dispositioner = mysql_fetch_assoc($dispositioner);
$totalRows_dispositioner = mysql_num_rows($dispositioner);

$colname_closed_by = "-1";
if (isset($_GET['data'])) {
  $colname_closed_by = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_closed_by = sprintf("SELECT q_ncr.closed_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_ncr, h_employee WHERE q_ncr.id = %s AND h_employee.id = q_ncr.id", GetSQLValueString($colname_closed_by, "int"));
$closed_by = mysql_query($query_closed_by, $core) or die(mysql_error());
$row_closed_by = mysql_fetch_assoc($closed_by);
$totalRows_closed_by = mysql_num_rows($closed_by);

$colname_apprv_disp = "-1";
if (isset($_GET['data'])) {
  $colname_apprv_disp = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_apprv_disp = sprintf("SELECT q_ncr.apprv_disp, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_ncr, h_employee WHERE q_ncr.id = %s AND h_employee.id = q_ncr.id", GetSQLValueString($colname_apprv_disp, "int"));
$apprv_disp = mysql_query($query_apprv_disp, $core) or die(mysql_error());
$row_apprv_disp = mysql_fetch_assoc($apprv_disp);
$totalRows_apprv_disp = mysql_num_rows($apprv_disp);

$colname_reviewed_by = "-1";
if (isset($_GET['data'])) {
  $colname_reviewed_by = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_reviewed_by = sprintf("SELECT q_ncr.reviewed_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_ncr, h_employee WHERE q_ncr.id = %s AND h_employee.id = q_ncr.reviewed_by", GetSQLValueString($colname_reviewed_by, "int"));
$reviewed_by = mysql_query($query_reviewed_by, $core) or die(mysql_error());
$row_reviewed_by = mysql_fetch_assoc($reviewed_by);
$totalRows_reviewed_by = mysql_num_rows($reviewed_by);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit NCR</title>
<?php include('../library/mrom.php');?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
  <?php {
		include "../date.php";
		require_once "../dateformat_funct.php";
	} ?>

<form method="POST" action="<?php echo $editFormAction; ?>" id="form1" name="form1">
  <table width="1000" border="0">
    <tr class="tabel_header">
      <td colspan="7" align="center"><strong>NON CONFORMANCE REPORT</strong></td>
    </tr>
    <tr>
      <td width="237" valign="top">Non Conformance Report</td>
      <td width="3" valign="top">:</td>
      <td width="287"><label for="ncr"></label>
      <textarea name="ncr" id="ncr" cols="40" rows="3"><?php echo $row_q_ncr['title_ncr']; ?></textarea></td>
      <td width="86" valign="top">NCR No.</td>
      <td width="3" valign="top">:</td>
      <td colspan="2" valign="top">
      <input type="text" name="no_ncr" id="no_ncr" value="<?php echo $row_q_ncr['no_ncr']; ?>" style="border:thin" />
      </td>
    </tr>
    <tr>
      <td>Department / Supplier</td>
      <td>:</td>
      <td><label for="dept"></label>
        
        <select name="dept" id="dept">
        <option value="<?php echo $row_h_dept['id']; ?>"><?php echo $row_h_dept['department']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_department['id']?>"><?php echo $row_h_department['department']?></option>
          <?php
} while ($row_h_department = mysql_fetch_assoc($h_department));
  $rows = mysql_num_rows($h_department);
  if($rows > 0) {
      mysql_data_seek($h_department, 0);
	  $row_h_department = mysql_fetch_assoc($h_department);
  }
?>
        </select>
      / 
      <input name="supp" type="text" id="supp" value="<?php echo $row_q_ncr['supp']; ?>" /></td>
      <td>Prod Code</td>
      <td>:</td>
      <td colspan="2">
        <select name="prod_code" id="prod_code">
         <option value="<?php echo $row_a_prod_code_ncr_ncr['id']; ?>"><?php echo $row_a_prod_code_ncr_ncr['productioncode']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_a_prod_code['id']?>"><?php echo $row_a_prod_code['productioncode']?></option>
          <?php
} while ($row_a_prod_code = mysql_fetch_assoc($a_prod_code));
  $rows = mysql_num_rows($a_prod_code);
  if($rows > 0) {
      mysql_data_seek($a_prod_code, 0);
	  $row_a_prod_code = mysql_fetch_assoc($a_prod_code);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Originator / Requestor</td>
      <td>:</td>
      <td><label for="req"></label>
      <input name="req" type="text" id="req" value="<?php echo $row_q_ncr['req']; ?>" /></td>
      <td>Date</td>
      <td>:</td>
      <td colspan="2"><label for="date"></label>
        <span id="sprytextfield1">
        <input name="date" type="text" id="tanggal1" value="<?php echo $row_q_ncr['ncr_date']; ?>" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="7"><strong>Detail of Conformity :</strong></td>
    </tr>
    <tr>
      <td colspan="7"><label for="detail"></label>
      <textarea name="detail" id="detail" cols="100" rows="5"><?php echo $row_q_ncr['detail']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
      <td>Approved By :</td>
      <td><label for="apprv_det"></label>
        <label for="apprv_det"></label>
        <select name="apprv_det" id="apprv_det">
        <option value="<?php echo $row_approved_by['apprv_det']; ?>"><?php echo $row_approved_by['firstname']; ?> <?php echo $row_approved_by['midlename']; ?> <?php echo $row_approved_by['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee['id']?>"><?php echo $row_h_employee['firstname']?> <?php echo $row_h_employee['midlename']; ?> <?php echo $row_h_employee['lastname']; ?></option>
          <?php
} while ($row_h_employee = mysql_fetch_assoc($h_employee));
  $rows = mysql_num_rows($h_employee);
  if($rows > 0) {
      mysql_data_seek($h_employee, 0);
	  $row_h_employee = mysql_fetch_assoc($h_employee);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
      <td>Date :</td>
      <td><label for="apprv_det_date"></label>
        <span id="sprytextfield2">
        <input name="apprv_det_date" type="text" id="tanggal2" value="<?php echo $row_q_ncr['apprv_det_date']; ?>" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="7"><strong>Disposition :</strong> </td>
    </tr>
    <tr>
      <td>Corrective Action Recommendation</td>
      <td>:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="155">&nbsp;</td>
      <td width="199">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7"><label for="disp_cor"></label>
      <textarea name="disp_corect" id="disp_corect" cols="150" rows="5"><?php echo $row_q_ncr['disp_correct']; ?></textarea></td>
    </tr>
    <tr>
      <td>Preventive Action Recommendation</td>
      <td>:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7"><label for="disp_prevent"></label>
      <textarea name="disp_prevent" id="disp_prevent" cols="150" rows="5"><?php echo $row_q_ncr['disp_prevent']; ?></textarea></td>
    </tr>
    <tr>
      <td>Dispositioner</td>
      <td>&nbsp;</td>
      <td><label for="disp">
        <select name="dispositioner" id="dispositioner">
          <option value="<?php echo $row_dispositioner['dispositioner']; ?>"><?php echo $row_dispositioner['firstname']; ?> <?php echo $row_dispositioner['midlename']; ?> <?php echo $row_dispositioner['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee['id']?>"><?php echo $row_h_employee['firstname']?> <?php echo $row_h_employee['midlename']; ?> <?php echo $row_h_employee['lastname']; ?></option>
          <?php
} while ($row_h_employee = mysql_fetch_assoc($h_employee));
  $rows = mysql_num_rows($h_employee);
  if($rows > 0) {
      mysql_data_seek($h_employee, 0);
	  $row_h_employee = mysql_fetch_assoc($h_employee);
  }
?>
        </select>
      </label></td>
      <td>Approved By</td>
      <td>&nbsp;</td>
      <td><label for="apprv_disp"></label>
        <select name="apprv_disp" id="apprv_disp">
        <option value="<?php echo $row_apprv_disp['apprv_disp']; ?>"><?php echo $row_apprv_disp['firstname']; ?> <?php echo $row_apprv_disp['midlename']; ?> <?php echo $row_apprv_disp['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee['id']?>"><?php echo $row_h_employee['firstname']?> <?php echo $row_h_employee['midlename']; ?> <?php echo $row_h_employee['lastname']; ?></option>
          <?php
} while ($row_h_employee = mysql_fetch_assoc($h_employee));
  $rows = mysql_num_rows($h_employee);
  if($rows > 0) {
      mysql_data_seek($h_employee, 0);
	  $row_h_employee = mysql_fetch_assoc($h_employee);
  }
?>
      </select></td>
      <td>Completion Date</td>
    </tr>
    <tr>
      <td>Date</td>
      <td>&nbsp;</td>
      <td><label for="disp_date"></label>
      <span id="sprytextfield3">
      <input name="disp_date" type="text" id="tanggal3" value="<?php echo $row_q_ncr['disp_date']; ?>" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>Date</td>
      <td>&nbsp;</td>
      <td><label for="apprv_disp_date"></label>
        <span id="sprytextfield4">
        <input name="apprv_disp_date" type="text" id="tanggal4" value="<?php echo $row_q_ncr['apprv_disp_date']; ?>" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td><label for="comp_date"></label>
        <span id="sprytextfield5">
        <input name="comp_date" type="text" id="tanggal5" value="<?php echo $row_q_ncr['comp_date']; ?>" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Closed By 
        ( Quality Department )</td>
      <td>&nbsp;</td>
      <td><label for="closed_by"></label>
        <select name="closed_by" id="closed_by">
        <option value="<?php echo $row_closed_by['closed_by']; ?>"><?php echo $row_closed_by['firstname']; ?> <?php echo $row_closed_by['midlename']; ?> <?php echo $row_closed_by['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_qly['id']?>"><?php echo $row_h_employee_qly['firstname']?> <?php echo $row_h_employee_qly['midlename']; ?> <?php echo $row_h_employee_qly['lastname']; ?></option>
          <?php
} while ($row_h_employee_qly = mysql_fetch_assoc($h_employee_qly));
  $rows = mysql_num_rows($h_employee_qly);
  if($rows > 0) {
      mysql_data_seek($h_employee_qly, 0);
	  $row_h_employee_qly = mysql_fetch_assoc($h_employee_qly);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Reviewed By ( QMR )</td>
      <td><label for="reviewed_by"></label>
        <select name="reviewed_by" id="reviewed_by">
        <option value="<?php echo $row_reviewed_by['reviewed_by']; ?>"><?php echo $row_reviewed_by['firstname']; ?> <?php echo $row_reviewed_by['midlename']; ?> <?php echo $row_reviewed_by['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_qly['id']?>"><?php echo $row_h_employee_qly['firstname']?> <?php echo $row_h_employee_qly['midlename']; ?> <?php echo $row_h_employee_qly['lastname']; ?></option>
          <?php
} while ($row_h_employee_qly = mysql_fetch_assoc($h_employee_qly));
  $rows = mysql_num_rows($h_employee_qly);
  if($rows > 0) {
      mysql_data_seek($h_employee_qly, 0);
	  $row_h_employee_qly = mysql_fetch_assoc($h_employee_qly);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Date :</td>
      <td>&nbsp;</td>
      <td colspan="5"><input name="tanggalclosed" type="text" id="tanggal10" value="<?php echo $row_q_ncr['date_closed']; ?>" /></td>
    </tr>
    <tr>
      <td>Comment</td>
      <td>&nbsp;</td>
      <td><label for="comment"></label>
        <label for="comment2"></label>
      <textarea name="comment" id="comment2" cols="45" rows="5"><?php echo $row_q_ncr['comment']; ?></textarea></td>
      <td>Cost</td>
      <td>&nbsp;</td>
      <td colspan="2"><input type="text" name="cost" id="cost" value="<?php echo $row_q_ncr['cost']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center"><a href="ncr_header.php"><input type="submit" name="submit" id="submit" value="Submit" /></a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
</script>
</body>
</html>
<?php
mysql_free_result($h_dept);

mysql_free_result($a_prod_code_ncr_ncr);

mysql_free_result($h_employee);

mysql_free_result($h_employee_qly);

mysql_free_result($q_ncr);

mysql_free_result($h_department);

mysql_free_result($a_prod_code);

mysql_free_result($approved_by);

mysql_free_result($dispositioner);

mysql_free_result($closed_by);

mysql_free_result($apprv_disp);

mysql_free_result($reviewed_by);
?>
