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
	
	$jenis_surat = $_POST['jenis_surat'];
	$firstname = $_SESSION['firstname'];
	$midlename = $_SESSION['midlename'];
	$lastname = $_SESSION['lastname'];
	if ($_POST['Submit'] == "Approve") {
		$statusapproval = "Y";
		$ntflink = "";
		$idmsgcat = 1;
		$isi = "$jenis_surat from $firstname $midlename $lastname has been approved by $vfname $vmname $vlname on $approvaltime $rmk";
		$psn = "$jenis_surat from $firstname $midlename $lastname has been approved";
		$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.code = 'K' AND h_employee.userlevel <> '' OR h_employee.userlevel = 'administrator'";
	}
	else if ($_POST['Submit'] == "Deny") {
		$statusapproval = "D";
		$ntflink = "";
		$idmsgcat = 2;
		$isi = "$jenis_surat from $firstname $midlename $lastname has been denied by $vfname $vmname $vlname on $approvaltime $rmk";
		$psn = "$jenis_surat from $firstname $midlename $lastname has been denied";
		$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.department = 'hrd' OR h_employee.userlevel = 'administrator'"; //OR h_employee.userlevel = 'branchmanager'";
	}
	//023-J134-14104-0414
}


$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}

mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT h_dinasluar.*, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_dinasluar, h_employee WHERE h_dinasluar.id = %s AND h_dinasluar.id_employee = h_employee.id", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vapprovedby'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="form1" id="form1">
  <table class="General">
    <tr>
      <td>Nik
      <input name="id_employee" type="text" id="id_employee" value="<?php echo $row_Recordset2['id']; ?>" /></td>
      <td>:</td>
      <td><input type="text" name="nik" value="<?php echo $row_Recordset2['nik']; ?>" size="32" readonly="readonly"/>
        <label for="hari"></label>
        <label for="jenis_surat"></label>
        <input type="text" name="jenis_surat" id="jenis_surat" value="Surat Dinas Luar" />
        <label for="id_employee"></label></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><label>
        <input type="text" name="nama" id="nama"  size="32" value="<?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['midlename']; ?> <?php echo $row_Recordset2['lastname']; ?>" readonly="readonly" />
      </label>
        <label for="dl"></label></td>
    </tr>
    <tr>
      <td>Tanggal</span></td>
      <td>:</td>
      <td><input type="text" id="tanggal1" name="date" value="<?php echo date("d M Y"); ?>" size="32"  />
        <label for="id_bulan"></label></td>
    </tr>
    <tr>
      <td>Keterangan</span></td>
      <td>:</td>
      <td><textarea name="keterangan" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>Approved By</td>
      <td>:</td>
      <td><label for="approved_by"></label>
        <select name="cmbApprover">
        <?php
			  	if ($row_rsapprovedby['id'] == $row_Recordset2['approved_by']) {
					?>
        <option value="<?php echo $row_rsapprovedby['id']?>" selected> <?php echo $row_rsapprovedby['fname']?> <?php echo $row_rsapprovedby['mname']; ?> <?php echo $row_rsapprovedby['lname']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $row_rsapprovedby['id']?>" selected> <?php echo $row_rsapprovedby['fname']?> <?php echo $row_rsapprovedby['mname']; ?> <?php echo $row_rsapprovedby['lname']; ?></option>
        <option value="<?php echo $row_rstmlogin['tm_id']; ?>"> <?php echo $row_rstmlogin['fname2']; ?> <?php echo $row_rstmlogin['mname2']; ?> <?php echo $row_rstmlogin['lname2']; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" align="center" nowrap="nowrap"><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			$jam = date("H:i");
			$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
			echo $sekarang; ?>
  <input type="text" name="hfapprovaldate" id="hfapprovaldate" value="<?php echo $sekarang; ?>">
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($rsapprovedby);

mysql_free_result($rscmbapprovedby);
?>
