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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "wpr")) {
  $insertSQL = sprintf("INSERT INTO pr_major_activities (id_wpr_header, eng_thisweek, eng_nextweek, proc_thisweek, proc_nextweek, fab_thisweek, fab_nextweek, inst_thisweek, isnt_nextweek) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_wpr'], "int"),
                       GetSQLValueString($_POST['eng_thisweek'], "text"),
                       GetSQLValueString($_POST['eng_nextweek'], "text"),
                       GetSQLValueString($_POST['proc_thisweek'], "text"),
                       GetSQLValueString($_POST['proc_nextweek'], "text"),
                       GetSQLValueString($_POST['fab_thisweek'], "text"),
                       GetSQLValueString($_POST['fab_nextweek'], "text"),
                       GetSQLValueString($_POST['inst_thisweek'], "text"),
                       GetSQLValueString($_POST['inst_nextweek'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "wpr")) {
  $insertSQL = sprintf("INSERT INTO pr_wpr_activities (id_wpr_header, eng_plan, eng_actual, proc_plan, proc_actual, fab_plan, fab_actual, inst_plan, inst_actual) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_wpr'], "int"),
                       GetSQLValueString($_POST['eng_plan'], "text"),
                       GetSQLValueString($_POST['eng_actual'], "text"),
                       GetSQLValueString($_POST['proc_plan'], "text"),
                       GetSQLValueString($_POST['proc_actual'], "text"),
                       GetSQLValueString($_POST['fab_plan'], "text"),
                       GetSQLValueString($_POST['fab_actual'], "text"),
                       GetSQLValueString($_POST['inst_plan'], "text"),
                       GetSQLValueString($_POST['inst_actual'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "wpr")) {
  $insertSQL = sprintf("INSERT INTO pr_wpr_issue (id_wpr_header, `description`, action_plan) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_wpr'], "int"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['action_plan'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "wpr")) {
  $insertSQL = sprintf("INSERT INTO pr_wpr_milestone (id_wpr_header, proc_complete, fab_complete, inst_complete) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_wpr'], "int"),
                       GetSQLValueString($_POST['proc_complete'], "text"),
                       GetSQLValueString($_POST['fab_complete'], "text"),
                       GetSQLValueString($_POST['inst_complete'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "wpr")) {
  $updateSQL = sprintf("UPDATE pr_wpr_comulative SET var_eng=%s, var_proc=%s, var_fab=%s, var_inst=%s, var_misc=%s, tot_weight=%s, tot_plan=%s, tot_act=%s, tot_variance=%s WHERE id_headerwpr=%s",
                       GetSQLValueString($_POST['var_eng'], "double"),
                       GetSQLValueString($_POST['var_proc'], "double"),
                       GetSQLValueString($_POST['var_fab'], "double"),
                       GetSQLValueString($_POST['var_inst'], "double"),
                       GetSQLValueString($_POST['var_misc'], "double"),
                       GetSQLValueString($_POST['tot_weight'], "double"),
                       GetSQLValueString($_POST['tot_plan'], "double"),
                       GetSQLValueString($_POST['tot_act'], "double"),
                       GetSQLValueString($_POST['tot_variance'], "double"),
                       GetSQLValueString($_POST['id_wpr'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "wpr")) {
  $insertSQL = sprintf("INSERT INTO pr_wpr_summary (id_wpr_header, id_wpr_tanggal) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr'], "int"),
                       GetSQLValueString($_POST['id_wpr_tanggal'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
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
$query_Recordset1 = "SELECT * FROM pr_header_wpr";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT * FROM pr_wpr_comulative WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset11, "int"));
$Recordset11 = mysql_query($query_Recordset11, $core) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);

mysql_select_db($database_core, $core);
$query_Recordset10 = "SELECT * FROM pr_weightfactor";
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset12 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset12 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset12 = sprintf("SELECT pr_wpr_tanggal.id, pr_wpr_tanggal.id_headerwpr, pr_wpr_tanggal.tanggal, pr_header_wpr.id, pr_header_wpr.project_title, pr_header_wpr.description, pr_header_wpr.contract_no, pr_header_wpr.wo_no, pr_header_wpr.aff_no, pr_header_wpr.const_eng, pr_header_wpr.pic_name, pr_header_wpr.ctr_approval, pr_header_wpr.type_ofwork, pr_header_wpr.ctr_reqd, pr_header_wpr.cutofdate FROM pr_wpr_tanggal, pr_header_wpr WHERE pr_wpr_tanggal.id = %s AND pr_header_wpr.id=pr_wpr_tanggal.id_headerwpr", GetSQLValueString($colname_Recordset12, "int"));
$Recordset12 = mysql_query($query_Recordset12, $core) or die(mysql_error());
$row_Recordset12 = mysql_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysql_num_rows($Recordset12);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM pr_wpr_tanggal WHERE id = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM pr_wbs_cost";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project - Input WPR</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<?php {
include "../date.php";} ?>
<form method="POST" action="<?php echo $editFormAction; ?>" name="wpr">
<table width="1785" height="550" border="1">
  <tr>
    <td width="61" align="center"><img src="../../images/chevron.jpg" alt="" width="58" height="42" /></td>
    <td width="93" align="center"><img src="../../images/bukaka.jpg" alt="" width="89" height="24" /></td>
    <td width="544" bgcolor="#2F75B5"><font color="#FFFFFF" size="3">WEEKLY PROGRESS REPORT</font><p><font color="#FFFFFF"><?php echo $row_Recordset1['description']; ?></font></p>
    <p><font color="#FFFFFF"><?php echo $row_Recordset12['tanggal']; ?></font>
      <input name="id_wpr_tanggal" type="hidden" id="id_wpr_tanggal" value="<?php echo $row_Recordset4['id']; ?>" />
    </p></td>
    <td width="136" bgcolor="#006600">&nbsp;</td>
    <td width="136" bgcolor="#FFFF00">&nbsp;</td>
    <td width="132" bgcolor="#6699FF">&nbsp;</td>
    <td width="173" bgcolor="#FFCC33">&nbsp;</td>
    <td width="173" bgcolor="#99CCFF">&nbsp;</td>
    <td width="173" bgcolor="#FF0000">&nbsp;</td>
    <td width="70" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="253" colspan="3"><table width="700" height="253" border="1" cellpadding="2" cellspacing="2">
      <tr>
        <td class="sizewpr">Project Title</td>
        <td colspan="3" ><?php echo $row_Recordset12['project_title']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Description</td>
        <td colspan="3"><?php echo $row_Recordset12['description']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Contract No.</td>
        <td colspan="3"><?php echo $row_Recordset12['contract_no']; ?></td>
      </tr>
      <tr>
        <td width="115" class="sizewpr">WO/CTR No.</td>
        <td width="144" ><?php echo $row_Recordset12['wo_no']; ?></td>
        <td width="98" class="sizewpr">CTR Approval</td>
        <td width="139" ><?php echo $row_Recordset12['ctr_approval']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">AFE/CC No.</td>
        <td ><?php echo $row_Recordset12['aff_no']; ?></td>
        <td class="sizewpr">Type of Work</td>
        <td ><?php echo $row_Recordset12['type_ofwork']; ?></td>
      </tr>
      <tr>
        <td class="sizewpr">Construction Eng.</td>
        <td ><?php echo $row_Recordset12['const_eng']; ?></td>
        <td class="sizewpr">CTR Req'd</td>
        <td >USD <font color="#FF0000"><?php echo '$ ' . number_format( $row_Recordset3['totalcost'],2); ?></font></td>
      </tr>
      <tr>
        <td height="36" class="sizewpr">Contractor PIC Name</td>
        <td colspan="3"><?php echo $row_Recordset12['pic_name']; ?></td>
      </tr>
    </table></td>
    <td colspan="3"><table height="253" border="1" cellspacing="2">
      <tr class="headerwpr" >
        <td colspan="3" align="center" valign="middle"><strong>ENGINEERING, CONSTRUCTION, PROCUREMENT &amp; INSTALATION</strong></td>
      </tr>
      <tr>
        <td width="100" class="headerwpr" height="20" ><strong>Activities</strong></td>
        <td width="169" class="headerwpr" ><strong> Planned Date</strong></td>
        <td width="169" class="headerwpr" ><strong> Actual Date</strong></td>
      </tr>
      <tr>
        <td height="40" class="sizewpr">Engineering </td>
<td align="center"><label>
  <input type="text" name="eng_plan" id="tanggal1" />
</label></td>
<td align="center"><label>
  <input type="text" name="eng_actual" id="tanggal2" />
</label></td>
      </tr>
     
      <tr>
        <td height="40" class="sizewpr">Procurement</td>
<td align="center"><label>
  <input type="text" name="proc_plan" id="tanggal3" />
</label></td>
<td align="center"><label>
  <input type="text" name="proc_actual" id="tanggal4" />
</label></td>
      </tr>
      <tr>
        <td height="40" class="sizewpr">Fabrication</td>
<td align="center"><label>
  <input type="text" name="fab_plan" id="tanggal5" />
</label></td>
<td align="center"><label>
  <input type="text" name="fab_actual" id="tanggal6" />
</label></td>
      </tr>
      <tr>
        <td height="40" class="sizewpr"> Instalation</td>
<td align="center"><label>
  <input type="text" name="inst_plan" id="tanggal7" />
</label></td>
<td align="center"><label>
  <input type="text" name="inst_actual" id="tanggal8" />
</label></td>
      </tr>
    </table></td>
    <td colspan="5"><table width="638" height="253" border="0" cellspacing="2">
      <tr>
        <td colspan="2" class="tabel_header">EPC ACTIVITIES</td>
      </tr>
      <tr class="tabel_header">
        <td height="20" colspan="2" class="tabel_header"> EPC ACTIVITIES - Major Activities /Accomplishment - This Period</td>
      </tr>
      <tr>
        <td width="104" height="40" class="sizewpr">Engineering</td>
<td width="520"><label>
  <textarea name="eng_thisweek" id="eng_thisweek" cols="75" rows="1" maxlength="174"></textarea>
</label></td>
      </tr>
      <tr class="">
        <td class="sizewpr" height="40">Procurement</td>
<td><label>
  <textarea name="proc_thisweek" id="proc_thisweek" cols="75" rows="1"  maxlength="174"></textarea>
</label></td>
      </tr>
      <tr class="">
        <td class="sizewpr" height="40">Fabrication</td>
<td><label>
  <textarea name="fab_thisweek" id="fab_thisweek" cols="75" rows="1"  maxlength="174"></textarea>
</label></td>
      </tr>
      <tr class="">
        <td class="sizewpr" height="40">Installation</td>
<td><label>
  <textarea name="inst_thisweek" id="inst_thisweek" cols="75" rows="1"  maxlength="174"></textarea>
</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6" height="200"><table width="1132" height="199" border="1" cellpadding="1" cellspacing="0">
      <tr class="tabel_header">
        <td height="13" colspan="2">MAJOR ISSUE, AREA CONCERN OR BOTTLENECKS </td>
      </tr>
      <tr class="tabel_header">
        <td width="554" height="13" class="tabel_header">Description</td>
        <td width="574"  height="13"  class="tabel_header">Action Plan</td>
      </tr>
      <tr valign="top">
        <?php $o=$o+1; ?>
        <td><label>
          <textarea name="description" id="description" cols="65" rows="9" maxlength="255"></textarea>
        </label></td>
        <td><label>
          <textarea name="action_plan" cols="65" rows="9" id="action_plan" maxlength="255"></textarea>
        </label></td>
       </tr>
    </table></td>
    <td colspan="5"><table width="638" height="204" border="1" cellspacing="2">
      <tr class="tabel_header">
        <td colspan="2" class=""> EPC ACTIVITIES - Major Activities /Accomplishment - Next Period</td>

      </tr>
      <tr class="">
        <td width="104" height="40" class="sizewpr">Engineering</td>
<td width="520"><label>
  <textarea name="eng_nextweek" id="eng_nextweek" cols="75" rows="1"  maxlength="174"></textarea>
</label></td>
      </tr>
      <tr class="">
        <td height="40" class="sizewpr">Procurement</td>
<td><label>
  <textarea name="proc_nextweek" id="proc_nextweek" cols="75" rows="1"  maxlength="174"></textarea>
</label></td>
      </tr>
      <tr class="">
        <td class="sizewpr">Fabrication</td>
<td height="40"><label>
  <textarea name="fab_nextweek" id="fab_nextweek" cols="75" rows="1"  maxlength="174"></textarea>
</label></td>
      </tr>
      <tr class="">
        <td height="40" class="sizewpr">Installation</td>
<td><label>
  <textarea name="inst_nextweek" id="inst_nextweek" cols="75" rows="1"  maxlength="174"></textarea>
</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="620" height="266" border="1" align="center" cellpadding="2" cellspacing="2">
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
      <tr>
        <td class="sizewpr">Engineering</td>
        <td><?php echo $row_Recordset10[wf_eng]; ?></td>
        <td><?php echo $row_Recordset11[cumm_plan_e1]; ?></td>
        <td><?php echo $row_Recordset11[cumm_actual_e1]; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr>
        <td class="sizewpr" >Procurement</td>
        <td ><?php echo $row_Recordset10[wf_proc]; ?></td>
        <td ><?php echo $row_Recordset11[cumm_plan_p2]; ?></td>
        <td ><?php echo $row_Recordset11[cumm_actual_p2]; ?></td>
        <td ><input type="text" name="var_proc" id="var_proc" size="10" value="<?php $var_proc=$row_Recordset11[cumm_actual_p2]-$row_Recordset11[cumm_plan_p2]; echo number_format ($var_proc,2); ?>" /></td>
        <td >&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr class="">
        <td class="sizewpr" >Fabrication</td>
        <td><?php echo $row_Recordset10[wf_fab]; ?></td>
        <td><?php echo $row_Recordset11[cumm_plan_f3]; ?></td>
        <td><?php echo $row_Recordset11[cumm_actual_f3]; ?></td>
        <td><input type="text" name="var_fab" id="var_fab" size="10" value="<?php $var_fab=$row_Recordset11[cumm_actual_f3]-$row_Recordset11[cumm_plan_f3]; echo number_format ($var_fab,2); ?>" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr class="">
        <td class="sizewpr">Installation</td>
        <td><?php echo $row_Recordset10[wf_instalation]; ?></td>
        <td><?php echo $row_Recordset11[cumm_plan_i4]; ?></td>
        <td><?php echo $row_Recordset11[cumm_actual_i4]; ?></td>
        <td><input type="text" name="var_inst" id="var_inst" size="10" value="<?php $var_inst=$row_Recordset11[cumm_actual_i4]-$row_Recordset11[cumm_plan_i4]; echo number_format ($var_inst,2); ?>" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr>
        <td class="sizewpr" >Miscellanous</td>
        <td><?php echo $row_Recordset10[wf_miscellanous]; ?></td>
        <td><?php echo $row_Recordset11[cumm_plan_m5]; ?></td>
        <td><?php echo $row_Recordset11[cumm_actual_m5]; ?></td>
        <td><input type="text" name="var_misc" id="var_misc" size="10" value="<?php $var_misc=$row_Recordset11[cumm_actual_m5]-$row_Recordset11[cumm_plan_m5]; echo number_format ($var_misc,2); ?>" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr>
        <td class="tabel_header">Total Progress</td>
        <td ><input type="text" name="tot_weight" id="tot_weight" size="10" value="<?php $tot_weight=$row_Recordset10[wf_eng]+$row_Recordset10[wf_proc]+$row_Recordset10[wf_fab]+$row_Recordset10[wf_instalation]+$row_Recordset10[wf_miscellanous]; echo number_format ($tot_weight,2); ?>" /></td>
        <td ><input type="text" name="tot_plan" id="tot_plan" size="10" value="<?php $tot_plan=$row_Recordset11[cumm_plan_e1]+$row_Recordset11[cumm_plan_p2]+$row_Recordset11[cumm_plan_f3]+$row_Recordset11[cumm_plan_i4]+$row_Recordset11[cumm_plan_m5]; echo number_format ($tot_plan,2) ?>" /></td>
        <td><input type="text" name="tot_act" id="tot_act" size="10" value="<?php $tot_act=$row_Recordset11[cumm_actual_e1]+$row_Recordset11[cumm_actual_p2]+$row_Recordset11[cumm_actual_f3]+$row_Recordset11[cumm_actual_i4]+$row_Recordset11[cumm_actual_m5]; echo number_format ($tot_act,2) ?>" /></td>
        <td ><input type="text" name="tot_variance" id="tot_variance" size="10" value="<?php $tot_variance=$var_eng+$var_proc+$var_fab+$var_inst+$var_misc; echo number_format ($tot_variance,2); ?>" /></td>
        <td >&nbsp;</td>
        </tr>
    </table>
      <input type="text" name="var_eng" id="var_eng" size="10" value="<?php $var_eng=$row_Recordset11[cumm_actual_e1]-$row_Recordset11[cumm_plan_e1]; echo number_format ($var_eng,2); ?>" /></td>
    <td colspan="3" align="center"><a href="#" onclick="MM_openBrWindow('../summary.php?data=<?php echo $row_Recordset4['id']; ?>','','scrollbars=yes,resizable=yes,width=400,height=600')">Input Summary</a></td>
    <td colspan="5" align="center"><table width="706" height="82" border="1" cellpadding="2" cellspacing="2">
      <tr>
        <td colspan="3" class="headerwpr">MILESTONE</td>
        </tr>
      <tr class="">
        <td class="sizewpr">Procurement Complete</td>
        <td colspan="2" ><label>
          <textarea name="proc_complete" id="proc_complete" cols="60" rows="1" maxlength="164"></textarea>
          </label></td>
        </tr>
      <tr class="" >
        <td class="sizewpr">Fabrication Complete</td>
        <td colspan="2" ><p>
          <label>
            <textarea name="fab_complete" id="fab_complete" cols="60" rows="1" maxlength="164"></textarea>
            </label>
          </p></td>
        </tr>
      <tr class="" >
        <?php $o=$o+1; ?>
        <td class="sizewpr">Instalation Complete</td>
        <td colspan="2" ><p>
          <label>
            <textarea name="inst_complete" id="inst_complete" cols="60" rows="1" maxlength="164"></textarea>
            </label>
          </p></td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="11" align="center">
      <input name="id_wpr" type="hidden" id="id_wpr" value="<?php echo $row_Recordset1['id']; ?>" />
      <input type="submit" name="submit" id="submit" value="Submit" /></td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="wpr" />
<input type="hidden" name="MM_update" value="wpr" />
</form>
</p>
</body>

</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset11);

mysql_free_result($Recordset10);

mysql_free_result($Recordset12);

mysql_free_result($Recordset4);

mysql_free_result($Recordset3);
?>
