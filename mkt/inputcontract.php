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
  $insertSQL = sprintf("INSERT INTO a_proj_code (project_code, customer, pracode, projecttitle) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['pracode'], "text"),
                       GetSQLValueString($_POST['projecttitle'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}



mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM a_customer ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT project_code FROM a_proj_code ORDER BY project_code DESC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM a_pra_code WHERE id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

//GIVE NOTIF
mysql_select_db($database_core, $core);
$query_rsidempdept = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Marketing' OR h_employee.department = 'Commercial' OR h_employee.userlevel = 'branchmanager' OR h_employee.userlevel = 'administrator' OR h_employee.level='0'";
$rsidempdept = mysql_query($query_rsidempdept, $core) or die(mysql_error());
$row_rsidempdept = mysql_fetch_assoc($rsidempdept);
$totalRows_rsidempdept = mysql_num_rows($rsidempdept);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	do {
  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['hfidinisial'], "int"),
                       GetSQLValueString($_POST['hfidcontract'], "text"),
                       GetSQLValueString($row_rsidempdept['id'], "int"),
                       GetSQLValueString($_POST['hfisi'], "text"));

		mysql_select_db($database_core, $core);
		$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	} while ($row_rsidempdept = mysql_fetch_assoc($rsidempdept));

  $insertGoTo = "view_contract.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$panjang = strlen($row_Recordset2["project_code"]); // cari panjang max dari string yg di dapat dari query
$tampungku = substr($row_Recordset2["project_code"],1,$panjang); // potong string, ambil nilai selain 'J'
$nextIncrement =(int)$tampungku + 1; // naekan nilai nya.... misalnya dapat J004.. maka disini jd nya 4 + 1 = 5
//
if($nextIncrement <10){
// pengecekan nilai increment
$nextString = "J00" . $nextIncrement; // jadinya J005
//
}
else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "J" . $nextIncrement; // jadinya J005
//
}
else {
// pengecekan nilai increment
$nextString = "J0" . $nextIncrement; // jadinya J005
//
}
//tambahkan else nya kalau mau... misnya kl <100 .. maka J0 . $nextIncrement dst....
//echo $nextString;


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
<title>Untitled Document</title>
</head>

<body class="General">
<p class="General">Add New Contract</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="580" border="0">
    <tr>
      <td width="148" class="General">Pracode</td>
      <td width="20">:</td>
      <td width="398"><input name="pracode" type="text" id="pracode" value="<?php echo $row_Recordset3['pracode']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td><input name="projectcode" type="text" class="General" id="projectcode" title="Project Code Silahkan Diisi" value="<?php echo $nextString ; ?>"/></td>
    </tr>
    <tr>
      <td class="General">Project Title</td>
      <td>:</td>
      <td><textarea name="projecttitle" id="projecttitle"><?php echo $row_Recordset3['tendername']; ?></textarea></td>
    </tr>
    <tr>
      <td class="General">Customer</td>
      <td>:</td>
      <td><textarea name="customer" cols="35" id="customer"><?php echo $row_Recordset3['customer']; ?></textarea></td>
    </tr>
    <tr>
      <td class="General"><input type="hidden" name="hfidinisial" id="hfidinisial" value="4" />
        <input type="hidden" name="hfidcontract" id="hfidcontract" value="<?php echo $nextString; ?>" />
<input type="hidden" name="hfisi" id="hfisi" value="Project Code : <?php echo $nextString; ?>, Contract Name : <?php echo $row_Recordset3['tendername']; ?> has been created " /></td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="Save" id="Save" value="Save" />
      </label></td>
    </tr>
  </table> 
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($rsidempdept);
?>
