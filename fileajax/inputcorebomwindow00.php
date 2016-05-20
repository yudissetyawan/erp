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
$query_hdrcorebom = sprintf("SELECT * FROM e_header_core_bom WHERE id = %s", GetSQLValueString($colname_hdrcorebom, "int"));
$hdrcorebom = mysql_query($query_hdrcorebom, $core) or die(mysql_error());
$row_hdrcorebom = mysql_fetch_assoc($hdrcorebom);
$totalRows_hdrcorebom = mysql_num_rows($hdrcorebom);

mysql_select_db($database_core, $core);
$query_headerBom = "SELECT id, tw, tlgh FROM e_header_bom WHERE id =".$row_hdrcorebom['id_header']."";
$headerBom = mysql_query($query_headerBom, $core) or die(mysql_error());
$row_headerBom = mysql_fetch_assoc($headerBom);
$totalRows_headerBom = mysql_num_rows($headerBom);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formmaterial")) {
	
  $updateSQLheader = sprintf("UPDATE e_header_bom SET tw=%s, tlgh=%s WHERE id=%s",
                       GetSQLValueString($_POST['tw'] + $row_headerBom['tw'], "double"),
                       GetSQLValueString($_POST['tlgh'] + $row_headerBom['tlgh'], "double"),
					   GetSQLValueString($row_headerBom['id'], "int"));
	
  $updateSQLheadercore = sprintf("UPDATE e_header_core_bom SET sumTW=%s, sumLgh=%s, sumPA=%s, sumTPA=%s WHERE id=%s",
                       GetSQLValueString($_POST['tw']+$row_hdrcorebom['sumTW'], "double"),
                       GetSQLValueString($_POST['tlgh']+$row_hdrcorebom['sumLgh'], "double"),
                       GetSQLValueString($_POST['paintarea']+$row_hdrcorebom['sumPA'], "double"),
                       GetSQLValueString($_POST['tpa']+$row_hdrcorebom['sumTPA'], "double"),
                       GetSQLValueString($_POST['header'], "int"));
	
  $insertSQL = sprintf("INSERT INTO e_core_bom (spec, thickness, width, length, unit, unitweight, qtyweight, qty, totalweight, totallength, paintarea, totalpaintarea, headercorebom) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['header'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQLheader, $core) or die(mysql_error());
  $Result2 = mysql_query($updateSQLheadercore, $core) or die(mysql_error());
  $Result3 = mysql_query($insertSQL, $core) or die(mysql_error());

  if($_GET['act']=='edit'){$deleteGoTo = "../editbom.php?data=".$_GET['data'] ; }
  else{$deleteGoTo = "../inputcorebom.php?data=".$_GET['data'];}
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formmaterial")) {
  
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
$query_Recordset2 = sprintf("SELECT e_header_core_bom.id, c_material.materialname AS name, c_material.spec FROM e_header_core_bom LEFT JOIN c_material ON e_header_core_bom.description=c_material.id WHERE e_header_core_bom.id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>
<form name="formmaterial" action="<?php echo $editFormAction; ?>" method="POST"  onkeyup="getTotal()">
<table width="646" onKeyUp="getTotal()"  onClick="getTotal()" >
  <tr>
    <td width="81">Description</td>
    <td width="4">:</td>
    <td width="233"><input type="text" value="<?php echo $row_Recordset2['name']; ?>" size="35" maxlength="25" readonly="readonly"><input type="hidden" name="header" value="<?php echo $row_Recordset2['id']; ?>"></td>
    <td width="37">T.W</td>
    <td width="255">: 
      <input name="tw"  id="totalweight" type="text" readonly="true" value="" /></td>
  </tr>
  <tr>
    <td>spec</td>
    <td>:</td>
    <td><input name="spec" type="text" value="<?php echo $row_Recordset2['spec']; ?>" size="35" maxlength="25" /></td>
    <td>T.Lgh</td>
    <td>: <input name="tlgh" id="tlgh" type="text" readonly="true"  value="" ></td>
  </tr>
  <tr>
    <td>thk</td>
    <td>:</td>
    <td><input type="text" name="thk" /></td>
    <td>T.P.A</td>
    <td>: <input name="tpa" id="totalpa" type="text" readonly="true" value="" ></td>
  </tr>
  <tr>
    <td>width</td>
    <td>:</td>
    <td><input type="text" name="width" id="width"  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>lgh</td>
    <td>:</td>
    <td><input type="text" name="lgh" id="lgh" value=""  ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>unit</td>
    <td>:</td>
    <td><select name="unit" id="select">
      <option value="">--unit--</option>
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
    <td><a href="#" onclick="addUnit()" class="addunitmat" >create new unit</a></td>
  </tr>
  <tr>
    <td>qty</td>
    <td>:</td>
    <td><input type="text" name="qty" id="qty" value="" ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>unit weight</td>
    <td>:</td>
    <td><input type="text" name="unitweight" id="unitweight" value="" ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>qty weight</td>
    <td>:</td>
    <td><input name="qtyweight" id="qtyweight" type="text" readonly="readonly" value="" ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Paint Area</td>
    <td>:</td>
    <td><input type="text" name="paintarea" id="paintarea"  /></td>
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
  <input type="hidden" name="MM_update" value="formmaterial" />
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($hdrcorebom);
?>