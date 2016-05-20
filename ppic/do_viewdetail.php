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

$colname_rsdoheader = "-1";
if (isset($_GET['data'])) {
  $colname_rsdoheader = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsdoheader = sprintf("SELECT p_do_header.*, h_employee.firstname AS manfname, h_employee.midlename AS manmname, h_employee.lastname AS manlname FROM p_do_header,h_employee WHERE h_employee.id = p_do_header.managername AND p_do_header. id = %s", GetSQLValueString($colname_rsdoheader, "int"));
$rsdoheader = mysql_query($query_rsdoheader, $core) or die(mysql_error());
$row_rsdoheader = mysql_fetch_assoc($rsdoheader);
$totalRows_rsdoheader = mysql_num_rows($rsdoheader);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DO Detail</title>
 <link rel="stylesheet" type="text/css" href="../css/print.css" />
<link rel="stylesheet" type="text/css" href="../css/styles.css" />
 <script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>M/S Request</title><link rel="stylesheet" type="text/css" href="../../css/print.css" /><link rel="stylesheet" type="text/css" href="../../css/layoutforprint.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../../css/print.css" media="screen"/><link rel="stylesheet" type="text/css" href="../../css/layoutforprint.css" /></head><body">')
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

<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">
<link href="/css/layoutforprint.css" rel="stylesheet" type="text/css" />

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
<?php
	$vid = $_GET['data'];
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator')) {
		echo '<p class="btn"><a href="do_inputdetail.php?data='.$vid.'" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item to DO</a></p>';
	}
?>
<table width="736" border="1">
  <tr>
    <td width="735"><table width="722" border="0" cellpadding="5" class="General">
      <tr>
        <td width="140" valign="middle"><img src="/images/bukaka.jpg" alt="" width="102" height="24" /></td>
        <td width="6">&nbsp;</td>
        <td colspan="2" align="center" class="huruf_besar"><strong><font size="+1">DELIVERY ORDER</font></strong><br />
          <font size="2"><b><i>SURAT IZIN PENGELUARAN BARANG</i></b></font> <br />
          <font size="2">DO No. : <?php echo $row_rsdoheader['donumber']; ?></font></td>
        <td align="center" class="huruf_besar">&nbsp;</td>
        <td align="center" class="huruf_besar">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <td>Ship to</td>
        <td>:</td>
        <td width="240"><?php echo $row_rsdoheader['shipto']; ?></td>
        <td width="140">Delivery Point</td>
        <td width="3">:</td>
        <td width="163"><?php echo $row_rsdoheader['deliverypoint']; ?></td>
      </tr>
      <tr>
        <?php include "../dateformat_funct.php"; ?>
        <td>Contract No.</td>
        <td>:</td>
        <td><?php echo $row_rsdoheader['contractnumber']; ?></td>
        <td>Carrier</td>
        <td>:</td>
        <td><?php echo $row_rsdoheader['carier']; ?></td>
      </tr>
      <tr>
        <td>Packing List No.</td>
        <td>:</td>
        <td>
		<?php
			$idpl = $row_rsdoheader['no_pl'];;
			mysql_select_db($database_core, $core);
			$query_rspkglist = "SELECT no_pl FROM p_pl_header WHERE id = '$idpl'";
			$rspkglist = mysql_query($query_rspkglist, $core) or die(mysql_error());
			$row_rspkglist = mysql_fetch_assoc($rspkglist);
			$totalRows_rspkglist = mysql_num_rows($rspkglist);

			echo $row_rspkglist['no_pl']; ?>
        </td>
        <td>Plat No. / Reg.</td>
        <td>:</td>
        <td><?php echo $row_rsdoheader['platno']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><iframe width="730" height="329" style="border:none" src="do_viewdetail_isi.php?data=<?php echo $_GET ['data']; ?>"></iframe></td>
  </tr>
  <tr>
    <td>
    <table width="730" border="1" class="General">
      <tr>
        
        <td width="180"><p>Manager : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="180"><p>Security : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="180"><p>Carrier : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="180"><p>Received by (Client) : </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
       <?php
		$idsecurity = $row_rsdoheader['securityname'];
		mysql_select_db($database_core, $core);
		$query_rssecurityname = "SELECT h_employee.id, h_employee.nik, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee, p_do_header WHERE h_employee.id = p_do_header.securityname AND p_do_header.securityname = '$idsecurity'";
		$rssecurityname = mysql_query($query_rssecurityname, $core) or die(mysql_error());
		$row_rssecurityname = mysql_fetch_assoc($rssecurityname);
		$totalRows_rssecurityname = mysql_num_rows($rssecurityname);
		
		$idcarrier = $row_rsdoheader['carriername'];
		mysql_select_db($database_core, $core);
		$query_rscarriername = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, p_do_header WHERE h_employee.id = p_do_header.cariername AND p_do_header.cariername = '$idcarrier'";
		$rscarriername = mysql_query($query_rscarriername, $core) or die(mysql_error());
		$row_rscarriername = mysql_fetch_assoc($rscarriername);
		$totalRows_rscarriername = mysql_num_rows($rscarriername);
	?>
        <td width="180"><div class="headeredit" id="<?php echo $row_rsdoheader['id']; ?>-manager"><?php echo $row_rsdoheader['manfname']; ?> <?php echo $row_rsdoheader['manmname']; ?> <?php echo $row_rsdoheader['manlname']; ?></div></td>
        <td width="180"><div class="headeredit" id="<?php echo $row_rsdoheader['id']; ?>-security"><?php echo $row_rssecurityname['fname']; ?> <?php echo $row_rssecurityname['mname']; ?> <?php echo $row_rssecurityname['lname']; ?></div></td>
        <td width="180"><div class="headeredit" id="<?php echo $row_rsdoheader['id']; ?>-carrier"><?php echo $row_rscarriername['firstname']; ?> <?php echo $row_rscarriername['midlename']; ?> <?php echo $row_rscarriername['lastname']; ?></div></td>
        <td width="180"><div class="headeredit" id="<?php echo $row_rsdoheader['id']; ?>-received"> <?php echo $row_rsdoheader['recievername']; ?></div></td>
      </tr>
    </table></td>
  </tr>
