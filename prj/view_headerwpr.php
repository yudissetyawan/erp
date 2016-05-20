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
$query_Recordset1 = "SELECT * FROM a_proj_code WHERE complete = '1' ORDER BY project_code ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_Recordset1 = "SELECT * FROM a_proj_code WHERE complete = '1' ORDER BY project_code ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?
include "../config.php";
?>

<link href="../css/induk.css" rel="stylesheet" type="text/css">
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
<body class="General">
<table width="1352" border="1" cellpadding="0" cellspacing="0" class="buatform">
  <tr>
    <td width="1348"><p align="center"><strong>Please Select Project Code</strong></p>
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
      
      <p align="center" class="buatform"><strong>Find Result - DATA WO/CTR</strong></p>
     
        <?
	  $sql=mysql_query("SELECT * FROM pr_header_wpr  WHERE pr_header_wpr.projectcode LIKE '%$cari%' ORDER BY  id ASC");
	  $not=mysql_query("SELECT * FROM a_proj_code WHERE a_proj_code.project_code LIKE '%$cari%'");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	 echo "<center><blink>No data available in table </bink></center>";
	  } else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>  <?
while($sql2=mysql_fetch_array($not)){
	  ?>
      <p>
     

		
                
                <? } ?>
      <div class="container">
	  <table width="1320" class="table" id="celebs">
		  <thead>
        <tr class="tabel_header">
          <th width='20' >No.</th>
          <th width='103'>WO/CTR No.</th>
          <th width='335'>Project Title</th>
          <th width='82'>Contract No.</th>
          <th width='73'>AFE/CC No.</th>
          <th width='104'>CTR Aproval</th>
          <th width='155'>Type of Work</th>
          <td width="91">Construction Eng.</td>
          <td width="84">CTR Req'd</td>
          <td width="100">Contractor PIC Name</td>
          <td width="125">&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <? 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
        <tr class="tabel_body">
          <?php $i=$i+1; ?>
          <td align='center'><?php echo $i ; ?></td>
          <td><?php echo $sql1[wo_no];?>/<?php echo $sql1[ctr_no];?></td>
          <td><a href="wpr/tanggalwpr.php?data=<? echo $sql1[id] ?>"><?=$sql1[project_title]?></a></td>
          <td align='center'><?=$sql1[contract_no]?></td>
          <td align='center'><?=$sql1[aff_no]?></td>
          <td align='center'><?=$sql1[ctr_approval]?></td>
          <td align='center'><?=$sql1[type_ofwork]?></td>
          <td align='center'><?=$sql1[const_eng]?></td>
          <td align='center'><?=$sql1[ctr_reqd]?></td>
          <td align='center'><?=$sql1[pic_name]?></td>
          <td align='center'><? if ($sql1['status']=='1') {echo "<a href='view_schedule.php'>View Schedule</a>";} else {echo  "<a href='../prj/view_wbs.php?data=$sql1[id]'>Detail</a>";} ?> | <a href="viewplanactual.php?data=<?php echo $sql1[id]; ?>">View Progress</a></td>
        </tr>
       <?
		}?>
        </tbody>
      </table>
     </div>
            <?
	}
	?>
      
   </td>
  </tr>
</table>
<p>
  
</body>
</html><?php
mysql_free_result($Recordset1);
?>
