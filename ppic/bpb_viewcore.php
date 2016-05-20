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

$colname_rsbpbheader = "-1";
if (isset($_GET['data'])) {
  $colname_rsbpbheader = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsbpbheader = sprintf("SELECT p_bpb_header.*, h_employee.firstname AS reqfname, h_employee.midlename AS reqmname, h_employee.lastname AS reqlname FROM p_bpb_header, h_employee WHERE h_employee.id = p_bpb_header.request_by AND p_bpb_header.id = %s", GetSQLValueString($colname_rsbpbheader, "int"));
$rsbpbheader = mysql_query($query_rsbpbheader, $core) or die(mysql_error());
$row_rsbpbheader = mysql_fetch_assoc($rsbpbheader);
$totalRows_rsbpbheader = mysql_num_rows($rsbpbheader);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Room Requisition (BPB)</title>
<link href="../css/layoutforprint.css" rel="stylesheet" type="text/css" />
<link href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>Bon Pemakaian Barang</title><link rel="stylesheet" type="text/css" href="../css/print.css" /><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../css/print.css" /><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css" /></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>
</head>

<body id="printarea">
<p class="btn"><a href="bpb_inputcore.php?data=<?php echo $_GET['data']; ?>" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item to BPB</a></p>
<table width="734" border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td><table width="733" border="0" cellpadding="5">
      <tr>
        <td width="150"><img src="/images/bukaka.jpg" alt="" width="102" height="24" /></td>
        <td colspan="4" align="center"><strong><font size="+1">BON PEMAKAIAN BARANG</font></strong></td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="6">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="83">BPB No.</td>
        <td width="3">:</td>
        <td width="163"><?php echo $row_rsbpbheader['bpb_no']; ?></td>
        </tr>
      <tr>
        <td>WO No. / SPK</td>
        <td>:</td>
        <td><?php echo $row_rsbpbheader['wo_number_or_spk']; ?></td>
        <?php { include "../dateformat_funct.php"; } ?>
        <td>Date</td>
        <td>:</td>
        <td><?php echo functddmmmyyyy($row_rsbpbheader['bpb_date']); ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><iframe width="733" height="329" style="border:none" src="bpb_viewcore_isi.php?data=<?php echo $_GET ['data']; ?>"></iframe></td>
  </tr>
  <tr>
    <td>
    <table width="733">
      <tr style="border-left:none">
        <td width="30" rowspan="2">Ori<br />Red<br /></td>
        <td width="4" rowspan="2">:<br />:</td>
        <td width="380" rowspan="2">Warehouse<br />User<br /></td>
        <td width="170"><p>Requested by :</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="170"><p>Approved by :</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
      <tr>
        <td><?php echo $row_rsbpbheader['reqfname']; ?> <?php echo $row_rsbpbheader['reqmname']; ?> <?php echo $row_rsbpbheader['reqlname']; ?></td>
        <td>
          <?php
			$approvedby = $row_rsbpbheader['approved_by'];
			mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, p_bpb_header WHERE h_employee.id = p_bpb_header.approved_by AND p_bpb_header.approved_by = '$approvedby'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

echo $row_rsapprovedby['firstname']; ?> <?php echo $row_rsapprovedby['midlename']; ?> <?php echo $row_rsapprovedby['lastname']; ?>
        </td>
        </tr>
    </table>
    </td>
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
	mysql_free_result($rsbpbheader);
	mysql_free_result($rsapprovedby);
?>