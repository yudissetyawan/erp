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
  $updateSQL = sprintf("UPDATE m_master SET itemprice=%s, lockprice=%s WHERE id_item=%s",
                       GetSQLValueString($_POST['txtprice'], "text"),
					   GetSQLValueString($_POST['cmblock'], "text"),
                       GetSQLValueString($_POST['iditem'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "../ppic/allmtrl/viewallmtrl_det.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsitemmr = "-1";
if (isset($_GET['data2'])) {
  $colname_rsitemmr = $_GET['data2'];
}
mysql_select_db($database_core, $core);
$query_rsitemmr = sprintf("SELECT m_master.id_item, m_master.item_code, m_e_model.mtrl_model, m_master.descr_name, m_master.id_mstd, m_master.descr_spec, m_master.id_type, m_master.brand, m_master.itemprice, m_master.lockprice, m_unit.unit, m_master_catg.mcatg_descr, m_master_subcatg.msubcatg_descr FROM m_master, m_unit, m_e_model, m_master_subcatg, m_master_catg WHERE m_master.id_unit = m_unit.id_unit AND m_e_model.id_mmodel = m_master.id_mmodel AND m_e_model.id_subcatg = m_master_subcatg.id_msubcatg AND m_master_catg.id_mcatg = m_master_subcatg.id_mcatg AND m_master.id_item = %s", GetSQLValueString($colname_rsitemmr, "int"));
$rsitemmr = mysql_query($query_rsitemmr, $core) or die(mysql_error());
$row_rsitemmr = mysql_fetch_assoc($rsitemmr);
$totalRows_rsitemmr = mysql_num_rows($rsitemmr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Price of Item</title>
</head>

<script type="text/javascript" src="../../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.pack.js"></script>

<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

<body class="General" onLoad="document.form1.txtprice.focus();">

<b>Update Price of Item</b>
<br /><br />

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="620" border="0" class="General">
    <tr>
      <td width="200" class="General">Category
        <input name="iditem" type="hidden" id="iditem" value="<?php echo $row_rsitemmr['id_item']; ?>" />
      </td>
      <td width="16">:</td>
      <td width="410"><?php echo $row_rsitemmr['mcatg_descr']; ?></td>
    </tr>
    <tr>
      <td class="General">Subcategory</td>
      <td width="16">:</td>
      <td><?php echo $row_rsitemmr['msubcatg_descr']; ?></td>
    </tr>
    <tr>
      <td class="General">Item Code</td>
      <td>:</td>
      <td><?php echo $row_rsitemmr['item_code']; ?></td>
    </tr>
    <tr>
      <td class="General">Name of Item [ Description ]</td>
      <td>:</td>
      <td><?php echo $row_rsitemmr['mtrl_model']; ?> [ <?php echo $row_rsitemmr['descr_name']; ?> ] </td>
    </tr>
    <tr>
      <td class="General">Specification</td>
      <td>:</td>
      <td><?php echo $row_rsitemmr['descr_spec']; ?></td>
    </tr>
    <tr>
      <td class="General">Material</td>
      <td>:</td>
      <td><?php echo $row_rsitemmr['id_type']; ?></td>
    </tr>
    <tr>
      <td class="General">Brand</td>
      <td>:</td>
      <td><?php echo $row_rsitemmr['brand']; ?></td>
    </tr>
    <tr>
      <td class="General">Unit</td>
      <td>:</td>
      <td><?php echo $row_rsitemmr['unit']; ?></td>
    </tr>
    <tr>
      <td class="General">Price</td>
      <td>:</td>
      <td><label for="txtprice"></label>
      <input type="text" name="txtprice" id="txtprice" style="text-align:right" size="18" value="<?php echo $row_rsitemmr['itemprice']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Lock Price</td>
      <td>:</td>
      <td><label for="cmblock"></label>
        <select name="cmblock" id="cmblock">
          <option value="1" <?php if ($row_rsitemmr['lockprice'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
          <option value="0" <?php if ($row_rsitemmr['lockprice'] == '0') { ?> selected="selected" <?php } ?>>No</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="General">&nbsp;</td>
      <td class="General"><input type="submit" name="submit" id="submit" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>

<?php
	mysql_free_result($rsitemmr);
?>