<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php {include "../date.php";}?>
<form id="form1" name="form1" method="post" action="">
  <table width="722" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td width="162" class="General">&nbsp;</td>
      <td width="9">&nbsp;</td>
      <td><input type="text" name="id_pelamar" id="id_pelamar" /></td>
      <td width="57" class="General">Date</td>
      <td width="14">&nbsp;</td>
      <td width="175"><input type="text" name="date" id="tanggal1" /></td>
    </tr>
    <tr>
      <td class="General">Nama</td>
      <td>:</td>
      <td><input type="text" name="nama" id="nama" /></td>
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
      <td class="General">Date</td>
      <td>:</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Pelaksana</td>
      <td>:</td>
      <td colspan="4">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>