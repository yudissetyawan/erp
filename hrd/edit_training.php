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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form11")) {
	require_once "../dateformat_funct.php";
  $updateSQL = sprintf("UPDATE h_training SET kategori=%s, jenis_training=%s, `date`=%s, exp_date=%s, no_certificate=%s, provider=%s, remark=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['jk'], "text"),
                       GetSQLValueString($_POST['jenis_training'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['exp_date']), "text"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['id_datapribadi2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_training WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Training</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form11" name="form11" method="POST">
            <table width="704" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td width="110" class="General"><strong>Training</strong></td>
                <td width="5">&nbsp;</td>
                <td width="263" class="General"><input name="id_datapribadi2" type="text" class="hidentext" id="id_datapribadi2" value="<?php echo $row_Recordset1['id_datapribadi']; ?>" size="5" readonly="readonly" /></td>
                <td width="99" class="General">&nbsp;</td>
                <td width="11" class="General">&nbsp;</td>
                <td width="202" class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kategori Training</td>
                <td>:</td>
                <td class="General">
                  <input type="radio" name="jk" value="1" <?php echo ($row_Recordset1['kategori']=='1')?'checked':'' ?> size="17">Management Training

<input type="radio" name="jk" value="2" <?php echo ($row_Recordset1['kategori']=='2')?'checked':'' ?> size="17">Skill Training</td>
                <td class="General">No. Sertifikat</td>
                <td>:</td>
                <td><input name="no_certificate" type="text" id="no_certificate" value="<?php echo $row_Recordset1['no_certificate']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="General"></td>
                <td class="General">Penyelenggara</td>
                <td>:</td>
                <td><input name="provider" type="text" class="huruf_besar" id="provider" value="<?php echo $row_Recordset1['provider']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Training</td>
                <td>:</td>
                <td class="General"><label>
                  <input name="jenis_training" type="text" id="jenis_training" value="<?php echo $row_Recordset1['jenis_training']; ?>" />
                </label></td>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Tanggal Training</td>
                <td>:</td>
                <td><input name="date" type="text" id="tanggal8" size="12" value="<?php echo $row_Recordset1['date']; ?>" /></td>
                <td class="General">Remark</td>
                <td>:</td>
                <td><textarea name="remark" id="remark" cols="25" rows="3"><?php echo $row_Recordset1['remark']; ?></textarea></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku</td>
                <td>:</td>
                <td><input name="exp_date" type="text" id="exp_date" size="12" value="<?php echo $row_Recordset1['exp_date']; ?>" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form11" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
