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

mysql_select_db($database_core, $core);
$query_q_ccomplaint = "SELECT * FROM q_ccomplaint";
$q_ccomplaint = mysql_query($query_q_ccomplaint, $core) or die(mysql_error());
$row_q_ccomplaint = mysql_fetch_assoc($q_ccomplaint);
$totalRows_q_ccomplaint = mysql_num_rows($q_ccomplaint);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<link href="/css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.datatables.js"></script>
<script type="text/javascript" src="/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="/js/jquery.blockui.js"></script>
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

</head>

<body>
<h2>Customer Complaint </h2>
<p><a href="cpar_complaint_input.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add</a>
</p>
<table width="646" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
    <td>No</td>
    <td>Date</td>
    <td>Title of Complaint</td>
    <td>Complaint by</td>
    <td>Complaint Via</td>
    <td> CPAR</td>
    <td>&nbsp;</td>
  </tr>
</thead>
<tbody>  
  <?php
  require_once "../dateformat_funct.php";
  
  do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a = $a + 1; echo $a; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_q_ccomplaint['tanggal']); ?></td>
      <td><a href="#" onclick="MM_openBrWindow('cpar_complaint_coreheader.php?data=<?php echo $row_q_ccomplaint['id']; ?>','Costumer Complaint','scrollbars=yes,width=450,height=400')"><?php echo $row_q_ccomplaint['title_complaint']; ?></a></td>
      <td><?php echo $row_q_ccomplaint['complaint_by']; ?></td>
      <td><?php echo $row_q_ccomplaint['compalint_via']; ?></td>
      <td align="center"><?php if ($row_q_ccomplaint['status_cpar']==1) { echo "<img src='../images/select(1).png' width='15' height='15' />"; } 
		  else { 
		  echo "<a href='cpar_input.php?data=$row_q_ccomplaint[id]' target=_blank>Create CPAR</a>";
		  }?></td>
      <td align="center"><a href="#">Edit</a></td>
    </tr>
    <?php } while ($row_q_ccomplaint = mysql_fetch_assoc($q_ccomplaint)); ?>
</tbody>    
</table>
</body>
</html>
<?php
mysql_free_result($q_ccomplaint);
?>
