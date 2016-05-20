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
  $insertSQL = sprintf("INSERT INTO c_ctr_detailklo (idctr, drawingnumber, afecc, engineeringservices, projectservices, structurestotalmaterialsupply, structurestotalfabrication, structurestotalinstallation, structurestotalpainting, pipingtotalmaterialsupply, pipingtotalfabrication, pipingtotalinstallation, pipingtotalpainting, electricaltotalmaterialsupply, electricaltotalinstallation, instrumentationtotalmaterialsupply, instrumentationtotalinstallation, pwht, ndt, landtransportation, civilwork, personeldayrate, equipmentdayrate, totalwovalue) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idctr2'], "int"),
                       GetSQLValueString($_POST['drawingnumber'], "text"),
                       GetSQLValueString($_POST['afecc'], "text"),
                       GetSQLValueString($_POST['angka1'], "double"),
                       GetSQLValueString($_POST['angka2'], "double"),
                       GetSQLValueString($_POST['angka3'], "double"),
                       GetSQLValueString($_POST['angka4'], "double"),
                       GetSQLValueString($_POST['angka5'], "double"),
                       GetSQLValueString($_POST['angka6'], "double"),
                       GetSQLValueString($_POST['angka7'], "double"),
                       GetSQLValueString($_POST['angka8'], "double"),
                       GetSQLValueString($_POST['angka9'], "double"),
                       GetSQLValueString($_POST['angka10'], "double"),
                       GetSQLValueString($_POST['angka11'], "double"),
                       GetSQLValueString($_POST['angka12'], "double"),
                       GetSQLValueString($_POST['angka13'], "double"),
                       GetSQLValueString($_POST['angka14'], "double"),
                       GetSQLValueString($_POST['angka15'], "double"),
                       GetSQLValueString($_POST['angka16'], "double"),
                       GetSQLValueString($_POST['angka17'], "double"),
                       GetSQLValueString($_POST['angka18'], "double"),
                       GetSQLValueString($_POST['angka19'], "double"),
                       GetSQLValueString($_POST['angka20'], "double"),
                       GetSQLValueString($_POST['jumlah'], "double"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pr_wbs_cost (id_ctr, id_wpr_header, eng_services, proj_services, material_civ_structure, material_piping, material_electrical_inst, fab_activities, painting_sandblastactivities, ndt, inst_civil_structure, inst_piping, inst_electric_inst, personal_dayrate, equip_dayrate, land_transportation, totalcost) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idctr2'], "int"),
                       GetSQLValueString($_POST['id_header_wpr'], "int"),
                       GetSQLValueString($_POST['engineeringservices'], "double"),
                       GetSQLValueString($_POST['projectservices'], "double"),
                       GetSQLValueString($_POST['material_civ_structure'], "double"),
                       GetSQLValueString($_POST['material_piping'], "double"),
                       GetSQLValueString($_POST['material_electrical_inst'], "double"),
                       GetSQLValueString($_POST['fab_activities'], "double"),
                       GetSQLValueString($_POST['painting_sandblastactivities'], "double"),
                       GetSQLValueString($_POST['ndt'], "double"),
                       GetSQLValueString($_POST['inst_civil_structure'], "double"),
                       GetSQLValueString($_POST['inst_piping'], "double"),
                       GetSQLValueString($_POST['inst_electric_inst'], "double"),
                       GetSQLValueString($_POST['personal_dayrate'], "double"),
                       GetSQLValueString($_POST['equip_dayrate'], "double"),
                       GetSQLValueString($_POST['land_transportation'], "double"),
                       GetSQLValueString($_POST['jumlah'], "double"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO c_total_ctr (id_ctr, total_eng, total_stuc, total_pipings, total_elect, total_instrument, total_pwht, total_ndt, total_transport, total_civil, total_personel, total_wovalue) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idctr2'], "int"),
                       GetSQLValueString($_POST['total_eng'], "double"),
                       GetSQLValueString($_POST['total_struc'], "double"),
                       GetSQLValueString($_POST['total_pipings'], "double"),
                       GetSQLValueString($_POST['total_elect'], "double"),
                       GetSQLValueString($_POST['total_instrument'], "double"),
                       GetSQLValueString($_POST['total_pwht'], "double"),
                       GetSQLValueString($_POST['total_ndt'], "double"),
                       GetSQLValueString($_POST['transport'], "double"),
                       GetSQLValueString($_POST['total_civil'], "double"),
                       GetSQLValueString($_POST['total_personel'], "double"),
                       GetSQLValueString($_POST['jumlah'], "double"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pr_wbs_cost SET engineering=%s, procurement=%s, fabrication=%s, instalation=%s, miscellanous=%s, totalcost=%s WHERE id_ctr=%s AND id_wpr_header=%s",
                       GetSQLValueString($_POST['engineering'], "double"),
                       GetSQLValueString($_POST['procurement'], "double"),
                       GetSQLValueString($_POST['fabrication'], "double"),
                       GetSQLValueString($_POST['installation'], "double"),
                       GetSQLValueString($_POST['miscellanous'], "double"),
                       GetSQLValueString($_POST['totalcost'], "double"),
                       GetSQLValueString($_POST['id_ctr_wbs'], "int"),
                       GetSQLValueString($_POST['id_header_wpr2'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "inputproductioncode.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM c_ctr_detailklo WHERE idctr = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM c_total_ctr WHERE id_ctr = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM c_ctr WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM pr_wbs_cost WHERE id_ctr = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM pr_header_wpr WHERE idctr = %s", GetSQLValueString($colname_Recordset5, "text"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
$year=date(y);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM pr_header_wpr ORDER BY id DESC LIMIT 1"));
$cekQ=$ceknomor[id];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
<? //eng services ?>
<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){one=document.form1.angka1.value;
					two=document.form1.angka2.value;
						document.form1.engineeringservices.value=(one*1);
						document.form1.projectservices.value=(two*1);
						document.form1.total_eng.value=(one*1)+(two*1)}
function stopCalc(){clearInterval(interval)}
</script>

<? //Structures ?>
<script type="text/javascript">
function startCalcu(){interval=setInterval("calcu()",1)}
function calcu(){one=document.form1.angka3.value;
					two=document.form1.angka4.value;
						three=document.form1.angka5.value;
							four=document.form1.angka6.value;
								five=document.form1.angka10.value;
								document.form1.painting_sandblastactivities.value=(four*1)+(five*1)
								document.form1.total_struc.value=(one*1)+(two*1)+(three*1)+(four*1)}
function stopCalcu(){clearInterval(interval)}
</script>

<? //pipings ?>
<script type="text/javascript">
function startCalcul(){interval=setInterval("calcul()",1)}
function calcul(){one=document.form1.angka7.value;
					two=document.form1.angka8.value;
						three=document.form1.angka9.value;
							four=document.form1.angka10.value;
								five=document.form1.angka4.value;
								document.form1.inst_piping.value=(three*1)
								document.form1.fab_activities.value=(two*1)+(five*1)
								document.form1.material_piping.value=(one*1)
								document.form1.total_pipings.value=(one*1)+(two*1)+(three*1)+(four*1)}
function stopCalcul(){clearInterval(interval)}
</script>

<? //electrict ?>
<script type="text/javascript">
function startCalcula(){interval=setInterval("calcula()",1)}
function calcula(){one=document.form1.angka11.value;
					two=document.form1.angka12.value;
						three=document.form1.angka5.value;
							four=document.form1.angka14.value;
						document.form1.inst_electric_inst.value=(two*1)+(four*1)
						document.form1.total_elect.value=(one*1)+(two*1)
						document.form1.inst_civil_structure.value=(two*1)+(three*1)+(four*1)}
function stopCalcula(){clearInterval(interval)}
</script>

<? //instrument ?>
<script type="text/javascript">
function startCalculat(){interval=setInterval("calculat()",1)}
function calculat(){one=document.form1.angka13.value;
					two=document.form1.angka14.value;
					three=document.form1.angka11.value;
						document.form1.material_electrical_inst.value=(one*1)+(three*1)
						document.form1.total_instrument.value=(one*1)+(two*1)}
function stopCalculat(){clearInterval(interval)}
</script>

<? //pwht ?>
<script type="text/javascript">
function startCalculate(){interval=setInterval("calculate()",1)}
function calculate(){one=document.form1.angka15.value;
						document.form1.total_pwht.value=(one*1)}
function stopCalculate(){clearInterval(interval)}
</script>

<? //ndt ?>
<script type="text/javascript">
function startCalculater(){interval=setInterval("calculater()",1)}
function calculater(){one=document.form1.angka16.value;
						document.form1.ndt.value=(one*1)
						document.form1.total_ndt.value=(one*1)}
function stopCalculater(){clearInterval(interval)}
</script>

<? //transport ?>
<script type="text/javascript">
function startCalculaterz(){interval=setInterval("calculaterz()",1)}
function calculaterz(){one=document.form1.angka17.value;
						document.form1.land_transportation.value=(one*1)
						document.form1.transport.value=(one*1)}
function stopCalculaterz(){clearInterval(interval)}
</script>

<? //civil ?>
<script type="text/javascript">
function startCalculaterzs(){interval=setInterval("calculaterzs()",1)}
function calculaterzs(){one=document.form1.angka18.value;
							two=document.form1.angka3.value;
						document.form1.material_civ_structure.value=(two*1);
						document.form1.total_civil.value=(one*1)}
function stopCalculaterzs(){clearInterval(interval)}
</script>

<? //personel ?>
<script type="text/javascript">
function startCalculaterzsz(){interval=setInterval("calculaterzsz()",1)}
function calculaterzsz(){one=document.form1.angka19.value;
					two=document.form1.angka20.value;
						document.form1.personal_dayrate.value=(one*1)
						document.form1.equip_dayrate.value=(two*1)
						document.form1.total_personel.value=(one*1)+(two*1)}
function stopCalculaterzsz(){clearInterval(interval)}
</script>

<? //JUMLAH ?>
<script type="text/javascript">
function startCal(){interval=setInterval("cal()",1)}
function cal(){one=document.form1.total_eng.value;
					two=document.form1.total_struc.value;
						three=document.form1.total_pipings.value;
							four=document.form1.total_elect.value;
								five=document.form1.total_instrument.value;
									six=document.form1.total_pwht.value;
										seven=document.form1.total_ndt.value;
											eight=document.form1.transport.value;
												nine=document.form1.total_civil.value;
													ten=document.form1.total_personel.value;
								document.form1.jumlah.value=(one*1)+(two*1)+(three*1)+(four*1)+(five*1)+(six*1)+(seven*1)+(eight*1)+(nine*1)+(ten*1)}
function stopCal(){clearInterval(interval)}
</script>

<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
  <table width="606" border="0">
    <tr>
      <td width="68" class="root">Project</td>
      <td width="201" class="contenthdr"><?php echo $row_Recordset1['projecttitle']; ?>
        <input name="projecttitle" type="hidden" value="<?php echo $row_Recordset1['projecttitle']; ?>" /></td>
      <td width="99" class="root">CTR No </td>
      <td width="182" class="contenthdr"><?php echo $row_Recordset1['ctrno']; ?>
        <input name="ctrno" type="hidden" value="<?php echo $row_Recordset1['ctrno']; ?>" /></td>
    </tr>
    <tr>
      <td class="root">PL</td>
      <td class="contenthdr"><?php echo $row_Recordset5['pic_name']; ?></td>
      <td class="root">DATE </td>
      <td class="contenthdr"><?php echo $row_Recordset1['dateest']; ?></td>
    </tr>
    <tr>
      <td class="root">Drawing</td>
      <td class="contenthdr"><input name="drawingnumber" type="text" value="<?php echo $row_Recordset2['drawingnumber']; ?>" /></td>
      <td class="root">CW No</td>
      <td class="contenthdr"><?php echo $row_Recordset1['ctrno']; ?></td>
    </tr>
    <tr>
      <td class="root">AFE/CC</td>
      <td class="contenthdr"><input name="afecc" type="text" value="<?php echo $row_Recordset5['aff_no']; ?>" /></td>
      <td class="root">US $</td>
      <td class="contenthdr"><?php echo $row_Recordset2['totalwovalue']; ?></td>
    </tr>
  </table>
  <table width="606">
    <tr class="tabel_header">
      <td><font size="3">NO</font></td>
      <td><font size="3">DESCRIPTION</font></td>
      <td><font size="3">SUB PRICE (US $)</font></td>
      <td><font size="3">TOTAL PRICE (US $)</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td></td>
      <td><input name="idctr2" type="text" class="hidentext" id="idctr2" value="<?php echo $row_Recordset1['id']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">1</td>
      <td>Engineering Services</td>
      <td>&nbsp;</td>
      <td><input name="total_eng" type="text" style="border:thin" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_eng']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">1.1</td>
      <td>Engineering Services</td>
      <td><input name="angka1" type="text"  onFocus="startCalc();" onBlur="stopCalc();" value="<?php echo $row_Recordset2['engineeringservices']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">1.2</td>
      <td>Project Services</td>
      <td><input name="angka2" type="text"  id="type2" onFocus="startCalc();" onBlur="stopCalc();" value="<?php echo $row_Recordset2['projectservices']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">2</td>
      <td>Structures</td>
      <td>&nbsp;</td>
      <td><input name="total_struc" type="text" style="border:thin"  onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_stuc']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">2.1</td>
      <td>Total Material Supply</td>
      <td><input name="angka3" type="text" onFocus="startCalcu();" onBlur="stopCalcu();" value="<?php echo $row_Recordset2['structurestotalmaterialsupply']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">2.2</td>
      <td>Total Fabrication</td>
      <td><input name="angka4" type="text" onFocus="startCalcu();" onBlur="stopCalcu();" value="<?php echo $row_Recordset2['structurestotalfabrication']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">2.3</td>
      <td>Total Instalation</td>
      <td><input name="angka5" type="text" onFocus="startCalcu();" onBlur="stopCalcu();" value="<?php echo $row_Recordset2['structurestotalinstallation']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">2.4</td>
      <td>Total Painting</td>
      <td><input name="angka6" type="text" onFocus="startCalcu();" onBlur="stopCalcu();" value="<?php echo $row_Recordset2['structurestotalpainting']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">3</td>
      <td>Pipings, Fitting and Valves</td>
      <td>&nbsp;</td>
      <td><input name="total_pipings" type="text" style="border:thin"  onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_pipings']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">3.1</td>
      <td>Total Material Supply</td>
      <td><input name="angka7" type="text" onFocus="startCalcul();" onBlur="stopCalcul();" value="<?php echo $row_Recordset2['pipingtotalmaterialsupply']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3.2</td>
      <td>Total Fabrication</td>
      <td><input name="angka8" type="text" onFocus="startCalcul();" onBlur="stopCalcul();" value="<?php echo $row_Recordset2['pipingtotalfabrication']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3.3</td>
      <td>Total Instalation</td>
      <td><input name="angka9" type="text" onFocus="startCalcul();" onBlur="stopCalcul();" value="<?php echo $row_Recordset2['pipingtotalinstallation']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3.4</td>
      <td>Total Painting</td>
      <td><input name="angka10" type="text" onFocus="startCalcul();" onBlur="stopCalcul();" value="<?php echo $row_Recordset2['pipingtotalpainting']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">4</td>
      <td>Electrical</td>
      <td>&nbsp;</td>
      <td><input name="total_elect"  type="text" style="border:thin" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_elect']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">4.1</td>
      <td>Total Material Supply</td>
      <td><input name="angka11" type="text" onFocus="startCalcula();" onBlur="stopCalcula();" value="<?php echo $row_Recordset2['electricaltotalmaterialsupply']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">4.2</td>
      <td>Total Installation</td>
      <td><input name="angka12" type="text" onFocus="startCalcula();" onBlur="stopCalcula();" value="<?php echo $row_Recordset2['electricaltotalinstallation']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">5</td>
      <td>Instrumentation</td>
      <td>&nbsp;</td>
      <td><input name="total_instrument" style="border:thin"  type="text" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_instrument']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">5.1</td>
      <td>Total Material Suply</td>
      <td><input name="angka13" type="text" onFocus="startCalculat();" onBlur="stopCalculat();" value="<?php echo $row_Recordset2['instrumentationtotalmaterialsupply']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">5.2</td>
      <td>Total Installation</td>
      <td><input name="angka14" type="text" onFocus="startCalculat();" onBlur="stopCalculat();" value="<?php echo $row_Recordset2['instrumentationtotalinstallation']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">6</td>
      <td>PWHT</td>
      <td></td>
      <td><input name="total_pwht"  type="text" style="border:thin" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_pwht']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="angka15" type="text" onFocus="startCalculate();" onBlur="stopCalculate();" value="<?php echo $row_Recordset2['pwht']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">7</td>
      <td>NDT</td>
      <td>&nbsp;</td>
      <td><input name="total_ndt"  type="text" style="border:thin" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_ndt']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="angka16" type="text" onFocus="startCalculater();" onBlur="stopCalculater();" value="<?php echo $row_Recordset2['ndt']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center">8</td>
      <td>Transportation</td>
      <td>&nbsp;</td>
      <td><input name="transport"  type="text" style="border:thin" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_transport']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">8.1</td>
      <td>Land Transportation</td>
      <td><input name="angka17" type="text" onfocus="startCalculaterz();" onblur="stopCalculaterz();" value="<?php echo $row_Recordset2['landtransportation']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td class="tabel_header" align="center">9</td>
      <td class="tabel_header">Civil Work</td>
      <td class="tabel_header">&nbsp;</td>
      <td class="tabel_header"><input name="total_civil" style="border:thin"  type="text" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_civil']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="angka18" type="text" onfocus="startCalculaterzs();" onblur="stopCalculaterzs();" value="<?php echo $row_Recordset2['civilwork']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td align="center"  class="tabel_header">10</td>
      <td class="tabel_header">Personel &amp; Equipment Day Rate</td>
      <td class="tabel_header">&nbsp;</td>
      <td class="tabel_header"><input name="total_personel"  style="border:thin" type="text" onFocus="startCal();" onBlur="stopCal();" value="<?php echo $row_Recordset3['total_personel']; ?>" /></td>
    </tr>
    <tr>
      <td align="center">10.1</td>
      <td>Personel Day Rate</td>
      <td><input name="angka19" type="text" onfocus="startCalculaterzsz();" onblur="stopCalculaterzsz();" value="<?php echo $row_Recordset2['personeldayrate']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">10.2</td>
      <td>Equipment Day Rate</td>
      <td><input name="angka20" type="text" onfocus="startCalculaterzsz();" onblur="stopCalculaterzsz();" value="<?php echo $row_Recordset2['equipmentdayrate']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F60">
      <td></td>
      <td>CTR Validity : 60 Days</td>
      <td align="right">Total WO Value</td>
      <td align="center"><input name="jumlah" type="text" style="border:thin" value="<?php echo $row_Recordset2['totalwovalue']; ?>" /></td>
    </tr>
</table>
  <input type="hidden" name="id_header_wpr" id="id_header_wpr" value="<?php echo $next ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
  <p align="center"><input type="submit" name="submit" id="submit" value="Insert WO Value" /></p>
<p>
  <input type="hidden" value="" name="engineeringservices" />
  <input type="hidden" value="" name="projectservices" />
  <input type="hidden" value="" name="material_civ_structure"  />
  <input type="hidden" name="material_piping" value="" />
  <input type="hidden" value="" name="material_electrical_inst" />
  <input type="hidden" name="fab_activities" id="fab_activities" value="" />
  <input type="hidden" name="painting_sandblastactivities" id="painting_sandblastactivities" value=""/>
  <input type="hidden" name="ndt" id="ndt" value="" />
  <input type="hidden" name="inst_civil_structure" id="inst_civil_structure" value="" />
  <input type="hidden" name="inst_piping" id="inst_piping" value="" />
  <input type="hidden" name="inst_electric_inst" id="inst_electric_inst" value="" />
  <input type="hidden" value="" name="personal_dayrate" />
  <input type="hidden" value="" name="land_transportation" />
  <input type="hidden" value="" name="equip_dayrate" />
</p>
</form>
<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <input name="totalcost" type="hidden" class="" id="totalcost" value="<? $totalcost=$row_Recordset4['eng_services']+$row_Recordset4['proj_services']+$row_Recordset4['material_civ_structure']+$row_Recordset4['material_piping']+$row_Recordset4['material_electrical_inst']+$row_Recordset4['fab_activities']+$row_Recordset4['painting_sandblastactivities']+$row_Recordset4['ndt']+$row_Recordset4['inst_civil_structure']+$row_Recordset4['inst_piping']+$row_Recordset4['inst_civil_structure']+$row_Recordset4['inst_piping']+$row_Recordset4['inst_electric_inst']+$row_Recordset4['personal_dayrate']+$row_Recordset4['equip_dayrate']+$row_Recordset4['land_transportation']; echo $totalcost ?>" />
  <input name="engineering" type="hidden" class="" id="engineering" value="<? $eng=$row_Recordset4[eng_services]+$row_Recordset4[proj_services]; echo $eng ?>" />
  <input name="procurement" type="hidden" class="" id="procurement" value="<? $proc=$row_Recordset4['material_civ_structure']+$row_Recordset4['material_piping']+$row_Recordset4['material_electrical_inst']; echo $proc  ?>" />
  <input type="hidden" name="fabrication" id="fabrication" value="<? $fab=$row_Recordset4[fab_activities]+$row_Recordset4[painting_sandblastactivities]+$row_Recordset4[ndt]; echo $fab ?>" />
  <input name="installation" type="hidden" class="" id="installation" value="<? $inst=$row_Recordset4[inst_civil_structure]+$row_Recordset4[inst_piping]+$row_Recordset4[inst_electric_inst]; echo $inst ?>" />
  <input name="miscellanous" type="hidden" class="" id="miscellanous" value="<? $misc=$row_Recordset4[personel_dayrate]+$row_Recordset4[land_transportation]+$row_Recordset4[equip_dayrate]; echo $misc ?>" />
  <p align="center"><input type="submit" name="submit2" id="submit2" value="Next" /></p>
  <input name="id_ctr_wbs" type="hidden" id="id_ctr_wbs" value="<?php echo $row_Recordset1['id']; ?>" />
  <input type="hidden" name="id_header_wpr2" id="id_header_wpr2" value="<?php echo $next ?>" />
  <input type="hidden" name="MM_update" value="form2" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset1);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
