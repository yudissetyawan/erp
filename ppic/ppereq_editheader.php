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
	require_once "../dateformat_funct.php";
  $updateSQL = sprintf("UPDATE p_ppereq_header SET ppereq_no=%s, ppereq_date=%s, id_projcode=%s, note=%s, req_by_manager=%s, req_sign_date=%s, passed_by=%s, passed_date=%s, distrib_by=%s, distrib_date=%s WHERE id=%s",
                       GetSQLValueString($_POST['ppereq_no'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['ppereq_date']), "text"),
					   GetSQLValueString($_POST['id_projcode'], "text"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['req_by_manager'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['req_sign_date']), "text"),
                       GetSQLValueString($_POST['passed_by'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['passed_date']), "text"),
                       GetSQLValueString($_POST['distrib_by'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['distrib_date']), "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "ppereq_viewheader.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}



mysql_select_db($database_core, $core);
$query_rscmbmanager = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE h_employee.userlevel = 'branchmanager' AND code = 'K' ORDER BY firstname ASC";
$rscmbmanager = mysql_query($query_rscmbmanager, $core) or die(mysql_error());
$row_rscmbmanager = mysql_fetch_assoc($rscmbmanager);
$totalRows_rscmbmanager = mysql_num_rows($rscmbmanager);

mysql_select_db($database_core, $core);
$query_rscmbpassby = "SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.id FROM h_employee WHERE h_employee.department LIKE '%HRD%' AND code='K'";
$rscmbpassby = mysql_query($query_rscmbpassby, $core) or die(mysql_error());
$row_rscmbpassby = mysql_fetch_assoc($rscmbpassby);
$totalRows_rscmbpassby = mysql_num_rows($rscmbpassby);

mysql_select_db($database_core, $core);
$query_rscmbdistby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'PPIC' AND code = 'K' ORDER BY firstname ASC";
$rscmbdistby = mysql_query($query_rscmbdistby, $core) or die(mysql_error());
$row_rscmbdistby = mysql_fetch_assoc($rscmbdistby);
$totalRows_rscmbdistby = mysql_num_rows($rscmbdistby);

$colname_rsppereqheader = "-1";
if (isset($_GET['data'])) {
  $colname_rsppereqheader = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsppereqheader = sprintf("SELECT * FROM p_ppereq_header WHERE id = %s", GetSQLValueString($colname_rsppereqheader, "int"));
$rsppereqheader = mysql_query($query_rsppereqheader, $core) or die(mysql_error());
$row_rsppereqheader = mysql_fetch_assoc($rsppereqheader);
$totalRows_rsppereqheader = mysql_num_rows($rsppereqheader);

mysql_select_db($database_core, $core);
$query_rscmbprojcd = "SELECT a_proj_code.id, a_proj_code.project_code, a_proj_code.projecttitle FROM a_proj_code ORDER BY a_proj_code.project_code ASC";
$rscmbprojcd = mysql_query($query_rscmbprojcd, $core) or die(mysql_error());
$row_rscmbprojcd = mysql_fetch_assoc($rscmbprojcd);
$totalRows_rscmbprojcd = mysql_num_rows($rscmbprojcd);

$year=date(y);
$month=date(m);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM p_mr_header ORDER BY nomr DESC LIMIT 1"));
$cekQ=$ceknomor[nomr];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;

if($next <10){
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J005
//
} else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "" . $next; // jadinya J005
//
} else {
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J005
//
} $nextpracode=sprintf ('R.BPN'.'/'.$year.'/'.$month.'/'.$nextString);
?>

<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#form1").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>



<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit PPE Header</title>
</head>

<body>
<?php { include "../date.php"; require_once "../dateformat_funct.php"; } ?>
<h3>Edit PPE Header</h3>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="700" border="0">
    <tr>
      <td width="225" class="General">PPE Request No.</td>
      <td width="10">:</td>
      <td><input name="ppereq_no" type="text" id="ppereq_no" value="<?php echo $row_rsppereqheader['ppereq_no']; ?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $row_rsppereqheader['id']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Date</td>
      <td>:</td>
      <td><input name="ppereq_date" type="text" id="tanggal8" value="<?php echo functddmmmyyyy($row_rsppereqheader['ppereq_date']); ?>" size="12" /></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td><select name="id_projcode" id="id_projcode">
        <option value="">-- Select Project Code --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbprojcd['id']?>" <?php if ($row_rscmbprojcd['id'] == $row_rsppereqheader['id_projcode']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbprojcd['project_code']?> <?php echo $row_rscmbprojcd['projecttitle']?></option>
        <?php
} while ($row_rscmbprojcd = mysql_fetch_assoc($rscmbprojcd));
  $rows = mysql_num_rows($rscmbprojcd);
  if($rows > 0) {
      mysql_data_seek($rscmbprojcd, 0);
	  $row_rscmbprojcd = mysql_fetch_assoc($rscmbprojcd);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Note</td>
      <td>:</td>
      <td>
      <textarea name="note" id="note" cols="45" rows="4"><?php echo $row_rsppereqheader['note']; ?></textarea></td>
    </tr>
    <tr>
      <td class="General">Request by (Manager)</td>
      <td>:</td>
      <td><select name="req_by_manager" id="req_by_manager">
          <option value="">-- Select Request by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbmanager['id']; ?>" <?php if ($row_rscmbmanager['id'] == $row_rsppereqheader['req_by_manager']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbmanager['firstname']; ?> <?php echo $row_rscmbmanager['midlename']; ?> <?php echo $row_rscmbmanager['lastname']; ?></option>
        <?php
} while ($row_rscmbmanager = mysql_fetch_assoc($rscmbmanager));
  $rows = mysql_num_rows($rscmbmanager);
  if($rows > 0) {
      mysql_data_seek($rscmbmanager, 0);
	  $row_rscmbmanager = mysql_fetch_assoc($rscmbmanager);
  }
