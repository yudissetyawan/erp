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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form10")) {
  $updateSQL = sprintf("UPDATE h_bahasa SET bahasa=%s, predikat=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['bahasa'], "text"),
                       GetSQLValueString($_POST['predikat'], "text"),
                       GetSQLValueString($_POST['idbahasa'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_bahasa WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form10" name="form10" method="POST">
  <table width="200" border="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="idbahasa" type="text" class="hidentext" id="idbahasa" value="<?php echo $row_Recordset1['id_datapribadi']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Bahasa</td>
      <td>:</td>
      <td><label for="bahasa"></label>
        <input name="bahasa" type="text" id="bahasa" value="<?php echo $row_Recordset1['bahasa']; ?>" /></td>
    </tr>
    <tr>
      <td>Predikat </td>
      <td>:</td>
      <td><label for="predikat"></label>
        <input name="predikat" type="text" id="predikat" value="<?php echo $row_Recordset1['predikat']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit11" id="submit10" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form10" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
