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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_wpr_corecomulative (id_headerwpr, id_jenis, tanggal, eng_services, proj_services, material_civ, material_pip, material_elect, fab_act, painting, ndt, inst_civ, inst_pip, inst_elect, pers_dayrate, equipt_dayrate, landtransport) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_headerwpr'], "text"),
                       GetSQLValueString($_POST['jenisid2'], "int"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['eng_services'], "double"),
                       GetSQLValueString($_POST['proj_services'], "double"),
                       GetSQLValueString($_POST['material_civ'], "double"),
                       GetSQLValueString($_POST['material_pip'], "double"),
                       GetSQLValueString($_POST['material_elect'], "double"),
                       GetSQLValueString($_POST['fab_act'], "double"),
                       GetSQLValueString($_POST['painting'], "double"),
                       GetSQLValueString($_POST['ndt'], "double"),
                       GetSQLValueString($_POST['inst_civ'], "double"),
                       GetSQLValueString($_POST['inst_pip'], "double"),
                       GetSQLValueString($_POST['inst_elect'], "double"),
                       GetSQLValueString($_POST['pers_dayrate'], "double"),
                       GetSQLValueString($_POST['equipt_dayrate'], "double"),
                       GetSQLValueString($_POST['landtransport'], "double"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pr_wpr_comulative SET cumm_actual_e1=%s, cumm_actual_p2=%s, cumm_actual_f3=%s, cumm_actual_i4=%s, cumm_actual_m5=%s WHERE id_headerwpr=%s AND id_wpr_tanggal=%s",
                       GetSQLValueString($_POST['eng2'], "double"),
                       GetSQLValueString($_POST['proc2'], "double"),
                       GetSQLValueString($_POST['fab2'], "double"),
                       GetSQLValueString($_POST['inst2'], "double"),
                       GetSQLValueString($_POST['misc2'], "double"),
                       GetSQLValueString($_POST['idwprheader'], "text"),
                       GetSQLValueString($_POST['idtanggal'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM pr_wpr_tanggal WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset12 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset12 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset12 = sprintf("SELECT pr_wpr_tanggal.id, pr_wpr_tanggal.id_headerwpr, pr_wpr_tanggal.tanggal, pr_header_wpr.id, pr_header_wpr.project_title, pr_header_wpr.description, pr_header_wpr.contract_no, pr_header_wpr.wo_no, pr_header_wpr.aff_no, pr_header_wpr.const_eng, pr_header_wpr.pic_name, pr_header_wpr.ctr_approval, pr_header_wpr.type_ofwork, pr_header_wpr.ctr_reqd, pr_header_wpr.cutofdate FROM pr_wpr_tanggal, pr_header_wpr WHERE pr_wpr_tanggal.id = %s AND pr_header_wpr.id=pr_wpr_tanggal.id_headerwpr", GetSQLValueString($colname_Recordset12, "int"));
$Recordset12 = mysql_query($query_Recordset12, $core) or die(mysql_error());
$row_Recordset12 = mysql_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysql_num_rows($Recordset12);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM pr_wpr_corecomulative WHERE tanggal = %s AND pr_wpr_corecomulative.id_jenis=2 ", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM pr_wpr_comulative WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_corecomulativeplan = "-1";
if (isset($_GET['data'])) {
  $colname_corecomulativeplan = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_corecomulativeplan = sprintf("SELECT * FROM pr_wpr_corecomulative WHERE tanggal = %s  AND pr_wpr_corecomulative.id_jenis=1", GetSQLValueString($colname_corecomulativeplan, "text"));
$corecomulativeplan = mysql_query($query_corecomulativeplan, $core) or die(mysql_error());
$row_corecomulativeplan = mysql_fetch_assoc($corecomulativeplan);
$totalRows_corecomulativeplan = mysql_num_rows($corecomulativeplan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h2 align="center">Input Actual</h2>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="406" border="0" cellpadding="2" cellspacing="1">
  <tr class="tabel_header">
    <td width="27">No.</td>
    <td width="283">Description</td>
    <td width="80">Actual</td>
    <td width="80">Plan</td>
  </tr>
  <tr class="header_description">
    <td class="header_description">I.</td>
    <td class="header_description">Engineering</td>
    <td class="header_description" align="center"><input type="hidden" style="border:thin" name="eng" id="eng" value="<?php echo $row_Recordset3['cumm_actual_e1']; ?>" /><?php echo $row_Recordset3['cumm_actual_e1']; ?></td>
    <td class="header_description" align="center"><?php echo $row_Recordset3['cumm_plan_e1']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">I.A.</td>
    <td class="tabel_body">Engineering Services</td>
    <td class="number_mkt" align="center"><input name="eng_services" type="text" style="border:thin" id="eng_services" value="<?php echo $row_Recordset2['eng_services']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[eng_services]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">I.B.</td>
    <td class="tabel_body">Project Services</td>
    <td class="number_mkt" align="center"><input name="proj_services" type="text" style="border:thin" id="proj_services" value="<?php echo $row_Recordset2['proj_services']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[proj_services]; ?></td>
  </tr>
  <tr>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
  </tr>
  <tr class="header_description">
    <td class="header_description">II.</td>
    <td class="header_description">Procurement</td>
    <td class="header_description" align="center"><input name="proc" type="hidden" style="border:thin" id="proc" value="<?php echo $row_Recordset3['cumm_actual_p2']; ?>" size="10" /><?php echo $row_Recordset3['cumm_actual_p2']; ?></td>
    <td class="header_description" align="center"><?php echo $row_Recordset3['cumm_plan_p2']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td>II.A.</td>
    <td>Material For Civil &amp; Structure</td>
    <td align="center"><input name="material_civ" type="text" style="border:thin" id="material_civ" value="<?php echo $row_Recordset2['material_civ']; ?>" size="10" /></td>
    <td align="center"><?php echo $row_corecomulativeplan[material_civ]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="number_mkt">II.B.</td>
    <td class="number_mkt">Material For Piping</td>
    <td align="center" class="number_mkt"><input name="material_pip" type="text" style="border:thin" id="material_pip" value="<?php echo $row_Recordset2['material_pip']; ?>" size="10" /></td>
    <td align="center" class="number_mkt"><?php echo $row_corecomulativeplan[material_pip]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td>II.C.</td>
    <td>Material For Electrical &amp; Instrument</td>
    <td align="center"><input name="material_elect" type="text" style="border:thin" id="material_elect" value="<?php echo $row_Recordset2['material_elect']; ?>" size="10" /></td>
    <td align="center"><?php echo $row_corecomulativeplan[material_elect]; ?></td>
  </tr>
  <tr>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
  </tr>
  <tr class="header_description">
    <td class="header_description">III.</td>
    <td class="header_description">Fabrication</td>
    <td class="header_description" align="center"><input type="hidden" style="border:thin" name="fab" id="fab" value="<?php echo $row_Recordset3['cumm_actual_f3']; ?>" size="10" /><?php echo $row_Recordset3['cumm_actual_f3']; ?></td>
    <td class="header_description" align="center"><?php echo $row_Recordset3['cumm_plan_f3']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">III.A.</td>
    <td class="tabel_body">Fabrication Activities</td>
    <td class="number_mkt" align="center"><input name="fab_act" type="text" style="border:thin" id="fab_act" value="<?php echo $row_Recordset2['fab_act']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[fab_act]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">III.B.</td>
    <td class="tabel_body">Painting &amp; Sand Blasting Activities</td>
    <td class="number_mkt" align="center"><input name="painting" type="text" style="border:thin" id="painting" value="<?php echo $row_Recordset2['painting']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[painting]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">III.C.</td>
    <td class="tabel_body">NDT</td>
    <td class="number_mkt" align="center"><input name="ndt" type="text" style="border:thin" id="ndt" value="<?php echo $row_Recordset2['ndt']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[ndt]; ?></td>
  </tr>
  <tr>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
  </tr>
  <tr class="header_description">
    <td class="header_description">IV.</td>
    <td class="header_description">Installation</td>
    <td class="header_description" align="center"><input type="hidden" style="border:thin" name="inst" id="inst" value="<?php echo $row_Recordset3['cumm_actual_i4']; ?>" size="10" /><?php echo $row_Recordset3['cumm_actual_i4']; ?></td>
    <td class="header_description" align="center"><?php echo $row_Recordset3['cumm_plan_i4']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">IV.A.</td>
    <td class="tabel_body">Installation For Civil &amp; Structure</td>
    <td class="number_mkt" align="center"><input name="inst_civ" type="text" style="border:thin" id="inst_civ" value="<?php echo $row_Recordset2['inst_civ']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[inst_civ]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">IV.B.</td>
    <td class="tabel_body">Installation for Piping</td>
    <td class="number_mkt" align="center"><input name="inst_pip" type="text" style="border:thin" id="inst_pip" value="<?php echo $row_Recordset2['inst_pip']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[inst_pip]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">IV.C.</td>
    <td class="tabel_body">Installation For Electrical &amp; Instrument</td>
    <td class="number_mkt" align="center"><input name="inst_elect" type="text" style="border:thin" id="inst_elect" value="<?php echo $row_Recordset2['inst_elect']; ?>" size="10" /></td>
    <td class="number_mkt" align="center"><?php echo $row_corecomulativeplan[inst_elect]; ?></td>
  </tr>
  <tr>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
    <td class="tabel_index">&nbsp;</td>
  </tr>
  <tr class="header_description">
    <td>V.</td>
    <td>Miscellanous</td>
    <td class="header_description" align="center"><input type="hidden" style="border:thin" name="misc" id="misc" value="<?php echo $row_Recordset3['cumm_actual_m5']; ?>"size="10" /><?php echo $row_Recordset3['cumm_actual_m5']; ?></td>
    <td class="header_description" align="center"><?php echo $row_Recordset3['cumm_plan_m5']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">V.A.</td>
    <td class="tabel_body">Personal Day Rate</td>
    <td align="center" class="number_mkt"><input name="pers_dayrate" type="text" style="border:thin" id="pers_dayrate" value="<?php echo $row_Recordset2['pers_dayrate']; ?>" size="10" /></td>
    <td align="center" class="number_mkt"><?php echo $row_corecomulativeplan[pers_dayrate]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">V.B.</td>
    <td class="tabel_body">Equipment Day Rate</td>
    <td align="center" class="number_mkt"><input name="equipt_dayrate" type="text" style="border:thin" id="equipt_dayrate" value="<?php echo $row_Recordset2['equipt_dayrate']; ?>" size="10" /></td>
    <td align="center" class="number_mkt"><?php echo $row_corecomulativeplan[equipt_dayrate]; ?></td>
  </tr>
  <tr class="tabel_body">
    <td class="tabel_body">V.C.</td>
    <td class="tabel_body">Land Transportation</td>
    <td align="center" class="number_mkt"><input name="landtransport" type="text" style="border:thin" id="landtransport" value="<?php echo $row_Recordset2['landtransport']; ?>" size="10" /></td>
    <td align="center" class="number_mkt"><?php echo $row_corecomulativeplan[landtransport]; ?></td>
  </tr>
  <tr class="tabel_header">
    <td class="tabel_header">&nbsp;</td>
    <td class="tabel_header">TOTAL</td>
    <td class="tabel_header"><input type="text" style="border:thin" name="total" id="total" value="<?php $allcum= $row_Recordset3['cumm_actual_e1']+$row_Recordset3['cumm_actual_p2']+$row_Recordset3['cumm_actual_f3']+$row_Recordset3['cumm_actual_i4']+$row_Recordset3['cumm_actual_m5']; echo number_format($allcum,2); ?>" size="10" /></td>
    <td class="tabel_header"><?php $allcum1= $row_Recordset3['cumm_plan_e1']+$row_Recordset3['cumm_plan_p2']+$row_Recordset3['cumm_plan_f3']+$row_Recordset3['cumm_plan_i4']+$row_Recordset3['cumm_plan_m5']; echo number_format($allcum1,2); ?></td>
  </tr>
  <tr>
    <?php $i=$i+1; ?>
    <td class=""><input type="hidden" name="jenisid2" value="2" /></td>
    <td class=""><input name="tanggal" type="hidden" id="tanggal" value="<?php echo $row_Recordset1['id']; ?>" /></td>
    <td class=""><input type="hidden" name="id_headerwpr" id="id_headerwpr" value="<?php echo $row_Recordset12['id_headerwpr']; ?>      " /></td>
    <td class="">&nbsp;</td>
  </tr>
</table>
<input type="submit" name="submit" id="submit" value="Submit" />
<input type="hidden" name="MM_insert" value="form1" />
</form>
<form action="<?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
  <p align="right">
    <input name="submit2" type="submit" id="submit2" value="Refresh"  />
    <input type="hidden" name="misc2" id="misc2" value="<?php $misc=$_POST[pers_dayrate]+$_POST[equipt_dayrate]+$_POST[landtransport]; echo $misc ?>"/>
    <input type="hidden" name="inst2" id="inst2" value="<?php $inst=$_POST[inst_civ]+$_POST[inst_pip]+$_POST[inst_elect]; echo $inst ?>" />
    <input type="hidden" name="fab2" id="fab2" value="<?php $fab=$_POST[fab_act]+$_POST[painting]+$_POST[ndt]; echo $fab ?>" />
    <input name="proc2" type="hidden" id="proc2" value="<?php $proc=$_POST[$material_civ]+$_POST[material_pip]+$_POST[material_elect]; echo $proc ?>" />
    <input type="hidden" name="eng2" id="eng2" value="<?php $eng=$_POST[eng_services]+$_POST[proj_services]; echo $eng ?>" />
    <input type="hidden" name="allcum" id="allcum" value="<?php $allcum=$_POST[eng2]+$_POST[proc2]+$_POST[fab2]+$_POST[inst2]+$_POST[misc2]; echo $allcum ?>" />
  </p>
<input type="hidden" name="jenisid" value="1" />
<input type="hidden" name="idtanggal" value="<?php echo $row_Recordset1['id']; ?>" />
<input type="hidden" name="idwprheader" value="<?php echo $row_Recordset12['id_headerwpr']; ?>" />
<input type="hidden" name="MM_update" value="form2" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset12);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($corecomulativeplan);
?>
