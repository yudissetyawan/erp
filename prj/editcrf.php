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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$usrid = $_SESSION['empID'];
$chosenapprover = $_POST['approvedby'];
mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$chosenapprover'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

mysql_select_db($database_core, $core);
$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.userlevel = 'branchmanager' AND h_employee.id <> '$chosenapprover' OR h_employee.userlevel = 'administrator'";
$rsemployeedept = mysql_query($query_rsemployeedept, $core) or die(mysql_error());
$row_rsemployeedept = mysql_fetch_assoc($rsemployeedept);
$totalRows_rsemployeedept = mysql_num_rows($rsemployeedept);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE a_crf SET jobtitle=%s, qty=%s, `date`=%s, customer=%s, projectcode=%s, productioncode=%s, name=%s, `ref`=%s, datw=%s, reference=%s, others=%s, drawingsketch=%s, suppliedmaterial=%s, otherstermsandcondition=%s, preparedby=%s, approvedby=%s, clientverivication=%s, marketing=%s, commercial=%s, quality=%s, hse=%s, engineering=%s, procurement=%s, production=%s, fabrication=%s, hrd=%s, acc=%s, maintenance=%s, it=%s, siteproject=%s, `file`=%s, approval=%s, issueddate=%s, fileupload=%s WHERE nocrf=%s",
                       GetSQLValueString($_POST['jobtitle'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
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
                       GetSQLValueString($usrid, "int"),
                       GetSQLValueString($_POST['approvedby'], "int"),
                       GetSQLValueString($_POST['clientverivication'], "int"),
                       GetSQLValueString(isset($_POST['marketing']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['commercial']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['quality']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['hse']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['engineering']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['procurement']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ppic']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['fabrication']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['hrd']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['acc']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['maintenance']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['it']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['siteproject']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['file']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString("RV", "text"),
                       GetSQLValueString($_POST['issueddate'], "text"),
                       GetSQLValueString($_POST['fileupload'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

/* OPEN THIS COMMENT
  //NOTIF
  	$no_crf = $_POST['nocrf'];
	$job_title = $_POST['jobtitle'];
	//$issued_date = $_POST['issueddate'];
	$approverfname = $row_rsapprovedby['fname'];
	$approvermname = $row_rsapprovedby['mname'];
	$approverlname = $row_rsapprovedby['lname'];
	$isipsn = "CRF No : $no_crf , Title : $job_title has been revised and waiting for approval by $approverfname $approvermname $approverlname";
	
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
	
	//NOTIF APPROVAL TO APPROVER
	$idcrf = $_POST['idcrf'];
	$isipsn2 = "CRF No. : $no_crf , Title : $job_title has been revised and need your approval";
	$goto = "../tm/crf_approval.php?data=$idcrf";
	
	$insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto, id_msgcat) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString('52', "int"),
						   GetSQLValueString($idcrf, "text"),
						   GetSQLValueString($chosenapprover, "int"),
						   GetSQLValueString($isipsn, "text"),
						   GetSQLValueString($goto, "text"),
						   GetSQLValueString('3', "text"));
	mysql_select_db($database_core, $core);
	$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	
	echo "<script>alert(\"CRF No : $no_crf has been revised, and waiting for approval by $approverfname $approvermname $approverlname\");
		parent.window.location.reload(true);
		</script>";
*/
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE a_crf_schedulle SET designstart=%s, designend=%s, drawingstart=%s, drawingend=%s, itpstart=%s, itpend=%s, materialstart=%s, materialend=%s, fabricationstart=%s, fabricationend=%s, testingstart=%s, testingend=%s, blastingpaintingstart=%s, blastingpaintingend=%s, instalationstart=%s, instalationend=%s, deliverystart=%s, deliveryend=%s, other1=%s, other2=%s, other3=%s, other4=%s, other1start=%s, other1end=%s, other2start=%s, other2end=%s, other3start=%s, other3end=%s, other4start=%s, other4end=%s WHERE crf=%s",
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
                       GetSQLValueString($_POST['other4end'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
  echo "<script>document.location=\"form_project.php\"</script>";
}

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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM a_crf_schedulle WHERE crf = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
//$date=date(my);
//$cari=$row_Recordset1['projectcode'];

 // cari panjang max dari string yg di dapat dari query
//$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM a_crf WHERE projectcode LIKE '%$cari%' ORDER BY nocrf DESC LIMIT 1"));
//$cekQ=$ceknomor[nocrf];
//$prod=$row_Recordset1['productioncode'];

#menghilangkan huruf
//$awalQ=substr($cekQ,0,3);
#ketemu angka awal(angka sebelumnya) + dengan 1
//$next=(int)$awalQ+1;
//$nextcrf=sprintf ("%03d", $next).'-'.$cari.'-'.$prod.'-'.$date;

mysql_select_db($database_core, $core);
$query_Recordset7 = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.userlevel FROM h_employee WHERE h_employee.userlevel = 'branchmanager'";
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

mysql_select_db($database_core, $core);
$query_rsclient = "SELECT * FROM a_contactperson";
$rsclient = mysql_query($query_rsclient, $core) or die(mysql_error());
$row_rsclient = mysql_fetch_assoc($rsclient);
$totalRows_rsclient = mysql_num_rows($rsclient);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit CRF</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

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
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td rowspan="3"><table width="529" border="0" cellspacing="2">
        <tr>
          <td width="207"> CRF ID</td>
          <td width="13">:</td>
          <td colspan="3"><label for="nocrf2"></label>
            <input name="nocrf" type="text" id="nocrf2" value="<?php echo $row_Recordset1['nocrf']; ?>" readonly="readonly" />
            <input name="idcrf" type="hidden" id="idcrf" value="<?php echo $row_Recordset1['id']; ?>" />
          </td>
        </tr>
        <tr>
          <td rowspan="3">Distribution List</td>
          <td rowspan="3">:</td>
          <td width="99"><? if ($row_Recordset1['marketing']==1) {echo  "<input name='marketing' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='marketing' type='checkbox'/>";  } ?>
            Marketing</td>
          <td width="94"><? if ($row_Recordset1['quality']==1) {echo  "<input name='quality' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='quality' type='checkbox'/>";  } ?>
            Quality </td>
          <td width="94"><? if ($row_Recordset1['procurement']==1) {echo  "<input name='procurement' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='procurement' type='checkbox'/>";  } ?>
            Procurement</td>
        </tr>
        <tr>
          <td><? if ($row_Recordset1['commercial']==1) {echo  "<input name='commercial' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='commercial' type='checkbox'/>";  } ?>
            Commercial</td>
          <td><? if ($row_Recordset1['hse']==1) {echo  "<input name='hse' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='hse' type='checkbox'/>";  } ?>
            HSE</td>
          <td><? if ($row_Recordset1['ppic']==1) {echo  "<input name='ppic' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='ppic' type='checkbox'/>";  } ?>
            PPIC</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><? if ($row_Recordset1['engineering']==1) {echo  "<input name='engineering' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='engineering' type='checkbox'/>";  } ?>
            Engineering</td>
          <td><? if ($row_Recordset1['fabrication']==1) {echo  "<input name='fabrication' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='fabrication' type='checkbox'/>";  } ?>
            Fabrication</td>
        </tr>
        <tr>
          <td>Job Title</td>
          <td>:</td>
          <td colspan="3"><label for="jobtitle"></label>
            <textarea name="jobtitle" id="jobtitle" cols="30" rows="3"><?php echo $row_Recordset1['jobtitle']; ?></textarea></td>
        </tr>
        <tr>
          <td>QTY</td>
          <td>:</td>
          <td colspan="3"><label for="qty"></label>
            <input name="qty" type="text" id="qty" value="<?php echo $row_Recordset1['qty']; ?>" /></td>
        </tr>
        <tr>
          <td>Date</td>
          <td>:</td>
          <td colspan="3"><input name="date" id="tanggal1" value="<?php echo $row_Recordset1['date']; ?>" /></td>
        </tr>
        <tr>
          <td>Project Code - Production Code - Customer</td>
          <td>:</td>
          <td colspan="3"><label for="productioncode">
            <input name="projectcode" type="text" id="project" value="<?php echo $row_Recordset1['projectcode']; ?>" size="5" readonly="readonly" />
-
<input name="productioncode" type="text" id="productioncode" value="<?php echo $row_Recordset1['productioncode']; ?>" size="5" readonly="readonly" />
            -
            <input name="customer" type="text" id="customer" size="35" value="<?php echo $row_Recordset1['customer']; ?>" readonly="readonly" />
          </label></td>
        </tr>
        <tr>
          <td>--- End User ---</td>
          <td>&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>Name</td>
          <td>:</td>
          <td colspan="3"><label for="name">
            <input name="name" type="text" id="name" value="<?php echo $row_Recordset1['name']; ?>" size="40" />
          </label></td>
        </tr>
        <tr>
          <td>Date</td>
          <td>:</td>
          <td colspan="3"><label for="datw"></label>
            <input name="datw" id="tanggal2" value="<?php echo $row_Recordset1['datw']; ?>" /></td>
        </tr>
        <tr>
          <td>Reference</td>
          <td>:</td>
          <td colspan="3"><label for="ref"></label>
            <input name="ref" type="text" id="ref" value="<?php echo $row_Recordset1['ref']; ?>" size="40" /></td>
        </tr>
        <tr>
          <td>Other</td>
          <td>:</td>
          <td colspan="3"><label for="others"></label>
            <textarea name="others" id="others" cols="45" rows="5"><?php echo $row_Recordset1['others']; ?></textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="3"><input name="fileupload" type="text" class="hidentext" id="fileupload" value="<?php if ($nama_file==""){echo $row_Recordset1['fileupload'];} else {echo $nama_file;} ?>" /></td>
        </tr>
        <tr>
          <td>--- End User ---</td>
          <td>&nbsp;</td>
          <td colspan="3"><input name="enduser" type="text" id="enduser" /></td>
        </tr>
        <tr>
          <td>Drawing Sketch</td>
          <td>:</td>
          <td colspan="3"><label for="drawingsketch"></label>
            <select name="drawingsketch" id="drawingsketch">
              <option value="">Drawing</option>
            </select></td>
        </tr>
        <tr>
          <td>Supplied Material</td>
          <td>:</td>
          <td colspan="3"><label for="suppliedmaterial"></label>
            <select name="suppliedmaterial" id="suppliedmaterial">
              <option value="">Supplied Material</option>
            </select></td>
        </tr>
        <tr>
          <td>Other Terms Condition</td>
          <td>:</td>
          <td colspan="3"><label for="otherstermsandcondition"></label>
            <textarea name="otherstermsandcondition" id="otherstermsandcondition" cols="45" rows="5"><?php echo $row_Recordset1['otherstermsandcondition']; ?></textarea></td>
        </tr>
        <tr>
          <td>Prepared By</td>
          <td>:</td>
          <td colspan="3"><?php $prepby = $row_Recordset1['preparedby'];
			mysql_select_db($database_core, $core);
$query_rsuser = "SELECT h_employee.id, h_employee.username, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE h_employee.id = '$prepby'";
$rsuser = mysql_query($query_rsuser, $core) or die(mysql_error());
$row_rsuser = mysql_fetch_assoc($rsuser);
$totalRows_rsuser = mysql_num_rows($rsuser);
			?>
            <?php echo $row_rsuser['firstname']; ?> <?php echo $row_rsuser['midlename']; ?> <?php echo $row_rsuser['lastname']; ?></td>
        </tr>
        <tr>
          <td>Approved By</td>
          <td>:</td>
          <td colspan="3"><select name="approvedby" id="approvedby">
            <?php do { ?>
            <option value="<?php echo $row_Recordset7['id']?>"<?php if ($row_Recordset7['id'] == $row_Recordset1['approvedby']) { ?> selected="selected" <?php } ?>> <?php echo $row_Recordset7['firstname']; echo " "; echo $row_Recordset7['midlename']; echo " "; echo $row_Recordset7['lastname']; ?> </option>
            <?php
			} while ($row_Recordset7 = mysql_fetch_assoc($Recordset7));
			  $rows = mysql_num_rows($Recordset7);
			  if($rows > 0) {
				  mysql_data_seek($Recordset7, 0);
				  $row_Recordset7 = mysql_fetch_assoc($Recordset7);
			  }
			?>
          </select></td>
        </tr>
        <tr>
          <td>Client Verification</td>
          <td>:</td>
          <td colspan="3"><select name="clientverification" id="clientverivication">
            <?php do { ?>
            <option value="<?php echo $row_rsclient['id']?>"> <?php echo $row_rsclient['firstname']; echo " "; echo $row_rsclient['lastname']?> </option>
            <?php
			} while ($row_rsclient = mysql_fetch_assoc($rsclient));
			  $rows = mysql_num_rows($rsclient);
			  if($rows > 0) {
				  mysql_data_seek($rsclient, 0);
				  $row_rsclient = mysql_fetch_assoc($rsclient);
			  }
			?>
          </select>
            &nbsp; <a href="../mkt/inputcustomercontact.php">Input Client Contact</a></td>
        </tr>
        <tr>
          <td>Issued Date</td>
          <td>:</td>
          <td colspan="3"><b>
            <?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tu", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			 $jam = date("H:i");
			$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
			echo $sekarang;
			?>
          </b>
            <input name="issueddate" type="hidden" id="issueddate" value="<?php echo $sekarang; ?>" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="3"><br />
            <input type="submit" name="Submit" id="Submit" value="Submit" /></td>
        </tr>
      </table></td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="52"><table width="210" border="0" cellspacing="2" cellpadding="1">
        <tr>
          <td><? if ($row_Recordset1['hrd']==1) {echo  "<input name='hrd' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='hrd' type='checkbox'/>";  } ?> 
            HRD </td>
          <td><? if ($row_Recordset1['it']==1) {echo  "<input name='it' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='it' type='checkbox'/>";  } ?> 
            IT</td>
        </tr>
        <tr>
          <td><? if ($row_Recordset1['acc']==1) {echo  "<input name='acc' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='acc' type='checkbox'/>";  } ?>
            Accounting</td>
          <td> <? if ($row_Recordset1['siteproject']==1) {echo  "<input name='siteproject' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='siteproject' type='checkbox'/>";  } ?> 
            Site Project</td>
        </tr>
        <tr>
          <td><? if ($row_Recordset1['maintenance']==1) {echo  "<input name='maintenance' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='maintenance' type='checkbox'/>";  } ?> 
            Maintenance</td>
          <td> <? if ($row_Recordset1['file']==1) {echo  "<input name='file' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='file' type='checkbox'/>";  } ?>
            DCC</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><table width="437" border="0" class="General">
        <tr class="judul">
          <td colspan="2">Type of Job</td>
          <td>Start Date</td>
          <td>Finish Date</td>
        </tr>
        <tr>
          <td width="91">Design</td>
          <td width="4">:</td>
          <td width="144"><input name="designstart" type="text" class="required" id="tanggal21" title="Date is required" value="<?php echo $row_Recordset4['designstart']; ?>" /></td>
          <td width="180"><input name="designend" type="text" class="required" id="tanggal22" title="Date is required" value="<?php echo $row_Recordset4['designend']; ?>" /></td>
        </tr>
        <tr>
          <td>Drawing</td>
          <td>:</td>
          <td><input name="drawingstart" type="text" class="required" id="tanggal3" title="Date is required" value="<?php echo $row_Recordset4['drawingstart']; ?>" /></td>
          <td><input name="drawingend" type="text" class="required" id="tanggal4" title="Date is required" value="<?php echo $row_Recordset4['drawingend']; ?>" /></td>
        </tr>
        <tr>
          <td>ITP</td>
          <td>:</td>
          <td><input name="itpstart" type="text" class="required" id="tanggal5" title="Date is required" value="<?php echo $row_Recordset4['itpstart']; ?>" /></td>
          <td><input name="itpend" type="text" class="required" id="tanggal6" title="Date is required" value="<?php echo $row_Recordset4['itpend']; ?>" /></td>
        </tr>
        <tr>
          <td>Material</td>
          <td>:</td>
          <td><input name="materialstart" type="text" class="required" id="tanggal7" title="Date is required" value="<?php echo $row_Recordset4['materialstart']; ?>" /></td>
          <td><input name="materialend" type="text" class="required" id="tanggal8" title="Date is required" value="<?php echo $row_Recordset4['materialend']; ?>" /></td>
        </tr>
        <tr>
          <td>Fabrication</td>
          <td>:</td>
          <td><input name="fabricationstart" type="text" class="required" id="tanggal9" title="Date is required" value="<?php echo $row_Recordset4['fabricationstart']; ?>" /></td>
          <td><input name="fabricationend" type="text" class="required" id="tanggal10" title="Date is required" value="<?php echo $row_Recordset4['fabricationend']; ?>" /></td>
        </tr>
        <tr>
          <td>Test/NDE</td>
          <td>:</td>
          <td><input name="testingstart" type="text" class="required" id="tanggal11" title="Date is required" value="<?php echo $row_Recordset4['testingstart']; ?>" /></td>
          <td><input name="testingend" type="text" class="required" id="tanggal12" title="Date is required" value="<?php echo $row_Recordset4['testingend']; ?>" /></td>
        </tr>
        <tr>
          <td>Blasting Painting</td>
          <td>:</td>
          <td><input name="blastingpaintingstart" type="text" class="required" id="tanggal13" title="Date is required" value="<?php echo $row_Recordset4['blastingpaintingstart']; ?>" /></td>
          <td><input name="blastingpaintingend" type="text" class="required" id="tanggal14" title="Date is required" value="<?php echo $row_Recordset4['blastingpaintingend']; ?>" /></td>
        </tr>
        <tr>
          <td>Delivery</td>
          <td>:</td>
          <td><input name="deliverystart" type="text" class="required" id="tanggal15" title="Date is required" value="<?php echo $row_Recordset4['instalationstart']; ?>" /></td>
          <td><input name="deliveryend" type="text" class="required" id="tanggal16" title="Date is required" value="<?php echo $row_Recordset4['instalationend']; ?>" /></td>
        </tr>
        <tr>
          <td>Instalation</td>
          <td>:</td>
          <td><input name="instalationstart" type="text" class="required" id="tanggal17" title="Date is required" value="<?php echo $row_Recordset4['deliverystart']; ?>" /></td>
          <td><input name="instalationend" type="text" class="required" id="tanggal18" title="Date is required" value="<?php echo $row_Recordset4['deliveryend']; ?>" /></td>
        </tr>
        <tr>
          <td>Others</td>
          <td>:</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><input type="text" name="other1" id="other1" value="<?php echo $row_Recordset4['other1']; ?>" /></td>
          <td>&nbsp;</td>
          <td><input name="other1start" type="text" class="required" id="tanggal19" title="Date is required" value="<?php echo $row_Recordset4['other1start']; ?>" /></td>
          <td><input name="other1end" type="text" class="required" id="tanggal20" title="Date is required" value="<?php echo $row_Recordset4['other1end']; ?>" /></td>
          </tr>
        <tr>
          <td><input type="text" name="other2" id="other2" value="<?php echo $row_Recordset4['other2']; ?>" /></td>
          <td>&nbsp;</td>
          <td><input name="other2start" type="text" class="required" id="tanggal28" title="Date is required" value="<?php echo $row_Recordset4['other2start']; ?>" /></td>
          <td><input name="other2end" type="text" class="required" id="tanggal27" title="Date is required" value="<?php echo $row_Recordset4['other2end']; ?>" /></td>
          </tr>
        <tr>
          <td><input type="text" name="other3" id="other3" value="<?php echo $row_Recordset4['other3']; ?>" /></td>
          <td>&nbsp;</td>
          <td><input name="other3start" type="text" class="required" id="tanggal24" title="Date is required" value="<?php echo $row_Recordset4['other3start']; ?>" /></td>
          <td><input name="other3end" type="text" class="required" id="tanggal23" title="Date is required" value="<?php echo $row_Recordset4['other3end']; ?>" /></td>
          </tr>
        <tr>
          <td><input type="text" name="other4" id="other4" value="<?php echo $row_Recordset4['other4']; ?>" /></td>
          <td>&nbsp;</td>
          <td><input name="other4start" type="text" class="required" id="tanggal25" title="Date is required" value="<?php echo $row_Recordset4['other4start']; ?>" /></td>
          <td><input name="other4end" type="text" class="required" id="tanggal26" title="Date is required" value="<?php echo $row_Recordset4['other4end']; ?>" /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset1);

mysql_free_result($Recordset4);

mysql_free_result($rsuser);
?>
