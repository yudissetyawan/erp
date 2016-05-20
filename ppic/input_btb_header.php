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
  $insertSQL = sprintf("INSERT INTO p_btb_header (id_po, no_btb, tanggal, diserahkan_by, diterima_by, diperiksa_by, accounting) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_po'], "int"),
                       GetSQLValueString($_POST['no_btb'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal']), "date"),
                       GetSQLValueString($_POST['diserahkan_by'], "int"),
                       GetSQLValueString($_POST['diterima_by'], "int"),
                       GetSQLValueString($_POST['diperiksa_by'], "int"),
                       GetSQLValueString($_POST['accounting'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

	$q = mysql_fetch_array(mysql_query("SELECT id FROM p_btb_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"btb/view_btb_core.php?data=$cekID\";</script>";
}

$colname_po_no = "-1";
if (isset($_GET['data'])) {
  $colname_po_no = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_po_no = sprintf("SELECT c_po_header.id, c_po_header.pono, c_po_header.vendor, c_vendor.vendorname FROM c_po_header, c_vendor WHERE c_po_header.id = %s AND c_po_header.vendor=c_vendor.id", GetSQLValueString($colname_po_no, "int"));
$po_no = mysql_query($query_po_no, $core) or die(mysql_error());
$row_po_no = mysql_fetch_assoc($po_no);
$totalRows_po_no = mysql_num_rows($po_no);

mysql_select_db($database_core, $core);
$query_supplier = "SELECT id, vendorname FROM c_vendor";
$supplier = mysql_query($query_supplier, $core) or die(mysql_error());
$row_supplier = mysql_fetch_assoc($supplier);
$totalRows_supplier = mysql_num_rows($supplier);

mysql_select_db($database_core, $core);
$query_diserahkan_by = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'procurement'";
$diserahkan_by = mysql_query($query_diserahkan_by, $core) or die(mysql_error());
$row_diserahkan_by = mysql_fetch_assoc($diserahkan_by);
$totalRows_diserahkan_by = mysql_num_rows($diserahkan_by);

mysql_select_db($database_core, $core);
$query_diterima_by = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'warehouse'";
$diterima_by = mysql_query($query_diterima_by, $core) or die(mysql_error());
$row_diterima_by = mysql_fetch_assoc($diterima_by);
$totalRows_diterima_by = mysql_num_rows($diterima_by);

mysql_select_db($database_core, $core);
$query_diperiksa_by = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE userlevel = 'qly'";
$diperiksa_by = mysql_query($query_diperiksa_by, $core) or die(mysql_error());

$row_diperiksa_by = mysql_fetch_assoc($diperiksa_by);
$totalRows_diperiksa_by = mysql_num_rows($diperiksa_by);

mysql_select_db($database_core, $core);
$query_accounting = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'finance'";
$accounting = mysql_query($query_accounting, $core) or die(mysql_error());
$row_accounting = mysql_fetch_assoc($accounting);
$totalRows_accounting = mysql_num_rows($accounting);

$year=date(y);
$month=date(m);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM p_btb_header ORDER BY no_btb DESC LIMIT 1"));
$cekQ=$ceknomor[no_btb];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;

if($next <10){
// pengecekan nilai increment
$nextString = "000" . $next; // jadinya J005
//
}
else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J005
//
}
else {
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J005
//
}
$nextno_btb=sprintf ('T.BPN'.'/'.$year.'/'.$month.'/'.$nextString);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input BTB Header</title>
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
<?php
	{ include "../date.php"; } 
?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="500">
    <tr>
      <td width="150">No. BTB</td>
      <td>:</td>
      <td><input type="text" name="no_btb" value="<?php echo $nextno_btb; ?>" size="32" readonly="readonly" style="border:thin" /></td>
    </tr>
    <tr>
      <td>No. PO</td>
      <td>:</td>
      <td><input readonly="readonly" style="border:thin" type="text" value="<?php echo $row_po_no['pono']; ?>" />
      <input name="id_po" type="hidden" id="id_po" value="<?php echo $row_po_no['id']; ?>" /></td>
    </tr>
    <tr>
      <td valign="top">Supplier</td>
      <td valign="top">:</td>
      <td><textarea readonly="readonly" style="border:thin" cols="40" rows="3"><?php echo $row_po_no['vendorname']; ?></textarea>
        </td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td><input type="text" name="tanggal" id="tanggal8" value="<?php echo date("d M Y") ?>" size="15" /></td>
    </tr>
    <tr>
      <td>Diserahkan Oleh</td>
      <td>:</td>
      <td><select name="diserahkan_by" id="diserahkan_by">
        <option value="">-- Procurement --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_diserahkan_by['id']?>"><?php echo $row_diserahkan_by['firstname']?> <?php echo $row_diserahkan_by['midlename']; ?> <?php echo $row_diserahkan_by['lastname']; ?></option>
        <?php
} while ($row_diserahkan_by = mysql_fetch_assoc($diserahkan_by));
  $rows = mysql_num_rows($diserahkan_by);
  if($rows > 0) {
      mysql_data_seek($diserahkan_by, 0);
	  $row_diserahkan_by = mysql_fetch_assoc($diserahkan_by);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Diterima Oleh</td>
      <td>:</td>
      <td><select name="diterima_by" id="diterima_by">
        <option value="">-- Warehouse --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_diterima_by['id']?>"><?php echo $row_diterima_by['firstname']?> <?php echo $row_diterima_by['midlename']; ?> <?php echo $row_diterima_by['lastname']; ?></option>
        <?php
} while ($row_diterima_by = mysql_fetch_assoc($diterima_by));
  $rows = mysql_num_rows($diterima_by);
  if($rows > 0) {
      mysql_data_seek($diterima_by, 0);
	  $row_diterima_by = mysql_fetch_assoc($diterima_by);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Diperiksa Oleh</td>
      <td>:</td>
      <td><select name="diperiksa_by" id="diperiksa_by">
        <option value="">-- Quality --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_diperiksa_by['id']?>"><?php echo $row_diperiksa_by['firstname']?> <?php echo $row_diperiksa_by['midlename']; ?> <?php echo $row_diperiksa_by['lastname']; ?></option>
        <?php
} while ($row_diperiksa_by = mysql_fetch_assoc($diperiksa_by));
  $rows = mysql_num_rows($diperiksa_by);
  if($rows > 0) {
      mysql_data_seek($diperiksa_by, 0);
	  $row_diperiksa_by = mysql_fetch_assoc($diperiksa_by);
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
        <option value="<?php echo $row_accounting['id']?>"><?php echo $row_accounting['firstname']?> <?php echo $row_accounting['midlename']; ?> <?php echo $row_accounting['lastname']; ?></option>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($po_no);

mysql_free_result($supplier);

mysql_free_result($diserahkan_by);

mysql_free_result($diterima_by);

mysql_free_result($diperiksa_by);

mysql_free_result($accounting);
?>
