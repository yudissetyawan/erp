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
  $insertSQL = sprintf("INSERT INTO m_master_subcatg (msubcatg_code, msubcatg_descr, id_mcatg, subcatg_notes) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['msubcatg_code'], "text"),
                       GetSQLValueString($_POST['msubcatg_descr'], "text"),
                       GetSQLValueString($_POST['id_mcatg'], "int"),
                       GetSQLValueString($_POST['subcatg_notes'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "view_master_subcatg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$mcatgcode = $_GET['data2'];

mysql_select_db($database_core, $core);
$query_rscatg = "SELECT id_mcatg, mcatg_code, mcatg_descr FROM m_master_catg";
$rscatg = mysql_query($query_rscatg, $core) or die(mysql_error());
$row_rscatg = mysql_fetch_assoc($rscatg);
$totalRows_rscatg = mysql_num_rows($rscatg);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Subcategory</title>
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

<body class="General" onLoad="document.form1.msubcatg_descr.focus();">
<b>Entry Subcategory of Items</b>
<br><br>

<?php
	$query = "SELECT MAX(msubcatg_code) AS maxKode FROM m_master_subcatg WHERE msubcatg_code LIKE '%$mcatgcode%'";
	$hasil = mysql_query($query);
	$data  = mysql_fetch_array($hasil);
	$kodeKata = $data['maxKode'];			
		$noUrut = (int) substr($kodeKata, 2, 2);			
			$noUrut++;			
				$char = $_GET['data2'];
				$newID = $char . sprintf("%02s", $noUrut);
?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="520">
    <tr valign="baseline">
      <td width="210">Code of Subcategory</td>
      <td width="10">:</td>
      <td width="300"><input type="text" name="msubcatg_code" value="<?php echo $newID; ?>" size="10" readonly="readonly" />
      	<input name="id_mcatg" type="hidden" value="<?php echo $_GET['data']; ?>" />
        </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Subcategory</td>
      <td nowrap="nowrap">:</td>
      <td><input type="text" name="msubcatg_descr" value="" size="50" /></td>
    </tr>
    <tr valign="middle">
      <td nowrap="nowrap">Notes</td>
      <td nowrap="nowrap">:</td>
      <td><textarea name="subcatg_notes" cols="40"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">&nbsp;</td>
      <td nowrap="nowrap">&nbsp;</td>
      <td><input type="submit" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rscatg);
?>
