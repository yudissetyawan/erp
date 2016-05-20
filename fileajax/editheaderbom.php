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
  $updateSQL = sprintf("UPDATE e_header_bom SET drawingno=%s, createdby=%s, location=%s, customer=%s, projectcode=%s, productioncode=%s, checkedby=%s, approvedby=%s WHERE id=%s",
                       GetSQLValueString($_POST['drawingno'], "text"),
                       GetSQLValueString($_POST['createdby'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['production'], "text"),
                       GetSQLValueString($_POST['checkedby'], "text"),
                       GetSQLValueString($_POST['approvedby'], "text"),
                       GetSQLValueString($_GET['data'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "../eng/editbom.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM a_customer ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_employee";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM a_proj_code";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset5 = "SELECT * FROM e_drawing_file";
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT e_drawing_file.drawingno, maker.firstname AS makername, a_customer.customername, e_header_bom.location, e_header_bom.tw, e_header_bom.tlgh, a_production_code.productioncode, a_proj_code.project_code, e_header_bom.revision, e_header_bom.`date`, checked.firstname AS checkedby, approve.firstname AS approvedby, e_header_bom.productioncode AS productionid, e_header_bom.drawingno AS drawingid, e_header_bom.createdby AS craetedid, e_header_bom.customer AS costumerid, e_header_bom.projectcode AS projectid, e_header_bom.checkedby AS checkedid, e_header_bom.approvedby AS approveid FROM e_header_bom LEFT JOIN e_drawing_file ON e_header_bom.drawingno=e_drawing_file.id LEFT JOIN  h_employee AS maker ON e_header_bom.createdby=maker.id LEFT JOIN a_customer ON e_header_bom.customer=a_customer.id LEFT JOIN a_production_code ON e_header_bom.productioncode=a_production_code.id LEFT JOIN a_proj_code ON e_header_bom.projectcode=a_proj_code.id LEFT JOIN  h_employee AS checked ON e_header_bom.checkedby=checked.id LEFT JOIN h_employee AS approve ON e_header_bom.approvedby = approve.id WHERE e_header_bom.id = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="625" border="0" class="General">
    <tr>
      <td width="124" class="General">Drawing Number</td>
      <td width="20">:</td>
      <td width="467"><select name="drawingno" id="drawingno" class="required" title="Please select Drawing Number" >
        <option value="<?php echo $row_Recordset4['drawingid']; ?>"><?php echo $row_Recordset4['drawingno']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset5['id']?>"><?php echo $row_Recordset5['drawingno']?></option>
        <?php
} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
  $rows = mysql_num_rows($Recordset5);
  if($rows > 0) {
      mysql_data_seek($Recordset5, 0);
	  $row_Recordset5 = mysql_fetch_assoc($Recordset5);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Created By</td>
      <td>:</td>
      <td><select name="createdby" id="createdby" class="required" title="Please select created by">
        <option value="<?php echo $row_Recordset4['craetedid']; ?>"><?php echo $row_Recordset4['makername']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td><input name="location" type="text" class="required" id="location" title="Location is required" value="<?php echo $row_Recordset4['location']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Customer</td>
      <td>:</td>
      <td><select name="customer" id="customer" class="required" title="Please select Customer">
      <option value="<?php echo $row_Recordset4['costumerid']; ?>"><?php echo $row_Recordset4['customername']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['customername']?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td><select name="projectcode" id="projectcode" class="required" title="Project Code" onChange="viewProduction()" >
        <option value="<?php echo $row_Recordset4['projectid']; ?>"><?php echo $row_Recordset4['project_code']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset3['id']?>"><?php echo $row_Recordset3['project_code']?></option>
        <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Production Code</td>
      <td>:</td>
      <td><div id="prodcon"><input type="text" value="<?php echo $row_Recordset4['productioncode']; ?>" /><input name="production" type="hidden" value="<?php echo $row_Recordset4['productionid']; ?>" /></div></td>
    </tr>
    <tr>
      <td class="General">Checked By</td>
      <td>:</td>
      <td><select name="checkedby" id="checkedby" class="required" title="Please select checked by">
        <option value="<?php echo $row_Recordset4['checkedid']; ?>"><?php echo $row_Recordset4['checkedby']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Approved By</td>
      <td>:</td>
      <td><select name="approvedby" id="approvedby" class="required" title="Please select required by">
      <option value="<?php echo $row_Recordset4['approveid']; ?>"><?php echo $row_Recordset4['approvedby']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td><input name="submit" type="submit" value="submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="jumM" id="jumM" value="" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset5);

mysql_free_result($Recordset4);
?>
