<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_rsdocore = "-1";
if (isset($_GET['data'])) {
  $colname_rsdocore = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsdocore = sprintf("SELECT p_do_core.*, m_e_model.mtrl_model, m_master.descr_name, m_master.brand, m_master.id_type, m_unit.unit AS itemunit FROM p_do_core, p_do_header, m_master, m_e_model, m_unit WHERE m_master.id_item = p_do_core.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_unit.id_unit = p_do_core.id_unit AND p_do_core.doheader = p_do_header.id AND p_do_header.id = %s", GetSQLValueString($colname_rsdocore, "int"));
$rsdocore = mysql_query($query_rsdocore, $core) or die(mysql_error());
$row_rsdocore = mysql_fetch_assoc($rsdocore);
$totalRows_rsdocore = mysql_num_rows($rsdocore);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>M/S Request</title>
 <link rel="stylesheet" type="text/css" href="../css/print.css" />
<link rel="stylesheet" type="text/css" href="../css/styles.css" />
 <script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>M/S Request</title><link rel="stylesheet" type="text/css" href="../css/print.css" /><link rel="stylesheet" type="text/css" href="../css/untuk_printmr.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../css/print.css" media="screen"/><link rel="stylesheet" type="text/css" href="../css/untuk_printmr.css" /></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>

<style type="text/css">
			table {border-collapse:collapse;}
			.tdclass{border-right:1px solid #333333;}
			body{
	font: 75.5% "Trebuchet MS", sans-serif;
	margin: 50px;
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 5px;
	margin-bottom: 5px;
}
			.demoHeaders { margin-top: 2em; }

			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
.headerdate {	text-align: left;
}
.headertable {
	text-align: center;
	color: #FFF;
	font-weight: 900;
}
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>

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
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>

</head>
<body id="printarea">
<table width="722" border="1" class="table" id="celebs">
  <thead>
  <tr align="center" class="tabel_header">
    <td width="20"><b>NO.</b></td>
    <td width="450"><b>DESCRIPTION</b></td>
    <td width="300"><b>QTY / UNIT / DIMENSION</b></td>
    <td width="200" align="center"><b>REMARK</b></td>
    <?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') && ($row_Recordset2['status_approval'] != 'W')) {
		//echo '<p class="btn"><a href="edit_detailmrsr.php?data='.$row_Recordset1['id'].'"><b>EDIT</b></a></p>';
		echo '<td class="btn">&nbsp;</td>';
	}
?>

    </tr>
  </thead>
  <tbody>
    <?php do { ?>
      <tr class="tabel_body"><?php $a=$a+1; ?>
        <td align="center"><?php echo $a; ?></td>
        <td>
			<?php echo $row_rsdocore['mtrl_model']; ?> (<?php echo $row_rsdocore['descr_name']; ?>) <?php echo $row_rsdocore['brand']; ?><?php echo $row_rsdocore['id_type']; ?>
        </td>
        <td align="center"><?php echo $row_rsdocore['qty']; ?> <?php echo $row_rsdocore['itemunit']; ?> <?php echo $row_rsdocore['dimension']; ?></td>
        <td width="142"><?php echo $row_rsdocore['remark']; ?></td>
        <?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') && ($row_Recordset2['status_approval'] != 'W')) {
		//<a href="edit_detailmrsr.php?data='.$row_Recordset1['id'].'"><b>Edit</b></a> | 
		echo '<td align="center" class="btn">
				<a href="do_deletedetail.php?data='.$row_rsdocore['id'].'"><b>Delete</b></a>
			</td>';
	}
		?>
      </tr>
      <?php } while ($row_rsdocore = mysql_fetch_assoc($rsdocore)); ?>
  </tbody>
</table>
<br />

</p>
<br />
</body>
</html>
<?php
	mysql_free_result($rsdocore);
	mysql_free_result($rsmanagername);
	mysql_free_result($rscarriername);
?>