<?php require_once('../../Connections/core.php'); ?>
<?php require_once('../../Connections/core.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO h_izin (employee, tanggal, keperluan, jenis, approval) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['employee'], "int"),
                       GetSQLValueString($_POST['tanggal3'], "text"),
                       GetSQLValueString($_POST['keperluan'], "text"),
                       GetSQLValueString($_POST['jenis_izin'], "int"),
                       GetSQLValueString($_POST['menyetujui'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$dept = $row_Recordset1[department];
$query_Recordset7 = "SELECT id, firstname, midlename, lastname, userlevel, department FROM h_employee WHERE userlevel = 'branchmanager' OR department = '$dept'";
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto) VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['id_inisial'], "int"),
						   GetSQLValueString($_POST['jenis_izin'], "text"),
						   GetSQLValueString($row_Recordset7['id'], "int"),
						   GetSQLValueString($_POST['isi'], "text"),
						   GetSQLValueString('izin_approval.php?data='.$_POST['id_izin'], "text"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	
	}
		while ($row_Recordset7 = mysql_fetch_assoc($Recordset7));	
		}

$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM h_izin ORDER BY id DESC LIMIT 1"));
$cekQ=$ceknomor[id];
$next=$cekQ+1;

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<script>
function myFunction()
{
alert("Silahkan Tunggu Pemberitahuan Selanjutnya");

}
</script>
</head>

<body>
<?php {include "../../date.php";} ?>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="627">
    <tr class="General">
      <td colspan="3">Surat Izin
      <input name="employee" type="hidden" id="employee" value="<?php echo $row_Recordset1['id']; ?>">
      <input type="hidden" name="id_inisial" id="id_inisial" value="61">
      <input type="text" name="isi" id="isi" value="<?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?> Asked for Permission">
      <input type="text" name="id_izin" id="id_izin" value="<?php echo $next; ?>"></td>
    </tr>
    <tr>
      <td width="106" class="General"> Nik</td>
      <td width="6">:</td>
      <td width="499"><input name="nik" type="text" value="<?php echo $row_Recordset1['nik']; ?>" size="28" readonly="readonly"  /></td>
    </tr>
    <tr>
      <td class="General">Nama</td>
      <td>:</td>
      <td><input name="nama" type="text" value="<?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?>" size="28" readonly="readonly"  /></td>
    </tr>
    <tr>
      <td class="General">Departemen</td>
      <td>:</td>
      <td><input name="dept" type="text" value="<?php echo $row_Recordset1['department']; ?>" size="28" readonly="readonly"  /></td>
    </tr>
    <tr>
      <td class="General">Bagian</td>
      <td>:</td>
      <td><input name="bagian" type="text" id="bagian" value="<?php echo $row_Recordset1['jabatan']; ?>"  size="28" readonly /></td>
    </tr>
    
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Tanggal</td>
      <td>:</td>
      <td><input type="text" name="tanggal3" id="tanggal3" size="28"  /></td>
    </tr>
    <tr>
      <td class="General">Untuk Keperluan</td>
      <td>:</td>
      <td><input type="text" name="keperluan" id="keperluan" size="28"  /></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td><table width="200" class="General">
        <tr>
          <td><label>
            <input type="radio" name="jenis_izin" value="1" id="jenis_izin_0">
            Izin Terlambat</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="jenis_izin" value="3" id="jenis_izin_1">
            Izin Pulang Awal</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="jenis_izin" value="2" id="jenis_izin_2">
            Izin Meninggalkan Pekerjaan</label></td>
        </tr>
      </table></td>
    </tr>
    <tr class="General">
      <td>Menyetujui</td>
      <td>:</td>
      <td><select name="menyetujui" id="menyetujui">
      <option value="">----</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset7['id']?>"><?php echo $row_Recordset7['firstname']?> <?php echo $row_Recordset7['midlename']; ?> <?php echo $row_Recordset7['lastname']; ?></option>
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
      <td colspan="3"  align="center"><label>
        <input type="submit" name="submit" id="submit" value="Submit" onClick="myFunction()" />
      </label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset7);

mysql_free_result($Recordset2);
?>