</table>

</p>
<br /><br /><br />
<table>
	<tr>
		<td><img src="/images/icon_print.gif" width="25" height="25" class="btn" onclick="PrintDoc()" /></td>
        <td><img src="/images/icon_printpw.gif" width="24" height="25" class="btn" onclick="PrintPreview()"/></td>
        <td>
        	<form action="<?php echo $editFormAction; ?>" method="POST" id="frmNotifMR" name="frmNotifMR">
            	<input name="idMR" type="hidden" value="<?php echo $row_Recordset2['id']; ?>" />
                <input name="noMR" type="hidden" value="<?php echo $row_Recordset2['nomr']; ?>" />
                <input name="projcd" type="hidden" value="<?php echo $row_Recordset2['projectcode']; ?>" />
                <input name="prodcd" type="hidden" value="<?php echo $row_Recordset2['productioncode']; ?>" />
                <input name="idApprover" type="hidden" value="<?php echo $row_Recordset2['approvedby']; ?>" />
              <input name="nmApprover" type="hidden" value="<?php echo $row_rscarriername['firstname']; ?> <?php echo $row_rscarriername['midlename']; ?> <?php echo $row_rscarriername['lastname']; ?>" />
            <!-- 	<input type="submit" class="btn" name="btnDone" id="btnDone" value="Done" title="Your request has Done and send for approval" /> -->
       	      <input type="hidden" name="MM_insert" value="frmNotifMR" />
       	      <input type="hidden" name="MM_update" value="frmNotifMR" />
            </form>
        </td>
    </tr>
</table>
</body>

</html>
<?php
	mysql_free_result($rsdoheader);
	mysql_free_result($rssecurityname);
	mysql_free_result($rscarriername);

mysql_free_result($rspkglist);
?>
