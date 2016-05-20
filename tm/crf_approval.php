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

/*
$btn = $_POST['Submit'];
if (isset($_POST['Submit'])) {
	echo "<script>alert(\"$btn\");</script>";
}
*/


if (isset($_POST['Submit'])) {
	$vcmbapprovedby = $_POST['cmbApprover'];
	
	mysql_select_db($database_core, $core);
$query_rscmbapprovedby = "SELECT h_employee.firstname AS apprv_fname, h_employee.midlename AS apprv_mname, h_employee.lastname AS apprv_lname FROM h_employee WHERE h_employee.id = '$vcmbapprovedby'";
$rscmbapprovedby = mysql_query($query_rscmbapprovedby, $core) or die(mysql_error());
$row_rscmbapprovedby = mysql_fetch_assoc($rscmbapprovedby);
$totalRows_rscmbapprovedby = mysql_num_rows($rscmbapprovedby);
	
	$vfname = $row_rscmbapprovedby['apprv_fname'];
	$vmname = $row_rscmbapprovedby['apprv_mname'];
	$vlname = $row_rscmbapprovedby['apprv_lname'];
	$approvaltime = $_POST['hfapprovaldate'];
	if ($_POST['remarks'] != '') {
		$vrmk = $_POST['remarks'];
		$rmk =  "(Remarks : $vrmk)";
	} else if ($_POST['remarks'] == '') {
		$rmk =  '';
	}
	
	$nocrf = $_POST['nocrf'];
	if ($_POST['Submit'] == "Approve") {
		$statusapproval = "Y";
		$ntflink = "";
		$idmsgcat = 1;
		$isi = "CRF No. $nocrf has been approved by $vfname $vmname $vlname on $approvaltime $rmk";
		$psn = "CRF No. $nocrf has been approved";
		$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.code = 'K' AND h_employee.userlevel <> '' OR h_employee.userlevel = 'administrator'";
	}
	else if ($_POST['Submit'] == "Deny") {
		$statusapproval = "D";
		$ntflink = "../prj/editcrf.php?data=$nocrf";
		$idmsgcat = 2;
		$isi = "CRF No. $nocrf has been denied by $vfname $vmname $vlname on $approvaltime $rmk";
		$psn = "CRF No. $nocrf has been denied";
		$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.department = 'Project' OR h_employee.userlevel = 'administrator'"; //OR h_employee.userlevel = 'branchmanager'";
	}
	//023-J134-14104-0414
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE a_crf SET approvedby=%s, dateapproval=%s WHERE nocrf=%s",
                       GetSQLValueString($_POST['cmbApprover'], "int"),
                       GetSQLValueString($_POST['approvaldate'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "form_tm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

/* <--- OPEN THIS COMMENT
//NOTIF TO SPESIFIC EMPLOYEE
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	mysql_select_db($database_core, $core);
	$rsemployeedept = mysql_query($query_rsemployeedept, $core) or die(mysql_error());
	$row_rsemployeedept = mysql_fetch_assoc($rsemployeedept);
	$totalRows_rsemployeedept = mysql_num_rows($rsemployeedept);

	$idpkj = $_POST['hfidpekerjaan'];
	$q = "UPDATE log_pesan SET ntf_goto='' WHERE id_pekerjaan='$idpkj' AND id_msgcat='2'";
	$cmd = mysql_query($q) or die(mysql_error());
	
	do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto, id_msgcat) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['hfidinisial'], "int"),
						   GetSQLValueString($_POST['hfidpekerjaan'], "text"),
						   GetSQLValueString($row_rsemployeedept['empID'], "int"),
						   GetSQLValueString($isi, "text"),
						   GetSQLValueString($ntflink, "text"),
						   GetSQLValueString($idmsgcat, "int"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	}
	while ($row_rsemployeedept = mysql_fetch_assoc($rsemployeedept));
	
	/* echo "<script>alert(\"Notif : $ntflink dan IDmsgcat : $idmsgcat dan Remark : $rmk\");</script>"; */
	
	/* <--- OPEN THIS COMMENT
	echo "<script>alert(\"$psn\");
			parent.window.location.reload(true);
			document.location=\"unapproved_crf.php\";
			</script>";
	/*
	$insertGoTo = "unapproved_crf.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $insertGoTo));
	*/
	
/* <--- OPEN THIS COMMENT
}
*/

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$vpreparedby = $row_Recordset1['preparedby'];
$vapprovedby = $row_Recordset1['approvedby'];
$vtmlogin = $_SESSION['empID'];
/* echo "<script>alert(\"$vtmlogin\");</script>"; */

mysql_select_db($database_core, $core);
$query_rspreparedby = "SELECT a_crf.preparedby, h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, a_crf WHERE h_employee.id = a_crf.preparedby AND a_crf.preparedby = '$vpreparedby'";
$rspreparedby = mysql_query($query_rspreparedby, $core) or die(mysql_error());
$row_rspreparedby = mysql_fetch_assoc($rspreparedby);
$totalRows_rspreparedby = mysql_num_rows($rspreparedby);

mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vapprovedby'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

mysql_select_db($database_core, $core);
$query_rstmlogin = "SELECT h_employee.id AS tm_id, h_employee.firstname AS fname2, h_employee.midlename AS mname2, h_employee.lastname AS lname2 FROM h_employee WHERE h_employee.id = '$vtmlogin'";
$rstmlogin = mysql_query($query_rstmlogin, $core) or die(mysql_error());
$row_rstmlogin = mysql_fetch_assoc($rstmlogin);
$totalRows_rstmlogin = mysql_num_rows($rstmlogin);
?>

<html>
<head><title></title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>
<body class="General">
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST" class="General" onSubmit="return validasi_input(this)">
  <table width="803" border="0" align="center">
    <tr>
      <td width="174">CRF No.</td>
      <td width="13">:</td>
      <td colspan="5"><b><?php echo $row_Recordset1['nocrf']; ?></b><input name="nocrf" type="hidden" id="nocrf" value="<?php echo $row_Recordset1['nocrf']; ?>"/></td>
    </tr>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="3">Distribution List</td>
      <td rowspan="3">:</td>
      <td width="117"><? if ($row_Recordset1['marketing']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?> Marketing</td>
      <td width="115"><? if ($row_Recordset1['quality']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  }?> Quality </td>
      <td width="117"><? if ($row_Recordset1['procurement']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?> Procurement</td>
      <td width="118"> <? if ($row_Recordset1['hrd']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       HRD </td>
      <td width="119"> <? if ($row_Recordset1['it']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       IT</td>
    </tr>
    <tr>
      <td> <? if ($row_Recordset1['commercial']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       Commercial</td>
      <td> <? if ($row_Recordset1['hse']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       HSE</td>
      <td> <? if ($row_Recordset1['production']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       PPIC</td>
      <td>  <? if ($row_Recordset1['acc']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>      Accounting</td>
      <td> <? if ($row_Recordset1['siteproject']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       Site Project</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><? if ($row_Recordset1['engineering']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>        Engineering</td>
      <td><? if ($row_Recordset1['fabrication']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>      Fabrication</td>
      <td>  <? if ($row_Recordset1['maintenance']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>      Maintenance</td>
      <td> <? if ($row_Recordset1['file']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       DCC</td>
    </tr>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td>Job Title</td>
      <td>:</td>
      <td colspan="5"><label for="jobtitle"><?php echo $row_Recordset1['jobtitle']; ?>
       
      </label></td>
    </tr>
    <tr>
      <td>QTY</td>
      <td>:</td>
      <td colspan="5"><label for="qty"><?php echo $row_Recordset1['qty']; ?></label></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td colspan="5"><?php echo $row_Recordset1['date']; ?></td>
    </tr>
    <tr>
      <td>Project Code - Production Code - Customer</td>
      <td>:</td>
      <td colspan="5"><label for="productioncode"><?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['productioncode']; ?> - <?php echo $row_Recordset1['customer']; ?></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td class="tabel_header">--- End User ---</td>
      <td class="tabel_header">&nbsp;</td>
      <td colspan="5" class="tabel_header">&nbsp;</td>
    </tr>
    <tr>
      <td>Name</td>
      <td>:</td>
      <td colspan="5"><label for="name"><?php echo $row_Recordset1['name']; ?></label></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td colspan="5"><label for="datw"><?php echo $row_Recordset1['datw']; ?></label></td>
    </tr>
    <tr>
      <td>Reference</td>
      <td>:</td>
      <td colspan="5"><label for="ref"><?php echo $row_Recordset1['ref']; ?></label></td>
    </tr>
    <tr>
      <td>Other</td>
      <td>:</td>
      <td colspan="5"><label for="others"><?php echo $row_Recordset1['others']; ?></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td class="tabel_header">--- End User ---</td>
      <td class="tabel_header">&nbsp;</td>
      <td colspan="5" class="tabel_header">&nbsp;</td>
    </tr>
    <tr>
      <td>Drawing Sketch</td>
      <td>:</td>
      <td colspan="5"><label for="drawingsketch"><?php echo $row_Recordset1['drawingsketch']; ?></label></td>
    </tr>
    <tr>
      <td>Supplied Material</td>
      <td>:</td>
      <td colspan="5"><label for="suppliedmaterial"><?php echo $row_Recordset1['suppliedmaterial']; ?></label></td>
    </tr>
    <tr valign="top">
      <td>Other Terms Condition</td>
      <td>:</td>
      <td colspan="5"><textarea rows="8" style="border:thin; font-size:12px; width:100%" class="General" readonly><?php echo $row_Recordset1['otherstermsandcondition']; ?></textarea></td>
    </tr>
    <tr>
      <td>Prepared By</td>
      <td>:</td>
      <td colspan="5"><?php echo $row_rspreparedby['firstname']; ?> <?php echo $row_rspreparedby['midlename']; ?> <?php echo $row_rspreparedby['lastname']; ?></td>
    </tr>
    <tr>
      <td>Approved By</td>
      <td>:</td>
      <td colspan="5"><select name="cmbApprover">
        <?php
			  	if ($row_rsapprovedby['id'] == $_SESSION['empID']) {
					?>
        <option value="<?php echo $row_rsapprovedby['id']?>" selected> <?php echo $row_rsapprovedby['fname']?> <?php echo $row_rsapprovedby['mname']; ?> <?php echo $row_rsapprovedby['lname']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $row_rsapprovedby['id']?>" selected> <?php echo $row_rsapprovedby['fname']?> <?php echo $row_rsapprovedby['mname']; ?> <?php echo $row_rsapprovedby['lname']; ?></option>
        <option value="<?php echo $row_rstmlogin['tm_id']; ?>"> <?php echo $row_rstmlogin['fname2']; ?> <?php echo $row_rstmlogin['mname2']; ?> <?php echo $row_rstmlogin['lname2']; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td>Client Verification</td>
      <td>:</td>
      <td colspan="5">
		<?php $idclient = $row_Recordset1['clientverivication'];
			mysql_select_db($database_core, $core);
			$query_rsclient = "SELECT a_contactperson.firstname AS fnamec, a_contactperson.lastname AS lnamec, a_contactperson.id FROM a_contactperson  WHERE a_contactperson.id = '$idclient'";
			$rsclient = mysql_query($query_rsclient, $core) or die(mysql_error());
			$row_rsclient = mysql_fetch_assoc($rsclient);
			$totalRows_rsclient = mysql_num_rows($rsclient);
		?>
        <?php echo $row_rsclient['fnamec']; ?> <?php echo $row_rsclient['lnamec']; ?>
      </td>
    </tr>
    <tr>
      <td>Issued Date</td>
      <td>:</td>
      <td colspan="5"><?php echo $row_Recordset1['issueddate']; ?></td>
    </tr>
    <tr>
      <td>Date Approval</td>
      <td>:</td>
      <td colspan="5">
      	<?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			$jam = date("H:i");
			$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
			echo $sekarang; ?>
            <input name="approvaldate" type="hidden" id="approvaldate" value="<?php echo $sekarang;?>">
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5"><a href="#" onClick="MM_openBrWindow('../prj/viewschedulle.php?data=<?php echo $row_Recordset1['nocrf']; ?>','Schedulle','toolbar=yes,location=yes,menubar=yes,resizable=yes,width=600,height=600')">View Schedule</a></td>
    </tr>
    <tr>
      <td>Remarks</td>
      <td>:</td>
      <td colspan="5"><label for="remarks"></label>
      <textarea name="remarks" id="remarks" cols="40" title="Fill it if necessary"></textarea></td>
    </tr>
    <tr>
      <td>
		<input type="hidden" name="hfidinisial" id="hfidinisial" value="52">
        <input type="hidden" name="hfidpekerjaan" id="hfidpekerjaan" value="<?php echo $row_Recordset1['id']; ?>">
        <input type="hidden" name="hfapprovaldate" id="hfapprovaldate" value="<?php echo $sekarang; ?>">
      </td>
      <td>&nbsp;</td>
      
      <td colspan="5">
      <br>
      <input type="submit" name="Submit" id="Submit" value="Approve" style="font-size:16px; font-weight:bold; cursor:pointer">      &nbsp;&nbsp;&nbsp;
        <input type="submit" name="Submit" id="Submit" value="Deny" style="font-size:16px; font-weight:bold; cursor:pointer">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<?php
	mysql_free_result($rsemployeedept);
	mysql_free_result($Recordset1);
	mysql_free_result($rspreparedby);
	mysql_free_result($rsapprovedby);
	mysql_free_result($rstmlogin);
	mysql_free_result($rsclient);
	mysql_free_result($rscmbapprovedby);
?>
