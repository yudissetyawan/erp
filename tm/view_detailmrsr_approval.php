<?php require_once('../Connections/core.php'); ?>
<?php
//initialize the session
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

//	$vreqname = $row_rsuser['fname']; $row_rsuser['mname']; $row_rsuser['lname'];
//	$vmname = $row_rsuserppic['pfname']; $row_rsuserppic['pmname']; $row_rsuserppic['plname'];
	$vlname = $row_rsapprover['firstname']; $row_rsapprover['midlename']; $row_rsapprover['lastname'];
	//$vidmr = $_POST['idmr'];
	$approvaldate = $_POST['approvaldte'];
	$vrequestby = $row_Recordset2['requestby'];
	$vpassedby = $row_Recordset2['passedby'];
/*	if ($_POST['note'] != '') {
		$vnote = $_POST['note'];
		$rmk =  "(Note : $vnote)";
	} else if ($_POST['note'] == '') {
		$rmk =  '';
	}
*/	
	$nomr = $_POST['nomr'];
	if ($_POST['Submit'] == "Approve") {
		$statusapproval = "Y";
		$ntflink = "";
		$idmsgcat = 1;
		$isi = "MR/SR No. $nomr has been approved by $vlname on $approvaldate $rmk";
		$psn = "MR/SR No. $nomr has been approved";
		$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.code = 'K' AND h_employee.userlevel <> '' OR h_employee.userlevel = 'administrator'";
	}
	else if ($_POST['Submit'] == "Deny") {
		$statusapproval = "D";
		$ntflink = "";
		$idmsgcat = 2;
		$isi = "MR/SR No. $nomr has been denied by $vlname on $approvaldate $rmk";
		$psn = "MR/SR No. $nomr has been denied";
		//$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.department = 'Project' OR h_employee.userlevel = 'administrator'";
		$query_rsemployeedept = "SELECT requestby, passedby FROM p_mr_header WHERE requestby = '$vrequestby' OR passedby = '$vpassedby'";
	}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE p_mr_header SET approvedby=%s, approvaldate=%s WHERE id=%s",
                       GetSQLValueString($_POST['approvedby'], "text"),
                       GetSQLValueString($_POST['approvaldte'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "/tm/unapproved_crf.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE log_pesan SET sudah_bacaYN=%s, ntf_goto=%s WHERE id_notif=%s",
                       GetSQLValueString('Y', "text"),
                       GetSQLValueString('', "text"),
                       GetSQLValueString($idnotif, "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT p_mr_core.id, p_mr_core.itemmr, p_mr_core.qty, p_mr_core.dateinuse, p_mr_core.tobeuse, p_mr_core.remark, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_type, m_unit.unit AS itemunit FROM p_mr_core, m_master, m_e_model, m_unit WHERE p_mr_core.mrheader = %s AND p_mr_core.itemmr = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT p_mr_header.*, p_mr_core.mrheader, a_production_code.projectcode, a_production_code.productioncode FROM p_mr_header, p_mr_core, a_production_code WHERE p_mr_header.id = %s AND p_mr_core.mrheader = p_mr_header.id AND a_production_code.id = p_mr_header.id_prodcode", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>M/S Request</title>
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
</script>

</head>

<body><form method="POST" action="<?php echo $editFormAction; ?>" name="form">
<table width="702" border="0" cellpadding="5" class="General">
  <tr>
    <td width="144"><img src="/images/bukaka.jpg" width="102" height="24" /></td>
    <td width="6">&nbsp;</td>
    <td colspan="2" align="center" class="huruf_besar"><strong><font size="+1">MATERIAL / SERVICE REQUEST</font></strong></td>
    <td align="center" class="huruf_besar">&nbsp;</td>
    <td align="center" class="huruf_besar">&nbsp;</td>
  </tr>
  <tr>
    <td><input name="idmr" type="hidden" id="idmr" value="<?php echo $row_Recordset1['id']; ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>MR/SR</td>
    <td>:</td>
    <td width="263"><u><?php echo $row_Recordset2['nomr']; ?> 
    <label for="nomr"></label>
    <input name="nomr" type="hidden" id="nomr" value="<?php echo $row_Recordset2['nomr']; ?>" />
    </u></td>
    <td width="83">Proj. Code</td>
    <td width="3">:</td>
    <td width="163"><u><?php echo $row_Recordset2['projectcode']; ?></u></td>
  </tr>
  <tr>
  <?php include "../dateformat_funct.php"; ?>
    <td>Date</td>
    <td>:</td>
    <td><u><?php echo functddmmmyyyy($row_Recordset2['date']); ?></u></td>
    <td>Prod. Code</td>
    <td>:</td>
    <td><u><?php echo $row_Recordset2['productioncode']; ?></u></td>
  </tr>
</table><hr align="left" width="702" /></p>
<table width="702" border="1" class="table" id="celebs">
  <thead>
  <tr align="center">
    <td width="22"><b>NO.</b></td>
    <td width="200"><b>DESCRIPTION</b></td>
    <td width="104"><b>SPEC</b></td>
    <td width="41"><b>QTY</b></td>
    <td width="100"><b>DATE IN USE</b></td>
    <td width="100"><b>TO BE USED</b></td>
    <td width="90"><b>PROD CODE</b></td>
    <td width="100"><b>REMARK</b></td>
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
  <tr>
    <?php $a=$a+1; ?>
    <td align="center"><?php echo $a; ?></td>
    <td><?php echo $row_Recordset1['mtrl_model']; ?> (<?php echo $row_Recordset1['descr_name']; ?>) <?php echo $row_Recordset1['id_type']; ?> <?php echo $row_Recordset1['brand']; ?></td>
    <td><?php echo $row_Recordset1['descr_spec']; ?></td>
    <td align="center"><?php echo $row_Recordset1['qty']; ?></td>
    <td align="center"><?php echo functddmmmyyyy($row_Recordset1['dateinuse']); ?></td>
    <td align="center"><?php echo $row_Recordset1['tobeuse']; ?></td>
    <td align="center"><?php echo $row_Recordset2['productioncode']; ?></td>
    <td><?php echo $row_Recordset1['remark']; ?></td>
  </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </tbody>
</table>
<?php
	$userreq = $row_Recordset2['requestby'];
	mysql_select_db($database_core, $core);
	$query_rsreqby = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.requestby AND p_mr_header.requestby = '$userreq'";
	$rsreqby = mysql_query($query_rsreqby, $core) or die(mysql_error());
	$row_rsreqby = mysql_fetch_assoc($rsreqby);
	$totalRows_rsreqby = mysql_num_rows($rsreqby);
	
	$userpass = $row_Recordset2['passedby'];
	mysql_select_db($database_core, $core);
	$query_rsuserppic = "SELECT h_employee.id, h_employee.nik, h_employee.firstname AS pfname, h_employee.midlename AS pmname, h_employee.lastname AS plname FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.passedby AND p_mr_header.passedby = '$userpass'";
	$rsuserppic = mysql_query($query_rsuserppic, $core) or die(mysql_error());
	$row_rsuserppic = mysql_fetch_assoc($rsuserppic);
	$totalRows_rsuserppic = mysql_num_rows($rsuserppic);
	
	$userapprover = $row_Recordset2['approvedby'];
	mysql_select_db($database_core, $core);
	$query_rsapprover = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname  FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.approvedby AND p_mr_header.approvedby = '$userapprover'";
	$rsapprover = mysql_query($query_rsapprover, $core) or die(mysql_error());
	$row_rsapprover = mysql_fetch_assoc($rsapprover);
	$totalRows_rsapprover = mysql_num_rows($rsapprover);
?>
<br /><br />
<table width="702" border="1" class="General">
  <tr>
    <td colspan="9" nowrap="nowrap">Note: 
      <label for="note2"><?php echo $row_Recordset2['note']; ?></label></td>
  </tr>
  <tr>
    <td colspan="3">Request By</td>
    <td colspan="3">Passed By</td>
    <td colspan="3">Approved By</td>
  </tr>
  <tr>
    <td colspan="3"><p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <p class="hidentext">.</p></td>
    <td colspan="3"><p>&nbsp;</p></td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="56">Name</td>
    <td width="4">:</td>
    <td width="154"><?php echo $row_rsreqby['firstname']; ?> <?php echo $row_rsreqby['midlename']; ?> <?php echo $row_rsreqby['lastname']; ?></td>
    <td width="50">Name</td>
    <td width="4">:</td>
    <td width="154"><?php echo $row_rsuserppic['pfname']; ?> <?php echo $row_rsuserppic['pmname']; ?> <?php echo $row_rsuserppic['plname']; ?></td>
    <td width="78">Name </td>
    <td width="4">:</td>
    <td width="154"><?php echo $row_rsapprover['firstname']; ?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?>
      <label for="approvedby"></label>
      <input type="hidden" name="approvedby" id="approvedby" value="<?php echo $row_rsapprover['firstname']; ?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?>" /></td>
  </tr>
  <tr>
    <td height="26">Date</td>
    <td>:</td>
    <td><?php echo $row_Recordset2['requesterapprovaldate']; ?></td>
    <td>Date</td>
    <td>:</td>
    <td><?php echo $row_Recordset2['parserapprovaldate']; ?></td>
    <td>Date</td>
    <td>:</td>
    <td><label for="approvaldte"><?php echo date("d M Y"); ?></label>
      <input type="hidden" name="approvaldte" id="approvaldte" value="<?php echo date("Y-m-d"); ?>" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
  <input type="submit" name="Submit2" id="Submit2" value="Approve" style="font-size:16px; font-weight:bold; cursor:pointer" />
  &nbsp;&nbsp;&nbsp;
        <input type="submit" name="Submit" id="Submit" value="Deny" style="font-size:16px; font-weight:bold; cursor:pointer">
</p>
<input type="hidden" name="MM_update" value="form" />
</form>
</body>
</html>

<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset2);
	mysql_free_result($rsuser);
	mysql_free_result($rsreqby);
	mysql_free_result($rsuserppic);
	mysql_free_result($rsapprover);
?>