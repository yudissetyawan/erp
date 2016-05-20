<?php require_once('../Connections/core.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO h_employee (nik, firstname, midlename, lastname, `initial`, department, jabatan, status, username, password, code, userlevel) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nik'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['midlename'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['initial'], "text"),
                       GetSQLValueString($_POST['department'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['code'], "text"),
                       GetSQLValueString($_POST['department'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_datapribadi SET id_h_employee=%s, status=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_datakeluarga SET id_h_employee=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_recruitment SET viewornot=%s WHERE id=%s",
                       GetSQLValueString($_POST['viewornot'], "int"),
                       GetSQLValueString($_POST['id_datapribadi'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_dataortu SET id_h_employee=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_penghargaan SET id_h_employee=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_sim SET id_h_employee=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_training SET id_h_employee=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_bahasa SET id_h_employee=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_experiences SET id_h_employee=%s, jabatan=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['id_datapribadi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_department";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_employee ORDER BY  h_employee.id DESC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM h_datakeluarga WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM h_employee ORDER BY id DESC LIMIT 1"));
$cekQ=$ceknomor[id];
$next=$cekQ+1;

?>


<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<script language=”javascript” type=”text/javascript”>
    function allcase(obj) {
    obj.value=obj.value.toucwords();
    }
    </script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRD - Input Karyawan Baru</title>
</head>

<body class="General">
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="300" border="0">
    <tr>
      <td width="148" class="General">NIK</td>
      <td width="20">:</td>
      <td width="398"><input name="nik" type="text" class="required" id="nik" title="NIK is required" size="8"/></td>
    </tr>
    <tr>
      <td class="General">First Name</td>
      <td>:</td>
      <td><label for="firstname"></label>
      <input name="firstname" type="text" class="General" id="firstname" value="<?php echo $row_Recordset3['firstname']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Second Name</td>
      <td>:</td>
      <td><input name="midlename" type="text" class="General" id="midlename" value="<?php echo $row_Recordset3['midlename']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Last Name</td>
      <td>:</td>
      <td><input name="lastname" type="text" class="General" id="lastname" value="<?php echo $row_Recordset3['lastname']; ?>" />
    </tr>
    <tr>
      <td class="General">Initial</td>
      <td>:</td>
      <td><input name="initial" type="text" class="General" id="initial" /></td>
    </tr>
    <tr>
      <td class="General">Department</td>
      <td>:</td>
      <td><select name="department" id="department" class="" title="Customer harus dipilih">
        <option value="">-- Pilih Department --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['department']?>"><?php echo $row_Recordset1['department']?></option>
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
      <td class="General">Posisi / Jabatan</td>
      <td>:</td>
      <td><input type="text" name="jabatan" id="jabatan" /></td>
    </tr>
    <tr>
      <td class="General">Status</td>
      <td>:</td>
      <td><select name="status" id="status" class="required" title="Please select Status">
        <option value="" selected="selected">-- Pilih Status --</option>
        <option value="PKWT">PKWT</option>
        <option value="PKWTT">PKWTT</option>
        <option value="Tetap Lokal">Tetap Lokal</option>
        <option value="Tetap Pusat">Tetap Pusat</option>
        <option value="Harian">Harian</option>
        <option value="Resign">Resign</option>
        <option value="Out Sourcing">Out Sourcing</option>
        <option value="SubCon">SubCon</option>
      </select></td>
    </tr>
    <tr>
      <td class="General">User Name</td>
      <td>:</td>
      <td><label for="username">
        <input name="username" type="text" class="General" id="username" />
      </label></td>
    </tr>
    <tr>
      <td class="General">Password</td>
      <td>:</td>
      <td><input name="password" type="text" class="General" id="password" /></td>
    </tr>
    <tr>
      <td class="General">*Code</td>
      <td>:</td>
      <td><select name="code" id="code" class="required" title="Pilih Status">
          <option value="CK">Calon Karyawan</option>
        <option value="K">Karyawan</option>
        <option value="MK">Mantan Karyawan</option>
      </select></td>
    </tr>
    <tr>
      <td class="General"><input type="hidden" name="id_h_employee" id="id_h_employee" value="<?php echo $next; ?>" /> <input name="id_datapribadi" type="hidden" id="id_datapribadi" value="<?php echo $row_Recordset3['id']; ?>" /></td>
      <td><input type="hidden" name="viewornot" id="viewornot" value="0" /></td>
      <td>
        <input type="submit" name="Save" id="Save" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
