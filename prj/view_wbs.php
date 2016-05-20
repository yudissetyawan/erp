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
$query_Recordset1 = sprintf("SELECT * FROM pr_header_wpr WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM pr_wbs_cost WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM pr_weightfactor WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM pr_wbs_cost WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project - Progress</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
		$sql=mysql_query("SELECT pr_core_ctrdata WHERE id_corectr='1'"); ?>
<table width="900" border="0" cellpadding="2" cellspacing="0">
  <tr class="General">
    <td colspan="6" class="tabel_header"><?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['project_title']; ?></td>
  </tr>
  <tr>
    <td class="sizewpr"> Description</td>
    <td class="sizewpr">:</td>
    <td colspan="4" class="contenthdr"><?php echo $row_Recordset1['description']; ?></td>
  </tr>
  <tr>
    <td width="119" class="sizewpr">Contract No.</td>
<td class="sizewpr">:</td>
   <td width="192"  class="contenthdr"><?php echo $row_Recordset1['contract_no']; ?></td>
    <td width="106" class="sizewpr">CTR Approval</td>
<td class="sizewpr">:</td>
    <td width="451"  class="contenthdr"><?php echo $row_Recordset1['ctr_approval']; ?></td>
  </tr>
  <tr>
    <td class="sizewpr">AFE/CC No.</td>
    <td class="sizewpr">:</td>
    <td  class="contenthdr"><?php echo $row_Recordset1['aff_no']; ?></td>
    <td class="sizewpr">Type of Work</td>
    <td class="sizewpr">:</td>
    <td  class="contenthdr"><?php echo $row_Recordset1['type_ofwork']; ?></td>
  </tr>
  <tr>
    <td class="sizewpr">Construction Eng.</td>
    <td class="sizewpr">:</td>
    <td  class="contenthdr"><?php echo $row_Recordset1['const_eng']; ?></td>
    <td  class="sizewpr">CTR Req'd</td>
    <td class="sizewpr">:</td>
    <td  class="contenthdr"><font color="#FF0000">USD $ <?php echo $row_Recordset4['totalcost']; ?></font></td>
  </tr>
  <tr>
    <td class="sizewpr">Contractor PIC Name</td>
    <td class="sizewpr">:</td>
    <td colspan="4"  class="contenthdr"><?php echo $row_Recordset1['pic_name']; ?></td>
  </tr>
  <tr class="tabel_header">
    <td colspan="6"><a href="#" onclick="history.back(-1)">&lt;== BACK</a> ||<a href="input_wbs.php?data=<?php echo $row_Recordset1['id']; ?>"> Calculate Weight Factor</a></td>
  </tr>
  <tr>
    <td colspan="6" class="General"><table width="895" border="0" cellpadding="2" cellspacing="1">
      <tr class="tabel_header">
        <td width="29">No.</td>
        <td width="266">Description</td>
        <td width="95">Unit</td>
        <td width="72">Qty</td>
        <td width="145">Budget Cost (USD)</td>
        <td width="147">Weight Factor</td>
        <td width="105">&nbsp;</td>
        </tr>
      <tr class="header_description">
        <td class="header_description">I.</td>
        <td class="header_description">Engineering</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description"><?php echo number_format ($row_Recordset2[engineering],2); ?></td>
        <td class="header_description"><?php echo number_format ($row_Recordset3['wf_eng'],2); ?> %</td>
        <td class="header_description"></td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">I.A.</td>
        <td class="tabel_body">Engineering Services</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[eng_services],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_eng_services'],2); ?> %</td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
       
        <td class="tabel_body">I.B.</td>
        <td class="tabel_body">Project Services</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[proj_services],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_proj_services'],2); ?> %</td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
<tr>
        <td colspan="7" class="tabel_index">&nbsp;</td>
      </tr>
      <tr class="header_description">
        <td class="header_description">II.</td>
        <td class="header_description">Procurement</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description"><?php echo number_format ($row_Recordset2[procurement],2); ?></td>
        <td class="header_description"><?php echo number_format ($row_Recordset3['wf_proc'],2); ?> %</td>
        <td class="header_description">&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td>II.A.</td>
        <td>Material For Civil &amp; Structure</td>
        <td align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[material_civ_structure],2); ?></td>
        <td><?php echo number_format ($row_Recordset3['wf_civ_structure'],2); ?> %</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="number_mkt">II.B.</td>
        <td class="number_mkt">Material For Piping</td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[material_piping],2); ?></td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset3['wf_piping'],2); ?> %</td>
        <td class="number_mkt">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
       
        <td>II.C.</td>
        <td>Material For Electrical &amp; Instrument</td>
        <td align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[material_electrical_inst],2); ?></td>
        <td><?php echo number_format ($row_Recordset3['wf_electrical_inst'],2); ?> % </td>
        <td>&nbsp;</td>
      </tr>
