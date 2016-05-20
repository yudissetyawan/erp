<?php require_once('../../Connections/core.php'); ?>
<?php require_once('../../Connections/core.php'); ?>
<?php require_once('../../Connections/core.php'); ?>
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
	
  $logoutGoTo = "../../index.php";
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

$idemp = $_SESSION['empID'];

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM e_dwnlistofnodwn WHERE id_groupwork = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Report <?php echo $row_Recordset1['month']; ?></title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../../js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
		// jeditable yang untuk header	
		$(".headereditable_select").editable("save.php?tb=h_absen_header&select=1&tb2=h_employee&fld=firstname", { 
			indicator : 'Saving....', // indikator saat melakukan proses
			loadurl: 'listemploy_json.php', // pengambilan data jason
			type   : "select", // tipe jeditable
			submit : "OK", // proses berlangsung saat di tekan ok
			 placeholder: '___'	//saat data kosong digantikan dengan ini
		});
		$('.headeredit').editable('save.php?tb=h_absen_header', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...', // saat jeditable di hoover akan muncul pesan ini
			placeholder: '___'
		});
	 	$('.headeredit_area').editable('save.php?tb=h_absen_header', { 
			 type      : 'textarea',
			 cancel    : 'Cancel',
			 submit    : 'OK',
			 indicator : 'Saving...',
			 rows      : 2, // tinggi sesuai nilai row
			 tooltip   : 'Click to edit...',
			 placeholder: '___'
     	});
		//untuk drawing no.
$(".coreedidrawing_select").editable("save.php?tb=e_dwnlistofnodwn&fld=drawing_no", { 
			indicator  : 'Saving....',
			type       : "text",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '----'
		});	
$(".coreeditanggal_select").editable("save.php?tb=h_absen&select=1&tb2=h_employee&fld=firstname", { 
			indicator  : 'Saving....',
			type       : "text",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});		
		$('.coreedit').editable('save.php?tb=h_absen', {
			indicator  : 'Saving...',
			tooltip    : 'Click to edit...',
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
		$('.coreedit_status').editable('save.php?tb=h_absen', {
			indicator  : 'Saving...',
			loadurl    : 'list_status.php',
			tooltip    : 'Click to edit...',
			type       : "select",
			submit     : "OK",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
	 	$('.coreedit_area').editable('save.php?tb=h_absen', { 
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
<link href="../../css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery.datatables.js"></script>
<script type="text/javascript" src="../../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../../js/jquery.blockui.js"></script>
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
<table width="1100" id="celebs">
  <thead>
    <tr class="tabel_header">
      <td width="23" rowspan="2" align="center">NO</td>
      <td width="156" rowspan="2" align="center">Drawing No.</td>
      <td width="290" rowspan="2" align="center">Description</td>
      <td width="107" rowspan="2" align="center">Handle By.</td>
      <td colspan="5">CRF Issued</td>
      <td width="49" rowspan="2" align="center">Owner</td>
      <td width="69" rowspan="2" align="center">Location / Area</td>
      <td width="60" rowspan="2" align="center">Project Code</td>
      <td width="53" rowspan="2" align="center">Binder Code</td>
      
      <td width="43" rowspan="2" align="center">&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td width="38" align="center" class="tabel_header">Rev. 0</td>
      <td width="38" align="center" class="tabel_header">Rev. 1</td>
      <td width="38" align="center" class="tabel_header">Rev. 2</td>
      <td width="38" align="center" class="tabel_header">Rev. 3</td>
      <td width="38" align="center" class="tabel_header">Rev. 4</td>
      
    </tr>
  </thead>
  <tbody>
    <?php if($totalRows_Recordset2>0){ $i=0 ;do{ ?>
      <tr class="tabel_body">
        <td align="center"><?php $i++; echo $i; ?></td>
        <td><div class="coreedidrawing_select" id="<?php echo $row_Recordset2['id']; ?>-drawing_no"><?php echo $row_Recordset2['drawing_no']; ?></div></td>
        <td><?php echo $row_Recordset2[nik]; ?></td>
        <td><?php echo $row_Recordset2[department]; ?></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h01"><?php echo $row_Recordset2[h01]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h02"><?php echo $row_Recordset2[h02]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h03"><?php echo $row_Recordset2[h03]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h04"><?php echo $row_Recordset2[h04]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h05"><?php echo $row_Recordset2[h05]; ?></div></td>
        
        <td align="center">
        <?php
	  	$tdkmsk = $row_Recordset2['h01'];
	$tdkmsk2 = $row_Recordset2['h02'];
	$tdkmsk3 = $row_Recordset2['h03'];
	$tdkmsk4 = $row_Recordset2['h04'];
	$tdkmsk5 = $row_Recordset2['h05'];
	$tdkmsk6 = $row_Recordset2['h06'];
	$tdkmsk7 = $row_Recordset2['h07'];
	$tdkmsk8 = $row_Recordset2['h08'];
	$tdkmsk9 = $row_Recordset2['h09'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	  ?><?php 	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "skt");
?></td>
        <td align="center"><?php 
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "iz");
?></td>
        <td align="center"><?php 
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "a");
?></td>
        <td align="center"><?php 
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ip");
?></td>
        
        <td width="43" align="center"><a style="text-decoration:none; color:#F00AAA" href="../../hrd/absnkary/delrow.php?header=<?php echo $_GET['data']; ?>&amp;data=<?php echo $row_Recordset2['id']; ?>&amp;tb=h_absen"><strong>x</strong></a></td>
      </tr>
      <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
<?php
  }
  ?>
  </tbody>
  <tr>
    <td align="center"><a style="text-decoration:none; color:#09F" href="../../hrd/absnkary/addrow.php?data=<?php echo $_GET['data']; ?>&amp;fld=idheader&amp;tb=h_absen"><strong>+</strong></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($rsuser);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
