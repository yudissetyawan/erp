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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO q_ncr (no_urutncr, no_ncr, title_ncr, dept, supp, req, prod_code, prod_code_other, ncr_date, apprv_det, apprv_det_date, dispositioner, disp_date, apprv_disp, apprv_disp_date, comp_date, closed_by, date_closed, reviewed_by, detail, disp_correct, disp_prevent, comment, cost, fileupload) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,  %s, %s, %s, %s, %s, %s, %s)",
  					   GetSQLValueString($_POST['no_urutncr'], "int"),
                       GetSQLValueString($_POST['no_ncr'], "text"),
                       GetSQLValueString($_POST['ncr'], "text"),
                       GetSQLValueString($_POST['dept'], "int"),
                       GetSQLValueString($_POST['supp'], "text"),
                       GetSQLValueString($_POST['req'], "text"),
                       GetSQLValueString($_POST['prod_code'], "int"),
					   GetSQLValueString($_POST['prod_code_other'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "date"),
                       GetSQLValueString($_POST['apprv_det'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['apprv_det_date']), "date"),
                       GetSQLValueString($_POST['dispositioner'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['disp_date']), "date"),
                       GetSQLValueString($_POST['apprv_disp'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['apprv_disp_date']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['comp_date']), "date"),
                       GetSQLValueString($_POST['closed_by'], "int"),
					   GetSQLValueString(functyyyymmdd($_POST['tanggal6']), "date"),
                       GetSQLValueString($_POST['reviewed_by'], "int"),
                       GetSQLValueString($_POST['detail'], "text"),
                       GetSQLValueString($_POST['disp_corect'], "text"),
                       GetSQLValueString($_POST['disp_prevent'], "text"),
                       GetSQLValueString($_POST['comment'], "text"),
					   GetSQLValueString($_POST['cost'], "text"),
					   GetSQLValueString($_POST['fileupload'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_h_dept = "SELECT * FROM h_department";
$h_dept = mysql_query($query_h_dept, $core) or die(mysql_error());
$row_h_dept = mysql_fetch_assoc($h_dept);
$totalRows_h_dept = mysql_num_rows($h_dept);

mysql_select_db($database_core, $core);
$query_a_prod_code = "SELECT id, productioncode FROM a_production_code";
$a_prod_code = mysql_query($query_a_prod_code, $core) or die(mysql_error());
$row_a_prod_code = mysql_fetch_assoc($a_prod_code);
$totalRows_a_prod_code = mysql_num_rows($a_prod_code);

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


$year = date(Y);
$month = date("Y-m-d");
$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM q_ncr ORDER BY no_urutncr DESC LIMIT 1"));
$cekQ = $ceknomor[no_urutncr];
#menghilangkan huruf
$awalQ = substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next = (int)$awalQ+1;

if ($next <10){
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J005
//
}
else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "" . $next; // jadinya J005
//
}
else {
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J005
//
}
$nextno = sprintf ($nextString);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include('../library/mrom.php');?>
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h3 { font-size:14px; font-weight:bold; }
	p {font-size:12px; font-weight:bold;}
	input { padding: 1px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
  <p>
    <?php {
include "../date.php"; include "ncr_upload.php";} ?>
  </p>
  <table width="1000" border="0">
    <tr>
      <td><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
                   Attachment File:
                   <input name="filencr" type="file" style="cursor:pointer;" />
                   <input type="submit" name="submit" value="Upload" />
      </form></td>
    </tr>
  </table>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="1000" border="0" align="center">
    <tr class="tabel_header">
      <td colspan="7" align="center"><h3>NON CONFORMANCE REPORT</h3></td>
    </tr>
    <tr>
      <td colspan="2">Non Conformance Report :</td>
      <td width="336"><label for="ncr"></label>
      <textarea name="ncr" id="ncr" cols="45" rows="3"></textarea></td>
      <td colspan="2">&nbsp;</td>
      <td width="163"><label for="no_ncr">No NCR :</label></td>
      <td width="208"><input type="text" name="no_ncr" id="no_ncr" value="<?php echo $nextno."/NC-BB/".MMRomawi($month)."/".$year; ?>" style="border:thin" />
        <label for="no_urutncr"></label>
      <input type="hidden" name="no_urutncr" id="no_urutncr" value="<?php echo $next; ?>" /></td>
    </tr>
    <tr>
      <td colspan="2">Department / Supplier :</td>
      <td><label for="dept"></label>
        <select name="dept" id="dept2">
        <option value="">- Department -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_dept['id']?>"><?php echo $row_h_dept['department']?></option>
          <?php
} while ($row_h_dept = mysql_fetch_assoc($h_dept));
  $rows = mysql_num_rows($h_dept);
  if($rows > 0) {
      mysql_data_seek($h_dept, 0);
	  $row_h_dept = mysql_fetch_assoc($h_dept);
  }
?>
        </select>
      / 
      <input type="text" name="supp" id="supp" /></td>
      <td colspan="2">&nbsp;</td>
      <td><label for="prod_code"></label>
        <label for="prod_code2">Prod Code :</label></td>
      <td><select name="prod_code" id="prod_code2">
        <option value="">- Production Code -</option>
        <?php
do {  
?>
<option value="<?php echo $row_a_prod_code['productioncode']?>"><?php echo $row_a_prod_code['productioncode']?></option>
        <?php
} while ($row_a_prod_code = mysql_fetch_assoc($a_prod_code));
  $rows = mysql_num_rows($a_prod_code);
  if($rows > 0) {
      mysql_data_seek($a_prod_code, 0);
	  $row_a_prod_code = mysql_fetch_assoc($a_prod_code);
  }
?>
      </select> 
        / 
        <label for="prod_code_other"></label>
        <input type="text" name="prod_code_other" id="prod_code_other" /></td>
    </tr>
    <tr>
      <td colspan="2">Originator / Requestor :</td>
      <td><label for="req"></label>
      <input type="text" name="req" id="req" /></td>
      <td colspan="2">&nbsp;</td>
      <td><label for="date">Date :</label></td>
      <td><span id="sprytextfield1">
      <input type="text" name="date" id="tanggal1" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="7"><p>Detail of Conformity :</p></td>
    </tr>
    <tr>
      <td colspan="7"><label for="detail"></label>
      <textarea name="detail" id="detail" cols="150" rows="5"></textarea></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
      <td>Approved By :</td>
      <td><label for="apprv_det"></label>
        <label for="apprv_det"></label>
        <select name="apprv_det" id="apprv_det">
        <option value="">- Aproved By -</option>
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
        <input type="text" name="apprv_det_date" id="tanggal2" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr class="tabel_header">
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td class="tabel_body" colspan="7"><p>Disposition :</p></td>
    </tr>
    <tr>
      <td colspan="7">Corrective Action Recommendation :</td>
    </tr>
    <tr>
      <td colspan="7"><label for="disp_cor"></label>
      <textarea name="disp_corect" id="disp_corect" cols="150" rows="5"></textarea></td>
    </tr>
    <tr>
      <td width="251">Preventive Action Recommendation :</td>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7"><label for="disp_prevent"></label>
      <textarea name="disp_prevent" id="disp_prevent" cols="150" rows="5"></textarea></td>
    </tr>
    <tr>
      <td colspan="2">Dispositioner :</td>
      <td><label for="disp">
        <select name="dispositioner" id="dispositioner">
          <option value="">- Dispositioner -</option>
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
      <td colspan="2">Approved By :</td>
      <td><label for="apprv_disp"></label>
        <select name="apprv_disp" id="apprv_disp">
        <option value="">- Approved By -</option>
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
      <td>Completion Date :</td>
    </tr>
    <tr>
      <td colspan="2"> Date :</td>
      <td><label for="disp_date"></label>
        <span id="sprytextfield3">
        <input type="text" name="disp_date" id="tanggal3" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td colspan="2">Date :</td>
      <td><label for="apprv_disp_date"></label>
        <span id="sprytextfield4">
        <input type="text" name="apprv_disp_date" id="tanggal4" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td><label for="comp_date"></label>
        <span id="sprytextfield5">
        <input type="text" name="comp_date" id="tanggal5" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr class="tabel_body">
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Closed By 
        ( Quality Department ) :</td>
      <td><label for="closed_by"></label>
        <select name="closed_by" id="closed_by">
        <option value="">- Closed By -</option>
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
      <td colspan="2">&nbsp;</td>
      <td>Reviewed By ( QMR ) :</td>
      <td><label for="reviewed_by"></label>
        <select name="reviewed_by" id="reviewed_by">
        <option value="">- Reviewed By -</option>
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
      <td colspan="2">Date : </td>
      <td colspan="5"><label for="tanggal6"></label>
        <span id="sprytextfield6">
        <input type="text" name="tanggal6" id="tanggal6" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="2">Comment :</td>
      <td colspan="2"><label for="comment"></label>
        <label for="comment2"></label>
      <textarea name="comment" id="comment2" cols="45" rows="5"></textarea></td>
      <td>Cost :</td>
      <td colspan="2"><label for="cost"></label>
      <input type="text" name="cost" id="cost" /></td>
    </tr>
    <tr class="tabel_header">
      <td colspan="7" align="center"><label for="fileupload"></label>
      <input type="text" name="fileupload" id="fileupload" value="<?php echo $nama_file;?>" /></td>
    </tr>
    <tr class="tabel_header">
      <td colspan="7" align="center">
	  </td>
    </tr>
    <tr class="tabel_header">
      <td colspan="7" align="center"><input type="submit" name="submit" id="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
</script>
</body>
</html>
<?php
mysql_free_result($h_dept);

mysql_free_result($a_prod_code);

mysql_free_result($h_employee);

mysql_free_result($h_employee_qly);

mysql_free_result($q_ncr);
?>
