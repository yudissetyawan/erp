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

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM a_crf WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
      <p align="center"><strong>Find Result - DATA CRF</strong></p>
      <p>
        <?
	  $sql=mysql_query("SELECT a_crf.issueddate, a_crf.approval, a_crf.dateapproval, a_crf.id idcrf,a_crf.nocrf, a_crf.jobtitle, a_crf.date, a_crf.customer, a_crf.projectcode, a_crf.productioncode, a_crf.name, a_crf.datw, a_crf.marketing, a_crf.commercial, a_crf.quality, a_crf.hse, a_crf.engineering, a_crf.procurement, a_crf.production, a_crf.fabrication, a_crf.hrd, a_crf.acc, a_crf.maintenance, a_crf.it, a_crf.siteproject, a_crf.file FROM a_crf WHERE  a_crf.projectcode LIKE '%$cari%' ORDER BY  nocrf ASC");
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink>No data available in table </bink></center>";
	  } else {
	  echo "All Amount of Data That Found is <b>$totalseluruhpendaftar</b> Data";
	  }
	  ?>
      <table width="1040" border="0" cellspacing="1" cellpadding="0" class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <th width='34' >No.</th>
          <th width='75'>PROD.CODE</th>
          <th width='208'>Job Title</th>
          <th width='98'>Issued Date</th>
          <th width='90'>Approval Date </th>
          <th width='38'>MKT</th>
          <th width='39'>COM</th>
          <th width='36'>QLY</th>
          <th width='36'>HSE</th>
          <th width='36'>ENG</th>
          <th width='36'>PRC</th>
          <th width='39'>PPIC</th>
          <th width='36'>FAB</th>
          <th width='38'>HRD</th>
          <th width='36'>ACC</th>
          <th width='38'>MNC</th>
          <th width='34'>IT</th>
          <th width='37'>PRJ</th>
          <th width='36'>DCC</th>
        </tr>
        </thead>
        <tbody>
        <? 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
        <tr class="tabel_body">
          <?php $i=$i+1; ?>
          <td align='center'><?php echo $i ; ?></td>
          <td><?php echo $sql1[projectcode] . " - " .$sql1[productioncode];?></td>
          <td ><a href="crf_approval.php?data=<?php echo $sql1[idcrf]; ?>"><b>
            <?=$sql1[jobtitle]?>
          </b></a></td>
          <td align='center'><?=$sql1[issueddate]?></td>
          <td align='center'><?=$sql1[dateapproval]?></td>
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
		?></td></tr>
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
</body>
</html><?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
