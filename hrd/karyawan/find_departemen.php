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

$colname_sql1 = "-1";
if (isset($_GET['data'])) {
  $colname_sql1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_sql1 = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_sql1, "int"));
$sql1 = mysql_query($query_sql1, $core) or die(mysql_error());
$row_sql1 = mysql_fetch_assoc($sql1);
$totalRows_sql1 = mysql_num_rows($sql1);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_department";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?
include "../../config.php";
?>

<link href="../../css/induk.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: none;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style><link href="../../css/table.css" rel="stylesheet" type="text/css">
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script><body class="General">
<table width="1000" border="1" cellspacing="0" cellpadding="0" class="buatform">
  <tr>
    <td width="1017"><p align="center"><strong>Please Select Department</strong></p>
      <form id="form1" name="form1" method="post" action="">
        <div align="center">
          <table width="419" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td class="General" align="center"><label>
                <select name="cari" id="cari">
                  <option value="">Departement</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['department']?></option>
                  <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td class="General" align="center"><input type="submit" name="Submit" value="Filter" /></td>
            </tr>
          </table>
        </div>
      </form>
      <?
	  $cari=$_POST['cari'];
	  if(!empty($cari)){
	  ?>
      <p align="center"><strong>Aplicant Data :</strong></p>
      <p>
        <?
	  $sql=mysql_query("SELECT h_employee.id, h_employee.firstname, h_employee.midlename,h_employee.lastname, h_employee.department, h_employee.nik, h_department.id,  h_depoartment.department FROM h_employee INNER JOIN h_department WHERE (h_employee.department=h_department.department) AND (h_department.id LIKE '%$cari%')");
	  
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink></bink></center>";
	  } else {
	  echo "";
	  }
	  ?>
      <table width="479" border="0" cellspacing="1" cellpadding="0"  class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <th width='42' >No.</th>
          <th width='71'>N I K</th>
          <th width='223'>Nama</th>
          <th width='138'>Departemen</th>
        </tr>
        </thead>
        <tbody>
        <? 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
        <tr class="tabel_body">
          <?php $i=$i+1; ?>
          <td align='center'><?php echo $i ; ?></td>
          <td ><?php echo $sql1[nik];?></td>
          <td width="67">
          <a href="viewdata_karyawan.php?data=<?php echo $sql1['id']; ?>" target="new"><? echo $sql1[firstname]. ' ' .$sql1[midlename].' '.$sql1[lastname];?></a><a href="viewdata_karyawan.php?data=<?php echo $sql1['id']; ?>" target="new"></b></a>
          
          <td align='center'><?php echo $sql1[department];?></td>
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
<p><p><p><p>
<p>
  
</body>
</html><?php
mysql_free_result($sql1);

mysql_free_result($Recordset1);
?>
