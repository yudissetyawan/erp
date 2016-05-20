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
  $updateSQL = sprintf("UPDATE m_master_catg SET mcatg_code=%s, mcatg_descr=%s, catg_notes=%s WHERE id_mcatg=%s",
                       GetSQLValueString($_POST['mcatg_code'], "text"),
                       GetSQLValueString($_POST['mcatg_descr'], "text"),
                       GetSQLValueString($_POST['catg_notes'], "text"),
                       GetSQLValueString($_POST['id_mcatg'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "view_master_catg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM m_master_catg";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM m_master_catg WHERE id_mcatg = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Category of Items</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
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
<b>Edit Category of Items</b>
<br><br>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr>
      <td width="100">Category Code</td>
      <td width="10">:</td>
      <td><input type="text" name="mcatg_code" value="<?php echo htmlentities($row_Recordset1['mcatg_code'], ENT_COMPAT, 'utf-8'); ?>" size="10" />
      <input type="hidden" name="id_mcatg" value="<?php echo $row_Recordset1['id_mcatg']; ?>" /></td>
    </tr>
    <tr>
      <td>Category</td>
      <td>:</td>
      <td><input type="text" name="mcatg_descr" value="<?php echo htmlentities($row_Recordset1['mcatg_descr'], ENT_COMPAT, 'utf-8'); ?>" size="50" /></td>
    </tr>
    <tr>
      <td>Notes</td>
      <td>:</td>
      <td><textarea name="catg_notes" cols="40"><?php echo htmlentities($row_Recordset1['catg_notes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Update" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
