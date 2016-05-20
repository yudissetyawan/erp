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

mysql_select_db($database_core, $core);
$query_sql1 = "SELECT f_manpower_loading.*, h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.department FROM f_manpower_loading, h_employee WHERE f_manpower_loading.employee=h_employee.id AND f_manpower_loading.idheader=$_GET[data] ";
$sql1 = mysql_query($query_sql1, $core) or die(mysql_error());
$row_sql1 = mysql_fetch_assoc($sql1);
$totalRows_sql1 = mysql_num_rows($sql1);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM f_manpower_loading_header WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<link href="../css/induk.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: none;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style>
<body class="General">
<table width="1000" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1017"><form id="form1" name="form1" method="post" action="">
        <div align="center">
          <table width="419" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td class="General">Pencarian Berdasarkan Departemen</td>
              <td>:</td>
              <td><select name="cari" id="cari">
                <option value="">Departemen</option>
                <?php
do {  
?>
                <option value="<?php echo $row_sql1['department']?>"><?php echo $row_sql1['department']?></option>
                <?php
} while ($row_sql1 = mysql_fetch_assoc($sql1));
  $rows = mysql_num_rows($sql1);
  if($rows > 0) {
      mysql_data_seek($sql1, 0);
	  $row_sql1 = mysql_fetch_assoc($sql1);
  }
?>
              </select>
              <input type="submit" name="Submit" value="Filter" /></td>
            </tr>
          </table>
        </div>
      </form>
      
	<?php
	$cari = $_POST['cari'];
	if (!empty($cari)) {
		?>
	  <p align="center"><b>Employee Data :</b></p>
		<p>
		<?php
		$sql1 = mysql_query("SELECT f_manpower_loading.*, h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.department FROM f_manpower_loading, h_employee WHERE f_manpower_loading.employee = h_employee.id AND h_employee.department = '$cari'");
	  	$row_sql1 = mysql_fetch_assoc($sql1);
		
		$totaldata = mysql_num_rows($sql1);
		if ($totaldata == '0') {
			echo "<center><blink>Maaf Data yang anda cari tidak ada di dalam database</bink></center>";
		} else {
			echo "Jumlah Seluruh Data yang ditemukan Adalah <b>$totaldata</b> Data";
		}
		?>        
		<table width="1260" class="table" id="celebs">
		  <thead>
		    <tr class="tabel_header">
		      <td width="17" rowspan="2" align="center">NO</td>
		      <td width="119" rowspan="2" align="center">NAMA</td>
		      <td width="82" rowspan="2" align="center">NIK</td>
		      <td width="125" rowspan="2" align="center">BAGIAN</td>
		      <td width="85" rowspan="2" align="center">JABATAN</td>
		      <td colspan="31" align="center">Tanggal pada bulan <?php echo $row_Recordset1['month']; ?></td>
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
	      </thead>
		  <tbody>
		    <?php if($totalRows_sql1>0){ $i=0 ;do{ ?>
		    <tr class="tabel_body">
		      <td align="center"><?php $i++; echo $i; ?></td>
		      <td><?php echo $row_sql1['firstname']; ?> <?php echo $row_sql1['midlename']; ?> <?php echo $row_sql1['lastname']; ?></td>
		      <td><?php echo $row_sql1['nik']; ?></td>
		      <td><?php echo $row_sql1['department']; ?></td>
		      <td><?php echo $row_sql1['skill']; ?></td>
		      <td align="center"><?php echo $row_sql1[mp1]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp2]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp3]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp4]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp5]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp6]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp7]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp8]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp9]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp10]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp11]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp12]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp13]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp14]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp15]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp16]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp17]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp18]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp19]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp20]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp21]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp22]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp23]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp24]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp25]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp26]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp27]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp28]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp29]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp30]; ?></td>
		      <td align="center"><?php echo $row_sql1[mp31]; ?></td>
		      <td><?php echo $row_sql1['keterangan'];?></td>
	        </tr>
		    <?php
  }while($row_sql1 = mysql_fetch_assoc($Recordset2));
  }
  ?>
	      </tbody>
	  </table>
		<p>
        <?php
}
	?>
      </p>
      <p><?php {include "lokasi.php";} ?></p>
      <table width="1115">
        <tr>
          <td>&nbsp;</td>
          <td width="96"><p>Prepare By :
            <p class="hidentext">.</p>
            <p class="hidentext">.</p>
            <p class="hidentext">.</p>
          <?php echo $row_Recordset1['prepare_by']; ?></td>
          <td width="96"><p>Checked By :                  
            <p class="hidentext">.</p>
            <p class="hidentext">.</p>
            <p class="hidentext">.</p>
            <?php echo $row_Recordset1['checked_by']; ?></td>
          <td width="96"><p>Approve By :                 
            <p class="hidentext">.</p>
            <p class="hidentext">.</p>
            <p class="hidentext">.</p>
            <?php echo $row_Recordset1['approved_by']; ?></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    <p>&nbsp; </p></td>
  </tr>
</table>
<p><p><p><p>
<p>
  
</body>
</html>
<?php
	mysql_free_result($sql1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
