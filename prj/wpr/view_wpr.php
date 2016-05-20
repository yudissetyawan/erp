<?php require_once('../../Connections/core.php'); ?>
<?php
// content="text/plain; charset=utf-8"
include "../../../jpgraph/src/jpgraph.php";
include "../../../jpgraph/src/jpgraph_pie.php";
include "../../../jpgraph/src/jpgraph_pie3d.php";
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
$query_Recordset1 = "SELECT * FROM pr_header_wpr";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset14 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset14 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset14 = sprintf("SELECT * FROM pr_wpr_activities WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset14, "int"));
$Recordset14 = mysql_query($query_Recordset14, $core) or die(mysql_error());
$row_Recordset14 = mysql_fetch_assoc($Recordset14);
$totalRows_Recordset14 = mysql_num_rows($Recordset14);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM pr_major_activities WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM pr_wpr_issue WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM pr_wpr_milestone WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM pr_wpr_summary WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset6, "int"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_select_db($database_core, $core);
$query_Recordset7 = "SELECT * FROM pr_wpr_tanggal";
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

mysql_select_db($database_core, $core);
$query_Recordset9 = "SELECT * FROM c_total_ctr";
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

mysql_select_db($database_core, $core);
$query_Recordset10 = "SELECT * FROM pr_weightfactor";
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT * FROM pr_wpr_comulative WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset11, "int"));
$Recordset11 = mysql_query($query_Recordset11, $core) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);

$colname_Recordset12 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset12 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset12 = sprintf("SELECT pr_wpr_tanggal.id, pr_wpr_tanggal.id_headerwpr, pr_wpr_tanggal.tanggal, pr_header_wpr.id, pr_header_wpr.project_title, pr_header_wpr.description, pr_header_wpr.contract_no, pr_header_wpr.wo_no, pr_header_wpr.aff_no, pr_header_wpr.const_eng, pr_header_wpr.pic_name, pr_header_wpr.ctr_approval, pr_header_wpr.type_ofwork, pr_header_wpr.ctr_reqd, pr_header_wpr.cutofdate FROM pr_wpr_tanggal, pr_header_wpr WHERE pr_wpr_tanggal.id = %s AND pr_header_wpr.id=pr_wpr_tanggal.id_headerwpr", GetSQLValueString($colname_Recordset12, "int"));
$Recordset12 = mysql_query($query_Recordset12, $core) or die(mysql_error());
$row_Recordset12 = mysql_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysql_num_rows($Recordset12);

$colname_Recordset13 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset13 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset13 = sprintf("SELECT * FROM pr_wpr_tanggal WHERE id = %s", GetSQLValueString($colname_Recordset13, "int"));
$Recordset13 = mysql_query($query_Recordset13, $core) or die(mysql_error());
$row_Recordset13 = mysql_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysql_num_rows($Recordset13);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project - Weekly Progress Report</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>Weekly Progress Report</title><link rel="stylesheet" type="text/css" href="../../css/print.css" /><link rel="stylesheet" type="text/css" href="../../css/untuk_printmr.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../../css/print.css" media="screen"/><link rel="stylesheet" type="text/css" href="../../css/untuk_printmr.css" /></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>

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
.textarea {
 resize:none;
}

.textarea1 { resize:none;
}
</style>

</head>

