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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT a.id, a.day_date, a.location, a.foreman, b.firstname, a.note FROM h_daily_report_header a LEFT JOIN h_employee b ON a.supervisor=b.id WHERE a.id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT a.id, a.headerid, a.employee, a.skill, a.keterangan, a.jp1, a.jp2, a.jp3, a.jp4, a.jp5, a.jp6, a.jp7, a.jp8, a.jp9, a.jp10, a.jp11, a.jp12, b.firstname,b.lastname,b.nik,c.department FROM h_daily_report_core a LEFT JOIN h_employee b ON a.employee=b.id LEFT JOIN  h_department c ON b.department=c.id WHERE a.headerid = '".$row_Recordset1['id']."'";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM h_daily_report_header WHERE id = '".$row_Recordset1['id']."'";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Report <?php echo $row_Recordset1['day_date']; ?></title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		// jeditable yang untuk header	
		$(".headereditable_select").editable("save.php?tb=h_daily_report_header&select=1&tb2=h_employee&fld=firstname", { 
			indicator : 'Saving....', // indikator saat melakukan proses
			loadurl: 'listemploy_json.php', // pengambilan data jason
			type   : "select", // tipe jeditable
			submit : "OK", // proses berlangsung saat di tekan ok
			 placeholder: '___'	//saat data kosong digantikan dengan ini
		});
		$('.headeredit').editable('save.php?tb=h_daily_report_header', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...', // saat jeditable di hoover akan muncul pesan ini
			placeholder: '___'
		});
	 	$('.headeredit_area').editable('save.php?tb=h_daily_report_header', { 
			 type      : 'textarea',
			 cancel    : 'Cancel',
			 submit    : 'OK',
			 indicator : 'Saving...',
			 rows      : 1, // tinggi sesuai nilai row
			 tooltip   : 'Click to edit...',
			 placeholder: '___'
     	});
		// sama seperti yang diatas tp yg ini untuk data core
		$(".coreeditable_select").editable("save.php?tb=h_daily_report_core&select=1&tb2=h_employee&fld=firstname", { 
			indicator  : 'Saving....',
			loadurl    : 'listemploy_json.php',
			type       : "select",
			submit     : "OK",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
		$('.coreedit').editable('save.php?tb=h_daily_report_core', {
			indicator  : 'Saving...',
			tooltip    : 'Click to edit...',
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
	 	$('.coreedit_area').editable('save.php?tb=h_daily_report_core', { 
			 type      : 'textarea',
			 cancel    : 'Cancel',
			 submit    : 'OK',
			 indicator : 'Saving...',
			 rows      : 1,
			 tooltip   : 'Click to edit...',
			 placeholder: '___'
     	});
 	});
</script>
</head>

<body>
<table width="1202">
  <tr>
    <td width="96"><strong>Day / Date</strong></td>
    <?php // data yang dikirim saat men submit id dan value  ?>
    <td width="353"><div class="headeredit" <?php // id ?>id="<?php echo $row_Recordset1['id']; ?>-day_date"><?php // value ?><?php echo $row_Recordset1['day_date']; ?></div></td>
    <td width="737"><strong>Note :</strong></td>
  </tr>
  <tr>
    <td><strong>Location</strong></td>
    <td><div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-location"><?php echo $row_Recordset1['location']; ?></div></td>
    <td rowspan="3" valign="top"><div class="headeredit_area" id="<?php echo $row_Recordset1['id']; ?>-note"><?php echo $row_Recordset1['note']; ?></div></td>
  </tr>
  <tr>
    <td><strong>Foreman</strong></td>
    <td><div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-foreman"><?php echo $row_Recordset1['foreman']; ?></div></td>
  </tr>
  <tr>
    <td><strong>Supervisor</strong></td>
    <td><div class="headereditable_select" id="<?php echo $row_Recordset1['id']; ?>-supervisor"><?php echo $row_Recordset1['firstname']; ?></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table>
  <tr class="tabel_header">
    <td width="20" rowspan="2" align="center">NO</td>
    <td width="102" rowspan="2" align="center">NAMA</td>
    <td width="76" rowspan="2" align="center">NIK</td>
    <td width="150" rowspan="2" align="center">SKILL</td>
    <td width="150" rowspan="2" align="center">BAGIAN</td>
    <td colspan="12" align="center">Jam Kerja Untuk Jenis Pekerjaan</td>
    <td width="40" rowspan="2" align="center">TOTAL</td>
    <td width="35" rowspan="2" align="center">Over Time</td>
    <td width="180" rowspan="2" align="center">Keterangan</td>
  </tr>
  <tr class="tabel_header">
    <td width="30" align="center" class="tabel_header">1</td>
    <td width="30" align="center" class="tabel_header">2</td>
    <td width="30" align="center" class="tabel_header">3</td>
    <td width="30" align="center" class="tabel_header">4</td>
    <td width="30" align="center" class="tabel_header">5</td>
    <td width="30" align="center" class="tabel_header">6</td>
    <td width="30" align="center" class="tabel_header">7</td>
    <td width="30" align="center" class="tabel_header">8</td>
    <td width="30" align="center" class="tabel_header">9</td>
    <td width="30" align="center" class="tabel_header">10</td>
    <td width="30" align="center" class="tabel_header">11</td>
    <td width="30" align="center" class="tabel_header">12</td>
  </tr>
  <?php if($totalRows_Recordset2>0){ $i=0 ;do{ ?>
  <tr class="tabel_body">
    <td align="center"><?php $i++; echo $i; ?></td>
    <td><div class="coreeditable_select" id="<?php echo $row_Recordset2['id']; ?>-employee"><?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['lastname']; ?></div></td>
    <td><?php echo $row_Recordset2['nik']; ?></td>
    <td><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-skill"><?php echo $row_Recordset2['skill'];?></div></td>
    <td><?php echo $row_Recordset2['department']; ?></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp1"><?php echo $row_Recordset2['jp1'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp2"><?php echo $row_Recordset2['jp2'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp3"><?php echo $row_Recordset2['jp3'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp4"><?php echo $row_Recordset2['jp4'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp5"><?php echo $row_Recordset2['jp5'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp6"><?php echo $row_Recordset2['jp6'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp7"><?php echo $row_Recordset2['jp7'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp8"><?php echo $row_Recordset2['jp8'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp9"><?php echo $row_Recordset2['jp9'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp10"><?php echo $row_Recordset2['jp10'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp11"><?php echo $row_Recordset2['jp11'];?></div></td>
    <td align="center"><div class="coreedit" id="<?php echo $row_Recordset2['id']; ?>-jp12"><?php echo $row_Recordset2['jp12'];?></div></td>
    <td align="center"><?php echo $total=$row_Recordset2['jp1']+ $row_Recordset2['jp2'] + $row_Recordset2['jp3'] + $row_Recordset2['jp4'] + $row_Recordset2['jp5'] +$row_Recordset2['jp6']+$row_Recordset2['jp7'] + $row_Recordset2['jp8'] + $row_Recordset2['jp9'] + $row_Recordset2['jp10'] + $row_Recordset2['jp11'] + $row_Recordset2['jp12']; ?></td>
    <td align="center"><?php if($total>8){echo $total-8;} ?></td>
    <td><div class="coreedit_area" id="<?php echo $row_Recordset2['id']; ?>-keterangan"><?php echo $row_Recordset2['keterangan'];?></div></td>
    <td width="10" align="center"><a style="text-decoration:none; color:#F00AAA" href="delrow.php?header=<?php echo $_GET['data']; ?>&data=<?php echo $row_Recordset2['id']; ?>&tb=h_daily_report_core"><strong>x</strong></a></td>
  </tr>
  <?php
  }while($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  }
  ?>
  <tr>
  	<td align="center">
    	<a style="text-decoration:none; color:#09F" href="addrow.php?data=<?php echo $_GET['data']; ?>&fld=headerid&tb=h_daily_report_core"><strong>+</strong></a>
    </td> 
  </tr>
</table>
<p>&nbsp;</p>
<table width="1115">
  <tr>
    <td width="400"><table width="400">
  <tr class="tabel_header">
    <td width="25">NO</td>
    <td width="213">JENIS PEKERJAAN</td>
    <td width="140">CODE PROJ/PROD</td>
  </tr>
  <?php $j=0; do{ ?>
  <tr class="tabel_body">
    <td align="center"><?php $j++; echo $j; ?></td>
    <td><div class="headeredit" id="<?php echo $row_Recordset3['id']; ?>-jp<?php echo $j; ?>"><?php echo $row_Recordset3['jp'.$j.'']; ?></div></td>
    <td align="center"><div class="headeredit" id="<?php echo $row_Recordset3['id']; ?>-cd<?php echo $j; ?>"><?php echo $row_Recordset3['cd'.$j.'']; ?></div></td>
  </tr>
  <?php }while ($j<6) ;?>
</table>
</td>
    <td width="403"><table width="400">
      <tr class="tabel_header">
        <td width="25">NO</td>
        <td width="213">JENIS PEKERJAAN</td>
        <td width="140">CODE PROJ/PROD</td>
      </tr>
      <?php do{ ?>
      <tr class="tabel_body">
        <td align="center"><?php $j++; echo $j; ?></td>
        <td><div class="headeredit" id="<?php echo $row_Recordset3['id']; ?>-jp<?php echo $j; ?>"><?php echo $row_Recordset3['jp'.$j.'']; ?></div></td>
        <td align="center"><div class="headeredit" id="<?php echo $row_Recordset3['id']; ?>-cd<?php echo $j; ?>"><?php echo $row_Recordset3['cd'.$j.'']; ?></div></td>
      </tr>
      <?php }while($j<12);?>
    </table></td>
    <td width="96"><p>Prepare By :</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.    </p>
    <p>___</p></td>
    <td width="96"><p>Checked By :</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
    <p>___</p></td>
    <td width="96"><p>Approve By :</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
    <p>___</p></td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
