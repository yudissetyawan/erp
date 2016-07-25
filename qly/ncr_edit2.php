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

$colname_h_dept = "-1";
if (isset($_GET['data'])) {
  $colname_h_dept = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_dept = sprintf("SELECT q_ncr.id, q_ncr.dept, h_department.department FROM q_ncr, h_department WHERE q_ncr.id = %s AND h_department.id = q_ncr.dept", GetSQLValueString($colname_h_dept, "int"));
$h_dept = mysql_query($query_h_dept, $core) or die(mysql_error());
$row_h_dept = mysql_fetch_assoc($h_dept);
$totalRows_h_dept = mysql_num_rows($h_dept);

$colname_q_ncr = "-1";
if (isset($_GET['data'])) {
  $colname_q_ncr = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_q_ncr = sprintf("SELECT q_ncr.* FROM q_ncr WHERE id = %s", GetSQLValueString($colname_q_ncr, "int"));
$q_ncr = mysql_query($query_q_ncr, $core) or die(mysql_error());
$row_q_ncr = mysql_fetch_assoc($q_ncr);
$totalRows_q_ncr = mysql_num_rows($q_ncr);

$colname_prod_code = "-1";
if (isset($_GET['data'])) {
  $colname_prod_code = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_prod_code = sprintf("SELECT q_ncr.id, q_ncr.prod_code, a_production_code.productioncode FROM q_ncr, a_production_code WHERE q_ncr.id = %s AND a_production_code.id = q_ncr.prod_code", GetSQLValueString($colname_prod_code, "int"));
$prod_code = mysql_query($query_prod_code, $core) or die(mysql_error());
$row_prod_code = mysql_fetch_assoc($prod_code);
$totalRows_prod_code = mysql_num_rows($prod_code);

$vdispositioner = $row_q_ncr['dispositioner'];
mysql_select_db($database_core, $core);
$query_dispositioner = "SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_ncr, h_employee WHERE h_employee.id = '$vdispositioner'";
$dispositioner = mysql_query($query_dispositioner, $core) or die(mysql_error());
$row_dispositioner = mysql_fetch_assoc($dispositioner);
$totalRows_dispositioner = mysql_num_rows($dispositioner);

$vapprv_det = $row_q_ncr['apprv_det'];
mysql_select_db($database_core, $core);
$query_apprv_det = "SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_ncr, h_employee WHERE h_employee.id = '$vapprv_det'";
$apprv_det = mysql_query($query_apprv_det, $core) or die(mysql_error());
$row_apprv_det = mysql_fetch_assoc($apprv_det);
$totalRows_apprv_det = mysql_num_rows($apprv_det);

$vapprv_disp = $row_q_ncr['apprv_disp'];
mysql_select_db($database_core, $core);
$query_apprv_disp = "SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, q_ncr WHERE h_employee.id = '$vapprv_disp'";
$apprv_disp = mysql_query($query_apprv_disp, $core) or die(mysql_error());
$row_apprv_disp = mysql_fetch_assoc($apprv_disp);
$totalRows_apprv_disp = mysql_num_rows($apprv_disp);

$vclosed_by = $row_q_ncr['closed_by'];
mysql_select_db($database_core, $core);
$query_closed_by = "SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, q_ncr WHERE h_employee.id = '$vclosed_by'";
$closed_by = mysql_query($query_closed_by, $core) or die(mysql_error());
$row_closed_by = mysql_fetch_assoc($closed_by);
$totalRows_closed_by = mysql_num_rows($closed_by);

$vreviewed_by = $row_q_ncr['reviewed_by'];
mysql_select_db($database_core, $core);
$query_reviewed_by = "SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, q_ncr WHERE h_employee.id = '$vreviewed_by'";
$reviewed_by = mysql_query($query_reviewed_by, $core) or die(mysql_error());
$row_reviewed_by = mysql_fetch_assoc($reviewed_by);
$totalRows_reviewed_by = mysql_num_rows($reviewed_by);

$year=date(YY);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM q_ncr ORDER BY no_ncr DESC"));
$cekQ=$ceknomor[no_ncr];
#menghilangkan huruf
$awalQ=substr($cekQ,3-6);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextno=sprintf ($next);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Detail NCR</title>

<?php include('../library/mrom.php');?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h3 { font-size:14px; font-weight:bold; }
	p {font-size:12px; font-weight:bold;}
	input { padding: 1px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
</style>

</head>

<body>
  <?php {
		include "../date.php";
  		require_once "../dateformat_funct.php";
	} ?>

<form method="POST" name="form1" class="General" id="form1">
  <table width="1000" border="1" style="border-collapse:collapse" cellpadding="2" cellspacing="3">
    <tr class="tabel_header">
      <td colspan="6" align="center"><h3>NON CONFORMANCE REPORT</h3></td>
    </tr>
    <tr>
      <td width="175" height="62" valign="top">Non Conformance Report :</td>
      <td colspan="3"><input name="title_ncr" type="text" id="title_ncr" value="<?php echo $row_q_ncr['title_ncr']; ?>" /></td>
      <td valign="top">NCR No. :</td>
      <td valign="top"><input name="no_ncr" type="text" id="no_ncr" value="<?php echo $row_q_ncr['no_ncr']; ?>" /></td>
    </tr>
    <tr>
      <td>Department / Supplier :</td>
      <td colspan="3"><?php echo $row_h_dept['department']; ?></td>
      <td><label for="prod_code3">Prod Code :</label></td>
      <td><?php echo $row_q_ncr['prod_code']; ?> <?php echo $row_q_ncr['prod_code_other']; ?></td>
    </tr>
    <tr>
      <td>Originator / Requestor :</td>
      <td colspan="3"><?php echo $row_q_ncr['req']; ?></td>
      <td>Date :</td>
      <td><?php echo functddmmmyyyy($row_q_ncr['ncr_date']); ?></td>
    </tr>
    <tr>
      <td colspan="6"><p>Detail of Conformity :</p></td>
    </tr>
    <tr>
      <td colspan="6"><label for="detail2"></label>
        <textarea readonly="readonly" name="detail" id="detail2" cols="150" rows="10"><?php echo $row_q_ncr['detail']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td width="189">Approved by :</td>
      <td width="241"><label for="apprv_det2"><?php echo $row_apprv_det['firstname']; ?> <?php echo $row_apprv_det['midlename']; ?> <?php echo $row_apprv_det['lastname']; ?></label></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td>Date :</td>
      <td><?php echo functddmmmyyyy($row_q_ncr['apprv_det_date']); ?></td>
    </tr>
    <tr class="tabel_header">
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" class="tabel_body"><p>Disposition :</p></td>
    </tr>
    <tr>
      <td colspan="6"><b>Corrective Action Recommendation</b>:</td>
    </tr>
    <tr>
      <td colspan="6"><label for="disp_cor2"></label>
        <textarea readonly="readonly" name="disp_corect" id="disp_corect" cols="150" rows="10"><?php echo $row_q_ncr['disp_correct']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="6"><b>Preventive Action Recommendation</b> :</td>
    </tr>
    <tr>
      <td colspan="6"><label for="disp_prevent2"></label>
        <textarea readonly="readonly" name="disp_prevent" id="disp_prevent2" cols="150" rows="5"><?php echo $row_q_ncr['disp_prevent']; ?></textarea></td>
    </tr>
    <tr>
      <td>Dispositioner :</td>
      <td width="257"><?php echo $row_dispositioner['firstname']; ?> <?php echo $row_dispositioner['midlename']; ?> <?php echo $row_dispositioner['lastname']; ?></td>
      <td width="86">Approved By</td>
      <td width="3">:</td>
      <td><?php echo $row_apprv_disp['firstname']; ?> <?php echo $row_apprv_disp['midlename']; ?> <?php echo $row_apprv_disp['lastname']; ?></td>
      <td>Completion Date</td>
    </tr>
    <tr>
      <td colspan="6" class="tabel_body">&nbsp;</td>
    </tr>
    <tr>
      <td>Date :</td>
      <td><?php echo functddmmmyyyy($row_q_ncr['disp_date']); ?></td>
      <td>Date</td>
      <td>:</td>
      <td><?php echo functddmmmyyyy($row_q_ncr['apprv_disp_date']); ?></td>
      <td><?php echo functddmmmyyyy($row_q_ncr['comp_date']); ?></td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td>Closed By ( Quality Department ) :</td>
      <td colspan="3"><?php echo $row_closed_by['firstname']; ?> <?php echo $row_closed_by['midlename']; ?> <?php echo $row_closed_by['lastname']; ?></td>
      <td>Reviewed By ( QMR )</td>
      <td><?php echo $row_reviewed_by['firstname']; ?> <?php echo $row_reviewed_by['midlename']; ?> <?php echo $row_reviewed_by['lastname']; ?></td>
    </tr>
    <tr>
      <td>Date :</td>
      <td colspan="5"><?php echo functddmmmyyyy($row_q_ncr['date_closed']); ?></td>
    </tr>
    <tr>
      <td valign="top">Comment :</td>
      <td colspan="3">
        <textarea readonly="readonly" name="comment" id="comment4" cols="50" rows="5" style="border:thin"><?php echo $row_q_ncr['comment']; ?></textarea></td>
      <td valign="top">Cost :</td>
      <td valign="top"><?php echo $row_q_ncr['cost']; ?></td>
    </tr>
    <tr>
      <td class="tabel_header" colspan="6">&nbsp;</td>
    </tr>
    
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($h_dept);

mysql_free_result($q_ncr);

mysql_free_result($prod_code);

mysql_free_result($dispositioner);

mysql_free_result($apprv_det);

mysql_free_result($apprv_disp);

mysql_free_result($closed_by);

mysql_free_result($reviewed_by);
?>
