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
</style>
<link href="../../css/table.css" rel="stylesheet" type="text/css">
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
</script>
<body class="General">
<table width="1000" border="1" cellspacing="0" cellpadding="0" class="buatform">
  <tr>
    <td width="1017"><p align="center"><strong>Please Select Status of Employee</strong></p>
      <form id="form1" name="form1" method="post" action="">
        <div align="center">
          <table width="419" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td class="General"><div align="center">
                <select name="cari" id="cari">
                  <option value="">Status</option>
                  <option value="K">Karyawan</option>
                  <option value="MK">Mantan Karyawan</option>
                  <option value="CK">Calon Karyawan</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td class="General"><div align="center">
                <input type="submit" name="Submit" value="Filter" />
              </div></td>
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
	  $sql=mysql_query("SELECT h_employee.id, h_employee.firstname, h_employee.midlename,h_employee.lastname, h_employee.status, h_employee.department, h_employee.nik, h_employee.code, h_datapribadi.id_datapribadi,  h_datapribadi.jk FROM h_datapribadi INNER JOIN h_employee WHERE (h_datapribadi.id_datapribadi=h_employee.id) AND (h_employee.code LIKE '%$cari%')");
	  
	  $totalseluruhpendaftar=mysql_num_rows($sql);
	  if($totalseluruhpendaftar=='0'){
	  echo "<center><blink></blink></center>";
	  } else {
	  echo "";
	  }
	  ?>
      <table width="757" border="0" cellspacing="1" cellpadding="0"  class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <th width='42' >No.</th>
          <th width='71'>NIK</th>
          <th width='223'>Name</th>
          <th width='138'>Gender</th>
          <th width='138'>Departement</th>
          <th width='138'>Code</th>
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
          <td ><? echo $sql1[firstname]. ' ' .$sql1[midlename].' '.$sql1[lastname];?></b></td>
          <td align='center'><?php echo $sql1[jk]; ?></td>
          <td align='center'><?php echo $sql1[department];?></td>
          <td align='center'><?php echo $sql1[code];?></td>
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
</html>