<?php require_once('../../Connections/core.php'); ?>
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

$colname_rsmrheader = "-1";
if (isset($_GET['data'])) {
  $colname_rsmrheader = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsmrheader = sprintf("SELECT p_mr_header.*, a_production_code.projectcode, a_production_code.productioncode FROM p_mr_header, a_production_code WHERE p_mr_header.id = %s AND a_production_code.id = p_mr_header.id_prodcode", GetSQLValueString($colname_rsmrheader, "int"));
$rsmrheader = mysql_query($query_rsmrheader, $core) or die(mysql_error());
$row_rsmrheader = mysql_fetch_assoc($rsmrheader);
$totalRows_rsmrheader = mysql_num_rows($rsmrheader);

$colname_rscoremr = "-1";
if (isset($_GET['data'])) {
  $colname_rscoremr = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rscoremr = sprintf("SELECT p_mr_core. * , m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_type, m_unit.unit AS MRunit FROM p_mr_core, m_master, m_e_model, m_unit WHERE p_mr_core.itemmr = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND p_mr_core.unit = m_unit.id_unit AND p_mr_core.mrheader = %s", GetSQLValueString($colname_rscoremr, "int"));
$rscoremr = mysql_query($query_rscoremr, $core) or die(mysql_error());
$row_rscoremr = mysql_fetch_assoc($rscoremr);
$totalRows_rscoremr = mysql_num_rows($rscoremr);
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
.headerdate {
	text-align: left;
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
<?php
	/* if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') && ($totalRows_rscoremr == 0)) {
		echo '<p class="btn"><a href="/ppic/inputmaterialrequestdetail.php?data='.$_GET[data].'"><b>+ ADD NEW</b></a></p>';
	} */
	{ include "../../dateformat_funct.php"; }
?>
<table width="1150" border="0" cellpadding="5" class="General">
  <tr>
    <td width="180"><img src="/images/bukaka.jpg" width="102" height="24" /></td>
    <td width="6">&nbsp;</td>
    <td colspan="2" align="center" class="huruf_besar"><strong><font size="+1">MATERIAL / SERVICE REQUEST</font></strong></td>
    <td align="center" class="huruf_besar">&nbsp;</td>
    <td align="center" class="huruf_besar">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td>MR/SR</td>
    <td>:</td>
    <td width="330"><?php echo $row_rsmrheader['nomr']; ?></td>
    <td width="150">Proj. Code</td>
    <td width="3">:</td>
    <td width="150"><?php echo $row_rsmrheader['projectcode']; ?></td>
  </tr>
  <tr>
  	<td>Date</td>
    <td>:</td>
    <td><?php echo functddmmmyyyy($row_rsmrheader['date']); ?></td>
    <td>Prod. Code</td>
    <td>:</td>
    <td><?php echo $row_rsmrheader['prodcode']; ?></td>
  </tr>
</table>

<p><hr align="left" width="1100" /></p>
<table width="1100" border="1" class="table" id="celebs">
  <thead>
    <tr align="center" class="tabel_header">
      <td width="10"><b>NO.</b></td>
      <td width="185"><b>DESCRIPTION</b></td>
      <td width="120"><b>SPEC.</b></td>
      <td width="45"><b>QTY</b></td>
      <td width="65"><b>DATE<br />IN USE</b></td>
      <td width="110"><b>TO BE USED</b></td>
      <td width="60"><b>PROD. CODE</b></td>
      <td width="100"><b>REMARK</b></td>
      <td width="330"><b>PO DATE ( PO No. ) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; INCOMING DATE ( BTB No. )</b></td>
    </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a=$a+1; echo $a; ?></td>
      <td><?php echo $row_rscoremr['mtrl_model']; ?> (<?php echo $row_rscoremr['descr_name']; ?>) <?php echo $row_rscoremr['id_type']; ?> <?php echo $row_rscoremr['brand']; ?></td>
      <td><?php echo $row_rscoremr['descr_spec']; ?></td>
      <td align="center"><?php echo $row_rscoremr[qty]; ?> <?php echo $row_rscoremr[MRunit]; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_rscoremr[dateinuse]); ?></td>
      <td><?php echo $row_rscoremr[tobeuse]; ?></td>
      <td align="center"><?php echo $row_rsmrheader[prodcode]; ?></td>
      <td><?php echo $row_rscoremr['remark']; ?></td>
      
      <td align="center">
	<?php
	  	$idmr = $row_rsmrheader['id'];
      	$iditemmr = $row_rscoremr['itemmr'];
		mysql_select_db($database_core, $core);
		$query_rspodate = "SELECT c_po_header.id, c_po_header.pono, c_po_header.podate, c_po_core.qty, c_po_core.unit FROM p_mr_core, c_po_header, c_po_core WHERE c_po_header.id = c_po_core.poheader AND p_mr_core.mrheader = c_po_header.mrno AND p_mr_core.itemmr = c_po_core.itemno AND p_mr_core.mrheader = '$idmr' AND p_mr_core.itemmr = '$iditemmr'";
		$rspodate = mysql_query($query_rspodate, $core) or die(mysql_error());
		$row_rspodate = mysql_fetch_assoc($rspodate);
		$totalRows_rspodate = mysql_num_rows($rspodate);
		?>
        <table width="350">
	<?php do { ?>
			<tr>
			<td align="center" width="70"><?php echo functddmmmyyyy($row_rspodate['podate']); ?></td>
            <td align="center"><?php echo $row_rspodate['pono']; ?></td>
            <td align="center">
			
      <?php $idpo = $row_rspodate['id'];
			mysql_select_db($database_core, $core);
			$query_rsbtbdate = "SELECT p_btb_header.no_btb, p_btb_header.tanggal AS BTBdate, p_btb_core.qty FROM c_po_core, p_btb_header, p_btb_core WHERE p_btb_header.id = p_btb_core.id_header AND c_po_core.poheader = p_btb_header.id_po AND c_po_core.itemno = p_btb_core.id_item AND c_po_core.poheader = '$idpo' AND c_po_core.itemno = '$iditemmr'";
			$rsbtbdate = mysql_query($query_rsbtbdate, $core) or die(mysql_error());
			$row_rsbtbdate = mysql_fetch_assoc($rsbtbdate);
			$totalRows_rsbtbdate = mysql_num_rows($rsbtbdate);
			/* echo "<script>alert(\"$idpo\");</script>"; */	
		?>
            <table width="170">
		<?php do { ?> 
				<tr>
                <td align="center" width="70"><?php echo functddmmmyyyy($row_rsbtbdate['BTBdate']); ?></td>
                <td align="center"><?php echo $row_rsbtbdate['no_btb']; ?></td>
                </tr>
				<?php } while ($row_rsbtbdate = mysql_fetch_assoc($rsbtbdate));
            ?></table>
            </td>
            </tr>		
		<?php	
			} while ($row_rspodate = mysql_fetch_assoc($rspodate)); ?>
    	</table>
      </td>
      
    </tr>
    <?php } while ($row_rscoremr = mysql_fetch_assoc($rscoremr)); ?>
  </tbody>
</table>
<br />

<table width="1100" border="1">
	<tr>
    	<td><b>Note : </b><?php echo $row_rsmrheader['note']; ?></td>
    </tr>
</table>
<br />

<?php
	$userreq = $row_rsmrheader['requestby'];
	mysql_select_db($database_core, $core);
	$query_rsuser = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.requestby AND p_mr_header.requestby = '$userreq'";
	$rsuser = mysql_query($query_rsuser, $core) or die(mysql_error());
	$row_rsuser = mysql_fetch_assoc($rsuser);
	$totalRows_rsuser = mysql_num_rows($rsuser);
	
	$userpass = $row_rsmrheader['passedby'];
	mysql_select_db($database_core, $core);
	$query_rsuserppic = "SELECT h_employee.id, h_employee.nik, h_employee.firstname AS pfname, h_employee.midlename AS pmname, h_employee.lastname AS plname FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.passedby AND p_mr_header.passedby = '$userpass'";
	$rsuserppic = mysql_query($query_rsuserppic, $core) or die(mysql_error());
	$row_rsuserppic = mysql_fetch_assoc($rsuserppic);
	$totalRows_rsuserppic = mysql_num_rows($rsuserppic);
	
	$userapprover = $row_rsmrheader['approvedby'];
	mysql_select_db($database_core, $core);
	$query_rsapprover = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname  FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.approvedby AND p_mr_header.approvedby = '$userapprover'";
	$rsapprover = mysql_query($query_rsapprover, $core) or die(mysql_error());
	$row_rsapprover = mysql_fetch_assoc($rsapprover);
	$totalRows_rsapprover = mysql_num_rows($rsapprover);
?>

<table width="1100" class="General">
  <tr>
    <td width="665">&nbsp;</td>
    <td width="150"><p>Request by :
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <div class="headeredit" id="<?php echo $row_rsuser['id']; ?>-prepareby"><?php echo $row_rsuser['fname']; ?> <?php echo $row_rsuser['mname']; ?> <?php echo $row_rsuser['lname']; ?></div></td>
    <td width="150"><p>Passed by :
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
      <div class="headeredit" id="<?php echo $row_rsuserppic['id']; ?>-checkedby"><?php echo $row_rsuserppic['pfname']; ?> <?php echo $row_rsuserppic['pmname']; ?> <?php echo $row_rsuserppic['plname']; ?></div>
    </td>
    <td width="150"><p>Approved by :
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <div class="headeredit" id="<?php echo $row_rsapprover['id']; ?>-approvedby"><?php echo $row_rsapprover['firstname']; ?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?></div></td>
  </tr>
</table>
</p>
<br />
<table>
	<tr>
		<td><img src="/images/icon_print.gif" width="25" height="25" class="btn" onclick="PrintDoc()" /></td>
        <td><img src="/images/icon_printpw.gif" width="24" height="25" class="btn" onclick="PrintPreview()"/></td>
    </tr>
</table>
</body>

</html>
<?php
	mysql_free_result($rsmrheader);
	mysql_free_result($rsuser);
	mysql_free_result($rsuserppic);
	mysql_free_result($rsapprover);
	mysql_free_result($rsbtbdate);
	mysql_free_result($rspodate);
	mysql_free_result($rscoremr);
?>
