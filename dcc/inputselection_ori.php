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
  $insertSQL = sprintf("INSERT INTO d_sop (id_dept, doc_no, rev, efect_date, title) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_dept'], "int"),
                       GetSQLValueString($_POST['doc_no'], "text"),
                       GetSQLValueString($_POST['rev'], "text"),
                       GetSQLValueString($_POST['efect_date'], "date"),
                       GetSQLValueString($_POST['title'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmsps'], "text"),
                       GetSQLValueString($_POST['id_dept'], "text"),
                       GetSQLValueString($_POST['inisial_pekerjaan'], "text"),
                       GetSQLValueString($_POST['efect_date'], "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"),
                       GetSQLValueString($_POST['title'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  echo "<script>
  	alert(\"Data has been saved\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_department ORDER BY department ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM d_sop";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM d_sop ORDER BY id DESC LIMIT 1"));
$cekQ=$ceknomor[id];
#menghilangkan huruf
$awalQ=$cekQ;

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextpracode=sprintf ($next);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Selection</title>
</head>

<body>

<p align="center">
<?php {
	include "../date.php";
	include "uploadsop.php";
	}?>
 </p>
<table width="500" border="0" cellpadding="3" cellspacing="3" align="center">
  <tr>
    <td width="114">Attachment File </td>
    <td width="3">:</td>
    <td width="359" class="contenthdr"><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit" value="Upload" />
    </form></td>
  </tr>
</table>
<br />

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="500" align="center" cellpadding="3" cellspacing="3">
    <tr>
      <td   width="114">Departemen</td>
      <td   width="3">:</td>
      <td width="357"><select name="id_dept" id="id_dept">
      <option value="">-Pilih Departemen-</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['department']?></option>
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
      <td>Document No</td>
      <td>:</td>
      <td><input type="text" name="doc_no" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Revisi</td>
      <td>:</td>
      <td><input type="text" name="rev" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Efective Date</td>
      <td>:</td>
      <td><input type="text" name="efect_date" id="tanggal1" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Title</td>
      <td>:</td>
      <td><textarea name="title" id="title" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>Jenis</td>
      <td>:</td>
      <td><select name="inisial_pekerjaan" id="inisial_pekerjaan">
        <option value="WI">Work Instruction</option>
        <option value="SOP">Standard Operating System</option>
        <option value="form">FORM</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" align="right">
        <input type="submit" value="Submit" />
      </td>
    </tr>
  </table>
  <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
  <input type="hidden" name="idmsps" id="idmsps" value="<?php echo $nextpracode;?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset2);
?>