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

$colname_sql1 = "-1";
if (isset($_GET['data'])) {
  $colname_sql1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_sql1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_sql1, "int"));
$sql1 = mysql_query($query_sql1, $core) or die(mysql_error());
$row_sql1 = mysql_fetch_assoc($sql1);
$totalRows_sql1 = mysql_num_rows($sql1);
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
              <td class="General">Pencarian Berdasarkan Jenis Kelamin</td>
              <td>:</td>
              <td><select name="cari" id="cari">
                <option value="" selected="selected">Posisi yang Dilamar</option>
                <option value="Site Coordinator">Site Coordinator</option>
                <option value="Operator Vacum Truck">Operator Vacum Truck</option>
                <option value="Asst. Operator Vacum Truck">Asst. Operator Vacum Truck</option>
                <option value="Asst. Operator Plant">Asst. Operator Plant</option>
                <option value="Machinist">Machinist</option>
                <option value="Machinis Plan">Machinis Plan</option>
                <option value="Electric Plan">Electric Plan</option>
                <option value="Mechanic Plan">Mechanic Plan</option>
                <option value="Operator Vacum">Operator Vacum</option>
                <option value="Asst. Administrasi Field">Asst. Administrasi Field</option>
                <option value="Operator Crane">Operator Crane</option>
                <option value="operator HE">operator HE</option>
                <option value="Operator Crane Mobil">Operator Crane Mobil</option>
                <option value="Field Administrasi Asst.">Field Administrasi Asst.</option>
                <option value="Rigger">Rigger</option>
                <option value="Tools Keeper">Tools Keeper</option>
                <option value="Administrasi Asst.">Administrasi Asst.</option>
                <option value="Instrument Process Plant">Instrument Process Plant</option>
                <option value="Instrument Techniciant">Instrument Techniciant</option>
                <option value="Instrument Plant">Instrument Plant</option>
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
	  $sql=mysql_query("SELECT h_recruitment.id, h_recruitment.no_pelamar, h_recruitment.firstname, h_recruitment.midlename,h_recruitment.lastname, h_recruitment.status, h_recruitment.date, h_recruitment.skill_test, h_recruitment.interview, h_recruitment.psikotes, h_recruitment.mcu, h_recruitment.agreement, h_job_position.id_pelamar, h_job_position.posisi 
	  
FROM h_recruitment 
INNER JOIN h_job_position 
WHERE (h_recruitment.id=h_job_position.id_pelamar) AND (h_job_position.posisi LIKE '%$cari%')");
	  
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>Maaf Data yang anda cari tidak ada di dalam database</bink></center>";
	  } else {
	  echo "Jumlah Seluruh Data yang ditemukan Adalah <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="700" border="0" cellspacing="1" cellpadding="0">
        <tr class="tabel_header">
          <th width='42' rowspan="2" >No.</th>
          <th width='71' rowspan="2">No. Pelamar</th>
          <th width='223' rowspan="2">Nama</th>
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
?>
