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

include "../config.php";
?>

<link href="../css/induk.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
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
<table width="1050" border="1" cellpadding="0" cellspacing="0" class="buatform">
  <tr>
    <td width="950"><p align="center" class="buatform"><strong>Please Select Project Code</strong></p>
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
      
        <br />
        <?
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      
      <p align="center" class="buatform"><strong>Find Results - DATA CRF</strong></p>
     
        <?
	  $sql=mysql_query("SELECT * FROM a_crf  WHERE a_crf.projectcode LIKE '%$cari%' ORDER BY  nocrf ASC");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>No data available in table </bink></center>";
	  } else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="1327" border="0" cellspacing="1" cellpadding="0" class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <th width='50' >No.</th>
          <th width='78'>No. CRF</th>
          <th width='400'>Job Title</th>
          <th width='40'>MKT</th>
          <th width='40'>COM</th>
          <th width='40'>QLY</th>
          <th width='40'>HSE</th>
          <th width='40'>ENG</th>
          <th width='40'>PRC</th>
          <th width='40'>PPIC</th>
          <th width='40'>FAB</th>
          <th width='40'>HRD</th>
          <th width='40'>ACC</th>
          <th width='40'>MNC</th>
          <th width='40'>IT</th>
          <th width='40'>PRJ</th>
          <th width='40'>DCC</th>
          <th width='5'>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <? 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
        <tr class="tabel_body">
          <?php $i=$i+1; ?>
          <td align='center'><?php echo $i ; ?></td>
          <td><?php echo $sql1[nocrf];?></td>
          <td ><a href="#" onClick="MM_openBrWindow('viewcrfdetail.php?data=<?php echo $sql1[nocrf];?>','crf','location=yes,scrollbars=yes,resizable=yes,width=1200,height=500')"><b></b></a><a href="#" onClick="MM_openBrWindow('viewcrfdetail.php?data=<?php echo $sql1[nocrf];?>','crf','width=1200,height=500')"><b>
            <?=$sql1[jobtitle]?>
          </b></a></td>
          <td align='center'><?php 
		if ($sql1[marketing]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[commercial]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[quality]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[hse]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[engineering]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[procurement]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[production]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[fabrication]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[hrd]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[acc]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[maintenance]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[it]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[siteproject]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><?php 
		if ($sql1[file]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          <td align='center'><a href="editcrf.php?data=<?php echo $sql1[nocrf];?>">Edit </a></td>
        </tr>
        <?
		}
		?>
        </tbody>
      </table>
            <?
	}
	?>
      
   </td>
  </tr>
</table>

<table width="1050" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="950">
      <p align="center">
        <?
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      </p>
      <p align="center"><strong>HASIL PENCARIAN - Work Status </strong></p>
      <p>
        <?php
		$not=mysql_query("SELECT * FROM a_proj_code WHERE project_code LIKE '%$cari%'");
		$sqlprod=mysql_query("SELECT * FROM a_production_code WHERE projectcode LIKE '%$cari%' ORDER BY productioncode ASC");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	 echo "<center><blink>Silahkan Input CRF untuk Project Code $cari </bink></center>";
			
	}
		else {
	  echo "Jumlah Seluruh Data yang ditemukan Adalah <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="921" border="0" cellspacing="1" cellpadding="0">
        <tr class="tabel_header">
          <th colspan="2" > <?
while($sql2=mysql_fetch_array($not)){
	  ?>
          <th colspan="6"><?php echo $sql2[project_code] . " - " . $sql2[customer];?>
            <? } ?>
          </th>
        </tr>
        <tr class="tabel_header">
          <th width="26" class="tabel_header">No.</th>
          <th width='102' class="tabel_header">Production Code</th>
          <th width='417' class="tabel_header">Job Title</th>
          <th colspan="2" class="tabel_header">CRF</th>
          <th width='82' class="tabel_header">Site project</th>
          <th width='69' class="tabel_header">Monitoring Activity</th>
          <th width='84' class="tabel_header">Progress/WIP</th>
        </tr>
        <?
while($sql1=mysql_fetch_array($sqlprod)){
	  ?>
        <tr class="tabel_body">
          <?php $no=$no+1; ?>
          <td align='center'><?php echo $no ; ?></td>
          <td><?php echo $sql1[projectcode] . " - " .$sql1[productioncode];?></td>
          <td ><b><?=$sql1[projecttitle]?>
            <td width="65" align="center" ><b><b>
              <?php if ($sql1[statuscrf]==1) { echo "<img src='../images/select(1).png' width='15' height='15' />"; } 
		  else { 
		  echo "<a href='inputcrf.php?data=$sql1[id]'>New CRF</a>";
		  }?>
          </b></b></td>
            <td width="67" align="center" ><a href="inputcrf.php?data=<?php echo $sql1[id];?>">Add CRF</a></td>
          <td >&nbsp;</td>
            <td ></td>
            <td></td>
          </b></tr>
        <?
		}
		?>
      </table>
      
      <?
	}
	?>
      <br />
      <br />
      <p></p></td>
  </tr>
</table>
<p>

</body>
</html><?php
mysql_free_result($Recordset1);
?>
