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
$query_mr = "SELECT p_mr_header.*, a_production_code.productioncode, a_production_code.projectcode FROM p_mr_header, a_production_code WHERE a_production_code.id=p_mr_header.id_prodcode ORDER BY p_mr_header.date DESC";
$mr = mysql_query($query_mr, $core) or die(mysql_error());
$row_mr = mysql_fetch_assoc($mr);
$totalRows_mr = mysql_num_rows($mr);

mysql_select_db($database_core, $core);
$query_rsitemmr = "SELECT p_mr_header.nomr, p_mr_core.id, p_mr_core.itemmr, p_mr_core.qty, p_mr_core.dateinuse, p_mr_core.tobeuse, p_mr_core.remark, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_type, m_unit.unit AS itemunit FROM p_mr_header, p_mr_core, m_master, m_e_model, m_unit WHERE p_mr_core.mrheader = p_mr_header.id AND p_mr_core.itemmr = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit ORDER BY p_mr_core.mrheader DESC LIMIT 1";
$rsitemmr = mysql_query($query_rsitemmr, $core) or die(mysql_error());
$row_rsitemmr = mysql_fetch_assoc($rsitemmr);
$totalRows_rsitemmr = mysql_num_rows($rsitemmr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List of Material / Service Request</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
function showData(str) {
	//alert (str);
	if (str=="") {
	  document.getElementById("txtHint").innerHTML="";
	  return;
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "view_detailmrsr.php?data=" + str, true);
	xmlhttp.send();
}
</script>

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
</head>

<p class="buatform"><b>List of Material / Service Request (M/S R)</b></p>
<?php { require_once "../dateformat_funct.php"; } ?>
<table border="0" class="table" id="celebs">
	<thead>
  <tr height="30" class="tabel_header">
    <td width="23">No</td>
    <td width="110">M/S R No.</td>
    <td width="90">Date</td>
    <td width="90">Prod. Code</td>
    <td width="120">Status</td>
    <td>Reference</td>
    <td>Note</td>
    <td width="50">&nbsp;</td>
  </tr>
  </thead>
  <tbody> 
  <?php do { ?>
  <!-- onclick="this.style.fontWeight='bold'; showData()" -->
    <tr class="tabel_body" onclick="showData(<?php echo $row_mr['id']; ?>)" style="cursor:pointer" title="Click to view Item of MR">
      <td align="center">
	  	<?php $a = $a + 1; echo $a;
		
		mysql_select_db($database_core, $core);
        $query_rsjmlPO = "SELECT c_po_header.mrno FROM c_po_header, p_mr_header WHERE p_mr_header.id = c_po_header.mrno AND p_mr_header.id = '$row_mr[id]'";
        $rsjmlPO = mysql_query($query_rsjmlPO, $core) or die(mysql_error());
        $row_rsjmlPO = mysql_fetch_assoc($rsjmlPO);
        $totalRows_rsjmlPO = mysql_num_rows($rsjmlPO);
		?>
      </td>
      
      <td align="center" title="<?php echo $totalRows_rsjmlPO.' PO'; ?>">
      	<a href="viewpoheader.php?data=<?php echo $row_mr['id']; ?>"><?php echo $row_mr['nomr']; ?></a>
      </td>
      
      <td align="center"><?php echo functddmmmyyyy($row_mr['date']); ?></td>
      <td align="center"><?php echo $row_mr['projectcode']; ?> - <?php echo $row_mr['productioncode']; ?></td>
      
      <td><?php echo $row_mr['status']; ?></td>
      <td width="177">
	  <? if ($row_mr['referencetype']=='') {echo "----";} else {echo  "<a href=../ppic/upload/refmr/$row_mr[referencetype]>$row_mr[referencetype]</a>";} ?>
      </td>
      <td width="178"><?php echo $row_mr['note']; ?></td>
      
      <td align="center" width="90">  
		<?php
		mysql_select_db($database_core, $core);
        $query_mrcore = "SELECT p_mr_core.itemmr FROM p_mr_header, p_mr_core WHERE p_mr_header.id = p_mr_core.mrheader AND p_mr_header.id = '$row_mr[id]'";
        $mrcore = mysql_query($query_mrcore, $core) or die(mysql_error());
        $row_mrcore = mysql_fetch_assoc($mrcore);
        $totalRows_coremr = mysql_num_rows($mrcore);
		
        mysql_select_db($database_core, $core);
        $query_mrcore1 = "SELECT p_mr_core.po_status FROM p_mr_header, p_mr_core WHERE p_mr_header.id = p_mr_core.mrheader AND p_mr_core.po_status = '0' AND p_mr_header.id = '$row_mr[id]'";
        $mrcore1 = mysql_query($query_mrcore1, $core) or die(mysql_error());
        $row_mrcore1 = mysql_fetch_assoc($mrcore1);
        $totalRows_coremr1 = mysql_num_rows($mrcore1);
        
		if ($totalRows_coremr != 0) {
			if ($totalRows_coremr1 == $totalRows_coremr) {
				echo "<img src='../images/select(1).png' width='15' height='15' />";
			} else {
				echo "<a href='inputpo.php?data=$row_mr[id]'>New PO</a>";
			}
		} else {
			echo "Empty Item";
		}
		?>
      </td>
      
    </tr>
    <?php } while ($row_mr = mysql_fetch_assoc($mr)); ?>
  </tbody>
</table>

<br /><br /><br />

<!-- <p class="buatform">Item of Material / Service Request (M/S R)</p> -->
<div id="txtHint">
	<p>Item of MR No. : <b><?php echo $row_rsitemmr['nomr']; ?></b></p>
    
    <table width="1000" class="table">
        <tr align="center" class="tabel_header" height="30">
          <td width="20">No.</td>
          <td width="263">Description</td>
          <td width="145">Spec.</td>
          <td width="48">Qty</td>
          <td width="86">Date In Use</td>
          <td width="170">To be Used</td>
          <td width="70">Prod. Code</td>
          <td>Remark</td>
        </tr>
        <?php do { ?>
          <tr class="tabel_body">
            <td align="center"><?php $b=$b+1; echo $b; ?></td>
            <td><?php echo $row_rsitemmr['mtrl_model']; ?> (<?php echo $row_rsitemmr['descr_name']; ?>) <?php echo $row_rsitemmr['id_type']; ?> <?php echo $row_rsitemmr['brand']; ?></td>
            <td><?php echo $row_rsitemmr['descr_spec']; ?></td>
            <td align="center"><?php echo $row_rsitemmr[qty]; ?> <?php echo $row_rsitemmr[itemunit]; ?></td>
            <td align="center"><?php echo functddmmmyyyy($row_rsitemmr[dateinuse]); ?></td>
            <td align="center"><?php echo $row_rsitemmr[tobeuse]; ?></td>
            <td align="center"><?php echo $row_rsitemmr[prodcode]; ?></td>
            <td width="142"><?php echo $row_rsitemmr['remark']; ?></td>
          </tr>
          <?php } while ($row_rsitemmr = mysql_fetch_assoc($row_rsitemmr)); ?>
    </table>
</div>

<?php
	mysql_free_result($mr);
	mysql_free_result($mrcore);
	mysql_free_result($mrcore1);
	mysql_free_result($rsitemmr);
?>