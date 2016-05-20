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
  $insertSQL = sprintf("INSERT INTO dms (id_departemen, fileupload) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_pekerjaan'], "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO p_mr_header (nomr, `date`, note, requestby, passedby, approvedby, referencetype, status, id_prodcode, prodcode) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nomr'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal1']), "date"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['requestby'], "text"),
                       GetSQLValueString($_POST['passedby'], "text"),
                       GetSQLValueString($_POST['approvedby'], "text"),
					   GetSQLValueString($_POST['referencetype'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id_prodcode'], "int"),
					   GetSQLValueString($_POST['prodcode'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  /* $insertGoTo = "/ppic/view_headermrsr.php?data=" . $_POST['id_prodcode'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo)); */
  
  $q = mysql_fetch_array(mysql_query("SELECT id FROM p_mr_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"view_detailmrsr.php?data=$cekID\";</script>";
}

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

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
$nextString = "000" . $next; // jadinya J0005
//
} else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J0005
//
} else {
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J0005
//
} $nextpracode=sprintf ('R.BPN'.'/'.$year.'/'.$month.'/'.$nextString);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry M/S Request Header</title>
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

<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

<body>
<p><b>Entry Material / Service Request</b></p>
<h3><?php { include "../date.php"; include "uploadrefmrsr.php"; } ?></h3>

<table width="600" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3"><input type="hidden" name="idmsps" id="idmsps" value="" /></td>
  </tr>
  <tr>
    <td width="184"><b>Reference </b></td>
    <td width="16">:</td>
    <td width="400" ><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit1" value="Upload" />
    </form></td>
  </tr>
</table>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="600" border="0">
    <tr>
      <td width="184" class="General">M / S Request No.</td>
      <td width="16">:</td>
      <td width="400"><input type="text" name="nomr" id="nomr" class="required" title="M/S Request is required" value="<?php echo $nextpracode; ?>" readonly style="border:thin" />        
<input name="id_prodcode" type="hidden" id="id_prodcode" value="<?php echo $row_Recordset4['id']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Date</td>
      <td>:</td>
      <td><input type="text" name="tanggal1" id="tanggal8" value="<?php echo date("d M Y") ?>" /></td>
    </tr>
    <tr>
      <td class="General">Project</td>
      <td>:</td>
      <td><?php echo $row_Recordset4['projectcode']; ?> - <?php echo $row_Recordset4['projecttitle']; ?></td>
    </tr>
    <tr>
      <td class="General">Production Code</td>
      <td>:</td>
      <td><input name="prodcode" type="text" value="<?php echo $row_Recordset4['productioncode']; ?>" title="This Production Code can be changed with new" /></td>
    </tr>
    
    <tr>
      <td class="General">Request By</td>
      <td>:</td>
      <td><select name="requestby" id="requestby" class="required" title="Please select Request by">
        <option value="">-- Select Request by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsreqby['id']; ?>"><?php echo $row_rsreqby['firstname'] ?> <?php echo $row_rsreqby['midlename']; ?> <?php echo $row_rsreqby['lastname']; ?></option>
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
      <td class="General">Passed By</td>
      <td>:</td>
      <td><select name="passedby" id="passedby" class="required" title="Please select passed by">
        <option value="">-- Select Passed by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsuserppic['id']?>"><?php echo $row_rsuserppic['firstname']?> <?php echo $row_rsuserppic['midlename']; ?> <?php echo $row_rsuserppic['lastname']; ?></option>
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
      <td class="General">Approved By</td>
      <td>:</td>
      <td><select name="approvedby" id="approvedby" class="required" title="Please Approved by">
        <option value="">-- Select Approved by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsapprover['id']?>"><?php echo $row_rsapprover['firstname']?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?></option>
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
      <td class="General">Status</td>
      <td>:</td>
      <td><input type="text" name="status" id="status" class="required" title="Status is required" /></td>
    </tr>
    <tr>
      <td class="General">Reference</td>
      <td>:</td>
      <td><input type="text" name="referencetype" id="referencetype" value="<?php echo $nama_file;?>" readonly="readonly" title="Reference is required" /></td>
    </tr>
    <tr>
      <td class="General">Note</td>
      <td>:</td>
      <td><textarea name="note" id="note" cols="45" rows="2" class="required" title="Note is Required; such as WO Number"></textarea></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Save" /></td>
    </tr>
  </table>
  <p>
    <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_pekerjaan" type="hidden" id="id_pekerjaan" value="MR/SR"/>
  </p>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
</body>
</html>
<?php
	mysql_free_result($rsreqby);
	mysql_free_result($Recordset4);
	mysql_free_result($rsuserppic);
	mysql_free_result($rsapprover);
?>
