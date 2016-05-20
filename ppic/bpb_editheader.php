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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	include "../dateformat_funct.php";
  $updateSQL = sprintf("UPDATE p_bpb_header SET bpb_no=%s, bpb_date=%s, wo_number_or_spk=%s, request_by=%s, approved_by=%s, received_by=%s, accounting=%s WHERE id=%s",
                       GetSQLValueString($_POST['bpb_no'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['bpb_date']), "text"),
                       GetSQLValueString($_POST['wo_number_or_spk'], "text"),
                       GetSQLValueString($_POST['cmbrequestby'], "int"),
                       GetSQLValueString($_POST['cmbapprovedby'], "int"),
                       GetSQLValueString($_POST['cmbreceivedby'], "int"),
                       GetSQLValueString($_POST['accounting'], "int"),
                       GetSQLValueString($_POST['bpb_idheader'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "bpb_viewheader.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_core, $core);
$query_rswono = "SELECT id AS idheader_wpr, wo_no FROM pr_header_wpr";
$rswono = mysql_query($query_rswono, $core) or die(mysql_error());
$row_rswono = mysql_fetch_assoc($rswono);
$totalRows_rswono = mysql_num_rows($rswono);

mysql_select_db($database_core, $core);
$query_rsrequestby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE code = 'K' ORDER BY firstname ASC";
$rsrequestby = mysql_query($query_rsrequestby, $core) or die(mysql_error());
$row_rsrequestby = mysql_fetch_assoc($rsrequestby);
$totalRows_rsrequestby = mysql_num_rows($rsrequestby);

mysql_select_db($database_core, $core);
$query_rsreceivedby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'warehouse' AND code = 'K' ORDER BY firstname ASC";
$rsreceivedby = mysql_query($query_rsreceivedby, $core) or die(mysql_error());
$row_rsreceivedby = mysql_fetch_assoc($rsreceivedby);
$totalRows_rsreceivedby = mysql_num_rows($rsreceivedby);

mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE userlevel = 'branchmanager' AND code = 'K' ORDER BY firstname ASC";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

mysql_select_db($database_core, $core);
$query_accounting = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'finance' AND code = 'K' ORDER BY firstname ASC";
$accounting = mysql_query($query_accounting, $core) or die(mysql_error());
$row_accounting = mysql_fetch_assoc($accounting);
$totalRows_accounting = mysql_num_rows($accounting);

$colname_rsbpbheader = "-1";
if (isset($_GET['data'])) {
  $colname_rsbpbheader = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsbpbheader = sprintf("SELECT * FROM p_bpb_header WHERE id = %s", GetSQLValueString($colname_rsbpbheader, "int"));
$rsbpbheader = mysql_query($query_rsbpbheader, $core) or die(mysql_error());
$row_rsbpbheader = mysql_fetch_assoc($rsbpbheader);
$totalRows_rsbpbheader = mysql_num_rows($rsbpbheader);

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
<title>Edit BPB</title>
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
<p><b>Edit BPB</b></p>
<?php { include "../date.php"; include "../dateformat_funct.php"; } ?>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table>
    <tr>
      <td>BPB No.
        <input type="hidden" name="bpb_idheader" id="bpb_idheader" value="<?php echo $_GET['data']; ?>" /></td>
      <td>:</td>
      <td><input type="text" name="bpb_no" value="<?php echo $row_rsbpbheader['bpb_no']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td><input type="text" name="bpb_date" id="tanggal8" value="<?php echo functddmmmyyyy($row_rsbpbheader['bpb_date']); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>WO No. / SPK</td>
      <td>:</td>
      <td><select name="wo_number_or_spk" id="wo_number_or_spk">
        <option value="">-- WO No. --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rswono['wo_no']?>" <?php if ($row_rswono['wo_no'] == $row_rsbpbheader['wo_number_or_spk']) { ?> selected="selected" <?php } ?>><?php echo $row_rswono['wo_no']?></option>
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
        <option value="<?php echo $row_rsrequestby['id']?>" <?php if ($row_rsrequestby['id'] == $row_rsbpbheader['request_by']) { ?> selected="selected" <?php } ?>><?php echo $row_rsrequestby['firstname']?> <?php echo $row_rsrequestby['midlename']; ?> <?php echo $row_rsrequestby['lastname']; ?></option>
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
        <option value="<?php echo $row_rsapprovedby['id']?>" <?php if ($row_rsapprovedby['id'] == $row_rsbpbheader['approved_by']) { ?> selected="selected" <?php } ?>><?php echo $row_rsapprovedby['firstname']?> <?php echo $row_rsapprovedby['midlename']; ?> <?php echo $row_rsapprovedby['lastname']; ?></option>
        <?php
} while ($row_rsapprovedby = mysql_fetch_assoc($rsapprovedby));
  $rows = mysql_num_rows($rsapprovedby);
  if($rows > 0) {
      mysql_data_seek($rsapprovedby, 0);
	  $row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Received by</td>
      <td>:</td>
      <td><select name="cmbreceivedby" id="cmbreceivedby">
          <option value="">-- Warehouse --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rsreceivedby['id']?>" <?php if ($row_rsreceivedby['id'] == $row_rsbpbheader['received_by']) { ?> selected="selected" <?php } ?>><?php echo $row_rsreceivedby['firstname']?> <?php echo $row_rsreceivedby['midlename']; ?> <?php echo $row_rsreceivedby['lastname']; ?></option>
          <?php
} while ($row_rsreceivedby = mysql_fetch_assoc($rsreceivedby));
  $rows = mysql_num_rows($rsreceivedby);
  if($rows > 0) {
      mysql_data_seek($rsreceivedby, 0);
	  $row_rsreceivedby = mysql_fetch_assoc($rsreceivedby);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Accounting</td>
      <td>:</td>
      <td><select name="accounting" id="accounting">
        <option value="">-- Accounting --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_accounting['id']?>" <?php if ($row_accounting['id'] == $row_rsbpbheader['accounting']) { ?> selected="selected" <?php } ?>><?php echo $row_accounting['firstname']?> <?php echo $row_accounting['midlename']; ?> <?php echo $row_accounting['lastname']; ?></option>
        <?php
} while ($row_accounting = mysql_fetch_assoc($accounting));
  $rows = mysql_num_rows($accounting);
  if($rows > 0) {
      mysql_data_seek($accounting, 0);
	  $row_accounting = mysql_fetch_assoc($accounting);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
      <td><input type="submit" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rswono);

mysql_free_result($rsrequestby);

mysql_free_result($rsreceivedby);

mysql_free_result($rsapprovedby);

mysql_free_result($accounting);

mysql_free_result($rsbpbheader);
?>
