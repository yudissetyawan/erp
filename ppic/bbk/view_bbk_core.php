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

$colname_p_btb_header = "-1";
if (isset($_GET['data'])) {
  $colname_p_btb_header = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_p_btb_header = sprintf("SELECT * FROM p_btb_header WHERE id = %s", GetSQLValueString($colname_p_btb_header, "int"));
$p_btb_header = mysql_query($query_p_btb_header, $core) or die(mysql_error());
$row_p_btb_header = mysql_fetch_assoc($p_btb_header);

$colname_p_bbk_header = "-1";
if (isset($_GET['data'])) {
  $colname_p_bbk_header = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_p_bbk_header = sprintf("SELECT p_bbk_header.*, p_bpb_header.bpb_no FROM p_bbk_header, p_bpb_header WHERE p_bbk_header.id = %s  AND p_bpb_header.id=p_bbk_header.id_bpb", GetSQLValueString($colname_p_bbk_header, "int"));
$p_bbk_header = mysql_query($query_p_bbk_header, $core) or die(mysql_error());
$row_p_bbk_header = mysql_fetch_assoc($p_bbk_header);
$totalRows_p_bbk_header = mysql_num_rows($p_bbk_header);

$colname_diketahui = "-1";
if (isset($_GET['data'])) {
  $colname_diketahui = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_diketahui = sprintf("SELECT p_bbk_header.id, p_bbk_header.diketahui_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_bbk_header, h_employee WHERE p_bbk_header.id = %s  AND h_employee.id =p_bbk_header.diketahui_by", GetSQLValueString($colname_diketahui, "int"));
$diketahui = mysql_query($query_diketahui, $core) or die(mysql_error());
$row_diketahui = mysql_fetch_assoc($diketahui);
$totalRows_diketahui = mysql_num_rows($diketahui);

$colname_diserahkan = "-1";
if (isset($_GET['data'])) {
  $colname_diserahkan = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_diserahkan = sprintf("SELECT p_bbk_header.id, p_bbk_header.diserahkan_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_bbk_header, h_employee WHERE p_bbk_header.id = %s  AND h_employee.id =p_bbk_header.diserahkan_by", GetSQLValueString($colname_diserahkan, "int"));
$diserahkan = mysql_query($query_diserahkan, $core) or die(mysql_error());
$row_diserahkan = mysql_fetch_assoc($diserahkan);
$totalRows_diserahkan = mysql_num_rows($diserahkan);

$colname_diterima = "-1";
if (isset($_GET['data'])) {
  $colname_diterima = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_diterima = sprintf("SELECT p_bbk_header.id, p_bbk_header.diterima_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_bbk_header, h_employee WHERE p_bbk_header.id = %s  AND h_employee.id =p_bbk_header.diterima_by", GetSQLValueString($colname_diterima, "int"));
$diterima = mysql_query($query_diterima, $core) or die(mysql_error());
$row_diterima = mysql_fetch_assoc($diterima);
$totalRows_diterima = mysql_num_rows($diterima);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Return Goods (BBK)</title>
<link href="../../css/layoutforprint.css" rel="stylesheet" type="text/css" />
<link href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>Bukti Terima Barang</title><link rel="stylesheet" type="text/css" href="../../css/print.css" /><link rel="stylesheet" type="text/css" href="../../css/layoutforprint.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../../css/print.css" /><link rel="stylesheet" type="text/css" href="../../css/layoutforprint.css" /></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>
</head>

<body id="printarea">
<p class="btn"><a href="../bbk/input_bbk_core.php?data=<?php echo $_GET['data']; ?>" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item to BBK</a></p>
<table width="734" border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td><table width="722" border="0" cellpadding="5">
      <tr>
        <td width="83"><img src="/images/bukaka.jpg" alt="" width="102" height="24" /></td>
        <td colspan="4" align="center"><strong><font size="+1">BON BARANG KEMBALI</font></strong></td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>No. BPB</td>
        <td>:</td>
        <td width="263"><?php echo $row_p_bbk_header['bpb_no']; ?></td>
        <td width="83">No. BBK</td>
        <td width="3">:</td>
        <td width="163"><?php echo $row_p_bbk_header['no_bbk']; ?></td>
        </tr>
      <tr>
        <?php require_once "../../dateformat_funct.php"; ?>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php echo functddmmmyyyy($row_p_bbk_header['tanggal']); ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><iframe width="730" height="329" style="border:none" src="view_bbk_isi.php?data=<?php echo $_GET ['data']; ?>"></iframe></td>
  </tr>
  <tr>
    <td>
    <table width="730">
      <tr style="border-left:none">
        <td width="39" rowspan="2">Asli<br />Merah</td>
        <td width="5" rowspan="2">:<br />:</td>
        <td width="150" rowspan="2">Inventory / Gudang<br />Pemakai</td>
        <td width="120"><p>Diketahui Oleh : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="120"><p>Diserahkan Oleh : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="120"><p>Diterima Oleh : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
      <tr>
        <td><?php echo $row_diketahui['firstname']; ?> <?php echo $row_diketahui['midlename']; ?> <?php echo $row_diketahui['lastname']; ?></td>
        <td><?php echo $row_diserahkan['firstname']; ?> <?php echo $row_diserahkan['midlename']; ?> <?php echo $row_diserahkan['lastname']; ?></td>
        <td><?php echo $row_diterima['firstname']; ?> <?php echo $row_diterima['midlename']; ?> <?php echo $row_diterima['lastname']; ?></td>
        </tr>
    </table></td>
  </tr>
  </table>
<table>
  <tr>
    <td><img src="/images/icon_print.gif" alt="" width="25" height="25" class="btn" onclick="PrintDoc()" /></td>
    <td><img src="/images/icon_printpw.gif" alt="" width="24" height="25" class="btn" onclick="PrintPreview()"/></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($p_bbk_header);

mysql_free_result($diketahui);

mysql_free_result($diserahkan);

mysql_free_result($diterima);
?>
