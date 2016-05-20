<?php require_once('Connections/core.php'); ?>
<?php include('library/mrom.php');?>
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

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT d_out_mail.id, d_out_mail.`date`, d_out_mail.`description`, d_out_mail.information , a_customer.customername, a_contactperson.firstname, h_employee.`initial` AS apv, mkrr.`initial` AS mkr
FROM d_out_mail LEFT JOIN a_customer ON d_out_mail.costumer=a_customer.id LEFT JOIN a_contactperson ON d_out_mail.contact_person=a_contactperson.id LEFT JOIN h_employee ON  d_out_mail.from_approv = h_employee.id LEFT JOIN h_employee AS mkrr ON d_out_mail.from_maker =mkrr.id ";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT a_contactperson.id, a_contactperson.firstname FROM a_contactperson";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM a_customer";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT `initial` FROM h_employee ORDER BY `initial` ASC";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_core, $core);
$query_Recordset5 = "SELECT * FROM d_out_mail  WHERE d_out_mail.status = '1'";
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM d_perusahaan";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
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
<link type="text/css" href="js/jquiuni.css" rel="stylesheet" />
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
<title>Home - Non Conformance Report</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<table width="1200" border="0" align="center">
  <tr>
    <td height="64" colspan="2" rowspan="2"><a href="home.php"><img src="images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></a></td>
    <td width="628" align="right" valign="bottom"><table width="400" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>
        <td width="8" align="right" valign="bottom">|</td>
        <td width="250" align="right" valign="bottom" class="demoHeaders">Your Logged as <a href="hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
        <td width="8" class="demoHeaders">|</a></td>
        <td width="85" class="demoHeaders"><a href="contact.php">Contact Us</a></td>
        <td width="8" class="demoHeaders">|</td>
        <td width="60" class="demoHeaders"><a href="logout.php">Logout</a></td>
        <td align="right" width="10">|</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom"><?php { include "menu_notification.php"; } ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#8db4e3" class="tabel_index" id="font">Non Conformance Report</td>
    <td colspan="2" align="right" bgcolor="#8db4e3" id="font"><table width="500" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" bgcolor="#EFEFEF" class="tabel_index"><?php echo date("l, d F Y");?></td>
        <td align="left" bgcolor="#EFEFEF" class="tabel_index"> Welcome <?php echo $_SESSION['MM_Username']?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="General" id="font"><iframe src="<?php
                    	if ($_GET[modul]=='unapproved'){
							echo "tm/unapproved_crf.php";
						}
						elseif ($_GET[modul]=='notif'){
							echo "prj/bacanotif.php?data=$usrid";
						}
						else {
							echo "qly/ncr_header.php";
						}										
					?>" width="1200" height="1000" style="border:thin"></iframe></td>
  </tr>
  <tr>
    <td width="174">&nbsp;</td>
    <td width="453" class="pesan"><?php echo $_GET['pesan']; ?></td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
