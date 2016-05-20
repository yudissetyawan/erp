<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrator,branchmanager,project";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/home.php?pesan=Sorry You re not Alowed to access Project Section";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

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
  $insertSQL = sprintf("INSERT INTO a_crf (idms, nocrf, jobtitle, qty, `date`, customer, projectcode, productioncode, name, `ref`, datw, reference, others, drawingsketch, suppliedmaterial, otherstermsandcondition, preparedby, approvedby, clientverivication, marketing, commercial, quality, hse, engineering, procurement, production, fabrication, hrd, acc, maintenance, it, siteproject, `file`, issueddate, fileupload) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idms'], "int"),
                       GetSQLValueString($_POST['nocrf'], "text"),
                       GetSQLValueString($_POST['jobtitle'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['productioncode'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['datw'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['others'], "text"),
                       GetSQLValueString($_POST['drawingsketch'], "int"),
                       GetSQLValueString($_POST['suppliedmaterial'], "int"),
                       GetSQLValueString($_POST['otherstermsandcondition'], "text"),
                       GetSQLValueString($_POST['prepareby'], "int"),
                       GetSQLValueString($_POST['approvedby'], "int"),
                       GetSQLValueString($_POST['clientverivication'], "int"),
                       GetSQLValueString(isset($_POST['marketing']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['commercial']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['quality']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['hse']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['engineering']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['procurement']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['production']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['fabrication']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['hrd']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['acc']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['maintenance']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['it']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['siteproject']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['file']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['issueddate'], "text"),
                       GetSQLValueString($_POST['fileupload'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "form_project.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO a_crf_schedulle (crf, designstart, designend, drawingstart, drawingend, itpstart, itpend, materialstart, materialend, fabricationstart, fabricationend, testingstart, testingend, blastingpaintingstart, blastingpaintingend, instalationstart, instalationend, deliverystart, deliveryend, other1, other2, other3, other4, other1start, other1end, other2start, other2end, other3start, other3end, other4start, other4end) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nocrf'], "text"),
                       GetSQLValueString($_POST['designstart'], "text"),
                       GetSQLValueString($_POST['designend'], "text"),
                       GetSQLValueString($_POST['drawingstart'], "text"),
                       GetSQLValueString($_POST['drawingend'], "text"),
                       GetSQLValueString($_POST['itpstart'], "text"),
                       GetSQLValueString($_POST['itpend'], "text"),
                       GetSQLValueString($_POST['materialstart'], "text"),
                       GetSQLValueString($_POST['materialend'], "text"),
                       GetSQLValueString($_POST['fabricationstart'], "text"),
                       GetSQLValueString($_POST['fabricationend'], "text"),
                       GetSQLValueString($_POST['testingstart'], "text"),
                       GetSQLValueString($_POST['testingend'], "text"),
                       GetSQLValueString($_POST['blastingpaintingstart'], "text"),
                       GetSQLValueString($_POST['blastingpaintingend'], "text"),
                       GetSQLValueString($_POST['instalationstart'], "text"),
                       GetSQLValueString($_POST['instalationend'], "text"),
                       GetSQLValueString($_POST['deliverystart'], "text"),
                       GetSQLValueString($_POST['deliveryend'], "text"),
                       GetSQLValueString($_POST['other1'], "text"),
                       GetSQLValueString($_POST['other2'], "text"),
                       GetSQLValueString($_POST['other3'], "text"),
                       GetSQLValueString($_POST['other4'], "text"),
                       GetSQLValueString($_POST['other1start'], "text"),
                       GetSQLValueString($_POST['other1end'], "text"),
                       GetSQLValueString($_POST['other2start'], "text"),
                       GetSQLValueString($_POST['other2end'], "text"),
                       GetSQLValueString($_POST['other3start'], "text"),
                       GetSQLValueString($_POST['other3end'], "text"),
                       GetSQLValueString($_POST['other4start'], "text"),
                       GetSQLValueString($_POST['other4end'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "form_project.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE a_production_code SET `date`=%s, statuscrf=%s WHERE productioncode=%s",
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString(isset($_POST['statuscrf']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['productioncode'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}
/* OPEN THIS COMMENT
//NOTIF FOR OTHER BRANCHMANAGER
$chosenapprover = $_POST['approvedby'];
mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$chosenapprover'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

mysql_select_db($database_core, $core);
$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.userlevel = 'branchmanager' AND h_employee.id <> '$chosenapprover' OR h_employee.userlevel = 'administrator' OR h_employee.department = 'Project'";
$rsemployeedept = mysql_query($query_rsemployeedept, $core) or die(mysql_error());
$row_rsemployeedept = mysql_fetch_assoc($rsemployeedept);
$totalRows_rsemployeedept = mysql_num_rows($rsemployeedept);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$no_crf = $_POST['nocrf'];
	$job_title = $_POST['jobtitle'];
	//$issued_date = $_POST['issueddate'];
	$approverfname = $row_rsapprovedby['fname'];
	$approvermname = $row_rsapprovedby['mname'];
	$approverlname = $row_rsapprovedby['lname'];
	$isipsn = "CRF No. : $no_crf , Job Title : $job_title is waiting for approval by $approverfname $approvermname $approverlname";
	
	do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString('52', "int"),
						   GetSQLValueString($no_crf, "text"),
						   GetSQLValueString($row_rsemployeedept['empID'], "int"),
						   GetSQLValueString($isipsn, "text"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	}
	while ($row_rsemployeedept = mysql_fetch_assoc($rsemployeedept));
	
	//NOTIF APPROVAL (SAVE IN TBL LOG_PESAN)
	$ceknomor = mysql_fetch_array(mysql_query("SELECT id FROM a_crf ORDER BY id DESC LIMIT 1"));
	$idcrf = $ceknomor['id'];
	
	$isipsn2 = "CRF No. : $no_crf , Job Title : $job_title need your approval";
	$goto = "../tm/crf_approval.php?data=$idcrf";
	
	$insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto, id_msgcat) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString('52', "int"),
						   GetSQLValueString($idcrf, "text"),
						   GetSQLValueString($chosenapprover, "int"),
						   GetSQLValueString($isipsn2, "text"),
						   GetSQLValueString($goto, "text"),
						   GetSQLValueString('3', "text"));
	
	mysql_select_db($database_core, $core);
	$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
		
	echo "<script>
			alert(\"CRF No : $no_crf has been issued and waiting for approval by $approverfname $approvermname $approverlname\");
			document.location=\"form_project.php\";
			parent.window.location.reload(true);
		</script>";
}
*/

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM e_drawing_file ORDER BY id ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM e_bom_file ORDER BY id ASC";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset7 = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.userlevel FROM h_employee WHERE h_employee.userlevel = 'branchmanager'";
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$usrid = $_SESSION['MM_Username'];
mysql_select_db($database_core, $core);
$query_rsuser = "SELECT h_employee.id, h_employee.username FROM h_employee WHERE h_employee.username = '$usrid'";
$rsuser = mysql_query($query_rsuser, $core) or die(mysql_error());
$row_rsuser = mysql_fetch_assoc($rsuser);
$totalRows_rsuser = mysql_num_rows($rsuser);

$vendor = $row_Recordset1['vendor'];
mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT a_contactperson.* FROM a_contactperson WHERE a_contactperson.customer='$vendor'";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);


$date = date(my);
$cari = $row_Recordset1['projectcode'];

 // cari panjang max dari string yg di dapat dari query
$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM a_crf WHERE projectcode LIKE '%$cari%' ORDER BY nocrf DESC LIMIT 1"));
$cekQ = $ceknomor[nocrf];
$prod = $row_Recordset1['productioncode'];

#menghilangkan huruf
$awalQ = substr($cekQ,0,3);
#ketemu angka awal(angka sebelumnya) + dengan 1
$next = (int)$awalQ+1;
$nextcrf = sprintf ("%03d", $next).'-'.$cari.'-'.$prod.'-'.$date;
#Memasukkan Nilai IDMS
$cekidms = mysql_fetch_array(mysql_query("SELECT * FROM a_crf ORDER BY idms DESC LIMIT 1 "));
$cekidQ = $cekidms[idms];
#(angka sebelumnya) + dengan 1
$idms = $cekidQ + 1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input CRF</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body class="General">

<?php
include "../date.php";
include "date.php";

    // requires the class
    require "../menu_assets/class.datepicker.php";
    
    // instantiate the object
    $db=new datepicker();
    
    // uncomment the next line to have the calendar show up in german
    //$db->language = "dutch";
    
    $db->firstDayOfWeek = 1;

    // set the format in which the date to be returned
    $db->dateFormat = "Y-m-d";
?>

<?php { include "uploadcrf.php"; } ?>
<br /><br />
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="993" border="0">
    <tr>
      <td width="174">No CRF</td>
      <td width="13">:</td>
      <td colspan="6"><label for="nocrf9"></label>
      <input name="nocrf" type="text" id="nocrf3" value="<?php echo $nextcrf; ?>" readonly="readonly" />
      <input name="idms" type="hidden" id="idms" value=<?php echo idms; ?> />      <label>
        <input name="id_a_production_code" type="text" class="hidentext" id="id_a_production_code" value="<?php echo $row_Recordset1['id']; ?>" />
      </label></td>
    </tr>
    <tr>
      <td rowspan="3">Distribution List</td>
      <td rowspan="3">:</td>
      <td width="81"><input name="marketing" type="checkbox" id="marketing" value="1" />
        Marketing</td>
      <td width="105"><input name="quality" type="checkbox" id="quality" value="1" />
        Quality </td>
      <td width="113"><input name="procurement" type="checkbox" id="procurement" value="1"  />
        Procurement</td>
      <td width="185"><input name="hrd" type="checkbox" id="hrd" value="1" />
        HRD </td>
      <td width="144"><input name="it" type="checkbox" id="it" value="1" />
        IT</td>
      <td width="144">&nbsp;</td>
    </tr>
    <tr>
      <td><input name="commercial" type="checkbox" id="commercial" value="1" />
        Commercial</td>
      <td><input name="hse" type="checkbox" id="hse" value="1" />
        HSE</td>
      <td><input name="production" type="checkbox" id="production" value="1" />
        PPIC</td>
      <td><input name="acc" type="checkbox" id="acc" value="1" />
        Accounting</td>
      <td><input name="siteproject" type="checkbox" id="siteproject" value="1" />
        Site Project</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="engineering" type="checkbox" id="engineering" value="1" />
        Engineering</td>
      <td><input name="fabrication" type="checkbox" id="fabrication" value="1" />
        Fabrication</td>
      <td><input type="checkbox" name="maintenance" id="maintenance" value="1"/>
        Maintenance</td>
      <td><input type="checkbox" name="file" id="file" value="1" />
        DCC</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="5">Job Title</td>
      <td rowspan="5">:</td>
      <td colspan="3" rowspan="5"><label for="jobtitle"></label>
      <textarea name="jobtitle" id="jobtitle" cols="45" rows="5" class="General"><?php echo $row_Recordset1['projecttitle']; ?></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="judul"><b>Tipe Pekerjaan</b></td>
      <td class="judul"><b>Start Date</b></td>
      <td class="judul"><b>Finish Date</b></td>
    </tr>
    <tr>
      <td>QTY</td>
      <td>:</td>
      <td colspan="3"><label for="qty"></label>
      <span id="sprytextfield1">
      <input type="text" name="qty" id="qty" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td width="185">Design</td>
      <td width="144"><span id="sprytextfield4">
        <input name="designstart" type="text" class="required" id="tanggal27" title="Date is required" />
      </span></td>
      <td width="144"><span id="sprytextfield5">
        <input name="designend" type="text" class="required" id="tanggal28" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td colspan="3"><span id="sprytextfield2">
        <input name="date" id="tanggal1" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>Drawing</td>
      <td><span id="sprytextfield6">
        <input name="drawingstart" type="text" class="required" id="tanggal3" title="Date is required" />
</span></td>
      <td><span id="sprytextfield7">
        <input name="drawingend" type="text" class="required" id="tanggal4" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td>Project Code - Production Code - Customer</td>
      <td>:</td>
      <td colspan="3"><?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['productioncode']; ?> - <?php echo $row_Recordset1['vendor']; ?>
        <label for="productioncode">
          <input name="projectcode" type="hidden" id="project" value="<?php echo $row_Recordset1['projectcode']; ?>" size="6" readonly="readonly" />
          <input name="productioncode" type="hidden" id="productioncode" value="<?php echo $row_Recordset1['productioncode']; ?>" size="5" readonly="readonly" />
          <input name="customer" type="hidden" id="customer" value="<?php echo $row_Recordset1['vendor']; ?>" readonly="readonly" />
      </label></td>
      <td>ITP</td>
      <td><span id="sprytextfield8">
        <input name="itpstart" type="text" class="required" id="tanggal5" title="Date is required" />
</span></td>
      <td><span id="sprytextfield9">
        <input name="itpend" type="text" class="required" id="tanggal6" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>Material</td>
      <td><span id="sprytextfield10">
        <input name="materialstart" type="text" class="required" id="tanggal7" title="Date is required" />
</span></td>
      <td><span id="sprytextfield11">
        <input name="materialend" type="text" class="required" id="tanggal29" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td>--- End User ---</td>
      <td>&nbsp;</td>
      <td colspan="3"><input name="statuscrf" type="checkbox" class="hidentext" id="statuscrf" checked="checked" /></td>
      <td>Fabrication</td>
      <td><span id="sprytextfield12">
        <input name="fabricationstart" type="text" class="required" id="tanggal30" title="Date is required" />
</span></td>
      <td><span id="sprytextfield13">
        <input name="fabricationend" type="text" class="required" id="tanggal31" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td>Name</td>
      <td>:</td>
      <td colspan="3"><?php echo $row_Recordset1['vendor']; ?><label for="name">
        <input name="name" type="hidden" id="name" value="<?php echo $row_Recordset1['vendor']; ?>" />
      </label></td>
      <td>Test/NDE</td>
      <td><span id="sprytextfield14">
        <input name="testingstart" type="text" class="required" id="tanggal32" title="Date is required" />
</span></td>
      <td><span id="sprytextfield15">
        <input name="testingend" type="text" class="required" id="tanggal33" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td colspan="3"><label for="datw"></label>
        <span id="sprytextfield3">
        <input name="datw" id="tanggal2" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>Blasting Painting</td>
      <td><span id="sprytextfield16">
        <input name="blastingpaintingstart" type="text" class="required" id="tanggal34" title="Date is required" />
</span></td>
      <td><span id="sprytextfield17">
        <input name="blastingpaintingend" type="text" class="required" id="tanggal35" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td>Reference</td>
      <td>:</td>
      <td colspan="3"><?php echo $row_Recordset1['Reference']; ?><label for="ref"></label>
        <input name="ref" type="hidden" id="ref" value="<?php echo $row_Recordset1['Reference']; ?>" /></td>
      <td>Delivery</td>
      <td><span id="sprytextfield18">
        <input name="deliverystart" type="text" class="required" id="tanggal36" title="Date is required" />
</span></td>
      <td><span id="sprytextfield19">
        <input name="deliveryend" type="text" class="required" id="tanggal37" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td rowspan="6">Other</td>
      <td rowspan="6">:</td>
      <td colspan="3" rowspan="6"><label for="others"></label>
        <textarea name="others" id="others" cols="45" rows="5" class="General"></textarea></td>
      <td>Instalation</td>
      <td><span id="sprytextfield20">
        <input name="instalationstart" type="text" class="required" id="tanggal38" title="Date is required" />
</span></td>
      <td><span id="sprytextfield21">
        <input name="instalationend" type="text" class="required" id="tanggal39" title="Date is required" />
</span></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><b>Others :</b></td>
    </tr>
    <tr>
      <td><input type="text" name="other1" id="other1" /></td>
      <td><input name="other1start" type="text" class="required" id="tanggal40" title="Date is required" /></td>
      <td><input name="other1end" type="text" class="required" id="tanggal41" title="Date is required" /></td>
    </tr>
    <tr>
      <td><input type="text" name="other2" id="other2" /></td>
      <td><input name="other2start" type="text" class="required" id="tanggal42" title="Date is required" /></td>
      <td><input name="other2end" type="text" class="required" id="tanggal43" title="Date is required" /></td>
    </tr>
    <tr>
      <td><input type="text" name="other3" id="other3" /></td>
      <td><input name="other3start" type="text" class="required" id="tanggal44" title="Date is required" /></td>
      <td><input name="other3end" type="text" class="required" id="tanggal45" title="Date is required" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3"><input name="fileupload" type="text" class="hidentext" id="fileupload" value="<?php echo $nama_file; ?>" /></td>
      <td><input type="text" name="other4" id="other4" /></td>
      <td><input name="other4start" type="text" class="required" id="tanggal46" title="Date is required" /></td>
      <td><input name="other4end" type="text" class="required" id="tanggal47" title="Date is required" /></td>
    </tr>
    <tr>
      <td>--- End User ---</td>
      <td>&nbsp;</td>
      <td colspan="3"><?php echo $row_Recordset1['contactperson']; ?><input name="enduser" type="hidden" id="enduser" value="<?php echo $row_Recordset1['contactperson']; ?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Drawing Sketch</td>
      <td>:</td>
      <td colspan="6"><label for="drawingsketch"></label>
        <select name="drawingsketch" id="drawingsketch">
          <option value="">Drawing</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['drawingno']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select></td>
    </tr>
    <tr>
      <td>Other Terms Condition</td>
      <td>:</td>
      <td colspan="6"><label for="otherstermsandcondition"></label>
        <textarea name="otherstermsandcondition" id="otherstermsandcondition" cols="45" rows="5" class="General"></textarea></td>
    </tr>
    <tr class="hidentext">
      <td>Prepared By</td>
      <td>:</td>
      <td colspan="6"><input type="text" name="prepareby" id="prepareby" readonly="readonly" value="<?php echo $row_rsuser['id']; ?>" /></td>
    </tr>
    
    <tr>
      <td>Approved By</td>
      <td>:</td>
      <td colspan="6">
        <select name="approvedby" id="approvedby">
		<?php do { ?>
          <option value="<?php echo $row_Recordset7['id']; ?>"<?php if ($row_Recordset7['id'] == '24') { ?> selected="selected" <?php } ?>>
			<?php echo $row_Recordset7['firstname']; echo " "; echo $row_Recordset7['midlename']; echo " "; echo $row_Recordset7['lastname']; ?>
          </option>
		<?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7));
		
		  $rows = mysql_num_rows($Recordset7);
		  if($rows > 0) {
			  mysql_data_seek($Recordset7, 0);
			  $row_Recordset7 = mysql_fetch_assoc($Recordset7);
		  } ?>
		</select>
		</td>
    </tr>
    
    <tr>
      <td>Client Verification</td>
      <td>:</td>
      <td colspan="6"><select name="clientverivication" id="clientverivication">
        <?php do { ?>
        <option value="<?php echo $row_Recordset4['id']?>"> <?php echo $row_Recordset4['firstname']; echo " "; echo $row_Recordset4['lastname']?></option>
        <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
		  
		  $rows = mysql_num_rows($Recordset4);
		  if ($rows > 0) {
			  mysql_data_seek($Recordset4, 0);
			  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
		} ?>
      </select>        &nbsp;
      <a href="../mkt/inputcustomercontact.php?data=<?php echo $row_Recordset1['vendor']; ?>">Input Client Contact</a></td>
    </tr>
    <tr>
      <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
      <td>Issued Date</td>
      <td>:</td>
      <td colspan="6"><b>
		<?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			$jam = date("H:i");
			$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
			echo $sekarang; ?></b>
            
            <input name="issueddate" type="hidden" id="issueddate" value="<?php echo $sekarang; ?>" />
		</td>
    </tr>
    <tr>
      <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="6"><input type="submit" name="Submit" id="Submit" value="Submit" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {isRequired:false});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {isRequired:false});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {isRequired:false});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {isRequired:false});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {isRequired:false});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "none", {isRequired:false});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {isRequired:false});
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "none", {isRequired:false});
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "none", {isRequired:false});
var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15", "none", {isRequired:false});
var sprytextfield16 = new Spry.Widget.ValidationTextField("sprytextfield16", "none", {isRequired:false});
var sprytextfield17 = new Spry.Widget.ValidationTextField("sprytextfield17", "none", {isRequired:false});
var sprytextfield18 = new Spry.Widget.ValidationTextField("sprytextfield18", "none", {isRequired:false});
var sprytextfield19 = new Spry.Widget.ValidationTextField("sprytextfield19", "none", {isRequired:false});
var sprytextfield20 = new Spry.Widget.ValidationTextField("sprytextfield20", "none", {isRequired:false});
var sprytextfield21 = new Spry.Widget.ValidationTextField("sprytextfield21", "none", {isRequired:false});
</script>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset2);
	mysql_free_result($Recordset3);
	mysql_free_result($Recordset7);
	mysql_free_result($rsuser);
	mysql_free_result($Recordset4);
	mysql_free_result($rsapprovedby);
	mysql_free_result($rsemployeedept);
?>