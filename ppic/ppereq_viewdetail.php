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

$colname_rsppereqheader = "-1";
if (isset($_GET['data'])) {
  $colname_rsppereqheader = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsppereqheader = sprintf("SELECT p_ppereq_header.*, h_employee.firstname AS manfname, h_employee.midlename AS manmname, h_employee.lastname AS manlname, a_proj_code.project_code FROM p_ppereq_header, h_employee, a_proj_code WHERE h_employee.id = p_ppereq_header.req_by_manager AND p_ppereq_header. id = %s AND a_proj_code.id = p_ppereq_header.id_projcode", GetSQLValueString($colname_rsppereqheader, "int"));
$rsppereqheader = mysql_query($query_rsppereqheader, $core) or die(mysql_error());
$row_rsppereqheader = mysql_fetch_assoc($rsppereqheader);
$totalRows_rsppereqheader = mysql_num_rows($rsppereqheader);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PPE Detail</title>
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">
<link href="/css/layoutforprint.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="../css/print.css" />
<link rel="stylesheet" type="text/css" href="../css/styles.css" />

<script type="text/javascript">
/*-- method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><head><title>M/S Request</title><link rel="stylesheet" type="text/css" href="../css/print.css" media="print" /><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css" /></head><body onload="window.print()">');
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</body></html>');
        popupWin.document.close();
    }

/*-- method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><head><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../css/print.css" media="screen"/><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css" /></head><body>');
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</body></html>');
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
<p class="btn">
<?php
	{ require_once "../dateformat_funct.php"; }
            
	$vid = $_GET['data'];
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator')) {
		echo '<p class="btn"><a href="ppereq_inputdetail.php?data='.$vid.'" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item PPE Request</a></p>';
	}
?></p>
<table width="730" border="1">
  <tr>
    <td width="728">
        <table width="727" border="0" cellpadding="5" class="General">
          <tr>
            <td width="140" valign="middle" height="70"><img src="/images/bukaka.jpg" alt="" width="102" height="24" /></td>
            <td width="6">&nbsp;</td>
            <td colspan="2" align="center" class="huruf_besar">
                <b><font size="+1">PERSONAL PROTECTIVE EQUIPMENT (PPE)</font></b> <b><font size="+1">REQUEST</font></b><br />
            <td width="6" class="huruf_besar">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td>Project Code</td>
            <td>:</td>
            <td width="240"><?php echo $row_rsppereqheader['project_code']; ?></td>
            <td width="130">&nbsp;&nbsp;&nbsp; Date</td>
            <td width="3">:</td>
            <td width="130"><?php echo functddmmmyyyy($row_rsppereqheader['ppereq_date']); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;&nbsp;&nbsp; No.</td>
            <td>:</td>
            <td><?php echo $row_rsppereqheader['ppereq_no']; ?></td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="center"><iframe width="727" height="329" style="border:none" src="ppereq_viewdetail_isi.php?data=<?php echo $_GET ['data']; ?>"></iframe></td>
  </tr>
  </table> 


<table width="731" border="1" class="General">
	<tr>
    	<td><b>Note : <?php echo $row_rsppereqheader['note']; ?></b></td>
    </tr>
</table>

  
    <table width="731" border="1" class="General">
      <tr>
        
        <td width="180"><p>Request by (Manager),</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="180"><p>Passed by (HRD),</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="180"><p>Distributed by,</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
       <?php
	   	$passedby = $row_rsppereqheader['passed_by'];
		mysql_select_db($database_core, $core);
		$query_rspassedby = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE h_employee.id = '$passedby'";
		$rspassedby = mysql_query($query_rspassedby, $core) or die(mysql_error());
		$row_rspassedby = mysql_fetch_assoc($rspassedby);
		$totalRows_rspassedby = mysql_num_rows($rspassedby);
		
		$distribby = $row_rsppereqheader['distrib_by'];
		mysql_select_db($database_core, $core);
		$query_rsdistribby = "SELECT h_employee.id, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$distribby'";
		$rsdistribby = mysql_query($query_rsdistribby, $core) or die(mysql_error());
		$row_rsdistribby = mysql_fetch_assoc($rsdistribby);
		$totalRows_rsdistribby = mysql_num_rows($rsdistribby);
	?>
    
        <td width="180"><div class="headeredit" id="<?php echo $row_rsppereqheader['id']; ?>-manager"><?php echo $row_rsppereqheader['manfname']; ?> <?php echo $row_rsppereqheader['manmname']; ?> <?php echo $row_rsppereqheader['manlname']; ?></div></td>
        <td width="180"><div class="headeredit" id="<?php echo $row_rsppereqheader['id']; ?>-passedby"><?php echo $row_rspassedby['firstname']; ?> <?php echo $row_rspassedby['midlename']; ?> <?php echo $row_rspassedby['lastname']; ?></div></td>
        <td width="180"><div class="headeredit" id="<?php echo $row_rsppereqheader['id']; ?>-distribby"> <?php echo $row_rsdistribby['fname']; ?> <?php echo $row_rsdistribby['mname']; ?> <?php echo $row_rsdistribby['lname']; ?></div></td>
      </tr>
    </table>

</p>
<br /><br /><br />
<table class="btn">
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
              <input name="nmApprover" type="hidden" value="<?php echo $row_rspassedby['firstname']; ?> <?php echo $row_rspassedby['midlename']; ?> <?php echo $row_rspassedby['lastname']; ?>" />
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
	mysql_free_result($rsppereqheader);
	mysql_free_result($rsdistribby);
	mysql_free_result($rspassedby);
?>
