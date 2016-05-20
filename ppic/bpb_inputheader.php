<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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
  $insertSQL = sprintf("INSERT INTO p_bpb_header (bpb_no, bpb_date, wo_number_or_spk, request_by, approved_by) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['bpb_no'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['bpb_date']), "text"),
                       GetSQLValueString($_POST['wo_number_or_spk'], "text"),
					   GetSQLValueString($_POST['cmbrequestby'], "int"),
                       GetSQLValueString($_POST['cmbapprovedby'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

	$q = mysql_fetch_array(mysql_query("SELECT id FROM p_bpb_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"bpb_viewcore.php?data=$cekID\";</script>";
}

mysql_select_db($database_core, $core);
$query_rswono = "SELECT id AS idheader_wpr, wo_no FROM pr_header_wpr";
$rswono = mysql_query($query_rswono, $core) or die(mysql_error());
$row_rswono = mysql_fetch_assoc($rswono);
$totalRows_rswono = mysql_num_rows($rswono);

mysql_select_db($database_core, $core);
$query_rsrequestby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE userlevel = 'fabrication' AND code = 'K' ORDER BY firstname ASC";
$rsrequestby = mysql_query($query_rsrequestby, $core) or die(mysql_error());
$row_rsrequestby = mysql_fetch_assoc($rsrequestby);
$totalRows_rsrequestby = mysql_num_rows($rsrequestby);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE userlevel='production' AND code = 'K' ORDER BY firstname ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$year = date(y);
$month = date(m);
$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM p_bpb_header ORDER BY bpb_no DESC LIMIT 1"));
$cekQ = $ceknomor[bpb_no];
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
$nextno_bpb = sprintf ('B.BPN'.'/'.$year.'/'.$month.'/'.$nextString);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input BPB</title>
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
<p><b>Entry BPB</b></p>
<?php { include "../date.php"; } ?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr>
      <td>BPB No.</td>
      <td>:</td>
      <td><input type="text" name="bpb_no" value="<?php echo $nextno_bpb; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td><input type="text" name="bpb_date" id="tanggal8" value="<?php echo date("d M Y") ?>" size="32" /></td>
    </tr>
    <tr>
      <td>WO No. / SPK</td>
      <td>:</td>
      <td><select name="wo_number_or_spk" id="wo_number_or_spk">
        <option value="">-- WO No. --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rswono['wo_no']?>"><?php echo $row_rswono['wo_no']?></option>
        <?php
} while ($row_rswono = mysql_fetch_assoc($rswono));
  $rows = mysql_num_rows($rswono);
  if($rows > 0) {
      mysql_data_seek($rswono, 0);
	  $row_rswono = mysql_fetch_assoc($rswono);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Request by</td>
      <td>:</td>
      <td><select name="cmbrequestby" id="cmbrequestby">
        <option value="">-- Request by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsrequestby['id']?>"><?php echo $row_rsrequestby['firstname']?> <?php echo $row_rsrequestby['midlename']; ?> <?php echo $row_rsrequestby['lastname']; ?></option>
        <?php
} while ($row_rsrequestby = mysql_fetch_assoc($rsrequestby));
  $rows = mysql_num_rows($rsrequestby);
  if($rows > 0) {
      mysql_data_seek($rsrequestby, 0);
	  $row_rsrequestby = mysql_fetch_assoc($rsrequestby);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Approved by</td>
      <td>:</td>
      <td><select name="cmbapprovedby" id="cmbapprovedby">
        <option value="">-- Approved by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['firstname']?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
      <td><input type="submit" value="Add" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rswono);

mysql_free_result($rsrequestby);

mysql_free_result($Recordset1);
?>
