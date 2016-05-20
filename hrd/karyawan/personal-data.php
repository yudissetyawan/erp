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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_datapribadi WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<html>
<head>
<title></title>
</head>
<body>

<table border="1">
  <tr class="tabel_body">
    <td>NIK</td>
    <td>Nama</td>
    <td>Departemen</td>
  </tr>
  <tr>
    <td><?php echo $row_Recordset2['nik']; ?></td>
    <td><?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['midlename']; ?> <?php echo $row_Recordset2['lastname']; ?></td>
    <td><?php echo $row_Recordset2['department']; ?></td>
  </tr>
</table>
<form id="form1" name="form1" method="POST">
        <table width="998" border="0" cellspacing="1" cellpadding="0">
            <tr>
                <td width="174"></td>
                <td width="9">&nbsp;</td>
                <td width="388"><input name="id_datapribadi" type="text" class="textarea" id="id_datapribadi" size="5" readonly /></td>
                <td width="162">&nbsp;</td>
                <td width="12">&nbsp;</td>
                <td width="246">&nbsp;</td>
          </tr>
              <tr>
                <td><span class="General">Jenis Kelamin</span></td>
                <td>:</td>
                <td><?php echo $row_Recordset1['jk']; ?></td>
                <td>Ukuran Baju</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['ukuran_baju']; ?></td>
          </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['status']; ?></td>
                <td>Ukuran Celana</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['ukuran_celana']; ?></td>
          </tr>
              <tr>
                <td>No. KTP</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['noktp']; ?></td>
                <td>Coverall (Dale)</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['Coverall']; ?></td>
          </tr>
              <tr>
                <td> Berlaku KTP Sampai dengan</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['berlakuktp']; ?></td>
                <td>Ukuran Sepatu (Safety)</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['ukuran_sepatu']; ?></td>
          </tr>
              <tr>
                <td>Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td><strong><?php echo $row_Recordset1['tempat_lahir']; ?>/<?php echo $row_Recordset1['tgl_lahir']; ?></strong></td>
                <td>Pendidikan Terakhir</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['pendidikan']; ?></td>
          </tr>
              <tr>
                <td>Umur</td>
                <td>:</td>
                <td>                  Tahun</td>
                <td>Nama Sekolah/PT</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['namapend']; ?></td>
          </tr>
              <tr>
                <td>Alamat Rumah</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['alamat']; ?></td>
                <td>Jurusan</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['jurusan']; ?></td>
          </tr>
              <tr>
                <td>Kode Pos </td>
                <td>:</td>
                <td><?php echo $row_Recordset1['poscode']; ?></td>
                <td>No. KPJ</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['nokpj']; ?></td>
          </tr>
              <tr>
                <td>No. Telp</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['notlp']; ?></td>
                <td>Gol. Darah</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['gol_darah']; ?></td>
          </tr>
              <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['nohp']; ?></td>
                <td>No. NPWP</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['no_npwp']; ?></td>
          </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['agama']; ?></td>
                <td>Email</td>
                <td>:</td>
                <td><?php echo $row_Recordset1['email']; ?></td>
          </tr>
              <tr>
                <td>Berat Badan</td>
                <td>:</td>
                <td> <?php echo $row_Recordset1['berat']; ?>Kg</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
          </tr>
              <tr>
                <td>Tinggi Badan</td>
                <td>&nbsp;</td>
                <td><?php echo $row_Recordset1['tinggi']; ?>Cm</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6" align="center">:<img src="../../images/google-chrome-print.gif" width="26" height="29" /> | <img src="../../images/edit.png" width="29" height="29" /></td>
          </tr>
  </table>
</form>
</body>
</html>
      <?php
mysql_free_result($Recordset3);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
