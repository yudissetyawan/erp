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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
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
</script>
<title>MR / DCC - Outgoing Mail </title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php
    include("../css/tanggal.php");?>
<p><a href="input_outmail.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add</a>
</p>
<div class="container">
  <table width="" border="0" cellpadding="2" cellspacing="2" class="table" id="celebs" >
    <thead>
      <tr align="center" bgcolor="#0066FF" class="tabel_header">
        <td width="190" class="">Nomor Surat</td>
        <td width="115" class="">Tanggal</td>
        <td width="282" class="">Uraian</td>
        <td width="229" class="">Perusahaan</td>
        <td width="121" class="">Attn.</td>
        <td width="76" class=""> Inisial Penanda Tangan </td>
        <td width="80" class="">Inisial Pembuat</td>
        <td width="180" class="">Keterangan</td>
        <td>&nbsp;</td>
      </tr>
    </thead>
    <tbody>
      <?php  do { ?>
      <tr class="tabel_body" <?php if(($n % 2)==0) ;?> >
        <form action="" method="get" class="tabel_body">
          <td align="center"><?php if($row_Recordset5['no_surat']<10){echo "00".$row_Recordset5['no_surat'];} else if($row_Recordset5['no_surat']<100){echo "0".$row_Recordset5['no_surat'];}else{echo $row_Recordset5['no_surat'];} echo "/BTU-BPN/".$row_Recordset5['from_approv']."-".$row_Recordset5['from_maker']."/".MMRomawi($row_Recordset5['date'])."/".date('Y',strtotime($row_Recordset5['date'])); ?></td>
          <td align="center">
		  <?php
				include "../dateformat_funct.php";
				echo functddmmmyyyy($row_Recordset5['date']);
			?>
          </td>
          <td><?php echo $row_Recordset5['description']; ?></td>
          <td align="center"><?php echo $row_Recordset5['costumer']; ?></td>
          <td><?php echo $row_Recordset5['contact_person']; ?></td>
          <td align="center"><?php echo $row_Recordset5['from_approv']; ?></td>
          <td align="center"><?php echo $row_Recordset5['from_maker']; ?></td>
          <td align="center"><?php echo $row_Recordset5['information']; ?></td>
          <td align="center"><a href="edit_outmail.php?data=<?php echo $row_Recordset5['id_nosurat']; ?>">Edit</a></td>
          </form>
      </tr>
      <?php } while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)); ?>
    </tbody>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
