<?php require_once('../../Connections/core.php'); ?>
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
$query_Recordset1 = "SELECT * FROM a_pra_code ORDER BY pracode ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html lang="en">
<head>
<title></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Description" content="Learn to create paginated, editable, and sortable tables in jQuery." />
<meta name="Keywords" content="jquery, datatables, jeditable, paginated tables, table sorting, akshitsethi" />
<meta name="Owner" content="Akshit Sethi" />
<link rel="shortcut icon" href="img/favicon.ico">
<link href="../css/induk.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css">
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>
<body>
  <p><?php
	if (($_SESSION['userlvl'] == 'marketing') || ($_SESSION['userlvl'] == 'administrator') ) {
		echo '<p><a href="inputpracode.php" class="buatform">Add New Tender</a></p>';
	}
?></p>
  <div class="container">
    <table width="2186" class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <td width="29" rowspan="2">No.</td>
          <td width="62" rowspan="2">Pracode</td>
          <td width="313" rowspan="2">Title Of Tender</td>
          <td width="114" rowspan="2">Tender No.</td>
          <td width="265" rowspan="2">Customer</td>
          <td colspan="6">Tender Plan</td>
          <td width="148" rowspan="2"> Estimation Value</td>
          <td rowspan="2">Remarks</td>
          <td rowspan="2">Attachment</td>
          <td width="99" rowspan="2">Status</td>
        </tr>
        <tr>
          <td width="110" class="tabel_header">Duration</td>
          <td width="115" class="tabel_header">Registration Date</td>
          <td width="125" class="tabel_header">PQ Submission</td>
          <td width="117" class="tabel_header">Collect Document</td>
          <td width="100" class="tabel_header">Pre-BID</td>
          <td width="124" class="tabel_header">Closing Date</td>
        </tr>
      </thead>
      <tbody>
        <?php do { ?>
        <tr class="tabel_body">
          <?php $n=$n+1; ?>
          <td align="center"><?php echo $n ; ?></td>
          <td align='center' style="color:#FFF" bgcolor="<? $k=$row_Recordset1['status']; if ($k
=='WIN') echo"#3574ec7"; if ($k=='LOSE') echo"#ED1A6F";  else echo "#F7F3F7"; $k++ ?>" ><?php if ($row_Recordset1[status]=="WIN") { echo $row_Recordset1[pracode]; } 
		  else { 
		  echo "<a href='inputtender.php?data=$row_Recordset1[id]'>$row_Recordset1[pracode]</a>";
		  };?></td>
          <td><?php echo $row_Recordset1['tendername']; ?></td>
          <td align="center"><?php echo $row_Recordset1['tenderno']; ?></td>
          <td><?php echo $row_Recordset1['customer']; ?></td>
          <td align="center"><?php echo $row_Recordset1['duration']. ' ' .$row_Recordset1['duration_satuan']; ?></td>
          <td align="center"><?php echo $row_Recordset1['startdate']; ?></td>
          <td align="center"><?php echo $row_Recordset1['registration']; ?></td>
          <td align="center"><?php echo $row_Recordset1['finishdate']; ?></td>
          <td align="center"><?php echo $row_Recordset1['prebid']; ?></td>
          <td align="center"><?php echo $row_Recordset1['closingdate']; ?></td>
          <td align="center"><?php echo '$ ' . number_format(  $row_Recordset1['priceestimation'], 0 , '' , ',' ); ?></td>
          <td width="256"><?php echo $row_Recordset1['remark']; ?></td>
          <td width="145" align="center"><?php if ($row_Recordset1[fileupload]=="") { echo "-"; } 
		  else { 
		  echo "<a href='../mkt/tenderdoc/$row_Recordset1[fileupload]'>$row_Recordset1[fileupload]</a>";
		  };?></td>
          <td align="center"><?php echo $row_Recordset1['status']; ?></td>
        </tr>
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </tbody>
    </table>
  </div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
