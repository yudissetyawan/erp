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
    <td width="1017"><p align="center"><strong>Find DATA PELAMAR</strong></p>
      <form id="form1" name="form1" method="post" action="">
        <div align="center">
          <table width="419" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td class="General">Silahkan Masukkan Kata yang dicari =&gt;</td>
              <td>:</td>
              <td><input type="text" name="cari" id="cari"></td>
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
	  $sql=mysql_query("SELECT * FROM h_recruitment WHERE h_recruitment.nama LIKE '%$cari%'");
	  
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>No data available in table </bink></center>";
	  } else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
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
          <th width='43'>Skill Test</th>
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
          <td ><b><?=$sql1[firstname]. ' ' .$sql1[midlename].' '.$sql1[lastname];?></b></td>
          <td align='center'><?php echo $sql1[jk]; ?></td>
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
</html>