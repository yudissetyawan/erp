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
$query_Recordset1 = sprintf("SELECT pr_progress_core_scopework.*, pr_progress_header.productioncode FROM pr_progress_core_scopework, pr_progress_header WHERE pr_progress_core_scopework.id_progress_header = %s AND pr_progress_header.id = pr_progress_core_scopework.id_progress_header", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT pr_progress_core_scopework.*, a_production_code.productioncode FROM pr_progress_core_scopework, a_production_code WHERE pr_progress_core_scopework.id_progress_header = %s AND a_production_code.id = pr_progress_core_scopework.id_progress_header", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Progress Scope of Work</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<table width="1081" border="0">
  <tr class="tabel_header">
    <td width="35" rowspan="2" >No.</td>
    <td width="128" rowspan="2" >Production Code</td>
    <td colspan="22" >Progress</td>
  </tr>
  <tr class="tabel_header">
    <td colspan="2" class="tabel_header">QLY</td>
    <td colspan="2" class="tabel_header">HSE</td>
    <td colspan="2" class="tabel_header">ENG</td>
    <td colspan="2" class="tabel_header">PRC</td>
    <td colspan="2" class="tabel_header">PPIC</td>
    <td colspan="2" class="tabel_header">FAB</td>
    <td colspan="2" class="tabel_header">HRD</td>
    <td colspan="2" class="tabel_header">FIN</td>
    <td colspan="2" class="tabel_header">MTN</td>
    <td colspan="2" class="tabel_header">IT</td>
    <td colspan="2" class="tabel_header">PRJ</td>
  </tr>
  
    <?php do { ?>
      <tr class="tabel_number">
        <?php $n=$n+1; ?>
        <td align='center'><?php echo $n ; ?></td>
        <td><?php echo $row_Recordset1['productioncode']; ?></td>
        <td width="50"><?php echo $row_Recordset1[progress_qly].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../qly/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_qly']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_hse].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../hse/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_hse']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_eng].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../eng/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_prc].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../proc/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_ppic].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../ppic/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_fab].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../fab/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_hrd].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../hrd/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="45"><?php echo $row_Recordset1[progress_fin].' % '; ?></td>
        <td width="29"><a href="#" onclick="MM_openBrWindow('../fin/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_mtn].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../mtn/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="44"><?php echo $row_Recordset1[progress_it].' % '; ?></td>
        <td width="30"><a href="#" onclick="MM_openBrWindow('../it/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
        <td width="43"><?php echo $row_Recordset1[progress_prj].' % '; ?></td>
        <td width="31"><a href="#" onclick="MM_openBrWindow('../prj/hasil_kerja.php?data=<?php echo $row_Recordset1['idms_eng']; ?>','','scrollbars=yes,resizable=yes,width=1000,height=600')">File</a></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
