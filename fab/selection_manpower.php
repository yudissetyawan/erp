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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM f_manpower_loading_header WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: none;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style></head>

<body>
<h2 align="center">BULAN  <?php echo $row_Recordset1['month']; ?></h2>
<table width="832" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="171" rowspan="2" valign="top"><table width="166" border="0" cellspacing="0" cellpadding="0">
      <tr class="tabel_index">
        <td width="164" class="tabel_index">Kategori Pencarian</td>
        <td width="10" colspan="2" rowspan="3" class="General">&nbsp;</td>
      </tr>
      <tr>
        <td class="tabel_number"><strong><a href="?data=<?php echo $_GET['data']; ?>&amp;modul=jabatan">Jabatan</a></strong></td>
      </tr>
      <tr>
        <td class="tabel_number"><strong><a href="?data=<?php echo $_GET['data']; ?>&amp;modul=dept">Department</a></strong></td>
    
      <tr>
    </table></td>
    <td width="658" rowspan="2" valign="top"><?php
                    	if($_GET[modul]=='jabatan'){
							include "find_bagian.php";
							}
						elseif ($_GET[modul]=='dept'){
							include "find_dept.php";
							}
						else {
							echo"=-=-=-=";
							}
					?></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
