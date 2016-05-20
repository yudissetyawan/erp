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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO f_manpower_loading (idheader) VALUES (%s)",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO f_manpower_loading_header (`month`, `year`) VALUES (%s, %s)",
                       GetSQLValueString($_POST['month'], "text"),
                       GetSQLValueString($_POST['year'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM f_manpower_loading_header";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$queryString_Recordset2 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset2") == false && 
        stristr($param, "totalRows_Recordset2") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset2 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset2 = sprintf("&totalRows_Recordset2=%d%s", $totalRows_Recordset2, $queryString_Recordset2);

$year=date(Y);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM f_manpower_loading_header ORDER BY id DESC"));
$tahun=$ceknomor[date];
$nows=substr($tahun,0,4);
$cekQ=$ceknomor[id];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextno=sprintf ($next);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Daily Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<link href="../css/induk.css" type="text/css" rel="stylesheet" />
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

<body><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="buatform" id="form1">
  Bulan : 
    <select name="month" id="month">
      <option>-PILIH BULAN-</option>
      <option value="JANUARI">JANUARI</option>
      <option value="FEBRUARI">FEBRUARI</option>
      <option value="MARET">MARET</option>
      <option value="APRIL">APRIL</option>
      <option value="MEI">MEI</option>
      <option value="JUNI">JUNI</option>
      <option value="JULI">JULI</option>
      <option value="AGUSTUS">AGUSTUS</option>
      <option value="SEPTEMBER">SEPTEMBER</option>
      <option value="OKTOBER">OKTOBER</option>
      <option value="NOVEMBER">NOVEMBER</option>
      <option value="DESEMBER">DESEMBER</option>
  </select>
  <input type="submit" name="button" id="button" value="Submit" />
  <label for="id"></label>
  <input name="id" type="text" class="hidentext" id="id" value="<? echo $nextno; ?>" size="5" readonly="readonly" />
  <label for="idsite"></label>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="year" id="year" value="<?php echo $year; ?>" />
</form>
<table width="334" class="table" id="celebs" >
<thead>
  <tr bgcolor="#0066FF" class="tabel_header">
    <td width="39">No</td>
    <td width="100">Tahun</td>
    <td colspan="2">Bulan</td>
    </tr>
</thead>
<tbody>
  <?php do { ?>
    <tr class="tabel_body">
      <td><?php $i++; echo $i; ?></td>
      <td><?php echo $row_Recordset1['year']; ?></td>
      <?php // link ke dailyreport detail sesuai degan id headernya ?>
      <td width="172"><a href="manpower_loading.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['month']; ?></a></td>
      <td width="10" ><a style="text-decoration:none; color:#F00AAA" href="delrow_manpower_loading_header.php?header=<?php echo $row_Recordset1['id']; ?>&amp;data=<?php echo $row_Recordset1['id']; ?>&amp;tb=f_manpower_loading_header"><strong>X</strong></a></td>
      </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</tbody>  
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
