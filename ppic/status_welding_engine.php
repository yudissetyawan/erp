<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM p_statusengine WHERE engineactiveYN = '1'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$vusr = $row_Recordset1['issued_user'];
mysql_select_db($database_core, $core);
$query_rsusr = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vusr'";
$rsusr = mysql_query($query_rsusr, $core) or die(mysql_error());
$row_rsusr = mysql_fetch_assoc($rsusr);
$totalRows_rsusr = mysql_num_rows($rsusr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Status Welding Engine</title>
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />

		<script src="/js/jquery.min.js"></script>
        <script src="/js/jquery.fixedheadertable.js"></script>
		
<script type="text/javascript">
$('celebs').fixedHeaderTable({
	altClass: 'odd',
	footer: true,
	cloneHeadToFoot: true,
	fixedColumn: 3,
});
</script>


<link href="/css/960.css" rel="stylesheet" type="text/css" />
<link href="/css/myTheme.css" rel="stylesheet" type="text/css" />
<link href="/css/defaultTheme.css" rel="stylesheet" type="text/css" />
</head>

<body>
<br />
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'maintenance') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<p><a href="statwelding_engine_input.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Welding Engine</a></p>';
	}
?>

<!--
<button title="Left" onMouseDown="left();" onMouseUp="left(1);">&lt;&lt;</button>
<button title="Right" onMouseDown="right();" onMouseUp="right(1);">&gt;&gt;</button>
<br />
-->


<table width="1400" border="0" class="fancyTable" id="celebs" cellpadding="0" cellspacing="0">
<thead>
  <tr class="tabel_header">
    <td align="center" width="20" height="50">No.</td>
    <td align="center" width="140">Brand</td>
    <td align="center" width="50">Year of Prod.</td>
    <td align="center" width="150">Engine No.</td>
    <td align="center" width="80">Serial No.</td>
    <td align="center" width="82">SKID No.</td>
    <td align="center" width="100">Location</td>
    <td align="center" width="90">Owner</td>
    <td align="center" width="70">Condition</td>
    <td align="center" width="50">Project</td>
    <td align="center" width="70">Proj. Code</td>
    <td align="center" width="150">Notes</td>
    <td align="center" width="110">Status</td>
    <td align="center" width="80">Update</td>
    <td align="center" width="105">Issued by</td>
    <?php if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'maintenance') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<td align="center" width="90">Edit | Delete</td>';
	} ?>
  </tr>
</thead>
<tbody>  
  <?php do { ?>
    <tr class="tabel_body" onclick="this.style.fontWeight='bold';" ondblclick="this.style.fontWeight='normal';" title="Double click data for 'highlight', and one click to remove highlight"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td><?php echo $row_Recordset1[merk]; ?></td>
      <td align="center"><?php echo $row_Recordset1[thn_prod]; ?></td>
      <td><?php echo $row_Recordset1[no_mesin]; ?></td>
      <td><?php echo $row_Recordset1[serial_no]; ?></td>
      <td><?php echo $row_Recordset1[skid_no]; ?></td>
      <td align="center" <?php if ($row_Recordset1['lokasi'] == 'Workshop') { echo 'style="background-color:#0AF"'; }?>>
	  		<?php echo $row_Recordset1[lokasi]; ?>
      </td>
      <td align="center"><?php echo $row_Recordset1[owner]; ?></td>
      <td align="center" <?php if ($row_Recordset1['engine_condition'] == 'Rusak') { echo 'style="background-color:#F00"'; }?>>
			<?php echo $row_Recordset1[engine_condition]; ?>
      </td>
      <td align="center"><?php echo $row_Recordset1[project]; ?></td>
      <td align="center"><?php echo $row_Recordset1[kode_proyek]; ?></td>
      <td><?php echo $row_Recordset1[keterangan]; ?></td>
      <td align="center"><?php echo $row_Recordset1[status]; ?></td>
      <td align="center"><?php { include "../dateformat_funct.php"; } echo functddmmmyyyy($row_Recordset1[last_update]); ?></td>
      <td><?php echo $row_rsusr[fname]; ?> <?php echo $row_rsusr[mname]; ?> <?php echo $row_rsusr[lname]; ?></td>
      <?php
		if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'maintenance') || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
			<td align="center"><a href="statwelding_engine_edit.php?data=<?php echo $row_Recordset1['id']; ?>">Edit</a> | <a href="statwelding_engine_delete.php?data=<?php echo $row_Recordset1['id']; ?>" onclick="return confirm('Are you sure to delete data of Engine No. <?php echo $row_Recordset1['no_mesin']; ?> ?')">Delete</a></td>
		<?php } ?>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>