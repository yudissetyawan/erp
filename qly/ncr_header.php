<?php require_once('../Connections/core.php'); ?>
<?php include('../library/mrom.php');?>
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

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT d_out_mail.no_surat, d_out_mail.`date`, d_out_mail.`description`, d_out_mail.information , a_customer.customername, a_contactperson.firstname, h_employee.`initial` AS apv, mkrr.`initial` AS mkr
FROM d_out_mail LEFT JOIN a_customer ON d_out_mail.costumer=a_customer.id LEFT JOIN a_contactperson ON d_out_mail.contact_person=a_contactperson.id LEFT JOIN h_employee ON  d_out_mail.from_approv = h_employee.id LEFT JOIN h_employee AS mkrr ON d_out_mail.from_maker =mkrr.id ";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_q_ncr = "SELECT q_ncr.*, h_department.department, a_production_code.productioncode FROM q_ncr, h_department, a_production_code WHERE h_department.id = q_ncr.id AND a_production_code.id = q_ncr.prod_code";
$q_ncr = mysql_query($query_q_ncr, $core) or die(mysql_error());
$row_q_ncr = mysql_fetch_assoc($q_ncr);
$totalRows_q_ncr = mysql_num_rows($q_ncr);mysql_select_db($database_core, $core);
$query_q_ncr = "SELECT q_ncr.*, h_department.department FROM q_ncr, h_department WHERE h_department.id = q_ncr.id ";
$q_ncr = mysql_query($query_q_ncr, $core) or die(mysql_error());
$row_q_ncr = mysql_fetch_assoc($q_ncr);
$totalRows_q_ncr = mysql_num_rows($q_ncr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<link href="../css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.datatables.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/jquery.blockui.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(function(){
				$('#dialog').dialog({
					autoOpen: false,
					title: 'ADD DATA',
					width: 750,
				});
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});
				$('#datepicker').datepicker({dateFormat: 'yy-mm-dd'});
				$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
		});
        var availableTags = [
        <?php do {  ?>
            "<?php echo $row_Recordset3['customername'] ?>",
		<?php
			} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
			$rows = mysql_num_rows($Recordset3);
			if($rows > 0) {
				mysql_data_seek($Recordset3, 0);
			$row_Recordset3 = mysql_fetch_assoc($Recordset3);
			}
	    ?>
		""
        ];
        $( "#company" ).autocomplete({
            source: availableTags
        });
		var availableTags = [	
			<?php do {  ?>
            	"<?php echo $row_Recordset2['firstname']?>",
            <?php
				} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
				$rows = mysql_num_rows($Recordset2);
				if($rows > 0) {
					mysql_data_seek($Recordset2, 0);
				$row_Recordset2 = mysql_fetch_assoc($Recordset2);
				}
	    	?>
			"Pimpinan",
			"-"
			];
			 $( "#attn" ).autocomplete({
            source: availableTags
		});
		var availableTags = [	
			<?php do {  ?>
            	"<?php echo $row_Recordset4['initial']?>",
            <?php
				} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
				$rows = mysql_num_rows($Recordset4);
				if($rows > 0) {
					mysql_data_seek($Recordset4, 0);
				$row_Recordset4 = mysql_fetch_assoc($Recordset4);
				}
	    	?>
			"-"
			];
			 $( ".initial" ).autocomplete({
            source: availableTags
		});
    });
	//Ajax
	function getidbyname(str,fl,tab,dv) {
		if (str.length==0){ 
			  document.getElementById(dv).innerHTML="";
			  return;
		}
		if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
		  	xmlhttp=new XMLHttpRequest();
		}
		else{
			// code for IE6, IE5
		  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(dv).innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","fileajax/employehidden.php?namex="+str+"&fl="+fl+"&tab="+tab+"&dv="+dv,true);
		xmlhttp.send();
	};
</script>

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
<title>Non Conformence Report</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php
    include("../css/tanggal.php");?>
<p><a href="ncr_input.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add</a>
</p>
<div class="container">
  <table width="100%" border="0" class="table" id="celebs">
  <thead>
    <tr class="tabel_header" height="40">
      <td width="30">No.</td>
      <td width="120">NCR No.</td>
      <td width="260">Title of NCR</td>
      <td width="80">Date</td>
      <td width="166">Department / Supplier</td>
      <td width="142">Originator / Request</td>
      <td width="90">Prod. Code</td>
      <td width="50">&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    <?php
    require_once "../dateformat_funct.php";
	do { ?>
      <tr class="tabel_body">
        <td align="center"><?php $a=$a+1; echo $a ?></td>
        <td align="center"><?php echo $row_q_ncr['no_ncr']; ?></td>
        <td><a href="#" onclick="MM_openBrWindow('ncr_viewcore.php?data=<?php echo $row_q_ncr['id']; ?>','','scrollbars=yes,resizable=yes,width=1200,height=700')"><?php echo $row_q_ncr['title_ncr']; ?></a></td>
        <td align="center"><?php echo functddmmmyyyy($row_q_ncr['ncr_date']); ?></td>
        <td><?php echo $row_q_ncr['department']; ?> <?php echo $row_q_ncr['supp']; ?></td>
        <td><?php echo $row_q_ncr['req']; ?></td>
        <td align="center"><?php echo $row_q_ncr['prod_code']; ?><?php echo $row_q_ncr['prod_code_other']; ?></td>
        <td align="center"><a href="ncr_edit.php?data=<?php echo $row_q_ncr['id']; ?>">EDIT</a></td>
      </tr>
      <?php } while ($row_q_ncr = mysql_fetch_assoc($q_ncr)); ?>
      </tbody>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($q_ncr);
?>
