<?php require_once('../../Connections/core.php'); ?>
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
$query_Recordset1 = "SELECT * FROM a_proj_code";
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
<div class="container">
<table width="1578" class="table" id="celebs">
      <thead>
	    		<tr class="tabel_header">
    <td width="26" rowspan="2">No.</td>
    <td width="82" rowspan="2">Pracode</td>
    <td width="86" rowspan="2">Project Code</td>
    <td width="334" rowspan="2">Contract Title</td>
    <td width="148" rowspan="2">QTY / OPRS Period</td>
    <td width="191" rowspan="2">Owner</td>
    <td colspan="5">Order Status</td>
    <td width="116">Value</td>
    <td width="116" rowspan="2">Attachment</td>
        </tr>
	    		<tr class="tabel_header">
    <td width="105" class="tabel_header">Received Order</td>
    <td width="111" class="tabel_header">Type Of Order</td>
    <td width="121" class="tabel_header">Contract  No.</td>
    <td width="105" class="tabel_header">Comm. Date</td>
    <td width="101" class="tabel_header">Completion Date</td>
    <td width="116" class="tabel_header">USD</td>
    </tr>
    </thead>
        <tbody>
	    <?php do { ?>
	    <tr class="tabel_body">
	      <?php $n=$n+1; ?>
	      <td align="center"><?php echo $n ; ?></td>
	      <td align='center'><?php echo $row_Recordset1[pracode]; ?></td>
	      <td align="center"><a href="editcontract.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1[project_code];?></a></td>
	      <td align=""><?php echo $row_Recordset1['projecttitle']; ?></td>
	      <td align=""><?php echo $row_Recordset1['qty']; ?></td>
	      <td align=""><?php echo $row_Recordset1['customer']; ?></td>
		  <td align="center"><?php echo $row_Recordset1[receivedorder]; ?></td>
		  <td align="center"><?php echo $row_Recordset1[typeorder]; ?></td>
		  <td align=""><?php echo $row_Recordset1[contractno]; ?></td>
		  <td align="center"><?php echo $row_Recordset1[commdate]; ?></td>
		  <td align="center"><?php echo $row_Recordset1[completiondate]; ?></td>
		  <td align="center"><?php echo '$ ' . number_format(  $row_Recordset1['projectvalue'], 0 , '' , ',' ); ?></td>
		  <td align="center"><?php if ($row_Recordset1[fileupload]=="") { echo "-"; } 
		  else { 
		  echo "<a href='../mkt/tenderdoc/$row_Recordset1[fileupload]'>$row_Recordset1[fileupload]</a>";
		  };?></td>
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
