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
$query_sql1 = "SELECT * FROM h_recruitment";
$sql1 = mysql_query($query_sql1, $core) or die(mysql_error());
$row_sql1 = mysql_fetch_assoc($sql1);
mysql_select_db($database_core, $core);
$query_sql1 = "SELECT * FROM h_recruitment ";
$sql1 = mysql_query($query_sql1, $core) or die(mysql_error());
$row_sql1 = mysql_fetch_assoc($sql1);
$totalRows_sql1 = mysql_num_rows($sql1);

mysql_select_db($database_core, $core);
$query_sql2 = "SELECT h_recruitment.no_pelamar, h_datapribadi.id_datapribadi, h_datapribadi.jk FROM h_recruitment, h_datapribadi WHERE h_datapribadi.id_datapribadi=h_recruitment.id";
$sql2 = mysql_query($query_sql2, $core) or die(mysql_error());
$row_sql2 = mysql_fetch_assoc($sql2);
$totalRows_sql2 = mysql_num_rows($sql2);
?>
<?
include "../config.php";
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
</style><body class="General">
<table width="1000" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1017"><p align="center"><strong>PENCARIAN DATA PELAMAR</strong></p>
      <form id="form1" name="form1" method="post" action="">
        <div align="center">
          <table width="419" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td class="General">Pencarian Berdasarkan Pendidikan Terakhir</td>
              <td>:</td>
              <td><select name="cari" id="cari">
                <option value="">Pendidikan Terakhir</option>
                <option value="SD">SD</option>
                <option value="SLTP">SLTP</option>
                <option value="SLTA">SLTA</option>
                <option value="DIII">DIII</option>
                <option value="S1">S1</option>
              </select></td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="Submit" value="Filter" /></td>
            </tr>
          </table>
        </div>
      </form>
      <?
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      <p align="center"><strong>Aplicant Data :</strong></p>
      <p>
        <?
	  $sql=mysql_query("SELECT h_recruitment.id, h_recruitment.no_pelamar, h_recruitment.firstname, h_recruitment.midlename,h_recruitment.lastname, h_recruitment.status, h_recruitment.date, h_recruitment.skill_test, h_recruitment.interview, h_recruitment.psikotes, h_recruitment.mcu, h_recruitment.agreement, h_datapribadi.id,  h_datapribadi.pendidikan, h_datapribadi.jk FROM h_recruitment INNER JOIN h_datapribadi WHERE (h_recruitment.id=h_datapribadi.id) AND (h_datapribadi.pendidikan LIKE '%$cari%')");
	  
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>Maaf Data yang anda cari tidak ada di dalam database</bink></center>";
	  } else {
	  echo "Jumlah Seluruh Data yang ditemukan Adalah <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <p>
      <table width="991" border="0" cellspacing="1" cellpadding="0">
        <tr class="tabel_header">
          <th width='42' rowspan="2" >No.</th>
          <th width='71' rowspan="2">No. Pelamar</th>
          <th width='223' rowspan="2">Nama</th>
          <th width='138' rowspan="2">Gender</th>
          <th width='138' rowspan="2">Pendidikan</th>
          <th width='138' rowspan="2">Date Apply</th>
          <th colspan="5">Recruitment Step</th>
        </tr>
        <tr class="tabel_header">
          <th width='43' class="tabel_header">Skill Test</th>
          <th width='43' class="tabel_header">Interview</th>
          <th width='43' class="tabel_header">Psikotes</th>
          <th width='43' class="tabel_header">MCU</th>
          <th width='44' class="tabel_header">Agreement</th>
        </tr>
        <? 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
        <tr class="tabel_body">
          <?php $i=$i+1; ?>
          <td align='center'><?php echo $i ; ?></td>
          <td ><a href="input_selection.php?data=<?php echo $sql1['id']; ?>"><?php echo $sql1[no_pelamar];?></a></td>
          <td width="67">
          <a href="viewcvdetailprint.php?data=<?php echo $sql1['id']; ?>" target="new"><? echo $sql1[firstname]. ' ' .$sql1[midlename].' '.$sql1[lastname];?></a><a href="viewcvdetail.php?data=<?php echo $sql1['id']; ?>" target="new"></b></a>
          
          <td align='center'><?php echo $sql1[jk];?></td>
          <td align='center'><?php echo $sql1[pendidikan];?></td>
          <td align='center'><?php echo $sql1[date];?></td>
          <td align='center'><?php 
		if ($sql1[skill_test]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[interview]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[psikotes]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[mcu]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[agreement]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
        </tr>
        <?
		}
		?>
      </table>
      <?
	}
	?></td>
  </tr>
</table>
<p><p><p><p>
<p>
  
</body>
</html><?php
mysql_free_result($sql1);

mysql_free_result($sql2);
?>
