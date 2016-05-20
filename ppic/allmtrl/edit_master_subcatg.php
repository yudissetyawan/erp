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
	$idmcatg = $_POST['id_mcatg'];
  $updateSQL = sprintf("UPDATE m_master_subcatg SET msubcatg_code=%s, msubcatg_descr=%s, id_mcatg=%s, subcatg_notes=%s WHERE id_msubcatg=%s",
                       GetSQLValueString($_POST['msubcatg_code'], "text"),
                       GetSQLValueString($_POST['msubcatg_descr'], "text"),
                       GetSQLValueString($_POST['id_mcatg'], "int"),
                       GetSQLValueString($_POST['subcatg_notes'], "text"),
                       GetSQLValueString($_POST['id_msubcatg'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
	
	echo "<script>document.location=\"view_master_subcatg.php?data=$idmcatg\";</script>";
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT a.*, b.mcatg_descr FROM m_master_subcatg a, m_master_catg b WHERE a.id_mcatg = b.id_mcatg AND id_msubcatg = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_rscmbcatg = "SELECT m_master_catg.id_mcatg, m_master_catg.mcatg_code, m_master_catg.mcatg_descr FROM m_master_catg WHERE m_master_catg.catg_stat = '1'";
$rscmbcatg = mysql_query($query_rscmbcatg, $core) or die(mysql_error());
$row_rscmbcatg = mysql_fetch_assoc($rscmbcatg);
$totalRows_rscmbcatg = mysql_num_rows($rscmbcatg);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Subcategory of Items</title>
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
<b>Edit Subcategory of Items</b>
<br><br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr>
      <td width="100">Category</td>
      <td width="20">:</td>
      <td><select name="mcatg_descr">
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbcatg['id_mcatg']?>" <?php if ($row_rscmbcatg['id_mcatg'] == $row_Recordset1['id_mcatg']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbcatg['mcatg_descr']?></option>
        <?php
} while ($row_rscmbcatg = mysql_fetch_assoc($rscmbcatg));
  $rows = mysql_num_rows($rscmbcatg);
  if($rows > 0) {
      mysql_data_seek($rscmbcatg, 0);
	  $row_rscmbcatg = mysql_fetch_assoc($rscmbcatg);
  }
?>
      </select>
        <input type="hidden" name="id_mcatg" value="<?php echo $row_Recordset1['id_mcatg']; ?>" size="32" />
        <input type="hidden" name="id_msubcatg" value="<?php echo $row_Recordset1['id_msubcatg']; ?>" />
      </td>
    </tr>
    <tr>
      <td>Subcategory Code</td>
      <td>:</td>
      <td><input type="text" name="msubcatg_code" value="<?php echo htmlentities($row_Recordset1['msubcatg_code'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Subcategory</td>
      <td>:</td>
      <td><input type="text" name="msubcatg_descr" value="<?php echo htmlentities($row_Recordset1['msubcatg_descr'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Notes</td>
      <td>:</td>
      <td><textarea cols="40" rows="3" name="subcatg_notes"><?php echo htmlentities($row_Recordset1['subcatg_notes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
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

mysql_free_result($rscmbcatg);
?>
