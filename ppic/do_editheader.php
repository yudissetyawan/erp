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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	include "../dateformat_funct.php";
  $updateSQL = sprintf("UPDATE p_do_header SET donumber=%s, shipto=%s, contractnumber=%s, packinglistnumber=%s, deliverypoint=%s, carier=%s, platno=%s, managername=%s, managerdate=%s, securityname=%s, securitydate=%s, cariername=%s, carierdate=%s, recievername=%s, recieverdate=%s WHERE id=%s",
                       GetSQLValueString($_POST['donumber'], "text"),
                       GetSQLValueString($_POST['shipto'], "text"),
                       GetSQLValueString($_POST['contractno'], "text"),
                       GetSQLValueString($_POST['pkglistno'], "text"),
                       GetSQLValueString($_POST['deliverypoint'], "text"),
                       GetSQLValueString($_POST['carrier'], "text"),
                       GetSQLValueString($_POST['platno'], "text"),
                       GetSQLValueString($_POST['cmbmanager'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['managerdate']), "date"),
                       GetSQLValueString($_POST['cmbsecurity'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['securitydate']), "date"),
                       GetSQLValueString($_POST['carriername'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['carrydate']), "date"),
                       GetSQLValueString($_POST['receivedby'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['receiveddate']), "date"),
                       GetSQLValueString($_POST['id_do'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "do_viewheader.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$viddo = $_GET['data'];
mysql_select_db($database_core, $core);
$query_rsdoheader = "SELECT * FROM p_do_header WHERE id = '$viddo'";
$rsdoheader = mysql_query($query_rsdoheader, $core) or die(mysql_error());
$row_rsdoheader = mysql_fetch_assoc($rsdoheader);
$totalRows_rsdoheader = mysql_num_rows($rsdoheader);

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
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM p_do_header ORDER BY nomr DESC LIMIT 1"));
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

<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
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
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Delivery Order (DO)</title>
</head>

<body>
<?php {include "../date.php"; include "uploadrefmrsr.php";} ?>
<p>
	<b>Edit Delivery Order (DO)</b>
</p>

<table width="570" border="0" cellpadding="2" cellspacing="2" hidden >
  <tr>
    <td colspan="3"><input type="hidden" name="idmsps" id="idmsps" value="" /></td>
  </tr>
  <tr>
    <td width="200"><b>Reference </b></td>
    <td width="20">:</td>
    <td width="330" ><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit1" value="Upload" />
    </form></td>
  </tr>
</table>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="950" border="0">
    <tr>
      <td width="200" class="General">DO No.</td>
      <td width="20">:</td>
      <td width="330"><input name="donumber" type="text" id="donumber" value="<?php echo $row_rsdoheader['donumber']; ?>" />        <input type="hidden" name="id_do" id="id_do" value="<?php echo $row_rsdoheader['id']; ?>" /></td>
      <td width="200">&nbsp;</td>
      <td width="20">&nbsp;</td>
      <td width="130">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Ship to</td>
      <td>:</td>
      <td><input name="shipto" type="text" id="shipto" value="<?php echo $row_rsdoheader['shipto']; ?>" /></td>
      <td class="General">Delivery Point</td>
      <td>:</td>
      <td><input name="deliverypoint" type="text" class="required" id="deliverypoint" title="Delivery Point is required" value="<?php echo $row_rsdoheader['deliverypoint']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Contract No.</td>
      <td>:</td>
      <td><select name="contractno" id="contractno">
     	 <option value="">-- Select Contract No. --</option>
        <?php
			do {  
			?>
				<option value="<?php echo $row_rscmbcontractno['contractno']?>" <?php if ($row_rscmbcontractno['contractno']== $row_rsdoheader['contractnumber']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbcontractno['contractno']?></option>
					<?php
			} while ($row_rscmbcontractno = mysql_fetch_assoc($rscmbcontractno));
			  $rows = mysql_num_rows($rscmbcontractno);
			  if($rows > 0) {
				  mysql_data_seek($rscmbcontractno, 0);
				  $row_rscmbcontractno = mysql_fetch_assoc($rscmbcontractno);
			  }
			?>
      </select></td>
      <td class="General">Carrier</td>
      <td>:</td>
      <td><input name="carrier" type="text" class="required" id="carrier" title="Carrier is required" value="<?php echo $row_rsdoheader['carier']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Packing List No.</td>
      <td>:</td>
      <td><select name="pkglistno" id="pkglistno">
        <option value="">-- Select Packing List No. --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbpkglist['id']?>" <?php if ($row_rscmbpkglist['id'] == $row_rsdoheader['packinglistnumber']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbpkglist['no_pl']?></option>
        <?php
} while ($row_rscmbpkglist = mysql_fetch_assoc($rscmbpkglist));
  $rows = mysql_num_rows($rscmbpkglist);
  if($rows > 0) {
      mysql_data_seek($rscmbpkglist, 0);
	  $row_rscmbpkglist = mysql_fetch_assoc($rscmbpkglist);
  }
?>
      </select></td>
      <td class="General">Plat No. / Reg.</td>
      <td>:</td>
      <td><input name="platno" type="text" class="required" id="platno" title="Plat No. / Reg. is required" value="<?php echo $row_rsdoheader['platno']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td class="General">Manager</td>
      <td>:</td>
      <td><select name="cmbmanager" id="cmbmanager" class="required" title="Please select Manager">
        <option value="">-- Select Manager --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbmanager['id']; ?>" <?php if ($row_rscmbmanager['id'] == $row_rsdoheader['managername']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbmanager['firstname'] ?> <?php echo $row_rscmbmanager['midlename']; ?> <?php echo $row_rscmbmanager['lastname']; ?></option>
        <?php
} while ($row_rscmbmanager = mysql_fetch_assoc($rscmbmanager));
  $rows = mysql_num_rows($rscmbmanager);
  if($rows > 0) {
      mysql_data_seek($rscmbmanager, 0);
	  $row_rscmbmanager = mysql_fetch_assoc($rscmbmanager);
  }
?>
      </select></td>
      <td class="General">Carrier Name</td>
      <td>:</td>
      <td><input name="carriername" type="text" class="required" id="carriername" title="Carrier is required" value="<?php echo $row_rsdoheader['cariername']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Signed by Manager on</td>
      <td>&nbsp;</td>
      <td><input name="managerdate" type="text" id="tanggal8" value="<?php echo $row_rsdoheader['managerdate']; ?>" /></td>
      <td class="General">Carried on</td>
      <td>:</td>
      <td><input name="carrydate" type="text" id="tanggal10" value="<?php echo $row_rsdoheader['carierdate']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Security</td>
      <td>:</td>
      <td><select name="cmbsecurity" id="cmbsecurity" class="required" title="Please select Security">
        <option value="">-- Select Security --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbsecurity['id']?>" <?php if ($row_rscmbsecurity['id'] == $row_rsdoheader['securityname']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbsecurity['firstname']?> <?php echo $row_rscmbsecurity['midlename']; ?> <?php echo $row_rscmbsecurity['lastname']; ?></option>
        <?php
} while ($row_rscmbsecurity = mysql_fetch_assoc($rscmbsecurity));
  $rows = mysql_num_rows($rscmbsecurity);
  if($rows > 0) {
      mysql_data_seek($rscmbsecurity, 0);
	  $row_rscmbsecurity = mysql_fetch_assoc($rscmbsecurity);
  }
?>
      </select></td>
      <td class="General">Received by (Client)</td>
      <td>:</td>
      <td><input name="receivedby" type="text" class="required" id="receivedby" title="Received By (Client) is required" value="<?php echo $row_rsdoheader['recievername']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Signed by Security on</td>
      <td>:</td>
      <td><input name="securitydate" type="text" id="tanggal9" value="<?php echo $row_rsdoheader['securitydate']; ?>" /></td>
      <td class="General">Received by (Client) on</td>
      <td>:</td>
      <td><input name="receiveddate" type="text" id="tanggal11" value="<?php echo $row_rsdoheader['recieverdate']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" class="General" align="right"><input type="submit" name="button" id="button" value="Save" /></td>
    </tr>
  </table>
  <p>
    <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_pekerjaan" type="hidden" id="id_pekerjaan" value="MR/SR"/>
  </p>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($rscmbmanager);
	mysql_free_result($rscmbsecurity);

mysql_free_result($rscmbcontractno);

mysql_free_result($rscmbpkglist);

mysql_free_result($rsdoheader);
	
?>
