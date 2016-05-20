<?php require_once('../Connections/core.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include('../library/mrom.php');?>
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
  <?php {
include "../date.php";} ?>

<form method="POST" action="<?php echo $editFormAction; ?>" id="form1" name="form1" >
  <table width="847" border="1">
    <tr>
      <td width="135"><img src="../images/bukaka.jpg" alt="" width="120" height="27" /></td>
      <td colspan="2"><label for="no_urutcpar">
        <input name="id" type="text" id="id" value="<?php echo $row_q_cpar['id']; ?>" />
        <input type="text" name="no_urutcpar" id="no_urutcpar2" value="<?php echo $next; ?>" />
      </label></td>
      <td colspan="2">Nomor. <input name="no_cpar" size="32" value="<?php echo $row_q_cpar['no_cpar']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="5" align="center">PERMINTAAN TINDAKAN PERBAIKAN / PENCEGAHAN</td>
    </tr>
    <tr>
      <td colspan="5" align="center">( CORRECTIVE &amp; PREVENTIVE ACTION REQUEST )</td>
    </tr>
    <tr>
      <td>Kepada (Dept.):</td>
      <td width="479"><label for="kepada"><input name="kepada" size="32" value="<?php echo $row_q_cpar['department']; ?>" /></label></td>
      <td colspan="2">Masalah:</td>
      <td width="265"><textarea name="masalah" cols="40" rows="3"><?php echo $row_q_cpar['masalah']; ?></textarea></td>
    </tr>
    <tr>
      <td>Dari (Penemu):</td>
      <td colspan="4">
        <label for="dari"><input name="dari" size="32" value="<?php echo $row_q_cpar['dari']; ?>" /></label></td>
    </tr>
    <tr>
      <td>Tanggal:</td>
      <td colspan="4"><label for="tanggal"><input name="tanggal" id="tanggal1" size="32" value="<?php echo $row_q_cpar['tanggal']; ?>" /></label></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">1. Uraian Ketidakpuasan / Potensi Ketidaksesuaian</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="7"><label for="uraian_ketidakpuasan"></label>
      <textarea name="uraian_ketidakpuasan" id="uraian_ketidakpuasan"  readonly="readonly" cols="100" rows="10"><?php echo $row_q_cpar['uraian_ketidakpuasan']; ?></textarea></td>
      <td>Dibuat Oleh</td>
    </tr>
    <tr>
      <td><label for="dibuat_oleh"></label>
      <select name="dibuat_oleh">
      <option value="<?php echo $row_dibuat_oleh['dibuat_oleh']; ?>"><?php echo $row_dibuat_oleh['firstname']; ?> <?php echo $row_dibuat_oleh['midlename']; ?> <?php echo $row_dibuat_oleh['lastname']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_h_employee_dari['id']?>"><?php echo $row_h_employee_dari['firstname']?> <?php echo $row_h_employee_dari['midlename']; ?> <?php echo $row_h_employee_dari['lastname']; ?></option>
        <?php
} while ($row_h_employee_dari = mysql_fetch_assoc($h_employee_dari));
  $rows = mysql_num_rows($h_employee_dari);
  if($rows > 0) {
      mysql_data_seek($h_employee_dari, 0);
	  $row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_dibuat"></label>
        <input name="tanggal_dibuat" type="text" value="<?php echo $row_q_cpar['tanggal_dibuat']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Disetujui Oleh</td>
    </tr>
    <tr>
      <td><select name="disetujui_oleh">
      <option value="<?php echo $row_disetujui_oleh['disetujui_oleh']; ?>"><?php echo $row_disetujui_oleh['firstname']; ?><?php echo $row_disetujui_oleh['midlename']; ?> <?php echo $row_disetujui_oleh['lastname']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_h_employee_dari['id']?>"><?php echo $row_h_employee_dari['firstname']?> <?php echo $row_h_employee_dari['midlename']; ?> <?php echo $row_h_employee_dari['lastname']; ?></option>
        <?php
} while ($row_h_employee_dari = mysql_fetch_assoc($h_employee_dari));
  $rows = mysql_num_rows($h_employee_dari);
  if($rows > 0) {
      mysql_data_seek($h_employee_dari, 0);
	  $row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
  }
?>
      </select>
      </td>
    </tr>
    <tr>
      <td>Tgl. 
<input name="tanggal_disetujui" type="text" value="<?php echo $row_q_cpar['tanggal_disetujui']; ?>" />        </td>
    </tr>
    <tr>
      <td colspan="5">2. Analisa Penyebab Ketidakpuasan / Potensi Ketidaksesuaian</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="4"><label for="analisa_penyebab"></label>
      <textarea readonly="readonly" name="analisa_penyebab" id="analisa_penyebab" cols="100" rows="10"><?php echo $row_q_cpar['analisa_penyebab']; ?></textarea></td>
      <td>Dianalisa Oleh</td>
    </tr>
    <tr>
      <td><label for="dianalisa_oleh"></label>
        <select name="dianalisa_oleh" id="dianalisa_oleh">
        <option value="<?php echo $row_dianalisa_oleh['dianalisa_oleh']; ?>"><?php echo $row_dianalisa_oleh['firstname']; ?> <?php echo $row_dianalisa_oleh['midlename']; ?> <?php echo $row_dianalisa_oleh['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_dari['id']?>"><?php echo $row_h_employee_dari['firstname']?> <?php echo $row_h_employee_dari['midlename']; ?> <?php echo $row_h_employee_dari['lastname']; ?> </option>
          <?php
} while ($row_h_employee_dari = mysql_fetch_assoc($h_employee_dari));
  $rows = mysql_num_rows($h_employee_dari);
  if($rows > 0) {
      mysql_data_seek($h_employee_dari, 0);
	  $row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
  }