?>
      </select></td>
    </tr>
    
    <tr>
      <td class="General">Request Date</td>
      <td>:</td>
      <td><input name="req_sign_date" type="text" id="tanggal9" value="<?php echo functddmmmyyyy($row_rsppereqheader['req_sign_date']); ?>" size="12" /></td>
    </tr>
    <tr>
      <td class="General">Passed by (HRD)</td>
      <td>:</td>
      <td>
		<select name="passed_by" id="passed_by" class="required" title="Please select Passed by">
        <option value="">-- Select Passed by --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rscmbpassby['id']?>" <?php if ($row_rscmbpassby['id'] == $row_rsppereqheader['passed_by']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbpassby['firstname']; ?> <?php echo $row_rscmbpassby['midlename']; ?> <?php echo $row_rscmbpassby['lastname'];?></option>
          <?php
} while ($row_rscmbpassby = mysql_fetch_assoc($rscmbpassby));
  $rows = mysql_num_rows($rscmbpassby);
  if($rows > 0) {
      mysql_data_seek($rscmbpassby, 0);
	  $row_rscmbpassby = mysql_fetch_assoc($rscmbpassby);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Passed Date</td>
      <td>:</td>
      <td><input name="passed_date" type="text" id="tanggal10" value="<?php echo functddmmmyyyy($row_rsppereqheader['passed_date']); ?>" size="12" /></td>
    </tr>
    <tr>
      <td class="General">Distributed by</td>
      <td>:</td>
      <td><select name="distrib_by" id="distrib_by" class="required" title="Please select Distributed by">
        <option value="">-- Select Distributed by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbdistby['id']?>" <?php if ($row_rscmbdistby['id'] == $row_rsppereqheader['distrib_by']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbdistby['firstname']?> <?php echo $row_rscmbdistby['midlename']; ?> <?php echo $row_rscmbdistby['lastname'];?></option>
        <?php
} while ($row_rscmbdistby = mysql_fetch_assoc($rscmbdistby));
  $rows = mysql_num_rows($rscmbdistby);
  if($rows > 0) {
      mysql_data_seek($rscmbdistby, 0);
	  $row_rscmbdistby = mysql_fetch_assoc($rscmbdistby);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Distributed Date</td>
      <td>:</td>
      <td><input name="distrib_date" type="text" id="tanggal11" value="<?php echo functddmmmyyyy($row_rsppereqheader['distrib_date']); ?>" size="12" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="General">&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($rscmbmanager);
	mysql_free_result($rscmbpassby);
	mysql_free_result($rscmbdistby);

mysql_free_result($rsppereqheader);

mysql_free_result($rscmbprojcd);
?>