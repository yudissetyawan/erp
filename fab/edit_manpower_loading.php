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
  $updateSQL = sprintf("UPDATE f_manpower_loading SET employee=%s, skill=%s, mp1=%s, mp2=%s, mp3=%s, mp4=%s, mp5=%s, mp6=%s, mp7=%s, mp8=%s, mp9=%s, mp10=%s, mp11=%s, mp12=%s, mp13=%s, mp14=%s, mp15=%s, mp16=%s, mp17=%s, mp18=%s, mp19=%s, mp20=%s, mp21=%s, mp22=%s, mp23=%s, mp24=%s, mp25=%s, mp26=%s, mp27=%s, mp28=%s, mp29=%s, mp30=%s, mp31=%s, keterangan=%s WHERE idheader=%s AND idsite=%s",
                       GetSQLValueString($_POST['nama'], "int"),
                       GetSQLValueString($_POST['skill'], "text"),
                       GetSQLValueString(isset($_POST['mp1']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp2']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp3']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp4']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp5']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp6']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp7']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp8']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp9']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp10']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp11']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp12']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp13']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp14']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp15']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp16']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp17']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp18']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp19']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp20']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp21']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp22']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp23']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp24']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp25']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp26']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp27']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp28']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp29']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp30']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mp31']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['textarea'], "text"),
                       GetSQLValueString($_POST['idheader'], "int"),
                       GetSQLValueString($_POST['idsite'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_employee ORDER BY h_employee.firstname ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT f_manpower_loading_header.*, f_site.id, f_site.nama_site, f_site.prod_code FROM f_manpower_loading_header, f_site WHERE f_manpower_loading_header.id = %s AND f_site.id = f_manpower_loading_header.idsite", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<html>
<head><title></title>
<link href="../css/induk.css" rel="stylesheet" type="text/css">
</head>
<body>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="1291" class="buatform">
    <tr>
      <td width="53"><strong>BULAN </strong></td>
      <td width="5">:</td>
      <?php // data yang dikirim saat men submit id dan value  ?>
      <td width="266"><input name="idheader" type="hidden" value="<?php echo $row_Recordset3['id']; ?>"><?php echo $row_Recordset3['month']; ?></td>
      <td width="119"><strong>Note </strong></td>
      <td width="7">:</td>
      <td width="189"><?php echo $row_Recordset3['note']; ?></td>
      <td width="104"><strong>Prepared By</strong></td>
      <td width="5">:</td>
      <td width="190"><?php echo $row_Recordset3['prepare_by']; ?></td>
      <td width="144"><strong>Approved By</strong></td>
      <td width="2">:</td>
      <td width="155"><?php echo $row_Recordset3['approved_by']; ?></td>
    </tr>
    <tr>
      <td><strong>Lokasi</strong></td>
      <td>:</td>
      <td><input name="idsite" type="hidden" value="<?php echo $row_Recordset3['idsite']; ?>"><?php echo $row_Recordset3['nama_site']; ?></td>
      <td><strong>Production Code </strong></td>
      <td>:</td>
      <td><?php echo $row_Recordset3['prod_code']; ?></td>
      <td><strong>Checked By</strong></td>
      <td>:</td>
      <td colspan="4"><?php echo $row_Recordset3['checked_by']; ?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="1218">
  <tr class="tabel_header">
    <td width="119" rowspan="2" align="center">NAMA</td>
    <td width="85" rowspan="2" align="center">JABATAN</td>
    <td colspan="31" align="center">Tanggal</td>
    <td width="124" rowspan="2" align="center">Keterangan</td>
  </tr>
  <tr class="tabel_header">
    <td width="22" align="center" class="tabel_header">1</td>
    <td width="22" align="center" class="tabel_header">2</td>
    <td width="22" align="center" class="tabel_header">3</td>
    <td width="22" align="center" class="tabel_header">4</td>
    <td width="22" align="center" class="tabel_header">5</td>
    <td width="22" align="center" class="tabel_header">6</td>
    <td width="22" align="center" class="tabel_header">7</td>
    <td width="22" align="center" class="tabel_header">8</td>
    <td width="22" align="center" class="tabel_header">9</td>
    <td width="22" align="center" class="tabel_header">10</td>
    <td width="22" align="center" class="tabel_header">11</td>
    <td width="22" align="center" class="tabel_header">12</td>
    <td width="22" align="center" class="tabel_header">13</td>
    <td width="22" align="center" class="tabel_header">14</td>
    <td width="22" align="center" class="tabel_header">15</td>
    <td width="22" align="center" class="tabel_header">16</td>
    <td width="22" align="center" class="tabel_header">17</td>
    <td width="22" align="center" class="tabel_header">18</td>
    <td width="22" align="center" class="tabel_header">19</td>
    <td width="22" align="center" class="tabel_header">20</td>
    <td width="22" align="center" class="tabel_header">21</td>
    <td width="22" align="center" class="tabel_header">22</td>
    <td width="22" align="center" class="tabel_header">23</td>
    <td width="22" align="center" class="tabel_header">24</td>
    <td width="22" align="center" class="tabel_header">25</td>
    <td width="22" align="center" class="tabel_header">26</td>
    <td width="22" align="center" class="tabel_header">27</td>
    <td width="22" align="center" class="tabel_header">28</td>
    <td width="22" align="center" class="tabel_header">29</td>
    <td width="22" align="center" class="tabel_header">30</td>
    <td width="22" align="center" class="tabel_header">31</td>
  </tr>
  <tr class="tabel_body">
    <td><label for="nama"></label>
      <select name="nama" id="nama">
        <option value="">-Nama-</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['firstname']?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
    <td><label for="skill"></label>
      <input type="text" name="skill" id="skill" /></td>
    <td align="center"><input type="checkbox" name="mp1" id="mp1" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp2" id="mp2" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp3" id="mp3" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp4" id="mp4" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp5" id="mp5" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp6" id="mp6" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp7" id="mp7" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp8" id="mp8" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp9" id="mp9" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp10" id="mp10" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp11" id="mp11" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp12" id="mp12" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp13" id="mp13" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp14" id="mp14" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp15" id="mp15" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp16" id="mp16" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp17" id="mp17" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp18" id="mp18" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp19" id="mp19" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp20" id="mp20" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp21" id="mp21" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp22" id="mp22" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp23" id="mp23" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp24" id="mp24" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp25" id="mp25" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp26" id="mp26" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp27" id="mp27" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp28" id="mp28" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp29" id="mp29" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp30" id="mp30" value="1" /></td>
    <td align="center"><input type="checkbox" name="mp31" id="mp31" value="1" /></td>
    <td><textarea name="textarea" id="textarea" cols="45" rows="2"></textarea></td>
  </tr>
</table>
  <p align="center"><input name="submit" type="submit" value="SIMPAN" /></p>
  <input type="hidden" name="MM_update" value="form1">
</form>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset3);
?>
