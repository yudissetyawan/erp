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
$query_Recordset1 = "SELECT * FROM a_proj_code ORDER BY project_code DESC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$query_Recordset1 = "SELECT * FROM a_proj_code";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$query_Recordset1 = "SELECT * FROM a_proj_code WHERE complete = '1'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Progress Scope of Work</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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

<body class="General">
<table width="1050" border="1" cellspacing="0" cellpadding="0" class="buatform">
<tr>
    <td width="1017"><p align="center"><strong>Please Select Project Code</strong></p>
<form id="form1" name="form1" method="post" action="">
        <div align="center">
          <select name="cari" id="cari">
            <option value="">Project Code</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['project_code']?>"><?php echo $row_Recordset1['project_code']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
          <input type="submit" name="Submit" value="Find" />
        </div>
</form>
 <?
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      <p align="center"><strong>Find Results - CRF Data</strong></p>
      <p>
        <?
	  $sql=mysql_query("SELECT * FROM pr_progress_header WHERE projectcode LIKE '%$cari%' ORDER BY  productioncode ASC");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>No data available in table</bink></center>";
	  } else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
		


<table width="1053" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header">
    <td width="21" rowspan="2" >No.</td>
    <td width="102" rowspan="2" >Production Code</td>
    <td width="395" rowspan="2" >Description</td>
    <td colspan="2" >Work Request (WR)</td>
    <td width="132" rowspan="2" >Project Value</td>
    <td colspan="2" >Progress Detail</td>
  </tr>
  <tr class="tabel_header">
    <td width="85" class="tabel_header">No.</td>
    <td width="93" class="tabel_header">Values</td>
    <td width="90" class="tabel_header">Scope Of Work</td>
    <td width="101" class="tabel_header">Work Status</td>
  </tr>
</thead>
<tbody>  
   <? 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
   <tr class="tabel_body">
     <?php $n=$n+1; ?>
     <td align='center'><?php echo $n ; ?></td>
     <td><?php echo $sql1[projectcode] . " - " .$sql1[productioncode];?></td>
     <td><?php echo $sql1[description];?></td>
     <td><?php echo $sql1[wrno];?></td>
     <td><? echo $sql1[wrvalue]; ?></td>
     <td><? echo $sql1[projectvalue];?></td>
     <td align="center"><a href="progress_scopework.php?data=<?php echo $sql1[id];?>">Detail</a></td>
     <td align="center"><a href="progress_workstatus.php?data=<?php echo $sql1[id];?>">Detail</a></td>
   </tr>
<?
		}
		?>
</tbody>        
</table>
<?
		}
		?>
</p></td></tr></table>        
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
?>
