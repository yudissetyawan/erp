<?php require_once('../Connections/core.php');  ?>
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

$colname_hdrcorebom = "-1";
if (isset($_GET['data2'])) {
  $colname_hdrcorebom = $_GET['data2'];
}

mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT e_core_bom.id, e_core_bom.spec, e_core_bom.thickness, e_core_bom.width, e_core_bom.length, e_core_bom.unitweight, e_core_bom.qtyweight, e_core_bom.qty, e_core_bom.totalweight, e_core_bom.totallength, e_core_bom.paintarea, e_core_bom.totalpaintarea, e_core_bom.headercorebom,e_core_bom.unit AS unitId, c_unit.unit FROM e_core_bom LEFT JOIN c_unit ON e_core_bom.unit=c_unit.id WHERE e_core_bom.id = %s", GetSQLValueString($colname_hdrcorebom, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);


mysql_select_db($database_core, $core);
$query_hdrcorebom = sprintf("SELECT * FROM e_header_core_bom WHERE id = %s", GetSQLValueString($row_Recordset3['headercorebom'], "int"));
$hdrcorebom = mysql_query($query_hdrcorebom, $core) or die(mysql_error());
$row_hdrcorebom = mysql_fetch_assoc($hdrcorebom);
$totalRows_hdrcorebom = mysql_num_rows($hdrcorebom);

