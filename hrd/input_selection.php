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
  $updateSQL = sprintf("UPDATE h_recruitment SET skill_test=%s, interview=%s, psikotes=%s, mcu=%s, agreement=%s WHERE no_pelamar=%s",
                       GetSQLValueString(isset($_POST['skill_test']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['interview']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['psikotes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['mcu']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['agreement']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['no_pelamar'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO h_selection_interview (id_pelamar, sd_tahun, sltp_tahun, slta_tahun, pend_terakhir, jurusan, ipk, gaji_diinginkan, posisi_dilamar, skill, leadership, loyalitas, tanggung_jawab, bakat, kepribadian, intelektual, kesimpulan, saran, date_interview, pelaksana_interview, suku, penyakit_bawaan) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pelamar'], "text"),
                       GetSQLValueString($_POST['sd_tahun'], "text"),
                       GetSQLValueString($_POST['sltp_tahun'], "text"),
                       GetSQLValueString($_POST['slta_tahun'], "text"),
                       GetSQLValueString($_POST['pend_terakhir'], "text"),
                       GetSQLValueString($_POST['jurusan'], "text"),
                       GetSQLValueString($_POST['ipk'], "text"),
                       GetSQLValueString($_POST['gaji_diinginkan'], "text"),
                       GetSQLValueString($_POST['posisi_dilamar'], "text"),
                       GetSQLValueString($_POST['skill'], "text"),
                       GetSQLValueString($_POST['leadership'], "text"),
                       GetSQLValueString($_POST['loyalitas'], "text"),
                       GetSQLValueString($_POST['tanggung_jawab'], "text"),
                       GetSQLValueString($_POST['bakat'], "text"),
                       GetSQLValueString($_POST['kepribadian'], "text"),
                       GetSQLValueString($_POST['skill'], "text"),
                       GetSQLValueString($_POST['kesimpulan'], "text"),
                       GetSQLValueString($_POST['saran'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['pelaksana'], "text"),
                       GetSQLValueString($_POST['suku'], "text"),
                       GetSQLValueString($_POST['penyakit'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO h_selection_skilltest (id_pelamar, nama, pendidikan, posisi, testskill, kesimpulan, saran, `date`, pelaksana) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pelamar2'], "text"),
                       GetSQLValueString($_POST['nama2'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['posisi'], "text"),
                       GetSQLValueString($_POST['test_skill'], "text"),
                       GetSQLValueString($_POST['kesimpulan'], "text"),
                       GetSQLValueString($_POST['saran'], "text"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['pelaksana'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1033" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
      <table width="578" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="100" class="General">&nbsp;</td>
          <td width="10">&nbsp;</td>
          <td colspan="5"><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" /></td>
          </tr>
        <tr>
          <td class="General">No. Pelamar</td>
          <td>:</td>
          <td colspan="5"><input name="no_pelamar" type="text" id="no_pelamar" value="<?php echo $row_Recordset1['no_pelamar']; ?>" readonly="readonly" /></td>
          </tr>
        <tr>
          <td class="General">Nama</td>
          <td>:</td>
          <td colspan="5"><input name="nama" type="text" id="nama" value="<?php echo $row_Recordset1['firstname'].' '.$row_Recordset1['midlename'].' '.$row_Recordset1['lastname']; ?>" readonly="readonly" /></td>
          </tr>
        <tr>
          <td class="General">Date Apply</td>
          <td>:</td>
          <td colspan="5"><input name="date" type="text" id="date" value="<?php echo $row_Recordset1['date']; ?>" readonly="readonly" /></td>
          </tr>
        <tr>
          <td class="General">Recruitment Step</td>
          <td>:</td>
          <td width="86"><input name="skill_test" type="checkbox" id="skill_test" value="<>" />            
            Skill Test</td>
          <td width="112"><input name="interview" type="checkbox" id="interview" />
            Interview</td>
          <td width="94"><input name="psikotes" type="checkbox" id="psikotes" />
            Psikotes</td>
          <td width="58"><input name="mcu" type="checkbox" id="mcu" />
            MCU</td>
          <td width="96"><input name="agreement" type="checkbox" id="agreement" />
            Agreement</td>
          </tr>
        <tr>
          <td class="General">&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      <input type="hidden" name="MM_update" value="form1" />
    </form></td>
  </tr>
  <tr>
    <td><div id="TabbedPanels1" class="TabbedPanels">
      <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="0">Skill Test</li>
        <li class="TabbedPanelsTab" tabindex="0">Interview</li>
        <li class="TabbedPanelsTab" tabindex="0">Psikotes</li>
        <li class="TabbedPanelsTab" tabindex="0">MCU</li>
      </ul>
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <form id="form2" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="722" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="162" class="General">&nbsp;</td>
                <td width="9">&nbsp;</td>
                <td><input type="text" name="id_pelamar2" id="id_pelamar2" /></td>
                <td width="57" class="General">Date</td>
                <td width="14">&nbsp;</td>
                <td width="175"><input type="text" name="tanggal" id="tanggal1" /></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td>:</td>
                <td><input type="text" name="nama2" id="nama2" /></td>
                <td class="General">Pelaksana</td>
                <td>&nbsp;</td>
                <td><input type="text" name="pelaksana" id="pelaksana" /></td>
              </tr>
              <tr>
                <td class="General">Pendidikan</td>
                <td>:</td>
                <td colspan="4"><input type="text" name="pendidikan" id="pendidikan" /></td>
              </tr>
              <tr>
                <td class="General">Posisi yang Dilamar</td>
                <td>:</td>
                <td colspan="4"><input type="text" name="posisi" id="posisi" /></td>
              </tr>
              <tr>
                <td class="General">Hasil Test Skill </td>
                <td>:</td>
                <td width="305"><textarea name="test_skill" id="test_skill" cols="45" rows="5"></textarea></td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kesimpulan</td>
                <td>:</td>
                <td colspan="4"><textarea name="kesimpulan" id="kesimpulan" cols="45" rows="5"></textarea></td>
              </tr>
              <tr>
                <td class="General">Saran</td>
                <td>:</td>
                <td colspan="4"><textarea name="saran" id="saran" cols="45" rows="5"></textarea></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="4"><label>
                  <input type="submit" name="button" id="button" value="Submit" />
                  </label></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1" />
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="956" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td colspan="2" class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td width="150" class="General">&nbsp;</td>
      <td width="11">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="190" class="General">No. Pelamar</td>
      <td width="10" class="General">:</td>
      <td width="302"><input type="text" name="id_pelamar" id="id_pelamar" /></td>
    </tr>
    <tr>
      <td class="General">Nama</td>
      <td class="General">:</td>
      <td><input type="text" name="nama" id="nama" /></td>
      <td rowspan="3" class="General">Riwayat Pekerjaan</td>
      <td rowspan="3">:</td>
      <td rowspan="3"><textarea name="riwayat" id="riwayat" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td class="General">Jenis Kelamin</td>
      <td class="General">&nbsp;</td>
      <td><input type="text" name="jk" id="jk" /></td>
    </tr>
    <tr>
      <td class="General">Alamat</td>
      <td class="General">:</td>
      <td><textarea name="alamat" id="alamat" cols="30" rows="2"></textarea></td>
    </tr>
    <tr>
      <td class="General">No. Telepon / HP</td>
      <td class="General">:</td>
      <td><input type="text" name="telp" id="telp" /></td>
      <td rowspan="3" class="General">Skill yang mendukung</td>
      <td rowspan="3">:</td>
      <td rowspan="3"><textarea name="skill" id="skill" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td class="General">Agama</td>
      <td class="General">:</td>
      <td><input type="text" name="agama" id="agama" /></td>
    </tr>
    <tr>
      <td class="General">Suku</td>
      <td class="General">:</td>
      <td><input type="text" name="suku" id="suku" /></td>
    </tr>
    <tr>
      <td class="General">Tinggi Badan</td>
      <td class="General">:</td>
      <td><input type="text" name="tinggi" id="tinggi" /></td>
      <td rowspan="3" class="General">Leadership</td>
      <td rowspan="3">:</td>
      <td rowspan="3"><textarea name="leadership" id="leadership" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td class="General">Berat Badan</td>
      <td class="General">:</td>
      <td><input type="text" name="berat" id="berat" /></td>
    </tr>
    <tr>
      <td height="41" class="General">Penyakit Bawaan</td>
      <td class="General">:</td>
      <td><input type="text" name="penyakit" id="penyakit" /></td>
    </tr>
    <tr>
      <td colspan="2" class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td rowspan="2">Loyalitas</td>
      <td rowspan="2">:</td>
      <td rowspan="2"><textarea name="loyalitas" id="loyalitas" cols="45" rows="2"></textarea></td>
    </tr>
    <tr>
      <td class="General">SD Tahun</td>
      <td class="General">:</td>
      <td><input type="text" name="sd_tahun" id="sd_tahun" /></td>
    </tr>
    <tr>
      <td class="General">SLTP. Tahun</td>
      <td class="General">&nbsp;</td>
      <td><input type="text" name="sltp_tahun" id="sltp_tahun" /></td>
      <td rowspan="2" class="General">Tanggung Jawab</td>
      <td rowspan="2">:</td>
      <td rowspan="2"><textarea name="tanggung_jawab" id="tanggung_jawab" cols="45" rows="2"></textarea></td>
    </tr>
    <tr>
      <td class="General">SLTA Tahun</td>
      <td class="General">:</td>
      <td><input type="text" name="slta_tahun" id="slta_tahun" /></td>
    </tr>
    <tr>
      <td class="General">Pendidikan Terakhir</td>
      <td class="General">:</td>
      <td><select name="pend_terakhir" id="pend_terakhir">
        <option value="SD">SD</option>
        <option value="SLTP">SLTP</option>
        <option value="SLTA">SLTA</option>
        <option value="DI/DII">DI/DII</option>
        <option value="D3">D3</option>
        <option value="S1">S1</option>
        <option value="S2">S2</option>
        <option value="S3">S3</option>
      </select></td>
      <td rowspan="2" class="General">Bakat dalam Pekerjaan</td>
      <td rowspan="2">:</td>
      <td rowspan="2"><textarea name="bakat" id="bakat" cols="45" rows="2"></textarea></td>
    </tr>
    <tr>
      <td class="General">Fakultas / Jurusan</td>
      <td class="General">:</td>
      <td><input type="text" name="jurusan" id="jurusan" /></td>
    </tr>
    <tr>
      <td class="General">IPK</td>
      <td class="General">:</td>
      <td><input type="text" name="ipk" id="ipk" /></td>
      <td rowspan="2" class="General">Kepribadian</td>
      <td rowspan="2">:</td>
      <td rowspan="2"><textarea name="kepribadian" id="kepribadian" cols="45" rows="2"></textarea></td>
    </tr>
    <tr>
      <td class="General">Gaji yang di inginkan</td>
      <td class="General">:</td>
      <td><input type="text" name="gaji_diinginkan" id="gaji_diinginkan" /></td>
    </tr>
    <tr>
      <td class="General">Bagian/ Posisi yang diinginkan</td>
      <td class="General">:</td>
      <td><input type="text" name="posisi_dilamar" id="posisi_dilamar" /></td>
      <td class="General">Kemampuan Intelektual</td>
      <td>:</td>
      <td><input name="textfield" type="text" id="textfield" size="45" /></td>
    </tr>
    <tr>
      <td class="General">Date</td>
      <td class="General">:</td>
      <td><input type="text" name="date" id="date" /></td>
      <td class="General">Kesimpulan</td>
      <td>:</td>
      <td><textarea name="kesimpulan" id="kesimpulan" cols="45" rows="2"></textarea></td>
    </tr>
    <tr>
      <td class="General">Pelaksana</td>
      <td>:</td>
      <td><input type="text" name="pelaksana" id="pelaksana" /></td>
      <td class="General">Saran</td>
      <td>:</td>
      <td><textarea name="saran" id="saran" cols="45" rows="2"></textarea></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button2" id="button2" value="Submit" />
      </label></td>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
          </form>
        </div>
        <div class="TabbedPanelsContent">Content 3</div>
        <div class="TabbedPanelsContent">Content 4</div>
      </div>
    </div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
