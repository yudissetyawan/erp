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
$query_rsdoheader = "SELECT p_do_header.*, h_employee.firstname AS manfname, h_employee.midlename AS manmname, h_employee.lastname AS manlname FROM p_do_header, h_employee WHERE p_do_header.managername = h_employee.id";
$rsdoheader = mysql_query($query_rsdoheader, $core) or die(mysql_error());
$row_rsdoheader = mysql_fetch_assoc($rsdoheader);
$totalRows_rsdoheader = mysql_num_rows($rsdoheader);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Delivery Order (DO)</title>
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.datatables.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/jquery.blockui.js"></script>
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

<body class="General">
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator')) {
		echo '<p><a href="do_inputheader.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>New DO</a></p>';
	}
?>
<br />
<table border="0" width="1350" class="table" id="celebs">
<thead>
  <tr class="tabel_header">
    <td width="15">No</td>
    <td width="100">DO No.</td>
    <td width="100">Ship to</td>
    <td width="80">Contract No.</td>
    <td width="100">Packing List No.</td>
    <td width="90">Delivery Point</td>
    <td width="90">Carrier</td>
    <td width="80">Plat No. / Reg.</td>
    <td width="90">Manager</td>
    <td width="70">Signed by <br /> Manager <br /> on</td>
    <td width="90">Security</td>
    <td width="70">Signed by <br /> Security <br /> on</td>
    <td width="90">Carrier</td>
    <td width="70">Signed by <br /> Carrier <br /> on</td>
    <td width="90">Received by <br /> (Client)</td>
    <td width="70">Received by <br /> (Client) <br /> on</td>
    <td width="30">&nbsp;</td>
  </tr>
 </thead>
 <tbody>
  <?php
  { include "../dateformat_funct.php"; }
  
  do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><a href="do_viewdetail.php?data=<?php echo $row_rsdoheader['id']; ?>"><?php echo $row_rsdoheader['donumber']; ?></a></td>
      <td><?php echo $row_rsdoheader['shipto']; ?></td>
         
      <td align="center"><?php echo $row_rsdoheader['contractnumber']; ?></td>
      <td align="center">
	  	<?php
		$idpl = $row_rsdoheader['packinglistnumber'];
		if ($idpl != '') {
        	mysql_select_db($database_core, $core);
			$query_rspkglist = "SELECT no_pl FROM p_pl_header WHERE id = '$idpl'";
			$rspkglist = mysql_query($query_rspkglist, $core) or die(mysql_error());
			$row_rspkglist = mysql_fetch_assoc($rspkglist);
			$totalRows_rspkglist = mysql_num_rows($rspkglist);
			echo $row_rspkglist['no_pl'];
		} else {
			echo '-';
		}
		?>
      </td>
      
      <td><?php echo $row_rsdoheader['deliverypoint']; ?></td>
      <td><?php echo $row_rsdoheader['carier']; ?></td>
      <td align="center"><?php echo $row_rsdoheader['platno']; ?></td>
      <td align="center"><?php echo $row_rsdoheader['manfname']; ?> <?php echo $row_rsdoheader['manmname']; ?> <?php echo $row_rsdoheader['manlname']; ?></td>
      <td width="80" align="center"><?php echo functddmmmyyyy($row_rsdoheader[managerdate]); ?></td>
      <td align="center">
	  <?php
      	$idsecurity = $row_rsdoheader['securityname'];
	  	mysql_select_db($database_core, $core);
		$query_rssecname = "SELECT h_employee.firstname AS secfname, h_employee.midlename AS secmname, h_employee.lastname AS seclname FROM h_employee WHERE h_employee.id = '$idsecurity'";
		$rssecname = mysql_query($query_rssecname, $core) or die(mysql_error());
		$row_rssecname = mysql_fetch_assoc($rssecname);
		$totalRows_rssecname = mysql_num_rows($rssecname);
		
		echo $row_rssecname['secfname']; ?> <?php echo $row_rssecname['mname']; ?> <?php echo $row_rssecname['lname'];
	?>
      </td>
      <td width="80" align="center"><?php echo functddmmmyyyy($row_rsdoheader[securitydate]); ?></td>
      <td align="center"><?php echo $row_rsdoheader['cariername']; ?></td>
      <td width="80" align="center"><?php echo functddmmmyyyy($row_rsdoheader[carierdate]); ?></td>
      <td align="center"><?php echo $row_rsdoheader['recievername']; ?></td>
      <td width="80" align="center"><?php echo functddmmmyyyy($row_rsdoheader[recieverdate]); ?></td>
      <td align="center"><a href="do_editheader.php?data=<?php echo $row_rsdoheader['id']; ?>">EDIT</a></td>
    </tr>
    <?php } while ($row_rsdoheader = mysql_fetch_assoc($rsdoheader)); ?>
 </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($rsdoheader);
	mysql_free_result($rspkglist);
?>