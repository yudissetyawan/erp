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
$query_rsarea = "SELECT * FROM f_site";
$rsarea = mysql_query($query_rsarea, $core) or die(mysql_error());
$row_rsarea = mysql_fetch_assoc($rsarea);
$totalRows_rsarea = mysql_num_rows($rsarea);

mysql_select_db($database_core, $core);
$query_rsplatform = "SELECT f_site.AreaName, f_site_platform.* FROM f_site_platform, f_site WHERE f_site_platform.AreaID = f_site.id";
$rsplatform = mysql_query($query_rsplatform, $core) or die(mysql_error());
$row_rsplatform = mysql_fetch_assoc($rsplatform);
$totalRows_rsplatform = mysql_num_rows($rsplatform);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List of Material / Service Request</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
function showData(str) {
	//alert (str);
	if (str=="") {
	  document.getElementById("txtHint").innerHTML="";
	  return;
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "view_detailrsareasr.php?data=" + str, true);
	xmlhttp.send();
}
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
</head>

<p class="buatform"><b>List of Area &amp; Sections</b></p>
<?php //{ require_once "../dateformat_funct.php"; } ?>
<table border="0" class="table" id="celebs">
	<thead>
  <tr height="30" class="tabel_header">
    <td width="30">No.</td>
    <td width="200">Name of Area</td>
    <td width="110"><i>Code of Location</i></td>
    <td width="200">Location</td>
    <td width="200">Note</td>
    <td width="40"><i>Active</i></td>
    <?php if ($_SESSION['userlvl'] == 'administrator') { ?>
    	<td width="50">&nbsp;</td>
	<?php } ?>
  </tr>
  </thead>
  <tbody> 
  <?php do { ?>
  <!-- onclick="this.style.fontWeight='bold'; showData()" -->
    <tr class="tabel_body" onclick="showData(<?php echo $row_rsarea['id']; ?>)" style="cursor:pointer" title="Click to view Item of MR">
      <td align="center">
	  	<?php $a = $a + 1; echo $a; ?>
      </td>  
      <td title="<?php echo $totalRows_rsjmlPO.' PO'; ?>"><?php echo $row_rsarea['AreaName']; ?></td>
      <td align="center"><?php echo $row_rsarea['kode_lokasi']; ?></td>
      <td><?php echo $row_rsarea['lokasi']; ?></td>
      <td><?php echo $row_rsarea['AreaNote']; ?></td>
      <td align="center" width="90"><?php echo $row_rsarea['AreaActiveYN']; ?></td>
      
      <?php if ($_SESSION['userlvl'] == 'administrator') { ?>
      	<td align="center" width="90"><a href="#">Edit</a> | <a href="#">Delete</a></td>
      <?php } ?>
      
    </tr>
    <?php } while ($row_rsarea = mysql_fetch_assoc($rsarea)); ?>
    
  </tbody>
</table>

<br />

<!-- <p class="buatform">Item of Material / Service Request (M/S R)</p> -->
<div id="txtHint">
	<p><b>Section of Area : <?php // echo $row_rsplatform['AreaName']; ?></b></p>
    
    <table class="table">
        <tr align="center" class="tabel_header" height="30">
          <td width="20">No.</td>
          <td width="200">Name of Section</td>
          <td width="150">Area</td>
          <td width="80">Initial</td>
          <td width="200">Note</td>
          <td width="50"><i>Active</i></td>
          <td width="50"><i>Has QSOP</i></td>
		<?php if ($_SESSION['userlvl'] == 'administrator') { ?> 
          <td>&nbsp;</td>
		<?php } ?>
        </tr>
        
      <?php do { ?>
          <tr class="tabel_body">
            <td align="center"><?php $b=$b+1; echo $b; ?></td>
            <td><?php echo $row_rsplatform['PlatformName']; ?></td>
            <td align="center"><?php echo $row_rsplatform['AreaName']; ?></td>
            <td align="center"><?php echo $row_rsplatform['PlatformCode']; ?></td>
            <td><?php echo $row_rsplatform['PlatformNote']; ?></td>
            <td align="center"><?php echo $row_rsplatform['SecActiveYN']; ?></td>
            <td align="center"><?php echo $row_rsplatform['HasQSOP']; ?></td>
            
		<?php if ($_SESSION['userlvl'] == 'administrator') { ?>
            <td align="center"><a href="#">Edit</a> | <a href="#">Delete</a></td>
		<?php } ?>
			
      </tr>
          <?php } while ($row_rsplatform = mysql_fetch_assoc($rsplatform)); //$row_rsplatform ?>
    </table>
</div>

<p>
<b><u>Note</u> :</b><br />
1 = Yes<br />
0 = No
</p>

<?php
	mysql_free_result($rsarea);
	mysql_free_result($rsplatform);
?>