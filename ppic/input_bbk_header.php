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
	include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO p_bbk_header (no_bbk, id_bpb, tanggal, diketahui_by, diserahkan_by, diterima_by) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_bbk'], "text"),
					   GetSQLValueString($_POST['id_bpb'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal']), "date"),
                       GetSQLValueString($_POST['diketahui_by'], "int"),
                       GetSQLValueString($_POST['diserahkan_by'], "int"),
                       GetSQLValueString($_POST['diterima_by'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  	$q = mysql_fetch_array(mysql_query("SELECT id FROM p_bbk_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"bbk/view_bbk_core.php?data=$cekID\";</script>";
}

mysql_select_db($database_core, $core);
$query_bpb = "SELECT id, bpb_no FROM p_bpb_header";
$bpb = mysql_query($query_bpb, $core) or die(mysql_error());
$row_bpb = mysql_fetch_assoc($bpb);
$totalRows_bpb = mysql_num_rows($bpb);

mysql_select_db($database_core, $core);
$query_diketahui = "SELECT * FROM h_employee WHERE code = 'K' AND userlevel = 'PPIC' ORDER BY firstname ASC";
$diketahui = mysql_query($query_diketahui, $core) or die(mysql_error());
$row_diketahui = mysql_fetch_assoc($diketahui);
$totalRows_diketahui = mysql_num_rows($diketahui);

mysql_select_db($database_core, $core);
$query_diserahkan = "SELECT * FROM h_employee WHERE code = 'K' ORDER BY firstname ASC";
$diserahkan = mysql_query($query_diserahkan, $core) or die(mysql_error());
$row_diserahkan = mysql_fetch_assoc($diserahkan);
$totalRows_diserahkan = mysql_num_rows($diserahkan);

mysql_select_db($database_core, $core);
$query_diterima = "SELECT * FROM h_employee WHERE code = 'K' AND userlevel = 'PPIC' ORDER BY firstname ASC";
$diterima = mysql_query($query_diterima, $core) or die(mysql_error());
$row_diterima = mysql_fetch_assoc($diterima);
$totalRows_diterima = mysql_num_rows($diterima);

$year=date(y);
$month=date(m);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM p_bbk_header ORDER BY no_bbk DESC LIMIT 1"));
$cekQ=$ceknomor[no_bbk];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;

if($next <10){
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J005
//
}
else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "" . $next; // jadinya J005
//
}
else {
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J005
//
}
$nextno_bbk=sprintf ('K.BPN'.'/'.$year.'/'.$month.'/'.$nextString);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input BBK Header</title>

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
<?php { include "../date.php"; } ?>
<h3>Input Header Bon Barang Kembali</h3>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="500">
    <tr>
      <td>No. BBK</td>
      <td>:</td>
      <td>
      <input type="text" name="no_bbk" id="no_bbk" value="<?php echo $nextno_bbk ?>" readonly="readonly" style="border:thin" /></td>
    </tr>
    <tr>
      <td> No. BPB</td>
      <td>:</td>
      <td>
        <select name="id_bpb" id="id_bpb">
          <option value="">-- No BPB --</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_bpb['id']?>"><?php echo $row_bpb['bpb_no']?></option>
          <?php
		} while ($row_bpb = mysql_fetch_assoc($bpb));
		  $rows = mysql_num_rows($bpb);
		  if($rows > 0) {
			  mysql_data_seek($bpb, 0);
			  $row_bpb = mysql_fetch_assoc($bpb);
		  }
		?>
        </select>
        </td>
    </tr>
    
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td><input type="text" name="tanggal" id="tanggal1" value="<?php echo date("d M Y"); ?>" size="15" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>Diketahui Oleh</td>
      <td>:</td>
      <td>
        <select name="diketahui_by" id="diketahui_by">
        <option value="">-- Diketahui Oleh --</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_diketahui['id']?>"><?php echo $row_diketahui['firstname']?> <?php echo $row_diketahui['midlename']; ?> <?php echo $row_diketahui['lastname']; ?></option>
          <?php
		} while ($row_diketahui = mysql_fetch_assoc($diketahui));
		  $rows = mysql_num_rows($diketahui);
		  if($rows > 0) {
			  mysql_data_seek($diketahui, 0);
			  $row_diketahui = mysql_fetch_assoc($diketahui);
		  }
		?>
      </select>
      </td>
    </tr>
    
    <tr>
      <td>Diserahkan Oleh</td>
      <td>:</td>
      <td>
        <select name="diserahkan_by" id="diserahkan_by">
        <option value="">-- Diserahkan Oleh --</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_diserahkan['id']?>"><?php echo $row_diserahkan['firstname']?> <?php echo $row_diserahkan['midlename']; ?> <?php echo $row_diserahkan['lastname']; ?></option>
          <?php
		} while ($row_diserahkan = mysql_fetch_assoc($diserahkan));
		  $rows = mysql_num_rows($diserahkan);
		  if($rows > 0) {
			  mysql_data_seek($diserahkan, 0);
			  $row_diserahkan = mysql_fetch_assoc($diserahkan);
		  }
		?>
      </select>
      </td>
    </tr>
    
    <tr>
      <td>Diterima Oleh</td>
      <td>:</td>
      <td>
        <select name="diterima_by" id="diterima_by">
        <option value="">-- Diterima Oleh --</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_diterima['id']?>"><?php echo $row_diterima['firstname']?> <?php echo $row_diterima['midlename']; ?> <?php echo $row_diterima['lastname']; ?></option>
          <?php
		} while ($row_diterima = mysql_fetch_assoc($diterima));
		  $rows = mysql_num_rows($diterima);
		  if($rows > 0) {
			  mysql_data_seek($diterima, 0);
			  $row_diterima = mysql_fetch_assoc($diterima);
		  }
		?>
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
      <td><input type="submit" value="Save" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($bpb);
	mysql_free_result($diketahui);
	mysql_free_result($diserahkan);
	mysql_free_result($diterima);
?>