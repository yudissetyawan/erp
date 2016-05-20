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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmNotifMR")) {
  $updateSQL = sprintf("UPDATE p_mr_header SET status_approval=%s WHERE id=%s",
                       GetSQLValueString('W', "text"),
                       GetSQLValueString($_POST['idMR'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

//NOTIF FOR BRANCHMANAGER OR OTHER

/*	$chosenapprover = $_POST['approvedby'];
	mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$chosenapprover'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);
	
	mysql_select_db($database_core, $core);
	$query_rsemployeedept = "SELECT h_employee.id AS empID FROM h_employee WHERE h_employee.userlevel = 'branchmanager' AND h_employee.id <> '$chosenapprover' OR h_employee.userlevel = 'administrator' OR h_employee.department = 'Project'";
	$rsemployeedept = mysql_query($query_rsemployeedept, $core) or die(mysql_error());
	$row_rsemployeedept = mysql_fetch_assoc($rsemployeedept);
	$totalRows_rsemployeedept = mysql_num_rows($rsemployeedept); */
	
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmNotifMR")) {
	$vidmr = $_POST['idMR'];
	$vnomr = $_POST['noMR'];
	$vprojcd = $_POST['projcd'];
	$vprodcd = $_POST['prodcd'];
	$approvername = $_POST['nmApprover'];
	$isipsn = "MR No. : $vnomr will be used for $vprojcd - $vprodcd , is waiting for approval by $approvername";
	$goto = "../tm/view_detailmrsr_approval.php?data=$vidmr";
	
  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto, id_msgcat) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString('62', "int"),
						   GetSQLValueString($vidmr, "text"),
						   GetSQLValueString($_POST['idApprover'], "int"),
						   GetSQLValueString($isipsn, "text"),
						   GetSQLValueString($goto, "text"),
						   GetSQLValueString('3', "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

	echo "<script>
		alert(\"MR No. : $vnomr has been submitted and waiting for approval by $approvername\");
		parent.window.location.reload(true);
	</script>";
	
  $insertGoTo = "/ppic/view_headermrsr.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT p_mr_header.*, a_production_code.projectcode, a_production_code.productioncode FROM p_mr_header, a_production_code WHERE p_mr_header.id = %s AND a_production_code.id = p_mr_header.id_prodcode", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>M/S Request</title>
<script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>M/S Request</title><link rel="stylesheet" type="text/css" href="../css/print.css" /><link href="../css/footer.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../css/print.css" media="screen"/><link href="../css/footer.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css"/></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>
<link href="../css/layoutforprint.css" rel="stylesheet" type="text/css" />
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
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') && ($row_Recordset2['status_approval'] != 'W')) {
		echo '<p class="btn"><a href="/ppic/inputmaterialrequestdetail.php?data='.$_GET[data].'"><b>+ ADD NEW</b></a></p>';
	}
?>
<table width="722" border="0" cellpadding="5">
  <tr>
    <td width="83"><img src="/images/bukaka.jpg" width="102" height="24" /></td>
    <td colspan="4" align="center"><strong><font size="+1">MATERIAL / SERVICE REQUEST</font></strong></td>
    <td align="center" class="huruf_besar">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>MR/SR</td>
    <td>:</td>
<td width="263"><u><?php echo $row_Recordset3['nomr']; ?></u></td>
    <td width="83">Proj. Code</td>
    <td width="3">:</td>
<td width="163"><u><?php echo $row_Recordset3['projectcode']; ?></u></td>
  </tr>
  <tr>
    <?php include "../dateformat_funct.php"; ?>
<td>Date</td>
    <td>:</td>
    <td><u><?php echo functddmmmyyyy($row_Recordset3['date']); ?></u></td>
    <td>Prod. Code</td>
    <td>:</td>
<td><u><?php echo $row_Recordset3['productioncode']; ?></u></td>
  </tr>
</table> 
<p>
<hr align="left" width="722" /></p>
<table width="722" border="1" class="table" id="celebs">
<thead>
  <tr align="center" class="tabel_header">
    <td width="18"><b>NO.</b></td>
    <td width="222"><b>DESCRIPTION</b></td>
    <td width="94"><b>SPEC</b></td>
    <td width="48"><b>QTY</b></td>
    <td width="54"><b>DATE IN USE</b></td>
    <td width="74"><b>TO BE USED</b></td>
    <td width="58"><b>PROD CODE</b></td>
    <td><b>REMARK</b></td>
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
        <td><?php echo $row_Recordset1['mtrl_model']; ?> (<?php echo $row_Recordset1['descr_name']; ?>) <?php echo $row_Recordset1['id_type']; ?> <?php echo $row_Recordset1['brand']; ?></td>
        <td><?php echo $row_Recordset1[descr_spec]; ?></td>
        <td align="center"><?php echo $row_Recordset1[qty]; ?> <?php echo $row_Recordset1[itemunit]; ?></td>
        <td align="center"><?php echo functddmmmyyyy($row_Recordset1[dateinuse]); ?></td>
        <td align="center"><?php echo $row_Recordset1[tobeuse]; ?></td>
        <td align="center"><?php echo $row_Recordset2[productioncode]; ?></td>
        <td width="102"><?php echo $row_Recordset1['remark']; ?></td>
        <?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') && ($row_Recordset2['status_approval'] != 'W')) {
		//<a href="edit_detailmrsr.php?data='.$row_Recordset1['id'].'"><b>Edit</b></a> | 
		echo '<td align="center" class="btn">
				<a href="delete_detailmrsr.php?data='.$row_Recordset1['id'].'"><b>Delete</b></a>
			</td>';
	}
		?>
      </tr>      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

      <tr class="tabel_body">
        <td colspan="8">Note : <?php echo $row_Recordset2['note']; ?></td>
      </tr>
  </tbody>
</table>
<?php
	$userreq = $row_Recordset2['requestby'];
	mysql_select_db($database_core, $core);
	$query_rsuser = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.requestby AND p_mr_header.requestby = '$userreq'";
	$rsuser = mysql_query($query_rsuser, $core) or die(mysql_error());
	$row_rsuser = mysql_fetch_assoc($rsuser);
	$totalRows_rsuser = mysql_num_rows($rsuser);
	
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

<table width="722" border="1" class="footernya">
  <tr>
    <td width="665" rowspan="2">&nbsp;</td>
    <td width="162"><p>Request by <p style="visibility:hidden">.</p>
    <p style="visibility:hidden">.</p>
    <div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-prepareby"><?php echo $row_rsuser['fname']; ?> <?php echo $row_rsuser['mname']; ?> <?php echo $row_rsuser['lname']; ?></div></td>
    <td width="162"><p>Passed by <p style="visibility:hidden">.</p>
    <p style="visibility:hidden">.</p>
      <div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-checkedby"><?php echo $row_rsuserppic['pfname']; ?> <?php echo $row_rsuserppic['pmname']; ?> <?php echo $row_rsuserppic['plname']; ?></div>
    </td>
    <td width="162"><p>Approved by <p style="visibility:hidden">.</p>
    <p style="visibility:hidden">.</p>
    <div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-approvedby"><?php echo $row_rsapprover['firstname']; ?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?></div></td>
  </tr>
  <tr>
    <td><?php echo $row_Recordset2['requesterapprovaldate']; ?></td>
    <td width="162"><?php echo $row_Recordset2['parserapprovaldate']; ?></td>
    <td width="162"><?php echo $row_Recordset2['approvaldate']; ?></td>
  </tr>
</table> 
</p><br />
<table>
	<tr>
		<!--<td><img src="/images/icon_print.gif" width="25" height="25" class="btn" onclick="PrintDoc()" /></td>!-->
        <td><a href="view_detailmrsr_ready.php?data=<?php echo $_GET['data']; ?>" target="_blank"><img src="/images/icon_printpw.gif" width="24" height="25" class="btn"/></a></td>
        <td>
        	<form action="<?php echo $editFormAction; ?>" method="POST" id="frmNotifMR" name="frmNotifMR">
            	<input name="idMR" type="hidden" value="<?php echo $row_Recordset2['id']; ?>" />
                <input name="noMR" type="hidden" value="<?php echo $row_Recordset2['nomr']; ?>" />
                <input name="projcd" type="hidden" value="<?php echo $row_Recordset2['projectcode']; ?>" />
                <input name="prodcd" type="hidden" value="<?php echo $row_Recordset2['productioncode']; ?>" />
                <input name="idApprover" type="hidden" value="<?php echo $row_Recordset2['approvedby']; ?>" />
                <input name="nmApprover" type="hidden" value="<?php echo $row_rsapprover['firstname']; ?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?>" />
            	<input type="submit" class="btn" name="btnDone" id="btnDone" value="Done" title="Your request has Done and send for approval" />
       	      <input type="hidden" name="MM_insert" value="frmNotifMR" />
       	      <input type="hidden" name="MM_update" value="frmNotifMR" />
            </form>
        </td>
    </tr>
</table>
</body>

</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset2);
	mysql_free_result($Recordset3);
	mysql_free_result($rsapprovedby);
?>
