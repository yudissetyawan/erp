<?php require_once('../Connections/core.php'); ?>
<?php
// content="text/plain; charset=utf-8"
include "../../jpgraph/src/jpgraph.php";
include "../../jpgraph/src/jpgraph_pie.php";
include "../../jpgraph/src/jpgraph_pie3d.php";
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
$query_Recordset2 = sprintf("SELECT * FROM pr_wpr_activities WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM pr_major_activities WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM pr_wpr_issue WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM pr_wpr_milestone WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM pr_wpr_summary WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset6, "int"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM pr_wpr_tanggal WHERE id_headerwpr = %s ORDER BY cumm_actual DESC", GetSQLValueString($colname_Recordset7, "int"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM pr_wpr_tanggal WHERE id_headerwpr = %s ORDER BY cumm_actual DESC", GetSQLValueString($colname_Recordset8, "int"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM c_total_ctr WHERE id_ctr = %s", GetSQLValueString($colname_Recordset9, "int"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_Recordset10 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset10 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset10 = sprintf("SELECT * FROM pr_weightfactor WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset10, "int"));
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT * FROM pr_wpr_comulative WHERE id_headerwpr = %s", GetSQLValueString($colname_Recordset11, "text"));
$Recordset11 = mysql_query($query_Recordset11, $core) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project - Weekly Progress Report</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.glossymenu {margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: 1px solid #9A9A9A;
	border-bottom-width: 0;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
.glossymenu {	margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: thin solid #000;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	line-height: normal;
	color: #000;    
}
-->
</style>
.textarea {
 resize:none;
}
</head>

<body>
<table width="1728" height="512" border="1">
  <tr>
    <td width="67" align="center"><img src="../images/chevron.jpg" alt="" width="58" height="42" /></td>
    <td width="102" align="center"><img src="../images/bukaka.jpg" alt="" width="89" height="24" /></td>
    <td width="486" bgcolor="#2F75B5"><font color="#FFFFFF" size="2">WEEKLY PROGRESS REPORT</font><p><font color="#FFFFFF"><?php echo $row_Recordset1['description']; ?></font></p>
    <p><font color="#FFFFFF"><?php echo $row_Recordset1['cutofdate']; ?></font></p></td>
    <td width="128" bgcolor="#006600">&nbsp;</td>
    <td width="131" bgcolor="#FFFF00">&nbsp;</td>
    <td width="135" bgcolor="#6699FF">&nbsp;</td>
    <td width="208" bgcolor="#FFCC33">&nbsp;</td>
    <td width="146" bgcolor="#99CCFF">&nbsp;</td>
    <td width="146" bgcolor="#FF0000">&nbsp;</td>
    <td width="115" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="215" colspan="3"><table width="680" height="230" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td class="sizewpr">Project Title</td>
        <td colspan="3" class="contenthdr" ><?php echo $row_Recordset1['project_title']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Description</td>
        <td colspan="3" class="contenthdr"><?php echo $row_Recordset1['description']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Contract No.</td>
        <td colspan="3" class="contenthdr"><?php echo $row_Recordset1['contract_no']; ?></td>
      </tr>
      <tr>
        <td width="115" class="sizewpr">WO/CTR No.</td>
        <td width="144" class="contenthdr" ><?php echo $row_Recordset1['wo_no']; ?></td>
        <td width="98" class="sizewpr">CTR Approval</td>
        <td width="139"  class="contenthdr"><?php echo $row_Recordset1['ctr_approval']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">AFE/CC No.</td>
        <td  class="contenthdr"><?php echo $row_Recordset1['aff_no']; ?></td>
        <td class="sizewpr">Type of Work</td>
        <td  class="contenthdr"><?php echo $row_Recordset1['type_ofwork']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Construction Eng.</td>
        <td  class="contenthdr"><?php echo $row_Recordset1['const_eng']; ?></td>
        <td class="sizewpr">CTR Req'd</td>
        <td  class="contenthdr">USD <font color="#FF0000"><?php echo '$ ' . number_format( $row_Recordset9['total_wovalue'],2); ?></font></td>
      </tr>
      <tr>
        <td height="36" class="sizewpr">Contractor PIC Name</td>
        <td colspan="3" class="contenthdr"><?php echo $row_Recordset1['pic_name']; ?></td>
      </tr>
    </table></td>
    <td colspan="3"><table height="230" border="0" cellspacing="2">
      <tr class="headerwpr" >
        <td colspan="3" align="center" valign="middle"><strong>ENGINEERING, CONSTRUCTION, PROCUREMENT &amp; INSTALATION</strong></td>
      </tr>
      <tr>
        <td width="100" class="headerwpr" height="20" ><strong>Activities</strong></td>
        <td width="146" class="headerwpr" ><strong> Planned Date</strong></td>
        <td width="153" class="headerwpr" ><strong> Actual Date</strong></td>
      </tr>
      <tr class="contenthdr">
        <td height="40" class="sizewpr">Engineering </td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[eng_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[eng_actual]; ?></td>
      </tr>
      <tr class="contenthdr">
        <td height="40" class="sizewpr">Procurement</td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[proc_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[proc_actual]; ?></td>
      </tr>
      <tr class="contenthdr">
        <td height="40" class="sizewpr">Fabrication</td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[fab_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[fab_actual]; ?></td>
      </tr>
      <tr class="contenthdr">
        <td height="40" class="sizewpr"> Instalation</td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[inst_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset2[inst_actual]; ?></td>
      </tr>
    </table></td>
    <td colspan="5"><table border="0" height="230" cellspacing="2">
      <tr>
        <td colspan="2" class="tabel_header">EPC ACTIVITIES</td>
      </tr>
      <tr class="tabel_header">
        <td height="20" colspan="2" class="tabel_header"> EPC ACTIVITIES - Major Activities /Accomplishment - This Period</td>
      </tr>
      <tr class="contenthdr">
        <td width="104" height="40" class="sizewpr">Engineering</td>
        <td width="520" class="contenthdr"><textarea name="eng_thisweek" cols="75" rows="2" class="textarea" maxlength="174" style="border:thin"><?php echo $row_Recordset3['eng_thisweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr" height="40">Procurement</td>
        <td class="contenthdr"><textarea name="proc_thisweek" id="proc_thisweek" cols="75" rows="2"  maxlength="174" style="border:thin" class="textarea"><?php echo $row_Recordset3['proc_thisweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr" height="40">Fabrication</td>
        <td class="contenthdr"><textarea name="fab_thisweek" id="fab_thisweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['fab_thisweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr" height="40">Installation</td>
        <td class="contenthdr"><textarea name="inst_thisweek" id="inst_thisweek" cols="75" rows="2"  style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['inst_thisweek']; ?></textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6" height="200"><table height="199" border="0" cellpadding="1" cellspacing="0">
      <tr class="tabel_header">
        <td height="13" colspan="2">MAJOR ISSUE, AREA CONCERN OR BOTTLENECKS </td>
      </tr>
      <tr class="tabel_header">
        <td width="554" height="13" class="tabel_header">Description</td>
        <td width="574"  height="13"  class="tabel_header">Action Plan</td>
      </tr>
      <tr valign="top">
        <?php $o=$o+1; ?>
        <td class="contenthdr"><textarea name="description" cols="65" rows="10" class="textarea" style="border:thin"id="description"><?php echo $row_Recordset4['description']; ?></textarea></td>
        <td class="contenthdr">
          <textarea name="action_plan" cols="65" rows="10" class="textarea" id="action_plan" style="border:thin"><?php echo $row_Recordset4['action_plan']; ?></textarea></td>
       </tr>
    </table></td>
    <td colspan="5"><table border="0" cellspacing="2">
      <tr class="tabel_header">
        <td colspan="2" class=""> EPC ACTIVITIES - Major Activities /Accomplishment - Next Period</td>
      </tr>
      <tr class="">
        <td width="104" height="40" class="sizewpr">Engineering</td>
        <td width="520" class="contenthdr">
          <textarea name="eng_nextweek" id="eng_nextweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['eng_nextweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td height="40" class="sizewpr">Procurement</td>
        <td class="contenthdr"><textarea name="proc_nextweek" id="proc_nextweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['proc_nextweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr">Fabrication</td>
        <td height="40" class="contenthdr">
          <textarea name="fab_nextweek" id="fab_nextweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['fab_nextweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td height="40" class="sizewpr">Installation</td>
        <td class="contenthdr"> <textarea name="inst_nextweek" id="inst_nextweek" style="border:thin" class="textarea" cols="75" rows="2"  maxlength="174"><?php echo $row_Recordset3['isnt_nextweek']; ?></textarea></td>
      </tr>
    </table></td>
  </tr>
</table><table width="1734"  height="638" border="1">
  <tr>
    <td width="566" height="82"><table border="0" width="620" cellpadding="2" cellspacing="2">
      <tr>
        <td>&nbsp;</td>
        <td width="76">&nbsp;</td>
        <td width="363" class="headerwpr">MILESTONE</td>
        </tr>
      <tr class="">
        <td width="108" class="sizewpr">Procurement Complete</td>
        <td colspan="2" class="contenthdr"><textarea class="textarea" style="border:thin" name="proc_complete" id="proc_complete" cols="60" rows="2" maxlength="174"><?php echo $row_Recordset5['proc_complete']; ?>          </textarea></td>
      </tr>
      <tr class="" >
        <td class="sizewpr">Fabrication Complete</td>
        <td colspan="2" class="contenthdr"><textarea name="fab_complete" id="fab_complete" cols="60" rows="2" class="textarea" style="border:thin" maxlength="174"><?php echo $row_Recordset5['fab_complete']; ?></textarea></td>
      </tr>
      <tr class="" >
        <?php $o=$o+1; ?>
        <td class="sizewpr">Instalation Complete</td>
        <td colspan="2" class="contenthdr">
          <textarea name="inst_complete" class="textarea" style="border:thin" id="inst_complete" cols="60" rows="2" maxlength="174"><?php echo $row_Recordset5['inst_complete']; ?></textarea></td>
      </tr>
    </table></td>
    <td width="331" rowspan="2"><table width="377" height="450" border="0" cellpadding="2">
      <tr>
        <td colspan="3" bgcolor="#F8CBAD" align="center"><h3>SUMMARY</h3></td>
      </tr>
      <tr>
        <td width="140" class="sizewpr">Start Date</td>
        <td width="130" class="contenthdr"><?php echo $row_Recordset6['startdate']; ?></td>
        <td width="58" class="contenthdr">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Finish Date</td>
        <td class="contenthdr"><?php echo $row_Recordset6['finishdate']; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#A9D08E">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Forecast Completion</td>
        <td class="contenthdr"><?php echo $row_Recordset6['forecast_comp']; ?></td>
        <td  class="contenthdr">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">On Schedule</td>
        <td class="contenthdr"><?php echo $row_Recordset6['onschedule']; ?></td>
        <td align="center" class="contenthdr">days</td>
      </tr>
      <tr>
        <td class="sizewpr">Planned Duration</td>
        <td class="contenthdr"><?php echo $row_Recordset6['planned_duration']; ?></td>
        <td align="center" class="contenthdr">days</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#A9D08E">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Time Elapsed</td>
        <td class="contenthdr"><?php echo $row_Recordset6['time_elapsed']; ?></td>
        <td align="center" class="contenthdr">days</td>
      </tr>
      <tr>
        <td class="sizewpr">Time Remaining</td>
        <td class="contenthdr"><?php echo $row_Recordset6['time_remaining']; ?></td>
        <td align="center" class="contenthdr">days</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#A9D08E">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Cm/tv Plan Progress</td>
        <td class="contenthdr"><?php echo $row_Recordset6['cmltv_plan']; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Cm/tv Actual Progress</td>
        <td class="contenthdr"><?php echo $row_Recordset6['cmltv_actual']; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#A9D08E">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Variance </td>
        <td class="contenthdr"><?php echo $row_Recordset6['variance']; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Incr. Actual</td>
        <td class="contenthdr"><?php echo $row_Recordset6['incr_actual']; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr">Est. Complete</td>
        <td class="contenthdr"><?php echo $row_Recordset6['est_complete']; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
    </table></td>
    <td width="860" rowspan="3"><iframe frameborder="0" width="730" height="650" src="chart/line.php"></iframe></td>
  </tr>
  <tr>
    <td height="253"><table width="620" height="266" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="tabel_header">EPC Weight Achievement</td>
        </tr>
      <tr class="tabel_header">
        <td width="104" class="tabel_header">Activities</td>
        <td width="79" class="tabel_header">Weight</td>
        <td width="77" class="tabel_header">Planned</td>
        <td width="68" class="tabel_header">Actual</td>
        <td width="79" class="tabel_header">Variance</td>
        <td width="62" class="tabel_header">-------</td>
      </tr>
      <tr class="contenthdr">
        <td class="sizewpr">Engineering</td>
        <td class="contenthdr"><?php echo $row_Recordset10[wf_eng]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_plan_e1]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_actual_e1]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[var_eng]; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr" >Procurement</td>
        <td class="contenthdr" ><?php echo $row_Recordset10[wf_proc]; ?></td>
        <td class="contenthdr" ><?php echo $row_Recordset11[cumm_plan_p2]; ?></td>
        <td class="contenthdr" ><?php echo $row_Recordset11[cumm_actual_p2]; ?></td>
        <td class="contenthdr" ><?php echo $row_Recordset11[var_proc]; ?></td>
        <td class="contenthdr" >&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr class="">
        <td class="sizewpr" >Fabrication</td>
        <td class="contenthdr"><?php echo $row_Recordset10[wf_fab]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_plan_f3]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_actual_f3]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[var_fab]; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr class="">
        <td class="sizewpr">Installation</td>
        <td class="contenthdr"><?php echo $row_Recordset10[wf_instalation]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_plan_i4]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_actual_i4]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[var_inst]; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <td class="sizewpr" >Miscellanous</td>
        <td class="contenthdr"><?php echo $row_Recordset10[wf_miscellanous]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_plan_m5]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[cumm_actual_m5]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[var_misc]; ?></td>
        <td class="contenthdr">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <td class="tabel_header">Total Progress</td>
        <td class="contenthdr" ><?php echo $row_Recordset11[tot_weight]; ?></td>
        <td class="contenthdr" ><?php echo $row_Recordset11[tot_plan]; ?></td>
        <td class="contenthdr"><?php echo $row_Recordset11[tot_act]; ?></td>
        <td class="contenthdr" ><?php echo $row_Recordset11[tot_variance]; ?></td>
        <td class="contenthdr" >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><iframe frameborder="0" width="470" height="230" src="chart/pie.php?data=1"></iframe>      <iframe frameborder="0"  width="400" height="230" src="chart/pie_summary.php?data=1"> </iframe></td>
  </tr>
</table>
</p>
</body>

</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);

mysql_free_result($Recordset9);

mysql_free_result($Recordset10);

mysql_free_result($Recordset11);
?>
