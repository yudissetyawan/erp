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
  $updateSQL = sprintf("UPDATE a_pra_code SET customer=%s, tendername=%s, tenderno=%s, duration=%s, duration_satuan=%s, startdate=%s, finishdate=%s, registration=%s, closingdate=%s, prebid=%s, remark=%s, fileupload=%s, priceestimation=%s, curency=%s, status=%s WHERE pracode=%s",
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['tendername'], "text"),
                       GetSQLValueString($_POST['tenderno'], "text"),
                       GetSQLValueString($_POST['duration'], "text"),
                       GetSQLValueString($_POST['satuan'], "text"),
                       GetSQLValueString($_POST['startdate'], "text"),
                       GetSQLValueString($_POST['finishdate'], "text"),
                       GetSQLValueString($_POST['registration'], "text"),
                       GetSQLValueString($_POST['closingdate'], "text"),
                       GetSQLValueString($_POST['prebid'], "text"),
                       GetSQLValueString($_POST['remarks'], "text"),
                       GetSQLValueString($_POST['fileupload'], "text"),
                       GetSQLValueString($_POST['priceestimation'], "int"),
                       GetSQLValueString($_POST['curency'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['pracode'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

if ($_POST['status'] == 'WIN') { $vgoto = "inputcontract.php"; } else { $vgoto = "view_tender.php"; }
		
  $updateGoTo = "$vgoto";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM a_customer ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM a_pra_code WHERE id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && $_POST['status'] != $_POST['hfstat']) {
	
	mysql_select_db($database_core, $core);
	if ($_POST['status'] == 'WIN') {
		$query_rsidempdept = "SELECT h_employee.id,  h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Marketing' OR h_employee.department = 'Commercial' OR h_employee.department = 'Finance' OR h_employee.userlevel = 'branchmanager' OR h_employee.userlevel = 'administrator' OR h_employee.userlevel = '0'";
		$vgoto = "inputcontract.php";
	} else {
		$query_rsidempdept = "SELECT h_employee.id,  h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Marketing' OR h_employee.department = 'Commercial' OR h_employee.department = 'Finance' OR h_employee.userlevel = 'branchmanager' OR h_employee.userlevel = 'administrator'";
		$vgoto = "view_tender.php";
	}
	$rsidempdept = mysql_query($query_rsidempdept, $core) or die(mysql_error());
	$row_rsidempdept = mysql_fetch_assoc($rsidempdept);
	$totalRows_rsidempdept = mysql_num_rows($rsidempdept);

	do { //do seharusnya di bawah if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
							   GetSQLValueString("3", "int"),
							   GetSQLValueString($_POST['hfidtender'], "text"),
							   GetSQLValueString($row_rsidempdept['id'], "int"),
							   GetSQLValueString('Tender No. : '.$_POST['tenderno'].', Tender Name : '.$_POST['tendername'].', Status = '.$_POST['status'], "text"));
		
		  mysql_select_db($database_core, $core);
		  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	}
	while ($row_rsidempdept = mysql_fetch_assoc($rsidempdept));	
	
	echo "<script>parent.window.location.reload(true);</script>";
	
	$insertGoTo = "$vgoto";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$panjang = strlen($row_Recordset2["pracode"]); // cari panjang max dari string yg di dapat dari query
$tampungku = substr($row_Recordset2["pracode"],1,$panjang); // potong string, ambil nilai selain 'J'
$nextIncrement =(int)$tampungku + 1; // naekan nilai nya.... misalnya dapat J004.. maka disini jd nya 4 + 1 = 5
//
if($nextIncrement < 10){
	// pengecekan nilai increment
	$nextString = "P" . $nextIncrement; // jadinya J005
	//
} else if($nextIncrement >= 100){
	// pengecekan nilai increment
	$nextString = "P" . $nextIncrement; // jadinya J005
	//
} else {
	// pengecekan nilai increment
	$nextString = "P" . $nextIncrement; // jadinya J005
	//
}
//tambahkan else nya kalau mau... misnya kl <100 .. maka J0 . $nextIncrement dst....
//echo $nextString;
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
<title>Input Tender</title>
</head>

<body class="General">
<?php { include "../date.php"; include "uploadtender.php"; } ?>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="940" border="0">
    <tr>
      <td width="92">Pracode</td>
      <td width="21">:</td>
      <td colspan="2"><input name="pracode" type="text" class="required" id="pracode" title="Pracode Harus Diisi" value="<?php echo $row_Recordset3['pracode']; ?>" 
      /></td>
      <td>PQ Submission</td>
      <td width="16">&nbsp;</td>
      <td colspan="2"><input name="registration" type="text" id="tanggal2" value="<?php echo $row_Recordset3['registration']; ?>" /></td>
    </tr>
    <tr>
      <td>Title Of Tender</td>
      <td>:</td>
      <td colspan="2"><textarea name="tendername" cols="40" id="tendername"><?php echo $row_Recordset3['tendername']; ?></textarea></td>
      <td>Pre- Bid</td>
      <td>&nbsp;</td>
      <td colspan="2"><input name="prebid" type="text" id="tanggal5" value="<?php echo $row_Recordset3['prebid']; ?>" /></td>
    </tr>
    <tr>
      <td>Tender No.</td>
      <td>:</td>
      <td colspan="2"><input name="tenderno" type="text" id="tenderno" value="<?php echo $row_Recordset3['tenderno']; ?>" /></td>
      <td width="186">Owner</td>
      <td>:</td>
      <td colspan="2"><textarea name="customer" cols="40" id="customer"><?php echo $row_Recordset3['customer']; ?></textarea></td>
    </tr>
    <tr>
      <td>Duration</td>
      <td>:</td>
      <td width="93"><input name="duration" type="text" id="duration" value="<?php echo $row_Recordset3['duration']; ?>" size="6" /></td>
      <td width="172"><input name="satuan" type="text" id="satuan" value="<?php echo $row_Recordset3['duration_satuan']; ?>" size="8"  />
      </td>
      <td>Collect Document</td>
      <td>&nbsp;</td>
      <td colspan="2"><input name="finishdate" type="text" id="tanggal3" value="<?php echo $row_Recordset3['finishdate']; ?>" /></td>
    </tr>
    <tr>
      <td>Registrasi Tender</td>
      <td>:</td>
      <td colspan="2"><input name="startdate" type="text" id="tanggal1" value="<?php echo $row_Recordset3['startdate']; ?>" /></td>
      <td>Closing Date</td>
      <td>:</td>
      <td colspan="2"><input name="closingdate" type="text" id="tanggal4" value="<?php echo $row_Recordset3['closingdate']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>:</td>
      <td colspan="2">&nbsp;</td>
      <td>Estimation Value (USD)</td>
      <td>:</td>
      <td><input name="priceestimation" type="text" id="priceestimation" value="<?php echo $row_Recordset3['priceestimation']; ?>" /></td>
      <td><input name="curency" type="text" id="curency" value="<?php echo $row_Recordset3['curency']; ?>" size="6"  /></td>
    </tr>
    <tr>
      <td>Remarks</td>
      <td>:</td>
      <td colspan="2"><textarea name="remarks" cols="40" rows="4" id="remarks"><?php echo $row_Recordset3['remark']; ?></textarea></td>
      <td>Status Tender</td>
      <td>:</td>
      <td><input type="hidden" name="hfstat" id="hfstat" value="<?php echo $row_Recordset3['status']; ?>" />
        <select name="status" id="status">
          <option value="On Progress" <?php if ($row_Recordset3['status'] == 'On Progress') { ?> selected="selected" <?php } ?>>On Progress</option>
          <option value="WIN" <?php if ($row_Recordset3['status'] == 'WIN') { ?> selected="selected" <?php } ?>>WIN</option>
          <option value="LOSE" <?php if ($row_Recordset3['status'] == 'LOSE') { ?> selected="selected" <?php } ?>>LOSE</option>
          <option value="REGISTER" <?php if ($row_Recordset3['status'] == 'REGISTER') { ?> selected="selected" <?php } ?>>REGISTER</option>
          <option value="FAILURE" <?php if ($row_Recordset3['status'] == 'FAILURE') { ?> selected="selected" <?php } ?>>FAILURE</option>
          <option value="SUBMIT" <?php if ($row_Recordset3['status'] == 'SUBMIT') { ?> selected="selected" <?php } ?>>SUBMIT</option>
          <option value="RE-TENDER" <?php if ($row_Recordset3['status'] == 'RE-TENDER') { ?> selected="selected" <?php } ?>>RE-TENDER</option>
          <option value="NO-QUOTATION" <?php if ($row_Recordset3['status'] == 'NO-QUOTATION') { ?> selected="selected" <?php } ?>>NO-QUOTATION</option>
        </select></td>
      <td width="169">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
      <input type="hidden" name="hfidtender" id="hfidtender" value="<?php echo $row_Recordset3['id']; ?>" />
      <td><input name="fileupload" type="text" class="hidentext" id="fileupload" value="<?php if ($nama_file==""){echo $row_Recordset3['fileupload'];} else {echo $nama_file;} ?>" /></td>
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="save" id="save" value="Submit" onClick="<a href="inputcontract.php?data=<?php echo $row_Recordset['id']; ?></td />      </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset3);

mysql_free_result($rsidempdept);
?>