?>
        </select>
        </td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_dianalisa"></label>
        <input name="tanggal_dianalisa" type="text" value="<?php echo $row_q_cpar['tanggal_dianalisa']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">3.Tindakan Perbaikan / Pencegahan</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="6"><label for="tindakan_perbaikan"></label>
      <textarea readonly="readonly" name="tindakan_perbaikan" id="tindakan_perbaikan" cols="100" rows="10"><?php echo $row_q_cpar['tindakan_perbaikan']; ?></textarea></td>
      <td>Penanggung Jawab</td>
    </tr>
    <tr>
      <td><label for="penanggung_jawab"></label>
        <select name="penanggung_jawab" id="penanggung_jawab">
        <option value="<?php echo $row_penanggung_jawab['penanggung_jawab']; ?>"><?php echo $row_penanggung_jawab['firstname']; ?> <?php echo $row_penanggung_jawab['midlename']; ?> <?php echo $row_penanggung_jawab['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_dari['id']?>"><?php echo $row_h_employee_dari['firstname']?> <?php echo $row_h_employee_dari['midlename']; ?> <?php echo $row_h_employee_dari['lastname']; ?></option>
          <?php
} while ($row_h_employee_dari = mysql_fetch_assoc($h_employee_dari));
  $rows = mysql_num_rows($h_employee_dari);
  if($rows > 0) {
      mysql_data_seek($h_employee_dari, 0);
	  $row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tgl_penanggung_jwb"></label>
        <input name="tgl_penanggung_jwb" type="text" value="<?php echo $row_q_cpar['tgl_penanggung_jwb']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Target Selesai</td>
    </tr>
    <tr>
      <td><label for="target_selesai"><input name="target_selesai" type="text" value="<?php echo $row_q_cpar['target_selesai']; ?>" /></label></td>
    </tr>
    <tr>
      <td colspan="5">4. Pemeriksaan Tindakan Perbaikan / Pencegahan</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="8"><label for="pemeriksaan_tindakan"></label>
      <textarea readonly="readonly" name="pemeriksaan_tindakan" id="pemeriksaan_tindakan" cols="100" rows="10"><?php echo $row_q_cpar['pemeriksaan_tindakan']; ?></textarea></td>
      <td>Diperiksa Oleh</td>
    </tr>
    <tr>
      <td><label for="diperiksa_oleh"></label>
        <select name="diperiksa_oleh" id="diperiksa_oleh">
        <option value="<?php echo $row_diperiksa_oleh['diperiksa_oleh']; ?>"><?php echo $row_diperiksa_oleh['firstname']; ?> <?php echo $row_diperiksa_oleh['midlename']; ?> <?php echo $row_diperiksa_oleh['lastname']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_dari['id']?>"><?php echo $row_h_employee_dari['firstname']?> <?php echo $row_h_employee_dari['midlename']; ?> <?php echo $row_h_employee_dari['lastname']; ?></option>
          <?php
} while ($row_h_employee_dari = mysql_fetch_assoc($h_employee_dari));
  $rows = mysql_num_rows($h_employee_dari);
  if($rows > 0) {
      mysql_data_seek($h_employee_dari, 0);
	  $row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_diperiksa"></label>
        <input name="tanggal_diperiksa" type="text" value="<?php echo $row_q_cpar['tanggal_diperiksa']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Diketahui Oleh </td>
    </tr>
    <tr>
      <td>(QMR)</td>
    </tr>
    <tr>
      <td> <label for="qmr"></label>
      <select name="qmr" id="qmr">
      <option value="<?php echo $row_qmr['diketahui_oleh']; ?>"><?php echo $row_qmr['firstname']; ?> <?php echo $row_qmr['midlename']; ?><?php echo $row_qmr['lastname']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_h_employee_dari['id']?>"><?php echo $row_h_employee_dari['firstname']?> <?php echo $row_h_employee_dari['midlename']; ?> <?php echo $row_h_employee_dari['lastname']; ?></option>
        <?php
} while ($row_h_employee_dari = mysql_fetch_assoc($h_employee_dari));
  $rows = mysql_num_rows($h_employee_dari);
  if($rows > 0) {
      mysql_data_seek($h_employee_dari, 0);
	  $row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_diketahui"></label>
        <input name="tanggal_diketahui" type="text" value="<?php echo $row_q_cpar['tanggal_diketahui']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="5" align="center"><input type="submit" name="submit" id="submit" value="Update" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>


</body>
</html>
<?php
mysql_free_result($h_employee_dari);

mysql_free_result($dibuat_oleh);

mysql_free_result($disetujui_oleh);

mysql_free_result($dianalisa_oleh);

mysql_free_result($penanggung_jawab);

mysql_free_result($diperiksa_oleh);

mysql_free_result($qmr);

mysql_free_result($q_cpar);
?>
