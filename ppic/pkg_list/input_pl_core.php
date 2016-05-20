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
  $insertSQL = sprintf("INSERT INTO p_pl_core (id_header, qty, id_unit, id_descr, id_prop, remark, weights, dimensions, volumes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
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

  $insertGoTo = "view_pl_core_ready.php?data=" . $row_Recordset1['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO m_master_prop (id_prop, id_item, weight_kgs, dimension_m, volume_m3) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_prop'], "int"),
                       GetSQLValueString($_POST['id_descr'], "int"),
                       GetSQLValueString($_POST['weight_kgs'], "double"),
                       GetSQLValueString($_POST['dimension_m'], "text"),
                       GetSQLValueString($_POST['volume_m3'], "double"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT p_pl_header.*, pr_si_header.no_si FROM p_pl_header, pr_si_header WHERE p_pl_header.id = %s AND p_pl_header.id_si=pr_si_header.id", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM m_unit";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT DISTINCT pr_si_core.id, pr_si_core.id_header, pr_si_core.id_descr, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_unit, m_e_model.mtrl_model, m_unit.unit FROM pr_si_core, m_master, m_e_model, m_unit WHERE pr_si_core.id_header = %s AND pr_si_core.id_descr=m_master.id_item AND m_master.id_mmodel=m_e_model.id_mmodel AND m_master.id_unit =m_unit.id_unit", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$ceknomor=mysql_fetch_array(mysql_query("SELECT id_prop FROM m_master_prop ORDER BY id_prop DESC LIMIT 1"));
$cekQ=$ceknomor[id_prop];
$next=$cekQ+1;

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
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table>
    <tr>
      <td>Description</td>
      <td>:</td>
      <td><label for="id_prop">
        <select name="id_descr" id="id_descr">
          <option value="">-- Description --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['id_descr']?>"><?php echo $row_Recordset3[mtrl_model]; ?> (<?php echo $row_Recordset3['descr_name']; ?>) <?php echo $row_Recordset3['id_type']; ?> <?php echo $row_Recordset3['brand']; ?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select>
        <em>*item yang tampil hanya yang ada pada SI no. <?php echo $row_Recordset1['no_si']; ?></em>
      </label></td>
    </tr>
    <tr>
      <td>Qty
<input type="hidden" name="id_header" value="<?php echo $row_Recordset1['id']; ?>" size="32" /></td>
      <td>:</td>
      <td><label for="id_unit">
        <input type="text" name="qty" value="" size="32" onFocus="startCalc();" onBlur="stopCalc();" />
      </label></td>
    </tr>
    <tr>
      <td>Unit</td>
      <td>:</td>
      <td><label for="id_descr">
        <select name="id_unit" id="id_unit">
          <option value="">-- Unit --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['id_unit']?>"><?php echo $row_Recordset3['unit']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Weight (Kgs)</td>
      <td>:</td>
      <td><label for="weight_kgs"></label>
        @ 
        <input type="text" name="weight_kgs" id="weight_kgs" onFocus="startCalc();" onBlur="stopCalc();" />
      <input type="hidden" name="id_prop" id="id_prop" value="<?php echo $next; ?>" /> <label for="weights"></label>
      <input type="text" name="weights" id="weights" style="border:thin"/></td>
    </tr>
    <tr>
      <td>Dimension (Mtr)</td>
      <td>:</td>
      <td><label for="dimension_m"></label>
      <input type="text" name="dimension_m" id="dimension_m"/> </td>
    </tr>
    <tr>
      <td>Volume (M3)</td>
      <td>:</td>
      <td><label for="volume_m3"></label>
      @ 
      <input type="text" name="volume_m3" id="volume_m3"  onFocus="startCalc();" onBlur="stopCalc();" /> <label for="volume"></label>
      <input type="text" name="volume" id="volume"  style="border:thin" /></td>
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
