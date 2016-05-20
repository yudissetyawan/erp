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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description6'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description3'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_weightfactor (id_wpr_header, wf_eng, wf_eng_services, wf_proj_services, wf_proc, wf_civ_structure, wf_piping, wf_electrical_inst, wf_fab, wf_fab_activities, wf_ndt, wf_instalation, wf_inst_civil_structure, wf_miscellanous, wf_personal_dayrate, wf_equip_dayrate, wf_land_transportation, totalwf) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['wf_eng'], "double"),
                       GetSQLValueString($_POST['wf_eng_services'], "double"),
                       GetSQLValueString($_POST['wf_proj_services'], "double"),
                       GetSQLValueString($_POST['wf_proc'], "double"),
                       GetSQLValueString($_POST['wf_civ_structure'], "double"),
                       GetSQLValueString($_POST['wf_piping'], "double"),
                       GetSQLValueString($_POST['wf_electrical_inst'], "double"),
                       GetSQLValueString($_POST['wf_fab'], "double"),
                       GetSQLValueString($_POST['wf_fab_activities'], "double"),
                       GetSQLValueString($_POST['wf_ndt'], "double"),
                       GetSQLValueString($_POST['wf_instalation'], "double"),
                       GetSQLValueString($_POST['wf_inst_civil_structure'], "double"),
                       GetSQLValueString($_POST['wf_miscellanous'], "double"),
                       GetSQLValueString($_POST['wf_personal_dayrate'], "double"),
                       GetSQLValueString($_POST['wf_equip_dayrate'], "double"),
                       GetSQLValueString($_POST['wf_land_transportation'], "double"),
                       GetSQLValueString($_POST['total_wf'], "double"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "view_wbs.php?data=" . $row_Recordset2['id_wpr_header'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description4'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description5'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description7'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description8'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description9'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description10'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description11'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description12'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description13'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_core_ctrdata (id_headerwpr, sub_description) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_wpr_header'], "int"),
                       GetSQLValueString($_POST['sub_description14'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_wpr_corecomulative (id_headerwpr) VALUES (%s)",
                       GetSQLValueString($_POST['id_wpr_header'], "text"));

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

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM pr_wbs_cost WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
    <td  class="contenthdr"><font color="#FF0000">USD  <?php echo '$ ' .  number_format(  $row_Recordset2['totalcost'],2 ); ?></font></td>
  </tr>
  <tr>
    <td class="sizewpr">Contractor PIC Name</td>
    <td class="sizewpr">:</td>
    <td colspan="4"  class="contenthdr"><?php echo $row_Recordset1['pic_name']; ?></td>
  </tr>
  <tr class="tabel_header">
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="General">
    <form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
    <table width="895" border="0" cellpadding="2" cellspacing="1">
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
        <td class="header_description"><?php echo  number_format(  $row_Recordset2['engineering'],2 ); ?> </td>
        <td class="header_description"><input type="text" name="wf_eng" id="wf_eng" value="<?php $eng= $row_Recordset2[engineering]/$row_Recordset2[totalcost]*100; echo  number_format($eng,2); ?>" readonly="readonly"/></td>
        <td class="header_description"><input name="id_wpr_header" type="hidden" id="id_wpr_header" value="<?php echo $row_Recordset2['id_wpr_header']; ?>" /></td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">I.A.</td>
        <td class="tabel_body">Engineering Services          <span class="tabel_index">
          <input type="hidden" name="sub_description" id="sub_description" value="Engineering Services" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['eng_services'],2 ); ?></td>
        <td class="tabel_body"><label>
          <input type="text" name="wf_eng_services" id="wf_eng_services" value="<?php $es=$row_Recordset2[eng_services]/$row_Recordset2[totalcost]*100; echo  number_format($es,2); ?>" readonly="readonly"/> 
        </label></td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
       
        <td class="tabel_body">I.B.</td>
        <td class="tabel_body">Project Services<span class="tabel_index">
          <input type="hidden" name="sub_description2" id="sub_description2" value="Project Services" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['proj_services'],2 ); ?></td>
        <td class="tabel_body"><label>
          <input type="text" name="wf_proj_services" id="wf_proj_services" value="<?php $ps= $row_Recordset2[proj_services]/$row_Recordset2[totalcost]*100; echo  number_format($ps,2); ?>" readonly="readonly"/>
        </label></td>
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
        <td class="header_description"><?php echo  number_format(  $row_Recordset2['procurement'],2 ); ?></td>
        <td class="header_description"><label>
          <input type="text" name="wf_proc" id="wf_proc" value="<?php $proc=$row_Recordset2[procurement]/$row_Recordset2['totalcost']*100; echo  number_format($proc,2); ?>" readonly="readonly"/>
        </label></td>
        <td class="header_description">&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td>II.A.</td>
        <td>Material For Civil &amp; Structure <span class="tabel_index">
          <input type="hidden" name="sub_description3" id="sub_description3" value="Material For Civil & Structure" />
        </span></td>
        <td align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['material_civ_structure'],2 ); ?></td>
        <td><label>
          <input type="text" name="wf_civ_structure" id="wf_civ_structure" value="<?php $civs=$row_Recordset2[material_civ_structure]/$row_Recordset2['totalcost']*100; echo  number_format($civs,2); ?>" readonly="readonly"/>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="number_mkt">II.B.</td>
        <td class="number_mkt">Material For Piping<span class="tabel_index">
          <input type="hidden" name="sub_description4" id="sub_description4" value="Material For Piping" />
        </span></td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['material_piping'],2 ); ?></td>
        <td class="number_mkt"><label>
          <input type="text" name="wf_piping" id="wf_piping" value="<?php $pip=$row_Recordset2[material_piping]/$row_Recordset2['totalcost']*100; echo  number_format($pip,2); ?>" readonly="readonly"/>
        </label></td>
        <td class="number_mkt">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
       
        <td>II.C.</td>
        <td>Material For Electrical &amp; Instrument <span class="tabel_index">
          <input type="hidden" name="sub_description5" id="sub_description5" value="Material For Electrical & Instrument" />
        </span></td>
        <td align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['material_electrical_inst'],2 ); ?></td>
        <td><label>
          <input type="text" name="wf_electrical_inst" id="wf_electrical_inst" value="<?php $elin=$row_Recordset2[material_electrical_inst]/$row_Recordset2['totalcost']*100; echo  number_format($elin,2); ?>" readonly="readonly"/>
        </label></td>
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
        <td class="header_description"><?php echo  number_format(  $row_Recordset2['fabrication'],2 ); ?></td>
        <td class="header_description"><label>
          <input type="text" name="wf_fab" id="wf_fab" value="<?php $fab=$row_Recordset2[fabrication]/$row_Recordset2['totalcost']*100; echo  number_format($fab,2); ?>" readonly="readonly"/>
        </label></td>
        <td class="header_description">&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">III.A.</td>
        <td class="tabel_body">Fabrication Activities<span class="tabel_index">
          <input type="hidden" name="sub_description6" id="sub_description6" value="Fabrication Activities" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['fab_activities'],2 ); ?></td>
        <td class="tabel_body"><label>
          <input type="text" name="wf_fab_activities" id="wf_fab_activities" value="<?php $fabact= $row_Recordset2[fab_activities]/$row_Recordset2['totalcost']*100; echo  number_format($fabact,2); ?>" readonly="readonly"/>
        </label></td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">III.B.</td>
        <td class="tabel_body">Painting &amp; Sand Blasting Activities <span class="tabel_index">
          <input type="hidden" name="sub_description7" id="sub_description7" value="Painting & Sand Blasting Activities" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['painting_sandblastactivities'],2 ); ?></td>
        <td class="tabel_body"><input type="text" name="wf_painting_sandblastingactivities" id="wf_painting_sandblastingactivities" value="<?php $fabpaint=$row_Recordset2[painting_sandblastactivities]/$row_Recordset2['totalcost']*100; echo  number_format($fabpaint,2); ?>" readonly="readonly"/></td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        
        <td class="tabel_body">III.C.</td>
        <td class="tabel_body">NDT <span class="tabel_index">
          <input type="hidden" name="sub_description8" id="sub_description8" value="NDT" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['ndt'],2 ); ?></td>
        <td class="tabel_body"><input type="text" name="wf_ndt" id="wf_ndt" value="<?php $ndt=$row_Recordset2[ndt]/$row_Recordset2['totalcost']*100; echo  number_format($ndt,2); ?>" readonly="readonly"/></td>
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
        <td class="header_description"><?php echo  number_format(  $row_Recordset2['instalation'],2 ); ?></td>
        <td class="header_description"><input type="text" name="wf_instalation" id="wf_instalation" value="<?php $inst=$row_Recordset2[instalation]/$row_Recordset2['totalcost']*100; echo  number_format($inst,2); ?>" readonly="readonly"/></td>
        <td class="header_description">&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">IV.A.</td>
        <td class="tabel_body">Installation For Civil &amp; Structure <span class="tabel_index">
          <input type="hidden" name="sub_description9" id="sub_description9" value="Installation For Civil & Structure" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['inst_civil_structure'],2 ); ?></td>
        <td><input type="text" name="wf_inst_civil_structure" id="wf_inst_civil_structure" value="<?php $instciv=$row_Recordset2[inst_civil_structure]/$row_Recordset2['totalcost']*100; echo  number_format($instciv,2); ?>" readonly="readonly"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">IV.B.</td>
        <td class="tabel_body">Installation for Piping <span class="tabel_index">
          <input type="hidden" name="sub_description10" id="sub_description10" value="Installation for Piping" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['inst_piping'],2 ); ?></td>
        <td class="number_mkt"><input type="text" name="instpip" id="instpip" value="<?php $instpip=$row_Recordset2[inst_piping]/$row_Recordset2['totalcost']*100; echo  number_format($instpip,2); ?>" readonly="readonly"/></td>
        <td class="number_mkt">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">IV.C.</td>
        <td class="tabel_body">Installation For Electrical &amp; Instrument <span class="tabel_index">
          <input type="hidden" name="sub_description11" id="sub_description11" value="Installation For Electrical & Instrument" />
        </span></td>
        <td class="number_mkt" align="center">Lot</td>
        <td class="number_mkt" align="center">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['inst_electric_inst'],2 ); ?></td>
        <td><span class="tabel_index">
          <input type="text" name="instelect" id="instelect" value="<?php $instelect=$row_Recordset2[inst_electric_inst]/$row_Recordset2['totalcost']*100; echo  number_format($instelect,2); ?>" readonly="readonly"/>
        </span></td>
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
        <td><?php echo  number_format(  $row_Recordset2['miscellanous'],2); ?></td>
        <td><input type="text" name="wf_miscellanous" id="wf_miscellanous" value="<?php $misc=$row_Recordset2[miscellanous]/$row_Recordset2['totalcost']*100; echo  number_format($misc,2); ?>" readonly="readonly"/></td>
        <td>&nbsp;</td>
        </tr>
      <tr class="tabel_body">
        <td class="tabel_body">V.A.</td>
        <td class="tabel_body">Personal Day Rate <span class="tabel_index">
          <input type="hidden" name="sub_description12" id="sub_description12" value="Personal Day Rate" />
        </span></td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['personal_dayrate'],2 ); ?></td>
        <td class="tabel_body"><input type="text" name="wf_personal_dayrate" id="wf_personal_dayrate" value="<?php $person=$row_Recordset2[personal_dayrate]/$row_Recordset2['totalcost']*100; echo  number_format($person,2); ?>" readonly="readonly"/></td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        <td class="tabel_body">V.B.</td>
        <td class="tabel_body">Equipment Day Rate <span class="tabel_index">
          <input type="hidden" name="sub_description13" id="sub_description13" value="Equipment Day Rate" />
        </span></td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['equip_dayrate'],2 ); ?></td>
        <td class="tabel_body"><input type="text" name="wf_equip_dayrate" id="wf_equip_dayrate" value="<?php $equip=$row_Recordset2[equip_dayrate]/$row_Recordset2['totalcost']*100; echo  number_format($equip,2); ?>" readonly="readonly"/></td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr class="tabel_body">
        
        <td class="tabel_body">V.C.</td>
        <td class="tabel_body">Land Transportation <span class="tabel_index">
          <input type="hidden" name="sub_description14" id="sub_description14" value="Land Transportation" />
        </span></td>
        <td align="center" class="number_mkt">Lot</td>
        <td class="number_mkt">&nbsp;</td>
        <td class="number_mkt"><?php echo  number_format(  $row_Recordset2['land_transportation'],2 ); ?></td>
        <td class="tabel_body"><input type="text" name="wf_land_transportation" id="wf_land_transportation" value="<?php $trans=$row_Recordset2[land_transportation]/$row_Recordset2['totalcost']*100; echo  number_format($trans,2); ?>" readonly="readonly"/></td>
        <td class="tabel_body">&nbsp;</td>
      </tr>
      <tr>
        <td class="tabel_index">&nbsp;</td>
        <td class="tabel_index">TOTAL</td>
        <td class="tabel_index">&nbsp;</td>
        <td class="tabel_index">&nbsp;</td>
        <td class="tabel_index">&nbsp;</td>
        <td class="tabel_index"><input type="text" name="total_wf" id="total_wf" value="<?php $sumwf=$misc+$inst+$fab+$eng+$proc; echo  number_format($sumwf); ?>" readonly="readonly"/> </td>
        <td class="tabel_index">&nbsp;</td>
      </tr>
      <tr>
  <?php $i=$i+1; ?>
  <td colspan="7" class="tabel_index"><input type="submit" name="submit" id="submit" value="Submit" /></td>
        </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_insert" value="form1" />
    </form></td></tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
