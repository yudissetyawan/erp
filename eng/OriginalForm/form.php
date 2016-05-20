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
?>
<?php
include "../config.php";
?>
<head>
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
</head>
<body>
<table width="1000" border="1" cellspacing="0" cellpadding="0" class="buatform">
  <tr>
    <td width="1017"><p align="center"><strong>Please Select Project Code</strong></p>
      <form id="form1" name="form1" method="post" action="">
        <div align="center">
          <select name="cari" id="cari">
            <option value="">Project Code</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['project_code'] ?>"><?php echo $row_Recordset1['project_code'] ?></option>
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
      <?php
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      <p align="center"><strong>Find Result - DATA CRF</strong></p>
     
        <?php
	  $sql=mysql_query("SELECT * FROM a_crf  WHERE (a_crf.approval='Y') AND (a_crf.projectcode LIKE '%$cari%') ORDER BY  nocrf ASC");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>No data available in table </bink></center>";
	  } else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="1073" border="0" cellspacing="1" cellpadding="0"  class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <th width='50' >No.</th>
          <th width='78'>PROD.CODE</th>
          <th width='400'>Job Title</th>
          <th width='50'>MKT</th>
          <th width='50'>COM</th>
          <th width='50'>QLY</th>
          <th width='50'>HSE</th>
          <th width='50'>ENG</th>
          <th width='50'>PRC</th>
          <th width='50'>PPIC</th>
          <th width='50'>FAB</th>
          <th width='50'>HRD</th>
          <th width='50'>ACC</th>
          <th width='50'>MNC</th>
          <th width='50'>IT</th>
          <th width='50'>PRJ</th>
          <th width='65'>DCC</th>
        </tr>
        </thead>
        <tbody>
        <?php 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
        <tr class="tabel_body">
        <?php $o=$o+1; ?>
          <td align='center'><?php echo $o ?></td>
          <td><?php echo $sql1[projectcode] . " - " .$sql1[productioncode];?></td>
          <td ><a href="#" onClick="MM_openBrWindow('../prj/viewcrfdetail.php?data=<?php echo $sql1[nocrf];?>','crf','width=1200,height=500')"><b> <?php echo $sql1[jobtitle] ?>
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
        </tr>
        <?php
		}
		?></tbody>
      </table>
      <p></p>
      <?php
	}
	?></td>
  </tr>
</table>

<table width="1100" border="0" cellspacing="0" cellpadding="0" class="buatform">
  <tr>
    <td width="1017"><p align="center">
      <?php
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      </p>
      <p align="center"><strong>Find Result - WORK STATUS </strong></p>
      <p>
        <?php
	 $sql=mysql_query("SELECT * FROM a_crf WHERE (a_crf.approval='Y') AND (a_crf.projectcode LIKE '%$cari%') AND (a_crf.engineering=1) ORDER BY nocrf ASC");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>No data available in table </bink></center>";
	  } else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="1075" border="0" cellspacing="1" cellpadding="0"  class="table" id="celebs2">
        <thead>
          <tr class="tabel_header">
            <th width='37' >No.</th>
            <th width='74'>PROD.CODE</th>
            <th width='438'>Job Title</th>
            <th width='64'>&nbsp;</th>
            <th width='48'>Design Input</th>
            <th width='64'>Design Calculation</th>
            <th width='58'>Drawing</th>
            <th width='41'>BOM</th>
            <th width='67'>Design Verification</th>
            <th width='73'>Design Validation</th>
            <th width='69'>Design Change</th>
          </tr>
        </thead>
        <tbody>
          <?php 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
          <tr class="tabel_body">
            <?php $n=$n+1; ?>
            <td align='center'><?php echo $n ; ?></td>
            <td><?php echo $sql1[projectcode] . " - " .$sql1[productioncode];?></td>
            <td ><a href="upload_work/work_eng.php?data=<?php echo $sql1['nocrf'];?>" target="_blank"><b></b></a><a href="work_engineering.php?data=<?php echo $sql1['nocrf'];?>" target="_blank"><b></b></a><a href="work_engineering.php?data=<?php echo $sql1['nocrf'];?>" target="_blank"><b><?php echo $sql1[jobtitle] ?></b></a></td>
            <td align='center'><?php {include "popup_attachment_work.html";}?></td>
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
		if ($sql1[procurement]==1) 
		{
			echo "<img src='../images/select(1).png' width='15' height='15' />";
		} 
		else {
			echo "<img src='../images/not.png' width='15' height='15' />";
			} 
		?></td>
          </tr>
          <?php
		}
		?>
        </tbody>
      </table>      <?php
	}
	?></td>
  </tr>
</table>
<p>

</body>
</html><?php
mysql_free_result($Recordset1);
?>
