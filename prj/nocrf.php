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
$query_Recordset1 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$date=date(my);
$cari=$row_Recordset1['projectcode'];

 // cari panjang max dari string yg di dapat dari query
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM a_crf WHERE projectcode LIKE '%$cari%' ORDER BY nocrf DESC LIMIT 1"));
$cekQ=$ceknomor[nocrf];
$prod=$row_Recordset1['productioncode'];

#menghilangkan huruf
$awalQ=substr($cekQ,0,3);
echo $awalQ;
#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextcrf=sprintf ("%03d", $next).'-'.$cari.'-'.$prod.'-'.$date;
?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />


<form action="" method="get">
  <input type="text" name="pracode" id="pracode"  value="<?php echo $nextcrf;?>" />
  <?php echo $row_Recordset1['projectcode']; ?>-
  <?php echo $row_Recordset1['productioncode']; ?>
</form>
<?php
mysql_free_result($Recordset1);
?>