mysql_select_db($database_core, $core);
$query_headerbom = sprintf("SELECT id, tw, tlgh FROM e_header_bom WHERE id = %s", GetSQLValueString($row_hdrcorebom['id_header'], "int"));
$headerbom = mysql_query($query_headerbom, $core) or die(mysql_error());
$row_headerbom = mysql_fetch_assoc($headerbom);
$totalRows_headerbom = mysql_num_rows($headerbom);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formmaterial")) {
  $updateSQLheader = sprintf("UPDATE e_header_bom SET tw=%s, tlgh=%s WHERE id=%s",
                       GetSQLValueString(($_POST['tw']+($row_headerbom['tw']-$row_Recordset3['totalweight'])), "double"),
                       GetSQLValueString(($_POST['tlgh']+($row_headerbom['tlgh']-$row_Recordset3['totallength'])), "double"),
					   GetSQLValueString($row_headerbom['id'], "int"));
	
  $updateSQLheadercore = sprintf("UPDATE e_header_core_bom SET sumTW=%s, sumLgh=%s, sumPA=%s, sumTPA=%s WHERE id=%s",
                       GetSQLValueString((($row_hdrcorebom['sumTW'] - $row_Recordset3['totalweight']) + $_POST['tw']), "double"),
                       GetSQLValueString((($row_hdrcorebom['sumLgh'] - $row_Recordset3['totallength']) + $_POST['tlgh']), "double"),
                       GetSQLValueString((($row_hdrcorebom['sumPA'] - $row_Recordset3['paintarea']) + $_POST['paintarea']), "double"),
                       GetSQLValueString((($row_hdrcorebom['sumTPA'] - $row_Recordset3['totalpaintarea']) + $_POST['tpa']), "double"),
                       GetSQLValueString($row_hdrcorebom['id'], "int"));
  
	
  $updateSQLcore = sprintf("UPDATE e_core_bom SET spec=%s, thickness=%s, width=%s, length=%s, unit=%s, unitweight=%s, qtyweight=%s, qty=%s, totalweight=%s, totallength=%s, paintarea=%s, totalpaintarea=%s WHERE id=%s",
                       GetSQLValueString($_POST['spec'], "double"),
                       GetSQLValueString($_POST['thk'], "double"),
                       GetSQLValueString($_POST['width'], "double"),
                       GetSQLValueString($_POST['lgh'], "double"),
                       GetSQLValueString($_POST['unit'], "int"),
                       GetSQLValueString($_POST['unitweight'], "double"),
                       GetSQLValueString($_POST['qtyweight'], "double"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['tw'], "double"),
                       GetSQLValueString($_POST['tlgh'], "double"),
                       GetSQLValueString($_POST['paintarea'], "double"),
                       GetSQLValueString($_POST['tpa'], "double"),
                       GetSQLValueString($_GET['data2'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQLheader, $core) or die(mysql_error());
  $Result2 = mysql_query($updateSQLheadercore, $core) or die(mysql_error());
  $Result3 = mysql_query($updateSQLcore, $core) or die(mysql_error());

  if($_GET['act']=='edit'){$deleteGoTo = "../editbom.php?data=".$_GET['data2'] ; }
  else{$deleteGoTo = "../inputcorebom.php?data=".$_GET['data2'];}
  header(sprintf("Location: %s", $deleteGoTo));
}


mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM c_unit";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data2'])) {
  $colname_Recordset2 = $_GET['data2'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT c_material.materialname AS name FROM e_core_bom LEFT JOIN e_header_core_bom ON e_core_bom.headercorebom = e_header_core_bom.id LEFT JOIN c_material ON e_header_core_bom.description=c_material.id WHERE e_core_bom.id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>
<form name="formmaterial" action="<?php echo $editFormAction; ?>" method="POST"  onkeyup="getTotal()">
<table width="603" onKeyUp="getTotal()"  onClick="getTotal()" >
  <tr>
    <td width="81">Description</td>
    <td width="4">:</td>
    <td width="179"><input value="<?php echo $row_Recordset2['name']; ?>" type="text" readonly="readonly"><input type="hidden" name="header" value="<?php echo $row_Recordset2['id']; ?>"></td>
    <td width="52">T.W</td>
    <td width="263">: <input name="tw"  id="totalweight" type="text" readonly="true" value="<?php echo $row_Recordset3['totalweight']; ?>"></td>
  </tr>
  <tr>
    <td>spec</td>
    <td>:</td>
    <td><input name="spec" type="text" value="<?php echo $row_Recordset3['spec']; ?>" /></td>
    <td>T.Lgh</td>
    <td>: <input name="tlgh" id="tlgh" type="text" value="<?php echo $row_Recordset3['totallength']; ?>" ></td>
  </tr>
  <tr>
    <td>thk</td>
    <td>:</td>
    <td><input name="thk" type="text" value="<?php echo $row_Recordset3['thickness']; ?>" /></td>
    <td>T.P.A</td>
    <td>: <input name="tpa" id="totalpa" type="text" readonly="true" value="<?php echo $row_Recordset3['totalpaintarea']; ?>" ></td>
  </tr>
  <tr>
    <td>width</td>
    <td>:</td>
    <td><input name="width" type="text" id="width" value="<?php echo $row_Recordset3['width']; ?>"  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>lgh</td>
    <td>:</td>
    <td><input type="text" name="lgh" id="lgh" value="<?php echo $row_Recordset3['length']; ?>"  ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>unit</td>
    <td>:</td>
    <td><select name="unit" id="select">
      <option value="<?php echo $row_Recordset3['unitId']; ?>"><?php echo $row_Recordset3['unit']; ?></option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['unit']?></option>
      <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>qty</td>
    <td>:</td>
    <td><input type="text" name="qty" id="qty" value="<?php echo $row_Recordset3['qty']; ?>" ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>unit weight</td>
    <td>:</td>
    <td><input type="text" name="unitweight" id="unitweight" value="<?php echo $row_Recordset3['unitweight']; ?>" ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>qty weight</td>
    <td>:</td>
    <td><input name="qtyweight" id="qtyweight" type="text" readonly="readonly" value="<?php echo $row_Recordset3['qtyweight']; ?>" ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Paint Area</td>
    <td>:</td>
    <td><input name="paintarea" type="text" id="paintarea" value="<?php echo $row_Recordset3['paintarea']; ?>"  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="" type="submit" value="submit"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="formmaterial">
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($hdrcorebom);

mysql_free_result($headerbom);

mysql_free_result($Recordset3);
?>