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

//if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {|| (isset($_GET['data0']
if (isset($_GET["data0"]) && isset($_GET["data1"])) {
	$ntfid = $_REQUEST['data0'];
	$empid = $_REQUEST['data1'];
	$updateSQL = sprintf("UPDATE log_pesan SET sudah_bacaYN=%s WHERE id_notif=%s AND id_empdept=%s",
                       GetSQLValueString("Y", "text"),
                       GetSQLValueString($ntfid, "int"),
					   GetSQLValueString($empid, "int"));
	mysql_select_db($database_core, $core);
	$Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
	echo "<script>parent.window.location.reload(true);</script>";
	
	$updateGoTo = "bacanotif.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $updateGoTo)); 
}

$usrid = $_GET['data'];
// $usrid = $_SESSION['empID'];
mysql_select_db($database_core, $core);
$query_rsbacapesan = "SELECT log_pesan.*, inisial_pekerjaan.inisial_pekerjaan FROM log_pesan, inisial_pekerjaan WHERE log_pesan.id_empdept = '$usrid' AND log_pesan.sudah_bacaYN = 'N' AND log_pesan.id_msgcat <> '3' AND inisial_pekerjaan.id_inisial = log_pesan.id_inisial ORDER BY log_pesan.waktu_notif DESC";
$rsbacapesan = mysql_query($query_rsbacapesan, $core) or die(mysql_error());
$row_rsbacapesan = mysql_fetch_assoc($rsbacapesan);
$totalRows_rsbacapesan = mysql_num_rows($rsbacapesan);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Read Notification</title>
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

</head>

<body class="General">

<p class="buatform"><blink><b>New Notification</b></blink></p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table title="Your New Notification(s)" width="900" border="0" class="table" id="celebs">
<thead>
      <tr class="tabel_header">
      	<!-- <td height="30">
            <input name="btnOK" type="button" id="btnOK" value="X" style="color:#FF0000; font-size:10px; font-weight:bold; border:none; cursor:pointer; background-color:#79baec" title="Remove notification which the checkbox is checked" onclick="alert('Sorry, this feature not available yet');">            <input name="cboxAll" type="checkbox"  onclick='for (i=0;i<$no;i++){document.getElementById(i).checked=true;}' />            <input type=radio name=pilih onClick='for (i=0;i<$no;i++){document.getElementById(i).checked=true;}'>
        </td> -->
        <td height="30" width="29" title="Click to sort by Number">No</td>
          <td width="625" title="Click to sort by Info">Info</td>
          <td width="140" title="Click to sort by Time of Notif">&nbsp;</td>
          <td align="center" width="70" title="Click to sort by Job Initial">Job Initial</td>
          <td title="Click to sort by specific header">Remove</td>
      </tr>
</thead>
<tbody>      
      <?php 
	  { include "../dateformat_funct.php"; }
	  $no = 0;
	  do { ?>
        <tr class="tabel_body"><?php $a = $a + 1; ?>
        <!--
        <td title="Check it to remove many info" align="center">
        	<?php
			/* if ($row_rsbacapesan['removable_ntf'] == 'R') { 
				echo '<input type="checkbox" name=cboxDel[] value=$row_rsbacapesan[id] id=$no />';
				$no++; 
			} */ ?>
        </td>
        -->
        <td align="center"><?php echo $a; ?></td>
        <td>
		<?php if ($row_rsbacapesan['ntf_goto'] != '') { ?>
        			<a href="<?php echo $row_rsbacapesan['ntf_goto']; ?>" style="text-decoration:none" onmouseover="this.style.textDecoration = 'underline';" onmouseout="this.style.textDecoration = 'none';"><?php echo $row_rsbacapesan['isi']; ?></a>
		<?php } else {
				 	echo $row_rsbacapesan['isi']; } ?>
		</td>
        
        <td align="center"><?php
			//$row_rsbacapesan['removable_ntf'] != 'UR'
			if ($row_rsbacapesan['id_inisial'] == '60') {
				list($month1, $date1, $year1) = functddmmyyyy(functyyyymmdd(substr($row_rsbacapesan['isi'], -11)));
				list($month2, $date2, $year2) = functddmmyyyy2(date("Y-m-d"));
				$jd1 = GregorianToJD($month1, $date1, $year1);
				$jd2 = GregorianToJD($month2, $date2, $year2);
				$selisih = $jd1 - $jd2;
				echo $selisih.' days remaining';
				
			} else { 
				echo functddmmmyyyy($row_rsbacapesan['waktu_notif']); ?>
          <?php echo substr($row_rsbacapesan['waktu_notif'], -8);
			} ?>
        </td>
        
        <td align="center"><?php echo $row_rsbacapesan['inisial_pekerjaan']; ?></td>

        <td align="center">
        	<!-- style="text-decoration:none; color:#000"
            <input type="hidden" name="sudah_bacaYN" id="sudah_bacaYN" value="Y" />
            <input name="id_notif" type="hidden" id="id_notif" value="id_notif" />
            -->
			<?php
            if ($row_rsbacapesan['removable_ntf'] == 'R') { 
                //echo '<input name="btnOK" type="submit" id="btnOK" value="X" style="color:#FF0000; font-size:10px; font-weight:bold; border:none; cursor:pointer; background-color:#c5d9f1">';
				?><a style="text-decoration:none; color:#F00AAA" href="bacanotif.php?data0=<?php echo $row_rsbacapesan['id_notif']; ?>&data1=<?php echo $usrid; ?>"><b>x</b></a>
            <?php 
			} ?>      
        </td>
        
    </tr>
    <?php } while ($row_rsbacapesan = mysql_fetch_assoc($rsbacapesan)); ?>
    
    </tbody>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>

<br><br>

<p><a href="#" onclick="MM_openBrWindow('old_bacanotif.php?data=<?php echo $usrid ?>','','scrollbars=yes,width=800,height=500')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-flag"></span>Old Notification</a></p>
</body>
</html>

<?php
	mysql_free_result($rsbacapesan);
	mysql_free_result($Recordset1);
?>