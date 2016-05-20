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
	if (strlen($_POST['po_date']) < 10) {
		$podate = "";
	} else {
		$podate = functyyyymmdd($_POST['po_date']);
	}
	/* echo "<script>alert(\"$podate\");</script>"; */
	
  $insertSQL = sprintf("INSERT INTO pr_si_header (no_si, `date`, `to`, dest, ship, po_no, po_date, contract_no, schedule_dlv, req_by, recv_by, apprv_by, req_date, recv_date, apprv_date, wo_no) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_si'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "date"),
                       GetSQLValueString($_POST['to'], "text"),
                       GetSQLValueString($_POST['dest'], "text"),
                       GetSQLValueString($_POST['ship'], "text"),
                       GetSQLValueString($_POST['po_no'], "text"),
                       GetSQLValueString($podate, "text"),
                       GetSQLValueString($_POST['contract_no'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['schedule_dlv']), "date"),
                       GetSQLValueString($_POST['req_by'], "text"),
                       GetSQLValueString($_POST['recv_by'], "text"),
                       GetSQLValueString($_POST['apprv_by'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['req_date']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['recv_date']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['apprv_date']), "date"),
					   GetSQLValueString($_POST['wo_no'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  
  $q = mysql_fetch_array(mysql_query("SELECT id FROM pr_si_header ORDER BY id DESC LIMIT 1"));
  $cekID = $q['id'];
  echo "<script>document.location=\"ship_inst/view_si_core.php?data=$cekID\";</script>";
}

mysql_select_db($database_core, $core);
$query_req_by = "SELECT h_employee.* FROM h_employee WHERE h_employee.department = 'project' AND h_employee.`level` = '0'";
$req_by = mysql_query($query_req_by, $core) or die(mysql_error());
$row_req_by = mysql_fetch_assoc($req_by);
$totalRows_req_by = mysql_num_rows($req_by);

mysql_select_db($database_core, $core);
$query_recv_by = "SELECT * FROM h_employee WHERE department = 'warehouse'";
$recv_by = mysql_query($query_recv_by, $core) or die(mysql_error());
$row_recv_by = mysql_fetch_assoc($recv_by);
$totalRows_recv_by = mysql_num_rows($recv_by);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_employee WHERE department = 'ppic' ";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT id, contract_no, wo_no, startdate FROM pr_header_wpr";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$year=date(y);
$month=date(m);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM pr_si_header ORDER BY no_si DESC LIMIT 1"));
$cekQ=$ceknomor[no_si];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;

if($next <10){
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
$nextno_si=sprintf ('SI/BTU-BPN'.'/'.'P'.'/'.$month.'/'.$nextString);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Header Shipping Instruction</title>

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
<?php { include "../date.php"; } ?>
<p><b>Input Header Shipping Instruction</b></p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="850">
    <tr>
      <td width="150">Shipping Instruction No.</td>
      <td width="10">:</td>
      <td width="300"><input type="text" readonly="readonly" style="border:thin" name="no_si" value="<?php echo $nextno_si; ?>" size="32" /></td>
      <td width="120">Contract No.</td>
      <td width="10">:</td>
      <td width="120"><input type="text" name="contract_no" value="" size="20" /></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td><input type="text" name="date" id="tanggal11" value="<?php echo date("d M Y"); ?>" size="12" /></td>
      <td>WO. No</td>
      <td>:</td>
      <td>
        <select name="wo_no" id="wo_no">
        <option value="">-- WO. No --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['wo_no']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>To</td>
      <td>:</td>
      <td><textarea name="to" cols="30" rows="4"></textarea></td>
      <td>Requested By</td>
      <td>:</td>
      <td><select name="req_by">
      <option value="">-- Request By --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_req_by['id']?>"><?php echo $row_req_by['firstname']?> <?php echo $row_req_by['midlename']; ?> <?php echo $row_req_by['lastname']; ?></option>
        <?php
} while ($row_req_by = mysql_fetch_assoc($req_by));
  $rows = mysql_num_rows($req_by);
  if($rows > 0) {
      mysql_data_seek($req_by, 0);
	  $row_req_by = mysql_fetch_assoc($req_by);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Destination</td>
      <td>:</td>
      <td><input type="text" name="dest" value="" size="32" /></td>
      <td>Revieved By</td>
      <td>:</td>
      <td><select name="recv_by" id="recv_by">
      <option value="">-- Recieved By --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_recv_by['id']?>"><?php echo $row_recv_by['firstname']?> <?php echo $row_recv_by['midlename']; ?> <?php echo $row_recv_by['lastname']; ?></option>
        <?php
} while ($row_recv_by = mysql_fetch_assoc($recv_by));
  $rows = mysql_num_rows($recv_by);
  if($rows > 0) {
      mysql_data_seek($recv_by, 0);
	  $row_recv_by = mysql_fetch_assoc($recv_by);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Shipped</td>
      <td>:</td>
      <td><input type="text" name="ship" value="" size="32" /></td>
      <td>Approved By</td>
      <td>:</td>
      <td>
        <select name="apprv_by" id="apprv_by">
        <option value="">-- Approved By --</option>
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
      <td>PO No.</td>
      <td>:</td>
      <td><input type="text" name="po_no" value="" size="32" /></td>
      <td>Requested Date</td>
      <td>:</td>
      <td><input type="text" name="req_date" id="tanggal8" value="" size="12" /></td>
    </tr>
    <tr>
      <td>PO date</td>
      <td>:</td>
      <td><input type="text" name="po_date" id="tanggal9" value="" size="12" /></td>
      <td>Recieved Date</td>
      <td>:</td>
      <td><input type="text" name="recv_date" value="" id="tanggal10" size="12" /></td>
    </tr>
    <tr>
      <td>Sechedule Delivery</td>
      <td>:</td>
      <td><input type="text" name="schedule_dlv" value="" id="tanggal13" size="20" /></td>
      <td>Approved Date</td>
      <td>:</td>
      <td><input type="text" name="apprv_date" id="tanggal12" value="" size="12" /></td>
    </tr>
    <tr>
      <td colspan="6" align="center" nowrap="nowrap"><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>
<?php
mysql_free_result($req_by);

mysql_free_result($recv_by);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
