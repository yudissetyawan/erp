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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_training SET id_datapribadi=%s, id_h_employee=%s, kategori=%s, jenis_training=%s, `date`=%s, exp_date=%s, no_certificate=%s, provider=%s, remark=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_datapribadi'], "text"),
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['jenis_training'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['exp_date'], "text"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}
$colname_training = "-1";
if (isset($_GET['data'])) {
  $colname_training = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_training = sprintf("SELECT * FROM h_training WHERE id = %s", GetSQLValueString($colname_training, "int"));
$training = mysql_query($query_training, $core) or die(mysql_error());
$row_training = mysql_fetch_assoc($training);
$totalRows_training = mysql_num_rows($training);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="487" align="center">
    <tr>
      <td>&nbsp;</td>
      <td><?php echo $row_training['id']; ?></td>
    </tr>
    <tr>
      <td>Kategori:</td>
      <td><input name="" id="" readonly="readonly" type="text" value="<?php
	if (($row_training['kategori'] == '1')) {
		echo 'Management Training';
	}
	else { echo 'Skill Training'; }
?>" />
<input type="hidden" name="kategori" id="kategori" value="<?php echo $row_training['kategori']; ?>" /></td>
    </tr>
    <tr>
      <td>Jenis Training:</td>
      <td><input type="text" name="jenis_training" value="<?php echo htmlentities($row_training['jenis_training'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Date:</td>
      <td><input type="text" name="date" value="<?php echo htmlentities($row_training['date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Expired Date:</td>
      <td><input type="text" name="exp_date" value="<?php echo htmlentities($row_training['exp_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>No Certificate:</td>
      <td><input type="text" name="no_certificate" value="<?php echo htmlentities($row_training['no_certificate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Provider:</td>
      <td><input type="text" name="provider" value="<?php echo htmlentities($row_training['provider'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Remark:</td>
      <td><textarea cols="45" rows="5" name="remark" id="remark"><?php echo $row_training['remark']; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" value="Update" /></td>
    </tr>
  </table>
  <input type="hidden" name="id_datapribadi" value="<?php echo htmlentities($row_training['id_datapribadi'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
<input type="hidden" name="id_h_employee" value="<?php echo htmlentities($row_training['id_h_employee'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
<input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_training['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($training);
?>