<body id="printarea">
<table width="1728" height="500" border="1">
  <tr>
    <td width="77" align="center"><img src="../../images/chevron.jpg" alt="" width="58"/></td>
    <td width="127" align="center"><img src="../../images/bukaka.jpg" alt="" width="89"/></td>
    <td width="489" bgcolor="#2F75B5"><font color="#FFFFFF" size="2">WEEKLY PROGRESS REPORT</font><p><font color="#FFFFFF"><?php echo $row_Recordset1['description']; ?></font></p>
      <p><font color="#FFFFFF" size="-1"><?php echo $row_Recordset12['tanggal']; ?></font></p>
    <p><font color="#FFFFFF"><?php echo $row_Recordset1['cutofdate']; ?></font></p></td>
    <td colspan="5"  bgcolor="#006600">&nbsp;</td>
  </tr>
  <tr>
    <td height="" colspan="3"><table width="700" height="250"border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td class="sizewpr">Project Title</td>
        <td colspan="3" class="contenthdr" ><?php echo $row_Recordset12['project_title']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Description</td>
        <td colspan="3" class="contenthdr"><?php echo $row_Recordset12['description']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Contract No.</td>
        <td colspan="3" class="contenthdr"><?php echo $row_Recordset12['contract_no']; ?></td>
      </tr>
      <tr>
        <td width="115" class="sizewpr">WO/CTR No.</td>
        <td width="144" class="contenthdr" ><?php echo $row_Recordset12['wo_no']; ?></td>
        <td width="98" class="sizewpr">CTR Approval</td>
        <td width="139"  class="contenthdr"><?php echo $row_Recordset12['ctr_approval']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">AFE/CC No.</td>
        <td  class="contenthdr"><?php echo $row_Recordset12['aff_no']; ?></td>
        <td class="sizewpr">Type of Work</td>
        <td  class="contenthdr"><?php echo $row_Recordset12['type_ofwork']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Construction Eng.</td>
        <td  class="contenthdr"><?php echo $row_Recordset12['const_eng']; ?></td>
        <td class="sizewpr">CTR Req'd</td>
        <td  class="contenthdr">USD <font color="#FF0000"><?php echo '$ ' . number_format( $row_Recordset9['total_wovalue'],2); ?></font></td>
      </tr>
      <tr>
        <td height="36" class="sizewpr">Contractor PIC Name</td>
        <td colspan="3" class="contenthdr"><?php echo $row_Recordset12['pic_name']; ?></td>
      </tr>
    </table></td>
    <td width="356" height=""><table  border="0" height="250" cellspacing="2">
      <tr class="headerwpr" >
        <td colspan="3" align="center" valign="middle"><strong>ENGINEERING, CONSTRUCTION, PROCUREMENT &amp; INSTALATION</strong></td>
      </tr>
      <tr>
        <td width="100" class="headerwpr"  ><strong>Activities</strong></td>
        <td width="146" class="headerwpr" ><strong> Planned Date</strong></td>
        <td width="153" class="headerwpr" ><strong> Actual Date</strong></td>
      </tr>
      <tr class="contenthdr">
        <td  class="sizewpr">Engineering </td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[eng_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[eng_actual]; ?></td>
      </tr>
      <tr class="contenthdr">
        <td  class="sizewpr">Procurement</td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[proc_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[proc_actual]; ?></td>
      </tr>
      <tr class="contenthdr">
        <td  class="sizewpr">Fabrication</td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[fab_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[fab_actual]; ?></td>
      </tr>
      <tr class="contenthdr">
        <td  class="sizewpr"> Instalation</td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[inst_plan]; ?></td>
        <td class="contenthdr" align="center"><?php echo $row_Recordset14[inst_actual]; ?></td>
      </tr>
    </table></td>
    <td width="645" colspan="5"><table border="0" height="250"  cellspacing="2">
      <tr>
        <td colspan="2" class="tabel_header">EPC ACTIVITIES</td>
      </tr>
      <tr class="tabel_header">
        <td  colspan="2" class="tabel_header"> EPC ACTIVITIES - Major Activities /Accomplishment - This Period</td>
      </tr>
      <tr class="contenthdr">
        <td width="104"  class="sizewpr">Engineering</td>
        <td width="520" class="contenthdr"><textarea name="eng_thisweek" cols="75" rows="2" class="textarea" maxlength="174" style="border:thin"><?php echo $row_Recordset3['eng_thisweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr" >Procurement</td>
        <td class="contenthdr"><textarea name="proc_thisweek" id="proc_thisweek" cols="75" rows="2"  maxlength="174" style="border:thin" class="textarea"><?php echo $row_Recordset3['proc_thisweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr" >Fabrication</td>
        <td class="contenthdr"><textarea name="fab_thisweek" id="fab_thisweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['fab_thisweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr" >Installation</td>
        <td class="contenthdr"><textarea name="inst_thisweek" id="inst_thisweek" cols="75" rows="2"  style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['inst_thisweek']; ?></textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" height="200"><table  border="0" cellpadding="1" cellspacing="0">
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
        <td class="contenthdr"><textarea name="action_plan" cols="65" rows="10" class="textarea1" id="action_plan" style="border:thin"><?php echo $row_Recordset4['action_plan']; ?></textarea></td>
       </tr>
    </table></td>
    <td colspan="5"><table border="0" cellspacing="2">
      <tr class="tabel_header">
        <td colspan="2" class=""> EPC ACTIVITIES - Major Activities /Accomplishment - Next Period</td>
      </tr>
      <tr class="">
        <td width="104"  class="sizewpr">Engineering</td>
        <td width="520" class="contenthdr">
          <textarea name="eng_nextweek" id="eng_nextweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['eng_nextweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td  class="sizewpr">Procurement</td>
        <td class="contenthdr"><textarea name="proc_nextweek" id="proc_nextweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['proc_nextweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td class="sizewpr">Fabrication</td>
        <td  class="contenthdr">
          <textarea name="fab_nextweek" id="fab_nextweek" cols="75" rows="2" style="border:thin" class="textarea"  maxlength="174"><?php echo $row_Recordset3['fab_nextweek']; ?></textarea></td>
      </tr>
      <tr class="">
        <td  class="sizewpr">Installation</td>
        <td class="contenthdr"> <textarea name="inst_nextweek" id="inst_nextweek" style="border:thin" class="textarea" cols="75" rows="2"  maxlength="174"><?php echo $row_Recordset3['isnt_nextweek']; ?></textarea></td>
      </tr>
    </table></td>
  </tr>
</table><table width="1734"  height="700" border="1">
  <tr>
    <td width="566" height="82"><table border="0" width="620" cellpadding="2" cellspacing="2">
      <tr>
        <td>&nbsp;</td>
        <td width="76">&nbsp;</td>
        <td width="363" class="headerwpr">MILESTONE</td>
        </tr>
      <tr class="">
        <td width="108" class="sizewpr">Procurement Complete</td>
        <td colspan="2" class="contenthdr"><textarea class="textarea" style="border:thin" name="proc_complete" id="proc_complete" cols="60" rows="2" maxlength="174"><?php echo $row_Recordset5['proc_complete']; ?></textarea></td>
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
    <td width="860" rowspan="3"><iframe frameborder="0" width="730" height="650" src="../chart/mulline.php?data=<?php echo rawurlencode($row_Recordset13['id']); ?>"></iframe></td>
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
        <td class="contenthdr"><b><b><b>
          <?php if ($sql1[statuscrf]==1) { echo "<img src='../images/select(1).png' width='15' height='15' />"; } 
		  else { 
		  echo "<a href='inputcrf.php?data=$sql1[id]'>New CRF</a>";
		  }?>
        </b></b></b></td>
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
    <td colspan="2" align="center"><iframe width="400" height="230" frameborder="0" src="../chart/pie.php?data=<?php echo rawurlencode($row_Recordset13['id']); ?>"> </iframe>      <iframe frameborder="0"  width="400" height="230" src="../chart/pie_summary.php?data=<?php echo rawurlencode($row_Recordset13['id']); ?>"> </iframe>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="center"><a href="input_detailwpr.php?data=<?php echo $row_Recordset13['id']; ?>">INPUT DETAIL WPR </a></td>
  </tr>
</table>
</p>

<script>
function printPreview() {
	if(!document._wb)
		document.body.insertAdjacentHTML(
			"beforeEnd", 
			"<object id='_wb' classid='CLSID:8856F961-340A-11D0-A96B-00C04FD705A2'></object>"
		); 
	_wb.ExecWB(7,1)
}
</script>
<table>
  <tr>
    <td><img src="/images/icon_print.gif" alt="" width="25" height="25" class="btn" onclick="PrintDoc()" /></td>
    <td><img src="/images/icon_printpw.gif" alt="" width="24" height="25" class="btn" onclick="PrintPreview()"/></td>
  </tr>
</table>
</body>

</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset14);

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

mysql_free_result($Recordset12);

mysql_free_result($Recordset13);
?>
