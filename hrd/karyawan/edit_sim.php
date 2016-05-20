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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form9")) {
	{ require_once "../../dateformat_funct.php"; }
	
  $updateSQL = sprintf("UPDATE h_sim SET sim_gol=%s, masaberlaku=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['sim_gol'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['masa_berlaku]']), "text"),
                       GetSQLValueString($_POST['idsim'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_sim WHERE id = %s", GetSQLValueString($colname_Recordset8, "int"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Driving License</title>
</head>

<body>
<?php { require_once "../../dateformat_funct.php"; } ?>
<form action="<?php echo $editFormAction; ?>" id="form9" name="form9" method="POST">
  <table width="375" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General"><input name="idsim" type="text" class="hidentext" id="idsim" value="<?php echo $row_Recordset8['id_datapribadi']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td width="100" class="General">Golongan SIM</td>
      <td width="10" class="General">:</td>
      <td class="General"><input name="sim_gol" type="text" id="sim_gol" value="<?php echo $row_Recordset8['sim_gol']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Masa Berlaku</td>
      <td class="General">:</td>
      <td class="General"><label for="masa_berlaku]"></label>
        <input name="masa_berlaku]" type="text" id="tanggal8" value="<?php echo functddmmmyyyy($row_Recordset8['masaberlaku']); ?>" /> <i>(dd mmm yyyy)</i></td>
    </tr>
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="General">&nbsp;</td>
      <td class="General"><input type="submit" name="submit7" id="submit6" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form9" />
</form>

</body>
</html>
<?php
	mysql_free_result($Recordset8);
?>