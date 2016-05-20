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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_dinasluar SET id_employee=%s, tanggal=%s, keperluan=%s, approved_by=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_employee'], "int"),
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['keperluan'], "text"),
                       GetSQLValueString($_POST['approved_by'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
      echo "<script>
  	alert(\"Form Dinas Luar has been updated\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";

}

$colname_h_dinasluar = "-1";
if (isset($_GET['data'])) {
  $colname_h_dinasluar = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_dinasluar = sprintf("SELECT h_dinasluar.*, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_dinasluar, h_employee WHERE h_dinasluar.id = %s AND h_dinasluar.id_employee = h_employee.id", GetSQLValueString($colname_h_dinasluar, "int"));
$h_dinasluar = mysql_query($query_h_dinasluar, $core) or die(mysql_error());
$row_h_dinasluar = mysql_fetch_assoc($h_dinasluar);
$totalRows_h_dinasluar = mysql_num_rows($h_dinasluar);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_employee ORDER BY firstname ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_h_dl_apprv = "-1";
if (isset($_GET['data'])) {
  $colname_h_dl_apprv = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_dl_apprv = sprintf("SELECT h_dinasluar.approved_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_dinasluar, h_employee WHERE h_dinasluar.id = %s AND h_dinasluar.approved_by = h_employee.id", GetSQLValueString($colname_h_dl_apprv, "int"));
$h_dl_apprv = mysql_query($query_h_dl_apprv, $core) or die(mysql_error());
$row_h_dl_apprv = mysql_fetch_assoc($h_dl_apprv);
$totalRows_h_dl_apprv = mysql_num_rows($h_dl_apprv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
* { font:Tahoma, Geneva, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="General">
    <tr>
      <td>NIK</td>
      <td>:</td>
      <td><label for="nik"></label>
      <input name="nik" type="text" id="nik" value="<?php echo $row_h_dinasluar['nik']; ?>" /></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><label for="nama"></label>
      <input name="nama" type="text" id="nama" value="<?php echo $row_h_dinasluar['firstname']; ?> <?php echo $row_h_dinasluar['midlename']; ?> <?php echo $row_h_dinasluar['lastname']; ?>" /></td>
    </tr>
    <tr>
      <td>Tanggal:</td>
      <td>:</td>
      <td><input type="text" id="tanggal1" name="tanggal" value="<?php echo htmlentities($row_h_dinasluar['tanggal'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Keperluan:</td>
      <td>:</td>
      <td><textarea name="keperluan" cols="45" rows="5"><?php echo htmlentities($row_h_dinasluar['keperluan'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr>
      <td>Disetujui Oleh</td>
      <td>:</td>
      <td><label for="approved_by"></label>
        <select name="approved_by" id="approved_by">
        <option value="<?php echo $row_h_dl_apprv['approved_by']; ?>"><?php echo $row_h_dl_apprv['firstname']; ?></option>
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
      <td colspan="3" align="center"><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_h_dinasluar['id']; ?>" />
  <input type="hidden" name="id_employee" value="<?php echo htmlentities($row_h_dinasluar['id_employee'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($h_dinasluar);

mysql_free_result($Recordset1);

mysql_free_result($h_dl_apprv);
?>
