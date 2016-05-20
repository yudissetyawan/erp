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

$colname_framemodel = "-1";
if (isset($_GET['idframe'])) {
  $colname_framemodel = $_GET['idframe'];
}
mysql_select_db($database_core, $core);
$query_framemodel = sprintf("SELECT * FROM e_framemodel WHERE id = %s", GetSQLValueString($colname_framemodel, "int"));
$framemodel = mysql_query($query_framemodel, $core) or die(mysql_error());
$row_framemodel = mysql_fetch_assoc($framemodel);
$totalRows_framemodel = mysql_num_rows($framemodel);

?>
<form name="form1" method="post" action="" >
  <table width="673">
    <tr>
      <td width="350"><h4>Section name</h4></td>
      <td width="311">: <input name="namesection" type="text" id="namesection" size="25" maxlength="25"><input id="frameid" type="hidden" value="<?php echo $row_framemodel['id']; ?>"></td>
    </tr>
  </table><br />
  <table width="672">
    <?php 
		if($row_framemodel['t3'] != ""){
			$query_dimension = sprintf("SELECT * FROM e_dimensi WHERE id = %s", GetSQLValueString($row_framemodel['t3'], "int"));
			$dimension = mysql_query($query_dimension, $core) or die(mysql_error());
			$row_dimension = mysql_fetch_assoc($dimension);
	?>
    <tr>
      <td width="349"><?php echo $row_dimension['dimensionname'] ?> (t3)</td>
      <td width="311">: 
      <input name="t3" type="text" id="t3" size="10" maxlength="25" onClick="calculateForm()" onKeyUp="calculateForm()"></td>
    </tr><?php } ?>
    <?php 
		if($row_framemodel['t2'] != ""){
			$query_dimension = sprintf("SELECT * FROM e_dimensi WHERE id = %s", GetSQLValueString($row_framemodel['t2'], "int"));
			$dimension = mysql_query($query_dimension, $core) or die(mysql_error());
			$row_dimension = mysql_fetch_assoc($dimension);
	?>
    <tr>
      <td width="349"><?php echo $row_dimension['dimensionname'] ?> (t2)</td>
      <td width="311">: <input name="t2" id="t2" type="text" size="10" maxlength="25" onClick="calculateForm()" onKeyUp="calculateForm()"></td>
    </tr><?php } ?>
    <?php 
		if($row_framemodel['tf'] != ""){
			$query_dimension = sprintf("SELECT * FROM e_dimensi WHERE id = %s", GetSQLValueString($row_framemodel['tf'], "int"));
			$dimension = mysql_query($query_dimension, $core) or die(mysql_error());
			$row_dimension = mysql_fetch_assoc($dimension);
	?>
    <tr>
      <td width="349"><?php echo $row_dimension['dimensionname'] ?> (t2)</td>
      <td width="311">: <input name="tf" id="tf" type="text" size="10" maxlength="25" onClick="calculateForm()" onKeyUp="calculateForm()"></td>
    </tr><?php } ?>
    <?php 
		if($row_framemodel['tw'] != ""){
			$query_dimension = sprintf("SELECT * FROM e_dimensi WHERE id = %s", GetSQLValueString($row_framemodel['tw'], "int"));
			$dimension = mysql_query($query_dimension, $core) or die(mysql_error());
			$row_dimension = mysql_fetch_assoc($dimension);
	?>
    <tr>
      <td width="349"><?php echo $row_dimension['dimensionname'] ?> (tw)</td>
      <td width="311">: <input name="tw" id="tw" type="text" size="10" maxlength="25" onClick="calculateForm()" onKeyUp="calculateForm()"></td>
    </tr><?php } ?>
    <?php 
		if($row_framemodel['t2b'] != ""){
			$query_dimension = sprintf("SELECT * FROM e_dimensi WHERE id = %s", GetSQLValueString($row_framemodel['t2b'], "int"));
			$dimension = mysql_query($query_dimension, $core) or die(mysql_error());
			$row_dimension = mysql_fetch_assoc($dimension);
	?>
    <tr>
      <td width="349"><?php echo $row_dimension['dimensionname'] ?> (t2b)</td>
      <td width="311">: <input name="t2b" id="t2b" type="text" size="10" maxlength="25" onClick="calculateForm()" onKeyUp="calculateForm()"></td>
    </tr><?php } ?>
    <?php 
		if($row_framemodel['tfb'] != ""){
			$query_dimension = sprintf("SELECT * FROM e_dimensi WHERE id = %s", GetSQLValueString($row_framemodel['tfb'], "int"));
			$dimension = mysql_query($query_dimension, $core) or die(mysql_error());
			$row_dimension = mysql_fetch_assoc($dimension);
	?>
    <tr>
      <td width="349"><?php echo $row_dimension['dimensionname'] ?> (tfb)</td>
      <td width="311">: <input name="tfb" id="tfb" type="text" size="10" maxlength="25" onClick="calculateForm()" onKeyUp="calculateForm()"></td>
    </tr><?php } ?>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="349">Area Width</td>
      <td width="311">: <input name="width" id="areawidth" type="text"></td>
    </tr>
  </table>
</form>
<?php
mysql_free_result($framemodel);

mysql_free_result($dimension);
?>
