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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_si_core (id_header, qty, id_unit, id_descr, id_prop, remark, weights, dimensions, volumes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_header'], "int"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['id_unit'], "int"),
                       GetSQLValueString($_POST['id_descr'], "int"),
                       GetSQLValueString($_POST['id_prop'], "int"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['weights'], "text"),
                       GetSQLValueString($_POST['dimensions'], "text"),
                       GetSQLValueString($_POST['volumes'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_descr = "SELECT m_master.*, m_e_model.mtrl_model FROM m_master, m_e_model WHERE m_master.id_mmodel=m_e_model.id_mmodel";
$descr = mysql_query($query_descr, $core) or die(mysql_error());
$row_descr = mysql_fetch_assoc($descr);
$totalRows_descr = mysql_num_rows($descr);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM m_unit";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM m_master_prop ORDER BY id_prop DESC LIMIT 1"));
$cekQ=$ceknomor[id_prop];
$nextid_prop=(int)$awalQ+1;

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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Description 
      <input type="text" name="id_header" value="<?php echo $_GET['data']; ?>" size="10" /></td>
      <td>:</td>
      <td>
        <select name="id_descr" id="id_descr">
        <option value="">-- Description --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_descr['id_item']?>"><?php echo $row_Recordset1[mtrl_model]; ?> (<?php echo $row_Recordset1['descr_name']; ?>) <?php echo $row_Recordset1['id_type']; ?> <?php echo $row_Recordset1['brand']; ?></option>
          <?php
} while ($row_descr = mysql_fetch_assoc($descr));
  $rows = mysql_num_rows($descr);
  if($rows > 0) {
      mysql_data_seek($descr, 0);
	  $row_descr = mysql_fetch_assoc($descr);
  }
?>
      </select></td>
      <td>Weights 
      <input type="text" name="id_prop" value="<?php echo $nextid_prop; ?>" size="10" /></td>
      <td>:</td>
      <td>@ 
      <input type="text" name="weight_kgs" id="weight_kgs" onfocus="startCalc();" onblur="stopCalc();" />        <input type="text" name="weights" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Qty</td>
      <td>:</td>
      <td><input type="text" name="qty" value="" size="20" onfocus="startCalc();" onblur="stopCalc();" /></td>
      <td>Dimensions</td>
      <td>:</td>
      <td><input type="text" name="dimensions" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unit</td>
      <td>:</td>
      <td>
        <select name="id_unit" id="id_unit">
        <option value="">-- Unit --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id_unit']?>"><?php echo $row_Recordset2['unit']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
      <td>Volumes</td>
      <td>:</td>
      <td>@ 
      <input type="text" name="volume_m3" id="volume_m3"  onfocus="startCalc();" onblur="stopCalc();" /> 
              <input type="text" name="volumes" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="right" nowrap="nowrap">&nbsp;</td>
      <td>Remark</td>
      <td>:</td>
      <td><input type="text" name="remark" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center"><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($descr);

mysql_free_result($Recordset2);
?>
