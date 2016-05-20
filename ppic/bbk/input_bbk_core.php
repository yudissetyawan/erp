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
  $insertSQL = sprintf("INSERT INTO p_bbk_core (id_header, id_item, id_prod_code, qty, unit, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_header'], "int"),
                       GetSQLValueString($_POST['id_item'], "int"),
                       GetSQLValueString($_POST['id_prod_code'], "int"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['unit'], "int"),
                       GetSQLValueString($_POST['keterangan'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "view_bbk_core.php?data=" . $row_rscmbbpbcore['id_header'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE p_stock_item SET id_bbk=%s, qty_bbk=%s WHERE id_item=%s",
                       GetSQLValueString($_POST['id_header'], "int"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['id_item'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_rscmbbpbcore = "-1";
if (isset($_GET['data'])) {
  $colname_rscmbbpbcore = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rscmbbpbcore = sprintf("SELECT m_master.item_code, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.id_mstd, m_master.id_type, m_master.brand, m_master.id_item FROM p_bbk_header, p_bpb_core, m_master, m_e_model WHERE p_bbk_header.id_bpb = p_bpb_core.bpb_idheader AND p_bpb_core.id_item = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND p_bbk_header.id = %s", GetSQLValueString($colname_rscmbbpbcore, "int"));
$rscmbbpbcore = mysql_query($query_rscmbbpbcore, $core) or die(mysql_error());
$row_rscmbbpbcore = mysql_fetch_assoc($rscmbbpbcore);
$totalRows_rscmbbpbcore = mysql_num_rows($rscmbbpbcore);

mysql_select_db($database_core, $core);
$query_rscmbprodcode = "SELECT id, projectcode, productioncode, a_production_code.projecttitle FROM a_production_code";
$rscmbprodcode = mysql_query($query_rscmbprodcode, $core) or die(mysql_error());
$row_rscmbprodcode = mysql_fetch_assoc($rscmbprodcode);
$totalRows_rscmbprodcode = mysql_num_rows($rscmbprodcode);

mysql_select_db($database_core, $core);
$query_unit = "SELECT id_unit, unit FROM m_unit";
$unit = mysql_query($query_unit, $core) or die(mysql_error());
$row_unit = mysql_fetch_assoc($unit);
$totalRows_unit = mysql_num_rows($unit);
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="hidden" name="id_header" value="<?php echo $_GET['data']; ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Kode &amp; Nama Barang</td>
      <td>:</td>
      <td><label for="id_item"></label>
        <select name="id_item" id="id_item">
          <?php
do {  
?>
          <option value="<?php echo $row_rscmbbpbcore['id_item']?>"><?php echo $row_rscmbbpbcore['item_code']; ?> - <?php echo $row_rscmbbpbcore['mtrl_model']; ?> (<?php echo $row_rscmbbpbcore['descr_name']; ?>) <?php echo $row_rscmbbpbcore['id_type']; ?> <?php echo $row_rscmbbpbcore['brand']; ?></option>
          <?php
} while ($row_rscmbbpbcore = mysql_fetch_assoc($rscmbbpbcore));
  $rows = mysql_num_rows($rscmbbpbcore);
  if($rows > 0) {
      mysql_data_seek($rscmbbpbcore, 0);
	  $row_rscmbbpbcore = mysql_fetch_assoc($rscmbbpbcore);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Qty</td>
      <td>:</td>
      <td><input type="text" name="qty" value="" size="20" /></td>
    </tr>
    <tr>
      <td>Unit</td>
      <td>:</td>
      <td>
        <select name="unit" id="unit">
        <option value="">-- Unit --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_unit['id_unit']?>"><?php echo $row_unit['unit']?></option>
          <?php
} while ($row_unit = mysql_fetch_assoc($unit));
  $rows = mysql_num_rows($unit);
  if($rows > 0) {
      mysql_data_seek($unit, 0);
	  $row_unit = mysql_fetch_assoc($unit);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Kode Produksi</td>
      <td>:</td>
      <td><label for="id_prod_code"></label>
        <select name="id_prod_code" id="id_prod_code">
        <option value="">-- Kode Produksi --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rscmbprodcode['id']?>"><?php echo $row_rscmbprodcode['projectcode']; ?> - <?php echo $row_rscmbprodcode['productioncode']?> - <?php echo $row_rscmbprodcode['projecttitle']; ?></option>
          <?php
} while ($row_rscmbprodcode = mysql_fetch_assoc($rscmbprodcode));
  $rows = mysql_num_rows($rscmbprodcode);
  if($rows > 0) {
      mysql_data_seek($rscmbprodcode, 0);
	  $row_rscmbprodcode = mysql_fetch_assoc($rscmbprodcode);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td align="">Keterangan</td>
      <td align="">:</td>
      <td align=""><label for="keterangan"></label>
      <textarea name="keterangan" id="keterangan" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" value="Insert record" /></td>
    </tr>
  </table> 
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rscmbbpbcore);

mysql_free_result($rscmbprodcode);

mysql_free_result($unit);
?>
