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
	include "../dateformat_funct.php";
	if ($_POST['nama_fileps'] == '') {
		$nfile = $_POST['nama_fileps2'];
	} else {
		$nfile = $_POST['nama_fileps'];
	}
	/* echo "<script>alert(\"$nfile\");</script>"; */

  $updateSQL = sprintf("UPDATE dms SET inisial_pekerjaan=%s, `date`=%s, fileupload=%s, keterangan=%s WHERE id=%s",
                       GetSQLValueString($_POST['inisial_pekerjaan'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal']), "text"),
					   GetSQLValueString($nfile, "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
  echo "<script>
  	alert(\"MOM has been changed\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM dms WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit MOM</title>
</head>

<body>
<?php { include "../date.php"; include "uploads.php"; include "../dateformat_funct.php"; }?>
  <table width="414" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td colspan="2"><input type="hidden" name="idmsps" id="idmsps" value="<?php echo $row_Recordset1['idms']; ?>" /></td>
    </tr>
    <tr>
      <td width="94">Attachment File </td>
      <td width="307" class="contenthdr"><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
        <input name="fileps" type="file" style="cursor:pointer;" />
        <input type="submit" name="submit" value="Upload" />
      </form></td>
    </tr>
  </table>
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <table width="412" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="95">Date</td>
        <td width="307" class="contenthdr"><input name="tanggal" type="text" id="tanggal8" value="<?php echo functddmmmyyyy($row_Recordset1['date']); ?>" />
        <input type="hidden" name="id" id="id" value="<?php echo $row_Recordset1['id'] ?>"/>
        </td>
      </tr>
      <tr>
        <td>Title</td>
        <td class="contenthdr"><textarea cols="20" rows="2" name="title"><?php echo $row_Recordset1['keterangan']; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><span class="contenthdr">
          <input name="inisial_pekerjaan" type="hidden" id="inisial_pekerjaan" value="<?php echo $row_Recordset1['inisial_pekerjaan']; ?>" />
        </span>          <input type="submit" name="submit5" id="submit" value="Submit" /></td>
      </tr>
    </table>
    <p>
      <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file; ?>" />
      <input name="nama_fileps2" type="hidden" id="nama_fileps2" value="<?php echo $row_Recordset1['fileupload']; ?>" />
      <input name="dateas" type="hidden" id="dateas" value="<?php echo $tanggal; ?>"/>
    </p>
    <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>