<?php require_once('Connections/core.php'); ?>
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
	include "dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO h_cuti (id_employee, date_awal, date_akhir, keperluan, kota_tujuan, no_hp1, no_hp2, disetujui_oleh) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_employee'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['date_awal']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['date_akhir']), "text"),
                       GetSQLValueString($_POST['keperluan'], "text"),
                       GetSQLValueString($_POST['kota_tujuan'], "text"),
                       GetSQLValueString($_POST['no_hp1'], "text"),
                       GetSQLValueString($_POST['no_hp2'], "int"),
					   GetSQLValueString($_POST['disetujui_oleh'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$colname_h_employee = "-1";
if (isset($_GET['data'])) {
  $colname_h_employee = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_employee = sprintf("SELECT id, nik, firstname, midlename, lastname FROM h_employee WHERE id = %s", GetSQLValueString($colname_h_employee, "int"));
$h_employee = mysql_query($query_h_employee, $core) or die(mysql_error());
$row_h_employee = mysql_fetch_assoc($h_employee);
$totalRows_h_employee = mysql_num_rows($h_employee);

mysql_select_db($database_core, $core);
$query_h_employee_apprv = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE `level` = '0' ORDER BY firstname ASC";
$h_employee_apprv = mysql_query($query_h_employee_apprv, $core) or die(mysql_error());
$row_h_employee_apprv = mysql_fetch_assoc($h_employee_apprv);
$totalRows_h_employee_apprv = mysql_num_rows($h_employee_apprv);

$panjang = strlen($row_Recordset2['total_cuti']); // cari panjang max dari string yg di dapat dari query
$tampungku = substr($row_Recordset2['total_cuti'],1,$panjang); // potong string, ambil nilai selain 'J'
$nextIncrement =(int)$tampungku + 1; // naekan nilai nya.... misalnya dapat J004.. maka disini jd nya 4 + 1 = 5
//
if($nextIncrement <10){
// pengecekan nilai increment
$nextString = "00" . $nextIncrement; // jadinya J005
//
}
else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "" . $nextIncrement; // jadinya J005
//
}
else {
// pengecekan nilai increment
$nextString = "0" . $nextIncrement; // jadinya J005
//
}
//tambahkan else nya kalau mau... misnya kl <100 .. maka J0 . $nextIncrement dst....
//echo $nextString;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
* { font:Tahoma, Geneva, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

</head>

<body class="General">
<h3>Form Cuti
  <?php {include "date.php";} ?>
</h3>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="512">
    <tr>
      <td >Nik</span></td>
      <td>:</td>
      <td><input name="nik" type="text" value="<?php echo $row_h_employee['nik']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Nama </td>
      <td>:</td>
      <td><label>
        <input name="nama" type="text" id="nama" value="<?php echo $row_h_employee['firstname']; ?> <?php echo $row_h_employee['midlename']; ?> <?php echo $row_h_employee['lastname']; ?>" readonly="readonly" />
      </label>
        <label for="id_employee"></label>
      <input name="id_employee" type="hidden" id="id_employee" value="<?php echo $row_h_employee['id']; ?>" /></td>
    </tr>
    <tr>
      <td >Date Awal</span></td>
      <td>:</td>
      <td><input type="text" name="date_awal" id="tanggal1" value=""  /> 
        s /d 
        <input type="text" name="date_akhir" id="tanggal2" value="" /></td>
    </tr>
    <tr v>
      <td>Untuk Keperluan</td>
      <td>:</td>
      <td><label>
        <textarea name="keperluan" id="keperluan" cols="45" rows="5"></textarea>
      </label></td>
    </tr>
    <tr>
      <td >Kota Tujuan</span></td>
      <td>:</td>
      <td><input type="text" name="kota_tujuan" value="" size="32" /></td>
    </tr>
    <tr>
      <td>No Hp </td>
      <td>:</td>
      <td><input type="text" name="no_hp1" value="" size="30" />
      / 
        <input type="text" name="no_hp2" value="" size="30" /></td>
    </tr>
    <tr>
      <td>Disetujui Oleh</td>
      <td>:</td>
      <td><label for="disetujui_oleh"></label>
        <select name="disetujui_oleh" id="disetujui_oleh">
        <option value="">-- Disetujui Oleh --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_apprv['id']?>"><?php echo $row_h_employee_apprv['firstname']?> <?php echo $row_h_employee_apprv['midlename']; ?> <?php echo $row_h_employee_apprv['lastname']; ?></option>
          <?php
} while ($row_h_employee_apprv = mysql_fetch_assoc($h_employee_apprv));
  $rows = mysql_num_rows($h_employee_apprv);
  if($rows > 0) {
      mysql_data_seek($h_employee_apprv, 0);
	  $row_h_employee_apprv = mysql_fetch_assoc($h_employee_apprv);
  }
?>
      </select></td>
    </tr>
    
    <tr>
      <td colspan="3" align="center" nowrap="nowrap"><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($h_employee);

mysql_free_result($h_employee_apprv);
?>
