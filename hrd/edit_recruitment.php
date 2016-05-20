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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_recruitment SET firstname=%s, midlename=%s, lastname=%s, status=%s, `date`=%s WHERE no_pelamar=%s",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['midlename'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['nik'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
  echo "<script>self.close();</script>";
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
function startstatus(){interval=setInterval("status()",1)}
function status(){one=document.form1.status2.value;
						document.form1.status.value=(one*1)}
function stopstatus(){clearInterval(interval)}
</script>

<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">

<table width="375" border="0" align="center">
  <tr>
    <td class="General">No. Pelamar</td>
    <td>:</td>
    <td><input name="nik" type="text" id="nik" value="<?php echo $row_Recordset1['no_pelamar']; ?>"  size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td width="129" class="General">First Name</td>
    <td width="10">:</td>
    <td width="222"><input name="firstname" type="text" class="huruf_besar" id="firstname" title="Firstname is required" value="<?php echo $row_Recordset1['firstname']; ?>" /></td>
  </tr>
  <tr>
    <td class="General">Midle Name</td>
    <td>:</td>
    <td><input name="midlename" type="text" class="huruf_besar" id="midlename" value="<?php echo $row_Recordset1['midlename']; ?>" /></td>
  </tr>
  <tr>
    <td class="General">Last Name</td>
    <td>:</td>
    <td><input name="lastname" type="text" class="huruf_besar" id="lastname" title="Lastname is required" value="<?php echo $row_Recordset1['lastname']; ?>" /></td>
  </tr>
  <tr>
    <td class="General">Status</td>
    <td>:</td>
    <td><input name="status" type="hidden" id="status" value="<?php echo $row_Recordset1['status']; ?>" />
      <select name="status2" id="status2" onchange="startstatus()">
      <option value="1">Baru</option>
      <option value="0">Pernah Dipanggil</option>
    </select></td>
  </tr>
  <tr>
    <td class="General">Date of Aplicant</td>
    <td>:</td>
    <td><input name="date" type="text" id="tanggal1" value="<?php echo $row_Recordset1['date']; ?>" /></td>
  </tr>
  <tr>
    <td class="General">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="Save" id="Save" value="Save" onclick="saveForm(); return false;" /></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
