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
  $updateSQL = sprintf("UPDATE d_out_mail SET `date`=%s, `description`=%s, costumer=%s, contact_person=%s, from_approv=%s, from_maker=%s, information=%s WHERE id_nosurat=%s",
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['costumer'], "text"),
                       GetSQLValueString($_POST['contact_person'], "text"),
                       GetSQLValueString($_POST['from_approv'], "text"),
                       GetSQLValueString($_POST['from_maker'], "text"),
                       GetSQLValueString($_POST['information'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "viewoutmail.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM d_out_mail WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input type="button" value="Go Back" onclick="history.back(-1)" />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline" class="tabel_header">
      <td colspan="2" align="center" nowrap="nowrap"><?php echo $row_Recordset1['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal:</td>
      <td><input type="text" name="date" value="<?php echo htmlentities($row_Recordset1['date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="middle">
      <td nowrap="nowrap" align="right">Uraian:</td>
      <td><textarea cols="50" rows="5" name="description"><?php echo htmlentities($row_Recordset1['description'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kepada Perusahaan:</td>
      <td><input type="text" name="costumer" value="<?php echo htmlentities($row_Recordset1['costumer'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kepada Attn.</td>
      <td><input type="text" name="contact_person" value="<?php echo htmlentities($row_Recordset1['contact_person'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dari(inisial) Penanda tangan</td>
      <td><input type="text" name="from_approv" value="<?php echo htmlentities($row_Recordset1['from_approv'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dari(inisial) Pembuat surat:</td>
      <td><input type="text" name="from_maker" value="<?php echo htmlentities($row_Recordset1['from_maker'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="middle">
      <td nowrap="nowrap" align="right">Keterangan:</td>
      <td><textarea name="information" cols="50" rows="5" ><?php echo htmlentities($row_Recordset1['information'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline" class="tabel_header">
      <td colspan="2" align="center" nowrap="nowrap"><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset1['id_nosurat']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
