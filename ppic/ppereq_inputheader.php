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
	require_once "../dateformat_funct.php";
	
  $insertSQL = sprintf("INSERT INTO p_ppereq_header (ppereq_no, ppereq_date, id_projcode, note, req_by_manager, passed_by, distrib_by) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ppereq_no'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['ppereq_date']), "text"),
                       GetSQLValueString($_POST['id_projcode'], "int"),
					   GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['req_by_manager'], "int"),
                       GetSQLValueString($_POST['passed_by'], "int"),
                       GetSQLValueString($_POST['distrib_by'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  
	$q = mysql_fetch_array(mysql_query("SELECT id FROM p_ppereq_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"ppereq_viewdetail.php?data=$cekID\";</script>";
}

mysql_select_db($database_core, $core);
$query_rscmbmanager = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE h_employee.level = '1' AND code = 'K' ORDER BY firstname ASC";
$rscmbmanager = mysql_query($query_rscmbmanager, $core) or die(mysql_error());
$row_rscmbmanager = mysql_fetch_assoc($rscmbmanager);
$totalRows_rscmbmanager = mysql_num_rows($rscmbmanager);

mysql_select_db($database_core, $core);
$query_rscmbpassby = "SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.id FROM h_employee WHERE h_employee.department LIKE '%HRD%' AND code='K'";
$rscmbpassby = mysql_query($query_rscmbpassby, $core) or die(mysql_error());
$row_rscmbpassby = mysql_fetch_assoc($rscmbpassby);
$totalRows_rscmbpassby = mysql_num_rows($rscmbpassby);

mysql_select_db($database_core, $core);
$query_rscmbdistby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'PPIC' AND code = 'K' ORDER BY firstname ASC";
$rscmbdistby = mysql_query($query_rscmbdistby, $core) or die(mysql_error());
$row_rscmbdistby = mysql_fetch_assoc($rscmbdistby);
$totalRows_rscmbdistby = mysql_num_rows($rscmbdistby);

mysql_select_db($database_core, $core);
$query_rscmbprojcd = "SELECT a_proj_code.id, a_proj_code.project_code, a_proj_code.projecttitle FROM a_proj_code ORDER BY a_proj_code.project_code ASC";
$rscmbprojcd = mysql_query($query_rscmbprojcd, $core) or die(mysql_error());
$row_rscmbprojcd = mysql_fetch_assoc($rscmbprojcd);
$totalRows_rscmbprojcd = mysql_num_rows($rscmbprojcd);

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry PPE Request Header</title>

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
<?php { require_once "../date.php"; } ?>
<h3>Input PPE Request</b></h3>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="700" border="0">
    <tr>
      <td width="225" class="General">PPE Request No.</td>
      <td width="10">:</td>
      <td><input type="text" name="ppereq_no" id="ppereq_no" /></td>
    </tr>
    <tr>
      <td class="General">Date</td>
      <td>:</td>
      <td><input type="text" name="ppereq_date" id="tanggal8" size="12" /></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td>
        <select name="id_projcode" id="id_projcode">
          <option value="">-- Select Project Code --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rscmbprojcd['id']?>"><?php echo $row_rscmbprojcd['project_code']?> <?php echo $row_rscmbprojcd['projecttitle']?></option>
          <?php
} while ($row_rscmbprojcd = mysql_fetch_assoc($rscmbprojcd));
  $rows = mysql_num_rows($rscmbprojcd);
  if($rows > 0) {
      mysql_data_seek($rscmbprojcd, 0);
	  $row_rscmbprojcd = mysql_fetch_assoc($rscmbprojcd);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Note</td>
      <td>:</td>
      <td>
      <textarea name="note" id="note" cols="45" rows="4"></textarea></td>
    </tr>
    <tr>
      <td class="General">Request by (Manager)</td>
      <td>:</td>
      <td><select name="req_by_manager" id="req_by_manager">
          <option value="">-- Select Request by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbmanager['id']; ?>"><?php echo $row_rscmbmanager['firstname']; ?> <?php echo $row_rscmbmanager['midlename']; ?> <?php echo $row_rscmbmanager['lastname']; ?></option>
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
      <td class="General">Passed by (HRD)</td>
      <td>:</td>
      <td>
		<select name="passed_by" id="passed_by" class="required" title="Please select Passed by">
        <option value="">-- Select Passed by --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rscmbpassby['id']?>"><?php echo $row_rscmbpassby['firstname']; ?> <?php echo $row_rscmbpassby['midlename']; ?> <?php echo $row_rscmbpassby['lastname'];?></option>
          <?php
} while ($row_rscmbpassby = mysql_fetch_assoc($rscmbpassby));
  $rows = mysql_num_rows($rscmbpassby);
  if($rows > 0) {
      mysql_data_seek($rscmbpassby, 0);
	  $row_rscmbpassby = mysql_fetch_assoc($rscmbpassby);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Distributed by</td>
      <td>:</td>
      <td><select name="distrib_by" id="distrib_by" class="required" title="Please select Distributed by">
        <option value="">-- Select Distributed by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rscmbdistby['id']?>"><?php echo $row_rscmbdistby['firstname']?> <?php echo $row_rscmbdistby['midlename']; ?> <?php echo $row_rscmbdistby['lastname']; ?></option>
        <?php
} while ($row_rscmbdistby = mysql_fetch_assoc($rscmbdistby));
  $rows = mysql_num_rows($rscmbdistby);
  if($rows > 0) {
      mysql_data_seek($rscmbdistby, 0);
	  $row_rscmbdistby = mysql_fetch_assoc($rscmbdistby);
  }
?>
      </select></td>
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
    <input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($rscmbmanager);
	mysql_free_result($rscmbdistby);

mysql_free_result($rscmbprojcd);
	mysql_free_result($rscmbpassby);
?>