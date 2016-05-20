<?php require_once('Connections/core.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include "dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO h_dinasluar (id_employee, tanggal, keperluan, approved_by) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_employee'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "date"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['approved_by'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}
mysql_select_db($database_core, $core);
$idemp = $_SESSION['empID'];
$query_Recordset2 = "SELECT h_employee.* FROM h_employee WHERE h_employee.id = $idemp";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_h_employee_list = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee";
$h_employee_list = mysql_query($query_h_employee_list, $core) or die(mysql_error());
$row_h_employee_list = mysql_fetch_assoc($h_employee_list);
$totalRows_h_employee_list = mysql_num_rows($h_employee_list);

/* OPEN THIS COMMENT */
//NOTIF FOR OTHER BRANCHMANAGER
$chosenapprover = $_POST['approved_by'];
mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$chosenapprover'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

mysql_select_db($database_core, $core);
$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.userlevel = 'branchmanager' AND h_employee.id <> '$chosenapprover' OR h_employee.userlevel = 'administrator' OR h_employee.department = 'hrd'";
$rsemployeedept = mysql_query($query_rsemployeedept, $core) or die(mysql_error());
$row_rsemployeedept = mysql_fetch_assoc($rsemployeedept);
$totalRows_rsemployeedept = mysql_num_rows($rsemployeedept);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$ceknomor = mysql_fetch_array(mysql_query("SELECT id FROM h_dinasluar ORDER BY id DESC LIMIT 1"));
	$iddl = $ceknomor['id'];
	$id_suratizin = $_POST['jenis_surat'];
	$fname = $_SESSION['firstname'];
	$mname = $_SESSION['midlename'];
	$lname = $_SESSION['lastname'];
	//$issued_date = $_POST['issueddate'];
	$approverfname = $row_rsapprovedby['fname'];
	$approvermname = $row_rsapprovedby['mname'];
	$approverlname = $row_rsapprovedby['lname'];
	$isipsn = "$fname $mname $lname is waiting for approval by $approverfname $approvermname $approverlname to $id_suratizin";
	
	do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString('64', "int"),
						   GetSQLValueString($iddl, "text"),
						   GetSQLValueString($row_rsemployeedept['empID'], "int"),
						   GetSQLValueString($isipsn, "text"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	}
	while ($row_rsemployeedept = mysql_fetch_assoc($rsemployeedept));
	
	//NOTIF APPROVAL (SAVE IN TBL LOG_PESAN)
	$isipsn2 = "$fname $mname $lname is waiting for approval by $approverfname $approvermname $approverlname to $id_suratizin";
	$goto = "../tm/approval_izin_dl.php?data=$iddl";
	
	$insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto, id_msgcat) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString('64', "int"),
						   GetSQLValueString($iddl, "text"),
						   GetSQLValueString($chosenapprover, "int"),
						   GetSQLValueString($isipsn2, "text"),
						   GetSQLValueString($goto, "text"),
						   GetSQLValueString('3', "text"));
	
	mysql_select_db($database_core, $core);
	$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
		
			echo "<script>
			alert(\"$fname $mname $lname is waiting for approval by $approverfname $approvermname $approverlname to $id_suratizin\");
			document.location=\"suratizin.php\";
			parent.window.location.reload(true);
		</script>";
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<script language="javascript">
 function inputFocus(i){
    if(i.value==i.defaultValue){ i.value=""; i.style.color="#000"; }
}
function inputBlur(i){
    if(i.value==""){ i.value=i.defaultValue; i.style.color="#888"; }
}
 </script>
 
<style type="text/css">
* { font:Tahoma, Geneva, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
 
</head>

<body>
<?php {include "date.php";} ?>
<h3>Form Dinas Luar</h3>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table class="General">
    <tr>
      <td>Nik</span></td>
      <td>:</td>
      <td><input type="text" name="nik" value="<?php echo $row_Recordset2['nik']; ?>" size="32" readonly="readonly"/> <label for="hari"></label>        <label for="jenis_surat"></label>
      <input type="text" name="jenis_surat" id="jenis_surat" value="Surat Dinas Luar" />        <label for="id_employee"></label></td>
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
      <td><input type="text" id="tanggal1" name="date" value="<?php echo date("d M Y"); ?>" size="32"  />  <label for="id_bulan"></label></td>
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
        <select name="approved_by" id="approved_by">
        <option value="">-- Approved By --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_list['id']?>"><?php echo $row_h_employee_list['firstname']?> <?php echo $row_h_employee_list['midlename']; ?> <?php echo $row_h_employee_list['lastname']; ?></option>
          <?php
} while ($row_h_employee_list = mysql_fetch_assoc($h_employee_list));
  $rows = mysql_num_rows($h_employee_list);
  if($rows > 0) {
      mysql_data_seek($h_employee_list, 0);
	  $row_h_employee_list = mysql_fetch_assoc($h_employee_list);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" align="center" nowrap="nowrap"><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input name="id_employee" type="hidden" id="id_employee" value="<?php echo $row_Recordset2['id']; ?>" />
<input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($h_employee_list);

mysql_free_result($rsemployeedept);

mysql_free_result($rsapprovedby);
?>
