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
$query_p_btb_header = sprintf("SELECT p_btb_header.*, c_vendor.vendorname, c_po_header.pono FROM p_btb_header, c_po_header, c_vendor WHERE p_btb_header.id = %s AND c_po_header.vendor=c_vendor.id AND c_po_header.id = p_btb_header.id_po", GetSQLValueString($colname_p_btb_header, "int"));
$p_btb_header = mysql_query($query_p_btb_header, $core) or die(mysql_error());
$row_p_btb_header = mysql_fetch_assoc($p_btb_header);
$totalRows_p_btb_header = mysql_num_rows($p_btb_header);

$colname_p_btb_core = "-1";
if (isset($_GET['data'])) {
  $colname_p_btb_core = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_p_btb_core = sprintf("SELECT p_btb_core.*, c_po_header.mrno, m_master.item_code, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_unit.unit, m_master.id_type, p_mr_header.nomr FROM p_btb_core, p_btb_header, c_po_header, m_master, m_e_model, m_unit, p_mr_header WHERE p_btb_core.id_header = %s AND p_btb_core.id_header=p_btb_header.id AND p_btb_header.id_po=c_po_header.id AND p_btb_core.id_item=m_master.id_item AND m_master.id_mmodel=m_e_model.id_mmodel AND m_master.id_unit=m_unit.id_unit AND c_po_header.mrno=p_mr_header.id", GetSQLValueString($colname_p_btb_core, "int"));
$p_btb_core = mysql_query($query_p_btb_core, $core) or die(mysql_error());
$row_p_btb_core = mysql_fetch_assoc($p_btb_core);
$totalRows_p_btb_core = mysql_num_rows($p_btb_core);

$colname_diserahkan_by = "-1";
if (isset($_GET['data'])) {
  $colname_diserahkan_by = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_diserahkan_by = sprintf("SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.diserahkan_by FROM h_employee, p_btb_header WHERE h_employee.department = 'procurement'  AND h_employee.id=p_btb_header.diserahkan_by AND p_btb_header.id = %s", GetSQLValueString($colname_diserahkan_by, "int"));
$diserahkan_by = mysql_query($query_diserahkan_by, $core) or die(mysql_error());
$row_diserahkan_by = mysql_fetch_assoc($diserahkan_by);
$totalRows_diserahkan_by = mysql_num_rows($diserahkan_by);

mysql_select_db($database_core, $core);
$query_diterima_by = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.diterima_by FROM h_employee, p_btb_header WHERE h_employee.department = 'warehouse' AND h_employee.id = p_btb_header.diterima_by";
$diterima_by = mysql_query($query_diterima_by, $core) or die(mysql_error());
$row_diterima_by = mysql_fetch_assoc($diterima_by);
$totalRows_diterima_by = mysql_num_rows($diterima_by);

mysql_select_db($database_core, $core);
$query_diperiksa_by = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.diperiksa_by FROM h_employee, p_btb_header WHERE h_employee.userlevel = 'qly' AND h_employee.id =p_btb_header.diperiksa_by";
$diperiksa_by = mysql_query($query_diperiksa_by, $core) or die(mysql_error());
$row_diperiksa_by = mysql_fetch_assoc($diperiksa_by);
$totalRows_diperiksa_by = mysql_num_rows($diperiksa_by);

mysql_select_db($database_core, $core);
$query_accounting = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.accounting FROM h_employee, p_btb_header WHERE h_employee.department = 'finance' AND h_employee.id =p_btb_header.accounting";
$accounting = mysql_query($query_accounting, $core) or die(mysql_error());
$row_accounting = mysql_fetch_assoc($accounting);
$totalRows_accounting = mysql_num_rows($accounting);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receiving Goods (BTB)</title>
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
<?php { include "../../dateformat_funct.php"; } ?>
<p class="btn"><a href="input_btb_core.php?data=<?php echo $_GET['data']; ?>" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item to BTB</a></p>

<table width="734" border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td><table width="722" border="0" cellpadding="5">
      <tr>
        <td width="83"><img src="/images/bukaka.jpg" alt="" width="102" height="24" /></td>
        <td colspan="4" align="center"><strong><font size="+1">BUKTI TERIMA BARANG</font></strong></td>
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
        <td>No. PO</td>
        <td>:</td>
        <td width="263"><?php echo $row_p_btb_header['pono']; ?></td>
        <td width="83">No. BTB</td>
        <td width="3">:</td>
        <td width="163"><?php echo $row_p_btb_header['no_btb']; ?></td>
        </tr>
      <tr>
        <td>Supplier </td>
        <td>:</td>
        <td><?php echo $row_p_btb_header['vendorname']; ?></td>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php echo functddmmmyyyy($row_p_btb_header['tanggal']); ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><iframe width="730" height="329" style="border:none" src="view_btb_core_isi.php?data=<?php echo $_GET['data']; ?>"></iframe></td>
  </tr>
  <tr>
    <td>
    <table width="722">
      <tr style="border-left:none">
        <td width="39" rowspan="2">Putih<br />
          Merah<br />
          Kuning</td>
        <td width="5" rowspan="2">:<br />:<br />:</td>
        <td width="200" rowspan="2">Inventory / Gudang<br />Keuangan<br />Procurement</td>
        <td width="120"><p>Diserahkan Oleh : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="120"><p>Diterima Oleh : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="120"><p>Diperiksa Oleh : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="120"><p>Accounting : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </td>
      </tr>
      <tr>
        <td><?php echo $row_diserahkan_by['firstname']; ?> <?php echo $row_diserahkan_by['midlename']; ?> <?php echo $row_diserahkan_by['lastname']; ?></td>
        <td><?php echo $row_diterima_by['firstname']; ?><?php echo $row_diterima_by['midlename']; ?> <?php echo $row_diterima_by['lastname']; ?></td>
        <td><?php echo $row_diperiksa_by['firstname']; ?> <?php echo $row_diperiksa_by['midlename']; ?> <?php echo $row_diperiksa_by['lastname']; ?></td>
        <td><?php echo $row_accounting['firstname']; ?> <?php echo $row_accounting['midlename']; ?> <?php echo $row_accounting['lastname']; ?></td>
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
	mysql_free_result($diserahkan_by);
	mysql_free_result($diterima_by);
	mysql_free_result($diperiksa_by);
	mysql_free_result($accounting);
	mysql_free_result($p_btb_header);
	mysql_free_result($p_btb_core);
?>