<tr>
  <td colspan="7" class="tabel_index">&nbsp;</td>
    </tr>
      <tr class="header_description">
        <td class="header_description">III.</td>
        <td class="header_description">Fabrication</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description"><?php echo number_format ($row_Recordset2[fabrication],2); ?></td>
        <td class="header_description"><?php echo number_format ($row_Recordset3['wf_fab'],2); ?> %</td>
        <td class="header_description">&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">III.A.</td>
        <td class="tabel_body">Fabrication Activities</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[fab_activities],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_fab_activities'],2); ?> %</td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">III.B.</td>
        <td class="tabel_body">Painting &amp; Sand Blasting Activities</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[painting_sandblastactivities],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_painting_sandblastactivities'],2); ?> %</td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        
        <td class="tabel_body">III.C.</td>
        <td class="tabel_body">NDT</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[ndt],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_ndt'],2); ?> % </td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
<tr>
  <td colspan="7" class="tabel_index">&nbsp;</td>
    </tr>
      <tr class="header_description">
        <td class="header_description">IV.</td>
        <td class="header_description">Installation</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description" align="center">&nbsp;</td>
        <td class="header_description"><?php echo number_format ($row_Recordset2[instalation],2); ?></td>
        <td class="header_description"><?php echo number_format ($row_Recordset3['wf_instalation'],2); ?> %</td>
        <td class="header_description">&nbsp; </td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">IV.A.</td>
        <td class="tabel_body">Installation For Civil &amp; Structure</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[inst_civil_structure],2); ?></td>
        <td><?php echo number_format ($row_Recordset3['wf_inst_civil_structure'],2); ?> %</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">IV.B.</td>
        <td class="tabel_body">Installation for Piping</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[inst_piping],2); ?></td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset3['wf_inst_piping'],2); ?> %</td>
        <td class="number_mkt">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">IV.C.</td>
        <td class="tabel_body">Installation For Electrical &amp; Instrument</td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[inst_electric_inst],2); ?></td>
        <td><?php echo number_format ($row_Recordset3['wf_inst_electric_inst'],2); ?> %</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" class="tabel_index">&nbsp;</td>
      </tr>
      <tr class="header_description">
        <td>V.</td>
        <td>Miscellanous</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td><?php echo number_format ($row_Recordset2[miscellanous],2); ?></td>
        <td><?php echo number_format ($row_Recordset3['wf_miscellanous'],2); ?> %</td>
        <td>&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">V.A.</td>
        <td class="tabel_body">Personal Day Rate</td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[personal_dayrate],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_personal_dayrate'],2); ?> %</td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">V.B.</td>
        <td class="tabel_body">Equipment Day Rate</td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[equip_dayrate],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_equip_dayrate'],2); ?> %</td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        
        <td class="tabel_body">V.C.</td>
        <td class="tabel_body">Land Transportation</td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt">&nbsp;</td>
        <td class="number_mkt"><?php echo number_format ($row_Recordset2[land_transportation],2); ?></td>
        <td class="tabel_body"><?php echo number_format ($row_Recordset3['wf_land_transportation'],2); ?>%</td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_header">
        <td class="tabel_header">&nbsp;</td>
        <td class="tabel_header">TOTAL</td>
        <td class="tabel_header">&nbsp;</td>
        <td class="tabel_header">&nbsp;</td>
        <td class="tabel_header">$ <?php echo number_format ($row_Recordset2['totalcost'],2); ?></td>
        <td class="tabel_header"><?php echo number_format ($row_Recordset3['totalwf']); ?> %</td>
        <td class="tabel_header">&nbsp;</td>
        </tr>
      <tr>
  <?php $i=$i+1; ?>
  <td colspan="4" class="tabel_index"><strong><a href="tanggalcomulative.php?data=<?php echo $row_Recordset1['id']; ?>">Input Schedule</a></strong></td>
        <td colspan="3" class="tabel_index"><strong><a href="tanggalcomulative_actual.php?data=<?php echo $row_Recordset1['id']; ?>">Input Actual</a></strong></td>
      </tr>
  </table></td></tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset1);
?>
