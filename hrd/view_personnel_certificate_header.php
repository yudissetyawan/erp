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

mysql_select_db($database_core, $core);
$query_h_employee = "SELECT * FROM h_employee WHERE h_employee.code='K' ORDER BY h_employee.firstname ASC";
$h_employee = mysql_query($query_h_employee, $core) or die(mysql_error());
$row_h_employee = mysql_fetch_assoc($h_employee);
$totalRows_h_employee = mysql_num_rows($h_employee);

$userid = $_SESSION['empID'];
mysql_select_db($database_core, $core);
$query_rsusrlogin = "SELECT h_employee.jabatan FROM h_employee WHERE h_employee.id = '$userid'";
$rsusrlogin = mysql_query($query_rsusrlogin, $core) or die(mysql_error());
$row_rsusrlogin = mysql_fetch_assoc($rsusrlogin);
$totalRows_rsusrlogin = mysql_num_rows($rsusrlogin);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Name of Personnel</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../../css/table.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery.datatables.js"></script>
<script type="text/javascript" src="../../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../../js/jquery.blockui.js"></script>
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
	xmlhttp.open("GET", "view_personnel_certificate.php?data=" + str, true);
	xmlhttp.send();
}
</script>

</head>

<body>
<table width="100%" border="0" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
    <td width="30">No.</td>
    <td width="50">NIK</td>
    <td width="200">Name of Employee</td>
    <td width="50">Initial</td>
    <td width="300">Email</td>
    <td>Department</td>
    <td>Position</td>
    <?php
	if (($_SESSION['userlvl'] == 'hrd') || ($row_rsusrlogin['jabatan'] == 'Receptionist') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<td>Phone No.</td>';
	}
?>
  </tr>
</thead>
<tbody>  
  <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a=$a+1; echo $a; ?></td>
      <td><?php echo $row_h_employee['nik']; ?></td>
      <td><a href="view_personnel_certificate.php?data=<?php echo $row_h_employee['id']; ?>" title="Click to view Personnel Certificate"><?php echo $row_h_employee['firstname']; ?> <?php echo $row_h_employee['midlename']; ?> <?php echo $row_h_employee['lastname']; ?></a></td>
      <td align="center"><?php echo $row_h_employee['initial']; ?></td>
      
      <?php
		$empid = $row_h_employee['id'];
        mysql_select_db($database_core, $core);
		$query_rsphoneno = "SELECT h_datapribadi.nohp, h_datapribadi.email FROM h_datapribadi WHERE id_h_employee='$empid'";
		$rsphoneno = mysql_query($query_rsphoneno, $core) or die(mysql_error());
		$row_rsphoneno = mysql_fetch_assoc($rsphoneno);
		$totalRows_rsphoneno = mysql_num_rows($rsphoneno);		
	?>
    
      <td align="center"><?php echo $row_rsphoneno['email']; ?></td>
      <td><?php echo $row_h_employee['department']; ?></td>
      <td><?php echo $row_h_employee['jabatan']; ?></td> 
		
		<?php
		if (($_SESSION['userlvl'] == 'hrd') || ($row_rsusrlogin['jabatan'] == 'Receptionist') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
				echo '<td align="center">'.$row_rsphoneno['nohp'].'</td>';
				
		} ?>
    </tr>
    <?php } while ($row_h_employee = mysql_fetch_assoc($h_employee)); ?>
</tbody>    
</table>

<div id="txtHint">

</div>

</body>
</html>
<?php
	mysql_free_result($h_employee);
	mysql_free_result($rsusrlogin);
	mysql_free_result($rsphoneno);
?>