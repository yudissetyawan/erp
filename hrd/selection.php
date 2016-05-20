<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
</style></head>

<body>
<table width="832" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="171" rowspan="2" valign="top"><table width="166" border="0" cellspacing="0" cellpadding="0">
      <tr class="tabel_index">
        <td width="164" class="tabel_index">Kategori Pencarian</td>
        <td width="10" colspan="2" rowspan="3" class="General">&nbsp;</td>
      </tr>
      <tr>
        <td class="tabel_number"><strong><a href="?modul=sim">SIM</a></strong></td>
      </tr>
      <tr>
        <td class="tabel_number"><strong><a href="?modul=pendidikan">Pendidikan</a></strong></td>
      </tr>
	 <tr>
        <td class="tabel_number"><strong><a href="?modul=jk">Jenis Kelamin</a></strong></td>
      </tr>
      <tr>
        <td class="tabel_number"><strong><a href="?modul=status">Status Karyawan</a></strong></td>
      </tr>
      <tr>
        <td class="tabel_number"><strong><a href="?modul=posisi">Posisi yang dilamar</a></strong></td>
      </tr>
    </table></td>
    <td width="658" rowspan="2" valign="top"><?php
                    	if($_GET[modul]=='sim'){
							include "find_sim.php";
							}
						elseif ($_GET[modul]=='status'){
							include "view_selection.php";
							}
						elseif ($_GET[modul]=='pendidikan'){
							include "find_pendidikan.php";
							}
						elseif ($_GET[modul]=='jk'){
							include "find_jk.php";
							}
							elseif ($_GET[modul]=='posisi'){
							include "find_posisi.php";
							}
						else {
							echo"=-=-=-=";
							}
					?></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>