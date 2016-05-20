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
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "view_cv.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_recruitment ORDER BY no_pelamar DESC ";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$year=date(y);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM h_recruitment ORDER BY no_pelamar DESC LIMIT 1"));
$cekQ=$ceknomor[no_pelamar];
#menghilangkan huruf
$awalQ=substr($cekQ,3-6);
echo $awalQ;
#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextString=sprintf ($year."%04d", $next);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php {
include "../date.php";
  }
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="509" border="0">
    <tr>
      <td class="General">No. Pelamar</td>
      <td>:</td>
      <td><input name="nik" type="text" id="nik" value="<?php echo $row_Recordset1['no_pelamar']; ?>" size="10" readonly="readonly" /></td>
    </tr>
    <tr>
      <td width="129" class="General">First Name</td>
      <td width="10">:</td>
      <td width="356"><input name="firstname" type="text" class="huruf_besar" id="firstname" title="Firstname is required" value="<?php echo $row_Recordset1['firstname']; ?>" /></td>
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
      <td><select name="status" id="status" title="<?php echo $row_Recordset1['status']; ?>">
        <option value="1">Baru</option>
        <option value="2">Pernah Dipanggil</option>
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
      <td><input type="submit" name="Update" id="Update" value="Update" onclick="saveForm(); return false;" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
