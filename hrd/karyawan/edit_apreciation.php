<?php require_once('../../Connections/core.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form5")) {
  $updateSQL = sprintf("UPDATE h_penghargaan SET nama_penghargaan=%s, provider=%s, tahun=%s, remark=%s, tipe_penghargaan=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['nama_penghargaan'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['tahun'], "text"),
                       GetSQLValueString($_POST['remark2'], "text"),
                       GetSQLValueString($_POST['tipe_penghargaan'], "text"),
                       GetSQLValueString($_POST['idapr'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM h_penghargaan WHERE id = %s", GetSQLValueString($colname_Recordset7, "int"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form5" name="form5" method="POST">
  <table width="559" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General"><input name="idapr" type="text" class="hidentext" id="idapr" value="<?php echo $row_Recordset7['id_datapribadi']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td class="General">Tipe</td>
      <td class="General">:</td>
      <td class="General"><label for="tipe_penghargaan"></label>
        <input name="tipe_penghargaan" type="text" id="tipe_penghargaan" value="<?php echo $row_Recordset7['tipe_penghargaan']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Nama Penghargaan</td>
      <td class="General">:</td>
      <td class="General"><label for="nama_penghargaan"></label>
        <input name="nama_penghargaan" type="text" id="nama_penghargaan" value="<?php echo $row_Recordset7['nama_penghargaan']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Provider</td>
      <td class="General">:</td>
      <td class="General"><label for="provider"></label>
        <input name="provider" type="text" id="provider" value="<?php echo $row_Recordset7['provider']; ?>" /></td>
    </tr>
    <tr>
      <td width="178" class="General">Tahun</td>
      <td width="10" class="General">:</td>
      <td width="372" class="General"><label for="tahun"></label>
        <input name="tahun" type="text" id="tahun" value="<?php echo $row_Recordset7['tahun']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Remark</td>
      <td class="General">:</td>
      <td class="General"><label for="remark"></label>
        <input name="remark2" type="text" id="remark" value="<?php echo $row_Recordset7['remark']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General"><input type="submit" name="submit6" id="submit5" value="Simpan" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form5" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset7);
?>
