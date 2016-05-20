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
$query_Recordset1 = "SELECT * FROM a_proj_code WHERE complete=1 ORDER BY project_code ASC";
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
<link href="/css/induk.css" media="screen" rel="stylesheet" type="text/css" />
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
<body class="General">
<table width="1000" border="1" cellpadding="0" cellspacing="0" class="buatform">
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
      <p align="center">
        <?
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      </p>
      <p align="center"><strong>Find Result - Data CTR</strong></p>
      <p>
        <?php
		$not=mysql_query("SELECT * FROM a_proj_code WHERE a_proj_code.project_code LIKE '%$cari%'");
	 $sql=mysql_query("SELECT a_proj_code.project_code, a_proj_code.id, a_proj_code.project_code, a_proj_code.projecttitle, a_proj_code.customer, c_ctr.id, c_ctr.ctrno, c_ctr.projecttitle, c_ctr.quantity, c_ctr.location, c_ctr.contactperson, c_ctr.status, c_ctr.requestor FROM c_ctr INNER JOIN a_proj_code WHERE (c_ctr.projectcode LIKE '%$cari%') AND (a_proj_code.project_code LIKE '%$cari%') AND (c_ctr.statusrev =1) ORDER BY c_ctr.ctrno ASC");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	 echo "<center><blink>No data available in table </bink></center>";
			
	}
		else {
	  echo "All amount of data that found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="1090" border="0" cellspacing="1" cellpadding="0" class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <th colspan="2" >
     <?
while($sql2=mysql_fetch_array($not)){
	  ?>
          <a href="inputctr.php?data=<?php echo $sql2[project_code]; ?>">Add New</a></th>
          
          <th colspan="7"><?php echo $sql2[project_code] . " - " . $sql2[customer];?>
            <? } ?>
            
          </th>
        </tr>
        
        <tr class="tabel_header">
          <th width="31" class="tabel_header" >No.</th>
          <th width='107' class="tabel_header">CTR No.</th>
          <th width='330' class="tabel_header">Job Title</th>
          <th width='136' class="tabel_header">Location</th>
          <th width='49' class="tabel_header">Quantity</th>
          <th width='181' class="tabel_header">End User</th>
          <th width='121' class="tabel_header">Requestor</th>
          <th width="51" class="tabel_header">Status</th>
          <th width="74" class="tabel_header">Revisi</th>
        </tr></thead><tbody>
        <?
while($sql1=mysql_fetch_array($sql)){
	  ?>        
        <tr class="tabel_body">
          <?php $n=$n+1; ?>
          <td align='center'><?php echo $n ; ?></td>
          <td><?php if ($sql1[status]=="Approved") { echo "<a href='view_ctr_value.php?data=$sql11[id]'>$sql1[ctrno]</a>"; } 
		  else { 
		  echo "$sql1[ctrno]";
		  };?></td>
          <td ><a href="editctr.php?data=<?php echo $sql1['id'];?>"><?php echo $sql1[projecttitle];?></a></td>
          <td ><?php echo $sql1[location];?></td>
          <td align="center"><?php echo $sql1[quantity];?></td>
          <td ><?php echo $sql1[contactperson];?></td>
          <td ><?php echo $sql1[requestor];?></td>
          <td align="center"><?php if ($sql1[status]=="Approved") { echo $sql1[status]; } 
		  else { 
		  echo "<a href='editctr_status.php?data=$sql1[id]'>$sql1[status]</a>";
		  };?>            </a></td>
          <td align="center"><a href="revisictr.php?data=<?php echo $sql1[ctrno];?>">Revisi</a></td>
          
        </tr>
        <?
		}
		?>
      </table>
      <p>&nbsp;</p>
      <?
	}
	?>
      <br />
      <br />
    <p></p></td>
  </tr>
</table>
<table width="1050" border="0" cellspacing="0" cellpadding="0" class="buatform">
  <tr>
    <td width="950"><p align="center">&nbsp;</p>
      <p align="center">
        <?
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      </p>
      <p align="center"><strong>Find Result - Work Status </strong></p>
      <p>
        <?php
		$not=mysql_query("SELECT * FROM a_proj_code WHERE a_proj_code.project_code LIKE '%$cari%'");
		$sql=mysql_query("SELECT * FROM a_crf WHERE (a_crf.approval='Y') AND (a_crf.projectcode LIKE '%$cari%') AND (a_crf.commercial=1) ORDER BY nocrf ASC ");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	 echo "<center><blink>No data available in table </bink></center>";
			
	}
		else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="1035" border="0" cellspacing="1" cellpadding="0" class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <th colspan="2" > <?
while($sql2=mysql_fetch_array($not)){
	  ?>
          <th colspan="5"><?php echo $sql2[project_code] . " - " . $sql2[customer];?>
            <? } ?></th>
        </tr>
        <tr class="tabel_header">
          <th width="31" class="tabel_header">No.</th>
          <th width='110' class="tabel_header">No. CRF</th>
          <th width='523' class="tabel_header">Job Title</th>
          <th width='95' class="tabel_header">Budgetting</th>
          <th width='91' class="tabel_header">Estimation</th>
          <th width='117' class="tabel_header">Progress/WIP</th>
          <th width="60" class="tabel_header">Status</th>
        </tr>
        </thead>
        <tbody>
        <?
while($sql1=mysql_fetch_array($sql)){
	  ?>
        <tr class="tabel_body">
          <?php $no=$no+1; ?>
          <td align='center'><?php echo $no ; ?></td>
          <td><?php echo $sql1[nocrf];?></td>
          <td ><a href="work_comm.php?data=<?php echo $sql1['idms'];?>" target="_blank"><b><?php echo $sql1[jobtitle];?></b></a></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td ></td>
          <td align="center">&nbsp;</td>
        </tr>
        <?
		}
		?>
        </tbody>
      </table>
      <?
	}
	?></td>
  </tr>
</table>
<p>
  
</body>
</html><?php
mysql_free_result($Recordset1);
?>
