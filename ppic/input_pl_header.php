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
  $insertSQL = sprintf("INSERT INTO p_pl_header (id, id_si, id_wo, no_pl, `date`, no_pack, type_pack, carrier, plat_noreg, prepared_by, approved_by, recieved_by, prepared_date, approved_date, recieved_date) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['id_si'], "int"),
                       GetSQLValueString($_POST['id_wo'], "text"),
                       GetSQLValueString($_POST['no_pl'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "date"),
                       GetSQLValueString($_POST['no_pack'], "text"),
                       GetSQLValueString($_POST['type_pack'], "text"),
                       GetSQLValueString($_POST['carrier'], "text"),
                       GetSQLValueString($_POST['plat_noreg'], "text"),
                       GetSQLValueString($_POST['prepared_by'], "text"),
                       GetSQLValueString($_POST['approved_by'], "text"),
                       GetSQLValueString($_POST['recieved_by'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['prepared_date']), "date"),
                       GetSQLValueString($_POST['approved_date'], "date"),
                       GetSQLValueString($_POST['recieved_date'], "date"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  
  	$q = mysql_fetch_array(mysql_query("SELECT id FROM p_pl_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"pkg_list/view_pl_core_ready.php?data=$cekID\";</script>";
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT id, contract_no, wo_no, startdate FROM pr_header_wpr";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE userlevel = 'ppic'";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE userlevel = 'branchmanager'";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_pr_si_header = "-1";
if (isset($_GET['data'])) {
  $colname_pr_si_header = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_pr_si_header = sprintf("SELECT * FROM pr_si_header WHERE id = %s", GetSQLValueString($colname_pr_si_header, "int"));
$pr_si_header = mysql_query($query_pr_si_header, $core) or die(mysql_error());
$row_pr_si_header = mysql_fetch_assoc($pr_si_header);
$totalRows_pr_si_header = mysql_num_rows($pr_si_header);

$year=date(y);
$month=date(m);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM p_pl_header ORDER BY no_pl DESC LIMIT 1"));
$cekQ=$ceknomor[no_pl];
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
$nextno_pl=sprintf ('PL/BTU-BPN'.'/'.'P'.'/'.$month.'/'.$nextString);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Header Packing List</title>

<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
</head>

<body>
<?php
	{ include "../date.php"; } 
?>
<h3>Input Packing List</h3>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="775">
    <tr>
      <td>SI No.</td>
      <td>:</td>
      <td colspan="4"><?php echo $row_pr_si_header['no_si']; ?>
      <input type="hidden" name="id_si" id="id_si" value="<?php echo $_GET['data']; ?>" /> </td>
    </tr>
    <tr>
      <td>WO No.</td>
      <td>:</td>
      <td><span id="spryselect1">
        <select name="id_wo" id="id_wo">
        <option value="-">- WO No. -</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['wo_no']?></option>
          <?php
		} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
		  $rows = mysql_num_rows($Recordset1);
		  if($rows > 0) {
			  mysql_data_seek($Recordset1, 0);
			  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
		  }
		?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
      <td>No. of Package</td>
      <td>:</td>
      <td><input type="text" name="no_pack" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Contract No.</td>
      <td>:</td>
      <td><?php echo $row_pr_si_header['contract_no']; ?></td>
      <td>Type of Package</td>
      <td>:</td>
      <td><input type="text" name="type_pack" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Packing List No.</td>
      <td>:</td>
      <td><input type="text" name="no_pl" style="border:thin" readonly="readonly" size="22" value="<?php echo $nextno_pl; ?>" /></td>
      <td>Carrier</td>
      <td>:</td>
      <td><input type="text" name="carrier" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td><input type="text" id="tanggal8" name="date" value="<?php echo date("d M Y"); ?>" size="12" /></td>
      <td>Plat No. / Reg</td>
      <td>:</td>
      <td><input type="text" name="plat_noreg" value="" size="32" /></td>
    </tr>
    <tr>
      <td>To</td>
      <td>:</td>
      <td><label for="kepada"></label>
      <?php echo $row_pr_si_header['to']; ?><br /></td>
      <td>Prepared by</td>
      <td>:</td>
      <td><label for="prepared_by"></label>
        <select name="prepared_by" id="prepared_by">
          <option value="">- Prepared by -</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_Recordset3['id']?>"><?php echo $row_Recordset3['firstname']?> <?php echo $row_Recordset3['midlename']; ?> <?php echo $row_Recordset3['lastname']; ?></option>
          <?php
		} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
		  $rows = mysql_num_rows($Recordset3);
		  if($rows > 0) {
			  mysql_data_seek($Recordset3, 0);
			  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
		  }
		?>
      </select></td>
    </tr>
    <tr>
      <td>Destination</td>
      <td>:</td>
      <td><?php echo $row_pr_si_header['dest']; ?></td>
      <td>Prepared Date</td>
      <td>:</td>
      <td><input type="text" id="tanggal9" name="prepared_date" value="" size="12" /></td>
    </tr>
    <tr>
      <td>Shipped</td>
      <td>:</td>
      <td><?php echo $row_pr_si_header['ship']; ?></td>
      <td>Approved by</td>
      <td>:</td>
      <td><label for="approved_by"></label>
        <select name="approved_by" id="approved_by">
          <option value="">- Approved by -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset4['id']?>"><?php echo $row_Recordset4['firstname']?> <?php echo $row_Recordset4['midlename']; ?> <?php echo $row_Recordset4['lastname']; ?></option>
          <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="center"><input type="submit" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset3);
	mysql_free_result($Recordset4);
	mysql_free_result($pr_si_header);
	mysql_free_result($Recordset1);
?>
