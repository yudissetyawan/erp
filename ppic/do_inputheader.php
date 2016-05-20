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
  $insertSQL = sprintf("INSERT INTO p_do_header (donumber, shipto, contractnumber, packinglistnumber, deliverypoint, carier, platno, managername, securityname, cariername, recievername) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['donumber'], "text"),
                       GetSQLValueString($_POST['shipto'], "text"),
                       GetSQLValueString($_POST['contractno'], "text"),
                       GetSQLValueString($_POST['pkglistno'], "text"),
                       GetSQLValueString($_POST['deliverypoint'], "text"),
                       GetSQLValueString($_POST['carrier'], "text"),
                       GetSQLValueString($_POST['platno'], "text"),
                       GetSQLValueString($_POST['cmbmanager'], "int"),
                       GetSQLValueString($_POST['cmbsecurity'], "int"),
                       GetSQLValueString($_POST['carriername'], "text"),
                       GetSQLValueString($_POST['receivedby'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  	$q = mysql_fetch_array(mysql_query("SELECT id FROM p_do_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"do_viewdetail.php?data=$cekID\";</script>";
}

mysql_select_db($database_core, $core);
$query_rscmbmanager = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE h_employee.userlevel = 'branchmanager' AND code = 'K' ORDER BY firstname ASC";
$rscmbmanager = mysql_query($query_rscmbmanager, $core) or die(mysql_error());
$row_rscmbmanager = mysql_fetch_assoc($rscmbmanager);
$totalRows_rscmbmanager = mysql_num_rows($rscmbmanager);

mysql_select_db($database_core, $core);
$query_rscmbsecurity = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'GAFF' AND Jabatan LIKE '%Security%' AND code = 'K' ORDER BY firstname ASC";
$rscmbsecurity = mysql_query($query_rscmbsecurity, $core) or die(mysql_error());
$row_rscmbsecurity = mysql_fetch_assoc($rscmbsecurity);
$totalRows_rscmbsecurity = mysql_num_rows($rscmbsecurity);

mysql_select_db($database_core, $core);
$query_rscmbcontractno = "SELECT DISTINCT a_proj_code.contractno, a_proj_code.id, a_proj_code.project_code, a_proj_code.projecttitle FROM a_proj_code";
$rscmbcontractno = mysql_query($query_rscmbcontractno, $core) or die(mysql_error());
$row_rscmbcontractno = mysql_fetch_assoc($rscmbcontractno);
$totalRows_rscmbcontractno = mysql_num_rows($rscmbcontractno);

mysql_select_db($database_core, $core);
$query_rscmbpkglist = "SELECT p_pl_header.id, p_pl_header.no_pl  FROM p_pl_header";
$rscmbpkglist = mysql_query($query_rscmbpkglist, $core) or die(mysql_error());
$row_rscmbpkglist = mysql_fetch_assoc($rscmbpkglist);
$totalRows_rscmbpkglist = mysql_num_rows($rscmbpkglist);

$year=date(y);
$month=date(m);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM p_mr_header ORDER BY nomr DESC LIMIT 1"));
$cekQ=$ceknomor[nomr];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;

if($next <10){
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J005
//
} else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "" . $next; // jadinya J005
//
} else {
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J005
//
} $nextpracode=sprintf ('R.BPN'.'/'.$year.'/'.$month.'/'.$nextString);
?>

<script type="text/javascript" src="/js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="/js/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#form1").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>

<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry M/S Request Header</title>
</head>

<body>
<?php {include "../date.php"; include "uploadrefmrsr.php";} ?>
<p>
	<b>Input Delivery Order (DO)</b>
</p>

<table width="570" border="0" cellpadding="2" cellspacing="2" hidden >
  <tr>
    <td colspan="3"><input type="hidden" name="idmsps" id="idmsps" value="" /></td>
  </tr>
  <tr>
    <td width="200"><b>Reference </b></td>
    <td width="16">:</td>
    <td width="350" ><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit1" value="Upload" />
    </form></td>
  </tr>
</table>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="570" border="0">
    <tr>
      <td width="200" class="General">DO No.</td>
      <td width="16">:</td>
      <td width="350"><input type="text" name="donumber" id="donumber" /></td>
    </tr>
    <tr>
      <td class="General">Ship to</td>
      <td>:</td>
      <td><input type="text" name="shipto" id="shipto" /></td>
    </tr>
    <tr>
      <td class="General">Contract No.</td>
      <td>:</td>
      <td><select name="contractno" id="contractno">
      	<option value="">-- Select Contract No. --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbcontractno['contractno']?>"><?php echo $row_rscmbcontractno['contractno']?></option>
        <?php
} while ($row_rscmbcontractno = mysql_fetch_assoc($rscmbcontractno));
  $rows = mysql_num_rows($rscmbcontractno);
  if($rows > 0) {
      mysql_data_seek($rscmbcontractno, 0);
	  $row_rscmbcontractno = mysql_fetch_assoc($rscmbcontractno);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Packing List No.</td>
      <td>:</td>
      <td><select name="pkglistno" id="pkglistno">
        <option value="">-- Select Packing List No. --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbpkglist['id']?>"><?php echo $row_rscmbpkglist['no_pl']?></option>
        <?php
} while ($row_rscmbpkglist = mysql_fetch_assoc($rscmbpkglist));
  $rows = mysql_num_rows($rscmbpkglist);
  if($rows > 0) {
      mysql_data_seek($rscmbpkglist, 0);
	  $row_rscmbpkglist = mysql_fetch_assoc($rscmbpkglist);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Delivery Point</td>
      <td>:</td>
      <td><input type="text" name="deliverypoint" id="deliverypoint" class="required" title="Delivery Point is required" /></td>
    </tr>
    <tr>
      <td class="General">Carrier</td>
      <td>:</td>
      <td><input type="text" name="carrier" id="carrier" class="required" title="Carrier is required" /></td>
    </tr>
    <tr>
      <td class="General">Plat No. / Reg.</td>
      <td>:</td>
      <td><input type="text" name="platno" id="platno" class="required" title="Plat No. / Reg. is required" /></td>
    </tr>
    
    <tr>
      <td class="General">Manager</td>
      <td>:</td>
      <td><select name="cmbmanager" id="cmbmanager" class="required" title="Please select Manager">
        <option value="">-- Select Manager --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbmanager['id']; ?>"><?php echo $row_rscmbmanager['firstname'] ?> <?php echo $row_rscmbmanager['midlename']; ?> <?php echo $row_rscmbmanager['lastname']; ?></option>
        <?php
} while ($row_rscmbmanager = mysql_fetch_assoc($rscmbmanager));
  $rows = mysql_num_rows($rscmbmanager);
  if($rows > 0) {
      mysql_data_seek($rscmbmanager, 0);
	  $row_rscmbmanager = mysql_fetch_assoc($rscmbmanager);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Security</td>
      <td>:</td>
      <td><select name="cmbsecurity" id="cmbsecurity" class="required" title="Please select Security">
        <option value="">-- Select Security --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbsecurity['id']?>"><?php echo $row_rscmbsecurity['firstname']?> <?php echo $row_rscmbsecurity['midlename']; ?> <?php echo $row_rscmbsecurity['lastname']; ?></option>
        <?php
} while ($row_rscmbsecurity = mysql_fetch_assoc($rscmbsecurity));
  $rows = mysql_num_rows($rscmbsecurity);
  if($rows > 0) {
      mysql_data_seek($rscmbsecurity, 0);
	  $row_rscmbsecurity = mysql_fetch_assoc($rscmbsecurity);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Carrier Name</td>
      <td>:</td>
      <td><input type="text" name="carriername" id="carriername" class="required" title="Carrier is required" /></td>
    </tr>
    <tr>
      <td class="General">Received By (Client)</td>
      <td>:</td>
      <td><input type="text" name="receivedby" id="receivedby" class="required" title="Received By (Client) is required" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="General">&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Save" /></td>
    </tr>
  </table>
  <p>
    <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_pekerjaan" type="hidden" id="id_pekerjaan" value="MR/SR"/>
  </p>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
</body>
</html>
<?php
	mysql_free_result($rscmbmanager);
	mysql_free_result($rscmbsecurity);

mysql_free_result($rscmbcontractno);

mysql_free_result($rscmbpkglist);
	
?>
