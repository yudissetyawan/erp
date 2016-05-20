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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO m_unit (id_unit, unit, unitdesc) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_unit'], "int"),
                       GetSQLValueString($_POST['unit'], "text"),
                       GetSQLValueString($_POST['unitdesc'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "inputallmtrl.php?data=" . $row_rssubcatg['id_msubcatg'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rssubcatg = "-1";
if (isset($_GET['data'])) {
  $colname_rssubcatg = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rssubcatg = sprintf("SELECT * FROM m_master_subcatg WHERE id_msubcatg = %s", GetSQLValueString($colname_rssubcatg, "int"));
$rssubcatg = mysql_query($query_rssubcatg, $core) or die(mysql_error());
$row_rssubcatg = mysql_fetch_assoc($rssubcatg);
$totalRows_rssubcatg = mysql_num_rows($rssubcatg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
  <table>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unit</td>
      <td>:</td>
      <td><input type="text" name="unit" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unit Description</td>
      <td>:</td>
      <td><input type="text" name="unitdesc" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="center" nowrap="nowrap"><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>
  <input type="submit" name="cancel" id="cancel" value="Cancel" onclick="history.back(-1)" />
</p>
</body>
</html>
<?php
	mysql_free_result($rssubcatg);
?>