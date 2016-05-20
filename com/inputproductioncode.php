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
	$insertSQL = sprintf("INSERT INTO a_production_code (projectcode, productioncode, wrno, `date`, status, Reference, principalvalue, curency, Location, projecttitle, quantity, contactperson, commdate, completedate, vendor, remark, fileupload) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['projectcode2'], "text"),
                       GetSQLValueString($_POST['productioncode'], "text"),
                       GetSQLValueString($_POST['wrno'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['reference'], "text"),
                       GetSQLValueString($_POST['principalvalue'], "text"),
                       GetSQLValueString($_POST['curency'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['projecttitle'], "text"),
                       GetSQLValueString($_POST['quantity'], "text"),
                       GetSQLValueString($_POST['contactperson'], "text"),
                       GetSQLValueString($_POST['commdate'], "text"),
                       GetSQLValueString($_POST['completedate'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['fileupload'], "text"));

	mysql_select_db($database_core, $core);
	$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	
/*
	$prodcd = $_POST['productioncode'];
	echo "<script>alert(\"$prodcd has been submitted\");</script>";
	
	$insertGoTo = "form_comm.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $insertGoTo));
}
	*/

	if ($_POST['status'] == '1') {
		//if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		mysql_select_db($database_core, $core);
		$query_rsidempdept = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Procurement' OR h_employee.department = 'Commercial' OR h_employee.department = 'Finance' OR h_employee.department = 'Project' OR h_employee.department = 'Engineering' AND h_employee.level = '0' OR h_employee.userlevel = 'administrator' OR h_employee.userlevel = 'branchmanager'";
		$rsidempdept = mysql_query($query_rsidempdept, $core) or die(mysql_error());
		$row_rsidempdept = mysql_fetch_assoc($rsidempdept);
		$totalRows_rsidempdept = mysql_num_rows($rsidempdept);
		
		//$query_rsidempdept = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Marketing' OR h_employee.department = 'Commercial' OR h_employee.userlevel = 'administrator'";
		
		do {
			$insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($_POST['hfidinisial'], "int"),
						   GetSQLValueString($_POST['hfidprodcode'], "text"),
						   GetSQLValueString($row_rsidempdept['id'], "int"),
						   GetSQLValueString($_POST['hfisi'], "text"));
		
			mysql_select_db($database_core, $core);
			$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
		
		} while ($row_rsidempdept = mysql_fetch_assoc($rsidempdept));	
	}
	
	$insertGoTo = "form_comm.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_proj_code WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM a_production_code WHERE projectcode = %s ORDER BY productioncode DESC", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM c_ctr WHERE id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM pr_header_wpr WHERE idctr = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM c_total_ctr WHERE id_ctr = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Production Code</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

<style type="text/css">
	* { font:"Times New Roman", Times, serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>  

</head>

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

<body class="General">
<p><b>Input Production detail from Project <?php echo $row_Recordset1['project_code']; ?></b></p>

<?php { include "uploadctr.php"; include "../date.php"; } ?>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="956" border="0">
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td class="General"><label>
        <input name="projectcode2" type="text" id="projectcode2" value="<?php echo $row_Recordset3['projectcode']; ?>" readonly />
      </label></td> 
<?php
	$cari = $row_Recordset3['projectcode'];
	$year = date(y);
	 // cari panjang max dari string yg di dapat dari query
	$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM a_production_code WHERE projectcode LIKE '%$cari%' ORDER BY productioncode DESC LIMIT 1"));
	$cekQ = $ceknomor[productioncode];
	#menghilangkan huruf
	$awalQ = substr($cekQ,-3);
	#ketemu angka awal(angka sebelumnya) + dengan 1
	$next = (int)$awalQ+1;
	$nextprodcode = sprintf($year."%03d", $next);
?>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td width="138" class="General">Production Code</td>
      <td width="11">:</td>
      <td width="260" class="General"><label>
        <input name="productioncode" type="text" class="required" id="productioncode" title="Production Code tidak boleh kosong" value="<?php echo $nextprodcode; ?>" readonly />
      </label></td>
      <td width="181" class="General">&nbsp;</td>
      <td width="24" class="General">&nbsp;</td>
      <td width="316" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Reference</td>
      <td>:</td>
      <td class="General"><input name="reference" type="text" id="reference" value="<?php echo $row_Recordset3['reference']; ?>" /></td>
      <td class="General">Contact Person</td>
      <td>:</td>
      <td class="General"><input name="contactperson" type="text" id="contactperson" value="<?php echo $row_Recordset3['contactperson']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Date</td>
      <td>:</td>
      <td class="General"><input name="date" type="text" id="tanggal1" value="<?php echo $row_Recordset3['date']; ?>" /></td>
      <td class="General">Comm. Date</td>
      <td>:</td>
      <td class="General"><input name="commdate" type="text" id="tanggal2" value="<?php echo $row_Recordset4['startdate']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td class="General"><input name="location" type="text" id="location" value="<?php echo $row_Recordset3['location']; ?>" /></td>
      <td class="General">Completion Date</td>
      <td>:</td>
      <td class="General"><input name="completedate" type="text" id="tanggal3" value="<?php echo $row_Recordset4['finishdate']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Project Title</td>
      <td>:</td>
      <td class="General"><textarea cols="40" name="projecttitle" id="projecttitle"><?php echo $row_Recordset3['projecttitle']; ?></textarea></td>
      <td class="General">WR/ WO No</td>
      <td>:</td>
      <td class="General"><label for="nowr"></label>
      <input name="wrno" type="text" id="wrno" value="<?php echo $row_Recordset4['wo_no']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Quantity</td>
      <td>:</td>
      <td class="General"><input name="quantity" type="text" id="quantity" value="<?php echo $row_Recordset3['quantity']; ?>" /></td>
      <td class="General">WR/ WO Value</td>
      <td>:</td>
      <td class="General"><input name="principalvalue" type="text" class="required" id="principalvalue" title="Silahkan isi Budget" value="<?php echo number_format ( $row_Recordset5['total_wovalue'],2); ?>" />
        <select name="curency" id="curency">
          <option value="USD">USD</option>
          <option value="IDR">IDR</option>
      </select></td>
    </tr>
    <tr>
      <td class="General">Vendor</td>
      <td>:</td>
      <td class="General"><textarea name="vendor" id="vendor"><?php echo $row_Recordset3['customer']; ?></textarea></td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
<td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Remark</td>
      <td>:</td>
      <td class="General"><textarea name="remark" id="remark" cols="40" rows="5" class="required" title="Silahkan isi Description"><?php echo $row_Recordset3['remark']; ?></textarea></td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      
      <td class="General">Project Status</td>
      <td>:</td>
      <td class="General"><select name="status" id="status" class="required" title="Silahkan pilih Status">
        <option value="">-- Piih Status --</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select></td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General"><input name="fileupload" type="text" class="hidentext" id="fileupload" value="<?php echo $nama_file; ?>" /></td>
    </tr>
    <tr>
      <td class="General"><input name="projectcode" type="hidden" id="projectcode" value="<?php echo $row_Recordset1['id']; ?>">
      <input name="idctr" type="hidden" id="idctr" value="<?php echo $row_Recordset3['id']; ?>" /> </td>
      <td colspan="5"><label>
        <input type="submit" name="Save" id="Save" value="Save" onclick="alert('Prod. code ' + document.getElementById('productioncode').value + ' has been submitted')">
        <input type="hidden" name="hfidinisial" id="hfidinisial" value="59" />
        <input type="hidden" name="hfidprodcode" id="hfidprodcode" value="<?php echo $nextprodcode; ?>" />
<input type="hidden" name="hfisi" id="hfisi" value="Production Code : <?php echo $nextprodcode; ?>, Contract Name : <?php echo $row_Recordset3['projecttitle']; ?> has been created " />
      </label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($rsidempdept);
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset2);
	mysql_free_result($Recordset3);
	mysql_free_result($Recordset4);
	mysql_free_result($Recordset5);
?>