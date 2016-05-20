<?php require_once('../Connections/core.php'); ?>
<?php
$nama_file = $_FILES['file']['name']; 

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
  $insertSQL = sprintf("INSERT INTO a_pra_code (pracode, customer, tendername, tenderno, duration, duration_satuan, startdate, finishdate, registration, closingdate, prebid, remark, fileupload, priceestimation, curency) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '$nama_file', %s, %s)",
                       GetSQLValueString($_POST['pracode'], "text"),
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
                       GetSQLValueString($_POST['priceestimation'], "int"),
                       GetSQLValueString($_POST['curency'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "view_tender.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

//GIVE NOTIF
mysql_select_db($database_core, $core);
$query_rsidempdept = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Marketing' OR h_employee.department = 'Commercial' OR h_employee.department = 'Finance' OR h_employee.userlevel = 'branchmanager' OR h_employee.userlevel = 'administrator'";
$rsidempdept = mysql_query($query_rsidempdept, $core) or die(mysql_error());
$row_rsidempdept = mysql_fetch_assoc($rsidempdept);
$totalRows_rsidempdept = mysql_num_rows($rsidempdept);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString("3", "int"),
						   GetSQLValueString($_POST['pracode'], "text"),
						   GetSQLValueString($row_rsidempdept['id'], "int"),
						   GetSQLValueString('Pra-Code : '.$_POST['pracode'].', Title of Tender : '.$_POST['tendername'].' has been created', "text"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	}
	while ($row_rsidempdept = mysql_fetch_assoc($rsidempdept));

  $insertGoTo = "view_tender.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM a_customer ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT pracode FROM a_pra_code ORDER BY pracode DESC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$year=date(y);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM a_pra_code ORDER BY pracode DESC LIMIT 1"));
$cekQ=$ceknomor[pracode];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextpracode=sprintf ($year.'8'."%02d", $next);
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
<title>Input Pracode</title>
</head>

<body class="General">
<?php { include "../date.php"; include "prosesupload.php"; } ?>
<form action="<?php echo $editFormAction; ?>"  method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="1000" border="0">
    <tr>
      <td width="130">Pracode</td>
      <td width="20">:</td>
      <td colspan="2"><input name="pracode" type="text" class="required" id="pracode" title="Pracode Harus Diisi" value="<?php echo $nextpracode;?>" readonly="readonly" />      
      *Auto Unique Code </td>
      <td width="20">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Title Of Tender</td>
      <td>:</td>
      <td colspan="2"><textarea name="tendername" cols="40" id="tendername"></textarea></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Tender No.</td>
      <td>:</td>
      <td width="241"><input type="text" name="tenderno" id="tenderno" /></td>
      <td width="157">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Owner</td>
      <td>:</td>
      <td><select name="customer" id="customer" class="required" title="Please select Customer">
        <option value="">-- Pilih Customer --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['customername']?>"><?php echo $row_Recordset1['customername']?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Duration</td>
      <td>:</td>
      <td><input name="duration" type="text" id="duration" size="6" />
<select name="satuan" id="satuan">
<option value="Week">Week</option>
  <option value="Month">Month</option>
  <option value="Year">Year</option>
      </select></td>
      <td>Collect Document</td>
      <td>&nbsp;</td>
      <td colspan="2"><input type="text" name="finishdate" id="tanggal2" /></td>
    </tr>
    <tr>
      <td>Registrasi Tender</td>
      <td>:</td>
      <td><input type="text" name="startdate" id="tanggal1" /></td>
      <td>Closing Date</td>
      <td>:</td>
      <td colspan="2"><input name="closingdate" id="tanggal4" /></td>
    </tr>
    <tr>
      <td>PQ Submission</td>
      <td>:</td>
      <td><input type="text" name="registration" id="tanggal3" /></td>
      <td>Estimation Value</td>
      <td>:</td>
      <td colspan="2"><input type="text" name="priceestimation" id="priceestimation" />
        <select name="curency" id="curency">
          <option value="USD">USD</option>
          <option value="IDR">IDR</option>
      </select></td>
    </tr>
    <tr>
      <td>Pre- Bid</td>
      <td>:</td>
      <td><input name="prebid" id="tanggal5" /></td>
      <td colspan="4">Pilih File:
      <input type="file" name="file" id="file"  /></td>
      <?php $nama=$_FILES['file']['name'];?>
    </tr>
    <tr>
      <td colspan="2">Remarks</td>
      <td><textarea name="remarks" cols="40" id="remarks"></textarea></td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4">
		<input type="submit" name="submit" value="Submit" />
		</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
