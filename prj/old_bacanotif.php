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

$usrid = $_GET['data'];
//$usrid = $_SESSION['empID'];
mysql_select_db($database_core, $core);
$query_rsbacapesan = "SELECT log_pesan.*, inisial_pekerjaan.inisial_pekerjaan FROM log_pesan, inisial_pekerjaan WHERE log_pesan.id_empdept = '$usrid' AND log_pesan.sudah_bacaYN = 'Y' AND log_pesan.id_msgcat <> '3' AND inisial_pekerjaan.id_inisial = log_pesan.id_inisial ORDER BY log_pesan.waktu_notif DESC";
$rsbacapesan = mysql_query($query_rsbacapesan, $core) or die(mysql_error());
$row_rsbacapesan = mysql_fetch_assoc($rsbacapesan);
$totalRows_rsbacapesan = mysql_num_rows($rsbacapesan);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Old Notification</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
</script></head>

<body class="General">

<p class="buatform"><blink><b>Old Notification</b></blink></p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table title="Your New Notification(s)" width="850" border="0" class="table" id="celebs">
<thead>
      <tr class="tabel_header">
        <td width="29">NO.</td>
          <td>INFO</td>
          <td>&nbsp;</td>
          <td>JOB INITIAL</td>
      </tr>
</thead>
<tbody>      
      <?php
      { include "../dateformat_funct.php"; }
	  do { ?>
        <tr class="tabel_body"><?php $a = $a + 1; ?>
        <td align="center"><?php echo $a; ?></td>
        <td width="625" ><?php echo $row_rsbacapesan['isi']; ?></td>
        <td width="140" align="center">
			<?php echo functddmmmyyyy($row_rsbacapesan['waktu_notif']); ?>
			<?php echo substr($row_rsbacapesan['waktu_notif'], -8) ?>
        </td>
        <td width="80" align="center"><?php echo $row_rsbacapesan['inisial_pekerjaan']; ?></td>
        </tr>
    <?php } while ($row_rsbacapesan = mysql_fetch_assoc($rsbacapesan)); ?>
    </tbody>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>

<br><br><br>
</body>
</html>

<?php
	mysql_free_result($rsbacapesan);
?>