<?php require_once('../../Connections/core.php'); ?>
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
  $updateSQL = sprintf("UPDATE h_employee SET nik=%s, firstname=%s, midlename=%s, lastname=%s, `initial`=%s, department=%s, jabatan=%s, `level`=%s, status=%s, username=%s, password=%s, code=%s, userlevel=%s WHERE id=%s",
                       GetSQLValueString($_POST['nik'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['midlename'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['initial'], "text"),
                       GetSQLValueString($_POST['department'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['level'], "int"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['code'], "text"),
                       GetSQLValueString(strtolower($_POST['userlevel']), "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  echo "<script>
  	alert(\"Data employee has been updated\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRD - Edit Karyawan </title>

<script>
	function myFunction() {
		alert("Anda Sudah Mengubah Data Karyawan, Silahkan Tutup Jendela ini");
	}
</script>

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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="580">
    <tr valign="baseline">
      <td>N I K</td>
      <td>:</td>
      <td><input type="text" name="nik" value="<?php echo htmlentities($row_Recordset1['nik'], ENT_COMPAT, 'utf-8'); ?>" size="8" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Firstname</td>
      <td>:</td>
      <td><input type="text" name="firstname" value="<?php echo htmlentities($row_Recordset1['firstname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Midlename</td>
      <td>:</td>
      <td><input type="text" name="midlename" value="<?php echo htmlentities($row_Recordset1['midlename'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Lastname</td>
      <td>:</td>
      <td><input type="text" name="lastname" value="<?php echo htmlentities($row_Recordset1['lastname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Initial</td>
      <td>:</td>
      <td><input type="text" name="initial" value="<?php echo htmlentities($row_Recordset1['initial'], ENT_COMPAT, 'utf-8'); ?>" size="3" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Department</td>
      <td>:</td>
      <td><input type="text" name="department" value="<?php echo htmlentities($row_Recordset1['department'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Posisi / Jabatan </td>
      <td>:</td>
      <td><input name="jabatan" type="text" id="jabatan" value="<?php echo $row_Recordset1['jabatan']; ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Level</td>
      <td>:</td>
      <td>
      <select name="level" id="level">
        <option value="" <?php if ($row_Recordset1['level'] == '') { ?> selected="selected" <?php } ?>>-- Level --</option>
        <option value="0" <?php if ($row_Recordset1['level'] == '0') { ?> selected="selected" <?php } ?>>Head</option>
        <option value="1" <?php if ($row_Recordset1['level'] == '1') { ?> selected="selected" <?php } ?>>Assistant 1</option>
        <option value="2" <?php if ($row_Recordset1['level'] == '2') { ?> selected="selected" <?php } ?>>Assistant 2</option>
        <option value="3" <?php if ($row_Recordset1['level'] == '3') { ?> selected="selected" <?php } ?>>Supervisor</option>
      </select>
      </td>
    </tr>
    
    <tr valign="baseline">
      <td>Status</td>
      <td>:</td>
      <td>
      <select name="status" id="status">
        <option value="" <?php if ($row_Recordset1['status'] == '') { ?> selected="selected" <?php } ?>>-- Select Status --</option>
        <option value="Tetap Pusat" <?php if ($row_Recordset1['status'] == 'Tetap Pusat') { ?> selected="selected" <?php } ?>>Tetap Pusat</option>
        <option value="Tetap Lokal" <?php if ($row_Recordset1['status'] == 'Tetap Lokal') { ?> selected="selected" <?php } ?>>Tetap Lokal</option>
        <option value="PKWT" <?php if ($row_Recordset1['status'] == 'PKWT') { ?> selected="selected" <?php } ?>>PKWT</option>
        <option value="PKWTT" <?php if ($row_Recordset1['status'] == 'PKWTT') { ?> selected="selected" <?php } ?>>PKWTT</option>
        <option value="Harian" <?php if ($row_Recordset1['status'] == 'Harian') { ?> selected="selected" <?php } ?>>Harian</option>
      </select>
      </td>
    </tr>
    
    <tr valign="baseline">
      <td>Username</td>
      <td>:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_Recordset1['username'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>Password</td>
      <td>:</td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_Recordset1['password'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
    </tr>
    
    <tr valign="baseline">
      <td>*Code</td>
      <td>:</td>
      <td>
      <select name="code" id="code">
        <option value="" <?php if ($row_Recordset1['code'] == '') { ?> selected="selected" <?php } ?>>-- Select Code --</option>
        <option value="K" <?php if ($row_Recordset1['code'] == 'K') { ?> selected="selected" <?php } ?>>Karyawan</option>
        <option value="CK" <?php if ($row_Recordset1['code'] == 'CK') { ?> selected="selected" <?php } ?>>Calon Karyawan</option>
        <option value="MK" <?php if ($row_Recordset1['code'] == 'MK') { ?> selected="selected" <?php } ?>>Mantan Karyawan</option>
      </select>
	</td>
    </tr>
    
    <tr valign="baseline">
      <td>*Userlevel</td>
      <td>:</td>
      <td>
      <input name="userlevel" type="text" id="userlevel" value="<?php echo $row_Recordset1['userlevel']; ?>" size="15"
      <?php // if ($_SESSION['userlvl'] != 'administrator') { echo "hidden"; } ?> /></td>
    </tr>
    
    <tr valign="baseline">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Update"  /></td> <!-- onclick="myFunction()" -->
    </tr>
  </table>
  
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset1['id']; ?>" />
</form>

<p>&nbsp;</p>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>