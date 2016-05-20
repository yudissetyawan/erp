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
  $insertSQL = sprintf("INSERT INTO pr_si_core (id_header, qty, id_unit, id_descr, id_prop, remark, weights, dimensions, volumes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_header'], "int"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['id_unit'], "int"),
                       GetSQLValueString($_POST['id_descr'], "int"),
                       GetSQLValueString($_POST['id_prop'], "int"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['weights'], "text"),
                       GetSQLValueString($_POST['dimension_m'], "text"),
                       GetSQLValueString($_POST['volume'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  
  $insertGoTo = "view_si_core.php?data=" . $_GET ['data'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));  
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO m_master_prop (id_prop, id_item, id_pkg_list, weight_kgs, dimension_m, volume_m3) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_prop'], "int"),
                       GetSQLValueString($_POST['id_descr'], "int"),
                       GetSQLValueString($_POST['id_header'], "int"),
                       GetSQLValueString($_POST['weight_kgs'], "double"),
                       GetSQLValueString($_POST['dimension_m'], "text"),
                       GetSQLValueString($_POST['volume_m3'], "double"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT m_master.*, m_e_model.mtrl_model FROM m_master, m_e_model WHERE m_master.id_mmodel=m_e_model.id_mmodel";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM pr_si_header WHERE id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_unit = "SELECT * FROM m_unit";
$unit = mysql_query($query_unit, $core) or die(mysql_error());
$row_unit = mysql_fetch_assoc($unit);
$totalRows_unit = mysql_num_rows($unit);

$ceknomor=mysql_fetch_array(mysql_query("SELECT id_prop FROM m_master_prop ORDER BY id_prop DESC LIMIT 1"));
$cekQ=$ceknomor[id_prop];
$next=$cekQ+1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Detail Shipping Instruction</title>

<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

<script type="text/javascript">
	function startCalc(){interval=setInterval("calc()",1)}
	function calc(){one=	document.form1.qty.value;
					two=	document.form1.weight_kgs.value;
					three=	document.form1.volume_m3.value;
							document.form1.weights.value=(one*1)*(two*1)
							document.form1.volume.value=(one*1)*(three*1)}
	function stopCalc(){clearInterval(interval)}
</script>

</head>

<body>
<h3>Input Detail Shipping Instruction</h3>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table>
    <tr>
      <td>Description</td>
      <td>:</td>
      <td><label for="id_prop2">
        <select name="id_descr" id="id_descr">
          <option value="">-- Description --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['id_item']?>"><?php echo $row_Recordset1[mtrl_model]; ?> (<?php echo $row_Recordset1['descr_name']; ?>) <?php echo $row_Recordset1['id_type']; ?> <?php echo $row_Recordset1['brand']; ?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Qty        
      <input type="hidden" name="id_header" value="<?php echo $_GET['data']; ?>" size="32" /></td>
      <td>:</td>
      <td><label for="id_unit">
        <input type="text" name="qty" value="" size="32" onfocus="startCalc();" onblur="stopCalc();" />
      </label></td>
    </tr>
    <tr>
      <td>Unit</td>
      <td>:</td>
      <td><label for="id_unit2"></label>
        <select name="id_unit" id="id_unit2">
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
      <td>Weight (Kgs)</td>
      <td>:</td>
      <td><label for="weight_kgs"></label>
        @
        <input type="text" name="weight_kgs" id="weight_kgs" onfocus="startCalc();" onblur="stopCalc();" />
        <input type="hidden" name="id_prop" id="id_prop" value="<?php echo $next; ?>" />
        <label for="weights"></label></td>
    </tr>
    <tr>
      <td>Total Weight</td>
      <td>:</td>
      <td><input type="text" name="weights" id="weights" style="border:thin"/></td>
    </tr>
    <tr>
      <td>Dimension (Mtr)</td>
      <td>:</td>
      <td><label for="dimension_m"></label>
        <input type="text" name="dimension_m" id="dimension_m"/></td>
    </tr>
    <tr>
      <td>Volume (M3)</td>
      <td>:</td>
      <td><label for="volume_m3"></label>
        @
        <input type="text" name="volume_m3" id="volume_m3"  onfocus="startCalc();" onblur="stopCalc();" />
        <label for="volume"></label></td>
    </tr>
    <tr>
      <td>Total Volume</td>
      <td>:</td>
      <td><input type="text" name="volume" id="volume"  style="border:thin" /></td>
    </tr>
    <tr>
      <td>Remark</td>
      <td>:</td>
      <td><label for="remark"></label>
        <textarea name="remark" id="remark" cols="45" rows="5"></textarea></td>
    </tr>
    <tr align="center">
      <td colspan="3"><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset3);
	mysql_free_result($unit);
?>
