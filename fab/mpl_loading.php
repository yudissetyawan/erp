<?php require_once('../Connections/core.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>

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
$query_Recordset1 = sprintf("SELECT a.id, a.month, a.foreman, a.supervisor, a.prepare_by, a.checked_by, a.approved_by,  b.firstname, a.note FROM f_manpower_loading_header a LEFT JOIN h_employee b ON a.supervisor=b.id WHERE a.id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $totalRows_Recordset1 = $_GET['data'];
}
$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT a.id, a.month, a.foreman, a.supervisor, a.prepare_by, a.checked_by, a.approved_by,  b.firstname,b.lastname,  a.note FROM f_manpower_loading_header a LEFT JOIN h_employee b ON a.supervisor=b.id WHERE a.id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT a.id, a.idheader, a.employee, a.skill, a.keterangan, a.mp1, a.mp2, a.mp3, a.mp4, a.mp5, a.mp6, a.mp7, a.mp8, a.mp9, a.mp10, a.mp11, a.mp12, a.mp13, a.mp14, a.mp15, a.mp16, a.mp17, a.mp18, a.mp19, a.mp20, a.mp21, a.mp22, a.mp23, a.mp24, a.mp25, a.mp26, a.mp27, a.mp28, a.mp29, a.mp30, a.mp31, b.firstname, b.nik, b.department, b.midlename, b.lastname FROM f_manpower_loading a LEFT JOIN h_employee b ON a.employee=b.id LEFT JOIN  h_department c ON b.department=c.id WHERE a.idheader = '".$row_Recordset1['id']."'";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM f_site";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM f_site WHERE id = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$idemp = $_SESSION['empID'];
mysql_select_db($database_core, $core);
$query_rsuser = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee  WHERE h_employee.id = '$idemp'";
$rsuser = mysql_query($query_rsuser, $core) or die(mysql_error());
$row_rsuser = mysql_fetch_assoc($rsuser);
$totalRows_rsuser = mysql_num_rows($rsuser);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Report <?php echo $row_Recordset1['month']; ?></title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
		// jeditable yang untuk header	
		$(".headereditable_select").editable("save.php?tb=f_manpower_loading_header&select=1&tb2=h_employee&fld=firstname", { 
			indicator : 'Saving....', // indikator saat melakukan proses
			loadurl: 'listemploy_json.php', // pengambilan data jason
			type   : "select", // tipe jeditable
			submit : "OK", // proses berlangsung saat di tekan ok
			 placeholder: '___'	//saat data kosong digantikan dengan ini
		});
		$('.headeredit').editable('save.php?tb=f_manpower_loading_header', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...', // saat jeditable di hoover akan muncul pesan ini
			placeholder: '___'
		});
	 	$('.headeredit_area').editable('save.php?tb=f_manpower_loading_header', { 
			 type      : 'textarea',
			 cancel    : 'Cancel',
			 submit    : 'OK',
			 indicator : 'Saving...',
			 rows      : 1, // tinggi sesuai nilai row
			 tooltip   : 'Click to edit...',
			 placeholder: '___'
     	});
		// sama seperti yang diatas tp yg ini untuk data core
		$(".coreeditable_select").editable("save.php?tb=f_manpower_loading&select=1&tb2=h_employee&fld=firstname", { 
			indicator  : 'Saving....',
			loadurl    : 'listemploy_json.php',
			type       : "select",
			submit     : "OK",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
$(".coreeditanggal_select").editable("save.php?tb=f_manpower_loading&select=1&tb2=h_employee&fld=firstname", { 
			indicator  : 'Saving....',
			loadurl    : 'list_site.php',
			type       : "select",
			submit     : "OK",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});		
		$('.coreedit').editable('save.php?tb=f_manpower_loading', {
			indicator  : 'Saving...',
			tooltip    : 'Click to edit...',
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
	 	$('.coreedit_area').editable('save.php?tb=f_manpower_loading', { 
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
<link href="/css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.datatables.js"></script>
<script type="text/javascript" src="/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="/js/jquery.blockui.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var table = $("#celebs");
	var oTable = table.dataTable({"sPaginationType": "full_numbers", "bStateSave": true});

	$(".editable", oTable.fnGetNodes()).editable("php/ajax.php?r=edit_celeb", {
		"callback": function(sValue, y) {
			var fetch = sValue.split(",");
			var aPos = oTable.fnGetPosition(this);
			oTable.fnUpdate(fetch[1], aPos[0], aPos[1]);
		},
		"submitdata": function(value, settings) {
			return {
				"row_id": this.parentNode.getAttribute("id"),
				"column": oTable.fnGetPosition(this)[2]
			};
		},
		"height": "14px"
	});

	$(document).on("click", ".delete", function() {
		var celeb_id = $(this).attr("id").replace("delete-", "");
		var parent = $("#"+celeb_id);
		$.ajax({
			type: "get",
			url: "php/ajax.php?r=delete_celeb&id="+celeb_id,
			data: "",
			beforeSend: function() {
				table.block({
					message: "",
					css: {
						border: "none",
						backgroundColor: "none"
					},
					overlayCSS: {
						backgroundColor: "#fff",
						opacity: "0.5",
						cursor: "wait"
					}
				});
			},
			success: function(response) {
				table.unblock();
				var get = response.split(",");
				if(get[0] == "success") {
					$(parent).fadeOut(200,function() {
						$(parent).remove();
					});
				}
			}
		});
	});
});
</script>

</head>

<body>
<table width="1202" class="buatform">
  <tr>
    <td width="53"><strong>BULAN </strong></td>
    <td width="9">:</td>
    <?php // data yang dikirim saat men submit id dan value  ?>
    <td width="386"><?php echo $row_Recordset1['month']; ?> <?php echo date(Y); ?></td>
    <td width="81"><strong>Note </strong></td>
    <td width="10">:</td>
    <td width="639"><?php echo $row_Recordset1['note']; ?></td>
  </tr>
  
</table>
<p>&nbsp;</p>
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
  <?php if($totalRows_Recordset2>0){ $i=0 ;do{ ?>
  <tr class="tabel_body">
    <td align="center"><?php $i++; echo $i; ?></td>
    <td><?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['midlename']; ?> <?php echo $row_Recordset2['lastname']; ?></td>
    <td><?php echo $row_Recordset2['nik']; ?></td>
    <td><?php echo $row_Recordset2['department']; ?></td>
    <td><?php echo $row_Recordset2['skill']; ?></td>
    <td align="center"> <?php echo $row_Recordset2[mp1]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp2]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp3]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp4]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp5]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp6]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp7]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp8]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp9]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp10]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp11]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp12]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp13]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp14]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp15]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp16]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp17]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp18]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp19]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp20]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp21]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp22]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp23]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp24]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp25]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp26]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp27]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp28]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp29]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp30]; ?> </td>
    <td align="center"> <?php echo $row_Recordset2[mp31]; ?> </td>
    <td><?php echo $row_Recordset2['keterangan'];?> </td>
  </tr>
  <?php
  }while($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  }
  ?>
  </tbody>
</table>
<p>&nbsp;</p>
<table border="0" class="table" id="celebs" width="256">
  <thead>
    
    <tr class="tabel_header">
      <td width="29">No</td>
      <td colspan="2">Lokasi</td>
    </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr class="tabel_body">
      <?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td width="369"><?php echo $row_Recordset3['lokasi']; ?></td>
    </tr>
    <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
  </tbody>
</table>
<p>&nbsp;</p>
<table width="1115" class="General">
  <tr>
    <td width="665">&nbsp;</td>
    <td width="162"><p>Prepare By :
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <?php echo $row_rsuser['fname']; ?> <?php echo $row_rsuser['mname']; ?> <?php echo $row_rsuser['lname']; ?></td>
    <td width="162"><p>Checked By :                  
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
      <?php echo $row_Recordset1['checked_by']; ?> 
    </td>
    <td width="162"><p>Approve By :                 
        <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <?php echo $row_Recordset1['approved_by']; ?> </td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($rsuser);
?>
