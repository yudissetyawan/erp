<?php require_once('../../Connections/core.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO h_absen_header (bulan, tahun) VALUES (%s, %s)",
                       GetSQLValueString($_POST['bulan'], "text"),
                       GetSQLValueString($_POST['tahun'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT h_absen_header.*, h_bulan.bulan FROM h_absen_header, h_bulan WHERE h_absen_header.bulan = h_bulan.id";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_h_absen_header = "SELECT DISTINCT tahun FROM h_absen_header";
$h_absen_header = mysql_query($query_h_absen_header, $core) or die(mysql_error());
$row_h_absen_header = mysql_fetch_assoc($h_absen_header);
$totalRows_h_absen_header = mysql_num_rows($h_absen_header);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/induk.css" media="screen" rel="stylesheet" type="text/css" />
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" class="General">
  Tambah Periode &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;
  <input type="text" name="tahun" id="tahun" size="4" maxlength="4" value="<?php echo date(Y); ?>" />
  <select name="bulan">
  <option value="">-- Bulan --</option>
    <option value="1">Januari</option>
    <option value="2">Februari</option>
    <option value="3">Maret</option>
    <option value="4">April</option>
    <option value="5">Mei</option>
    <option value="6">Juni</option>
    <option value="7">Juli</option>
    <option value="8">Agustus</option>
    <option value="9">September</option>
    <option value="10">Oktober</option>
    <option value="11">November</option>
    <option value="12">Desember</option>
  </select>
  <input type="submit" name="submit" id="submit" value="Submit" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<table width="200" border="0">
  <tr class="tabel_header">
    <td colspan="2">Rekap Absen per tahun </td>
  </tr>
  <tr class="tabel_header">
    <td width="23">No</td>
    <td width="167">Tahun</td>
  </tr>
  <?php do { ?>
    <tr align="center" class="tabel_body"><?php $A=$A+1; ?>
      <td align="center"><?php echo $A; ?></td>
      <td align="center"><?php echo $row_h_absen_header['tahun']; ?></td>
    </tr>
    <?php } while ($row_h_absen_header = mysql_fetch_assoc($h_absen_header)); ?>
</table>
<p class="buatform">Periode </p>
<table width="200" border="0">
  <tr class="tabel_header" height="30">
    <td width="30">No</td>
    <td width="50">Tahun</td>
    <td>Bulan</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><?php echo $row_Recordset1['tahun']; ?></td>
      <td align="center"><a href="absen.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['bulan']; ?></a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($h_absen_header);
?>
