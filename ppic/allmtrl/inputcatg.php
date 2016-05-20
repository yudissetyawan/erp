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
  $insertSQL = sprintf("INSERT INTO m_master_catg (mcatg_code, mcatg_descr, mtrl_or_service, catg_notes) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['mcatg_code'], "text"), //$_POST['mcatg_code']
                       GetSQLValueString($_POST['mcatg_descr'], "text"),
					   GetSQLValueString($_POST['cmbmatsvc'], "text"),
                       GetSQLValueString($_POST['catg_notes'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "view_master_catg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Category</title>
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

<body class="General" onLoad="document.form1.mcatg_code.focus();">
<b>Entry Category of Items</b>
<br><br>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td width="150">Material or Service</td>
      <td>:</td>
      <td><label for="cmbmatsvc"></label>
        <select name="cmbmatsvc" id="cmbmatsvc">
          <option value="M">Material</option>
          <option value="S">Service</option>
      </select></td>
    </tr>
    <?php
	/* mysql_select_db($database_core, $core);
	$query_rsmcatg = "SELECT m_master_catg.mcatg_code FROM m_master_catg ORDER BY m_master_catg.mcatg_code DESC LIMIT 1";
	$rsmcatg = mysql_query($query_rsmcatg, $core) or die(mysql_error());
	$row_rsmcatg = mysql_fetch_assoc($rsmcatg);
	$totalRows_rsmcatg = mysql_num_rows($rsmcatg);
	if ($totalRows_rsmcatg != 0) {
		$vidcat = $row_rsmcatg['mcatg_code'];
		switch($vidcat){
			case "A" : $kd="B";break;
			case "B" : $kd="C";break;
			case "C" : $kd="D";break;
			case "D" : $kd="E";break;
			case "E" : $kd="F";break;
			case "F" : $kd="G";break;
			case "G" : $kd="H";break;
			case "H" : $kd="I";break;
			case "I" : $kd="J";break;
			case "J" : $kd="K";break;
			case "K" : $kd="L";break;
			case "L" : $kd="M";break;
			case "M" : $kd="N";break;
			case "N" : $kd="O";break;
			case "O" : $kd="P";break;
			case "P" : $kd="Q";break;
			case "Q" : $kd="R";break;
			case "R" : $kd="S";break;
			case "S" : $kd="T";break;
			case "T" : $kd="U";break;
			case "U" : $kd="V";break;
			case "V" : $kd="W";break;
			case "W" : $kd="X";break;
			case "X" : $kd="Y";break;
			case "Y" : $kd="Z";break;
		}
	} */
	?>
    <tr valign="baseline">
      <td width="100">Code of Category</td>
      <td width="20">&nbsp;</td>
      <td><input type="text" name="mcatg_code" value="<?php echo $kd; ?>" size="3"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Category Name</td>
      <td nowrap="nowrap">:</td>
      <td><input type="text" name="mcatg_descr" value="" size="50" /></td>
    </tr>
    <tr valign="middle">
      <td nowrap="nowrap">Notes</td>
      <td nowrap="nowrap">:</td>
      <td><textarea name="catg_notes" id="catg_notes" cols="40" rows="3"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsmcatg);
?>
