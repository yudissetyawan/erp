<?php require_once('../../Connections/core.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../../hrd/index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['inisialps2'], "text"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"),
                       GetSQLValueString($_POST['title'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE idms = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_cm = "SELECT dms.id, dms.inisial_pekerjaan, dms.`date`, dms.fileupload, dms.keterangan FROM dms WHERE inisial_pekerjaan = 'MOMcm' ORDER BY date DESC";
$cm = mysql_query($query_cm, $core) or die(mysql_error());
$row_cm = mysql_fetch_assoc($cm);
$totalRows_cm = mysql_num_rows($cm);

mysql_select_db($database_core, $core);
$query_mr = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMmr' ORDER BY date DESC";
$mr = mysql_query($query_mr, $core) or die(mysql_error());
$row_mr = mysql_fetch_assoc($mr);
$totalRows_mr = mysql_num_rows($mr);

mysql_select_db($database_core, $core);
$query_am = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMam' ORDER BY date DESC";
$am = mysql_query($query_am, $core) or die(mysql_error());
$row_am = mysql_fetch_assoc($am);
$totalRows_am = mysql_num_rows($am);

mysql_select_db($database_core, $core);
$query_tr = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMtr' ORDER BY date DESC";
$tr = mysql_query($query_tr, $core) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_core, $core);
$query_kom = "SELECT * FROM dms WHERE dms.inisial_pekerjaan ='MOMkom' ORDER BY date DESC";
$kom = mysql_query($query_kom, $core) or die(mysql_error());
$row_kom = mysql_fetch_assoc($kom);
$totalRows_kom = mysql_num_rows($kom);

mysql_select_db($database_core, $core);
$query_st = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMst' ORDER BY date DESC";
$st = mysql_query($query_st, $core) or die(mysql_error());
$row_st = mysql_fetch_assoc($st);
$totalRows_st = mysql_num_rows($st);

mysql_select_db($database_core, $core);
$query_tm = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMtm' ORDER BY date DESC";
$tm = mysql_query($query_tm, $core) or die(mysql_error());
$row_tm = mysql_fetch_assoc($tm);
$totalRows_tm = mysql_num_rows($tm);

mysql_select_db($database_core, $core);
$query_pm = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMpm' ORDER BY date DESC";
$pm = mysql_query($query_pm, $core) or die(mysql_error());
$row_pm = mysql_fetch_assoc($pm);
$totalRows_pm = mysql_num_rows($pm);

mysql_select_db($database_core, $core);
$query_gm = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMgm' ORDER BY date DESC";
$gm = mysql_query($query_gm, $core) or die(mysql_error());
$row_gm = mysql_fetch_assoc($gm);
$totalRows_gm = mysql_num_rows($gm);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM dms WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_jeniscm = "SELECT * FROM d_jenis_mom WHERE id = 1";
$jeniscm = mysql_query($query_jeniscm, $core) or die(mysql_error());
$row_jeniscm = mysql_fetch_assoc($jeniscm);
$totalRows_jeniscm = mysql_num_rows($jeniscm);

mysql_select_db($database_core, $core);
$query_jenispm = "SELECT * FROM d_jenis_mom WHERE id = 2";
$jenispm = mysql_query($query_jenispm, $core) or die(mysql_error());
$row_jenispm = mysql_fetch_assoc($jenispm);
$totalRows_jenispm = mysql_num_rows($jenispm);

mysql_select_db($database_core, $core);
$query_jenisgm = "SELECT * FROM d_jenis_mom WHERE id = 3";
$jenisgm = mysql_query($query_jenisgm, $core) or die(mysql_error());
$row_jenisgm = mysql_fetch_assoc($jenisgm);
$totalRows_jenisgm = mysql_num_rows($jenisgm);

mysql_select_db($database_core, $core);
$query_jenismr = "SELECT * FROM d_jenis_mom WHERE id = 4";
$jenismr = mysql_query($query_jenismr, $core) or die(mysql_error());
$row_jenismr = mysql_fetch_assoc($jenismr);
$totalRows_jenismr = mysql_num_rows($jenismr);

mysql_select_db($database_core, $core);
$query_jenisam = "SELECT * FROM d_jenis_mom WHERE id = 5";
$jenisam = mysql_query($query_jenisam, $core) or die(mysql_error());
$row_jenisam = mysql_fetch_assoc($jenisam);
$totalRows_jenisam = mysql_num_rows($jenisam);

mysql_select_db($database_core, $core);
$query_jenistr = "SELECT * FROM d_jenis_mom WHERE id = 6";
$jenistr = mysql_query($query_jenistr, $core) or die(mysql_error());
$row_jenistr = mysql_fetch_assoc($jenistr);
$totalRows_jenistr = mysql_num_rows($jenistr);

mysql_select_db($database_core, $core);
$query_jeniskom = "SELECT * FROM d_jenis_mom WHERE id = 7";
$jeniskom = mysql_query($query_jeniskom, $core) or die(mysql_error());
$row_jeniskom = mysql_fetch_assoc($jeniskom);
$totalRows_jeniskom = mysql_num_rows($jeniskom);

mysql_select_db($database_core, $core);
$query_jenistm = "SELECT * FROM d_jenis_mom WHERE id = 9";
$jenistm = mysql_query($query_jenistm, $core) or die(mysql_error());
$row_jenistm = mysql_fetch_assoc($jenistm);
$totalRows_jenistm = mysql_num_rows($jenistm);

mysql_select_db($database_core, $core);
$query_jenisst = "SELECT * FROM d_jenis_mom WHERE id = 8";
$jenisst = mysql_query($query_jenisst, $core) or die(mysql_error());
$row_jenisst = mysql_fetch_assoc($jenisst);
$totalRows_jenisst = mysql_num_rows($jenisst);

$tanggal=date("d M Y");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DCC - Minutes Of Meeting</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function datediff($tgl1, $tgl2){
	 $tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	 $tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
 	  $diff_secs = abs($tgl1 - $tgl2);
	 $base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	 $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	 return array( "years" => date("Y", $diff) - $base_year,
	"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	"months" => date("n", $diff) - 1,
	"days_total" => floor($diff_secs / (3600 * 24)),
	"days" => date("j", $diff) - 1 ),
	 "hours_total" => floor($diff_secs / 3600),
	"hours" => date("G", $diff),
	"minutes_total" => floor($diff_secs / 60),
	"minutes" => (int) date("i", $diff),
	"seconds_total" => $diff_secs,
	"seconds" => (int) date("s", $diff)  );
	 }
</script>

<style type="text/css">
<!--
a:link {
	color: #00F;
	text-decoration: underline;
}
a:visited {
	text-decoration: underline;
	color: #90C;
}
a:hover {
	text-decoration: underline;
	color: #F00;
}
a:active {
	text-decoration: underline;
	color: #000;
}
-->
</style>

<script src="../../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

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
</script>

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

</head>

	
<body>
<?php { include "../../date.php"; }
	require_once "../../dateformat_funct.php";
?>
<table width="1270" border="0" align="center">
  <tr>
    <td colspan="5" align="left" class="General" id="font"><div id="TabbedPanels1" class="VTabbedPanels">
      <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="0">Coordination Meeting</li>
        <li class="TabbedPanelsTab" tabindex="0">Payment Meeting</li>
        <li class="TabbedPanelsTab" tabindex="0">General Meeting</li>
        <li class="TabbedPanelsTab" tabindex="0">Management Review</li>
        <li class="TabbedPanelsTab" tabindex="0">Annually Meeting</li>
        <li class="TabbedPanelsTab" tabindex="0">Tender Review </li>
        <li class="TabbedPanelsTab" tabindex="0">Kick Off Meeting</li>
		<li class="TabbedPanelsTab" tabindex="0">Safety Talk</li>
        <li class="TabbedPanelsTab" tabindex="0">Toolbox Meeting</li>
      </ul>
      
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <div class="container">
	  <table width="624" border="0" class="table" id="celebs">
		  <thead>
            <tr class="tabel_header">
              <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jeniscm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
              </tr>
            <tr class="tabel_header">
              <td width="30">No.</td>
              <td width="100">Date</td>
              <td width="380">Title</td>
              <td width="50">&nbsp;</td>
            </tr>
            </thead>
            <tbody>
            <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php $a=$a+1; echo $a ?></td>
                <td align="center"><?php echo functddmmmyyyy($row_cm['date']); ?></td>
                
                <td><a href=../MOM_/uploadmom/<?php echo $row_cm[fileupload]; ?> target="_blank"></a><a href=../MOM_/uploadmom/<?php echo $row_cm[fileupload]; ?> target="_blank"><?php echo $row_cm['keterangan']; ?></a></td>
                <td align="center"><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_cm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
              </tr>
              <?php } while ($row_cm = mysql_fetch_assoc($cm)); ?></tbody>
          </table>
          </div>
        </div>
        
        <div class="TabbedPanelsContent">   
          <table width="624" class="table" id="celebs2" border="0">
            <thead>
              <tr class="tabel_header">
                <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jenispm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
                </tr>
              <tr class="tabel_header">
                <td width="30">No.</td>
                <td width="100">Date</td>
                <td width="380">Title</td>
                <td width="50">&nbsp;</td>
              </tr>
            </thead>
            <tbody>
              <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php $i=$i+1; echo $i ?></td>
                <td align="center"><?php echo functddmmmyyyy($row_pm[date]); ?></td>
                <td><a href="../MOM_/uploadmom/<?php echo $row_pm[fileupload]; ?>"><?php echo $row_pm['keterangan']; ?></a></td>
                <td><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_pm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
              </tr>
              <?php } while ($row_pm = mysql_fetch_assoc($pm)); ?>
            </tbody>
          </table>
          <h2><a href="viewMOMpm.php" target="_blank"></a></h2>
</div>

        <div class="TabbedPanelsContent">
          <table width="624" class="table" id="celebs3" border="0">
            <thead>
              <tr class="tabel_header">
                <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jenisgm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
                </tr>
              <tr class="tabel_header">
                <td width="30">No.</td>
                <td width="100">Date</td>
                <td width="380">Title</td>
                <td width="50">&nbsp;</td>
              </tr>
            </thead>
            <tbody>
              <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><? $j=$j+1; echo $j ?></td>
                <td align="center"><?php echo functddmmmyyyy($row_gm['date']); ?></td>
                <td><a href=../MOM_/uploadmom/<?php echo $row_gm['fileupload']; ?>><?php echo $row_gm['keterangan']; ?></td>
                <td><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_gm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
              </tr>
              <?php } while ($row_gm = mysql_fetch_assoc($gm)); ?>
            </tbody>
          </table>
          </div>
          
        <div class="TabbedPanelsContent">
          <div class="container">
            <table width="642" border="0" class="table" id="celebs">
              <thead>
                <tr class="tabel_header">
                  <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jenismr['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
                  </tr>
                <tr class="tabel_header">
                  <td width="30">No.</td>
                  <td width="100">Date</td>
                  <td width="380">Title</td>
                  <td width="50">&nbsp;</td>
                </tr>
              </thead>
              <tbody>
                <?php do { ?>
                <tr class="tabel_body">
                  <td align="center"><?php $b=$b+1; echo $b; ?></td>
                  <td align="center"><?php echo functddmmmyyyy($row_mr['date']); ?></td>
                  <td><a href=../MOM_/uploadmom/<?php echo $row_mr[fileupload]; ?> target="_blank"><?php echo $row_mr['keterangan']; ?></td>
                  <td align="center"><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_mr['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
                </tr>
                <?php } while ($row_mr = mysql_fetch_assoc($mr)); ?>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="TabbedPanelsContent">
          <table border="0" width="624">
            <tr class="tabel_header">
              <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jenisam['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
              </tr>
            <tr class="tabel_header">
              <td width="30">No.</td>
              <td width="100">Date</td>
              <td width="380">Title</td>
              <td width="50">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td align="center"><? $l=$l+1; echo $l; ?></td>
              <td align="center"><?php echo functddmmmyyyy($row_am['date']); ?></td>
              <td><a href=../MOM_/uploadmom/<?php echo $row_am['fileupload']; ?>><?php echo $row_am['keterangan']; ?></td>
              <td align="center"><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_am['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
            </tr>
            <?php } while ($row_am = mysql_fetch_assoc($am)); ?>
          </table>
        </div>
        
        <div class="TabbedPanelsContent">
          <table border="0" width="624">
            <tr class="tabel_header">
              <td colspan="5"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jenistr['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
              </tr>
            <tr class="tabel_header">
              <td width="30">No.</td>
              <td width="100">Date</td>
              <td width="380">Title</td>
              <td width="50">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td align="center"><? $m=$m+1; echo $m; ?></td>
              <td align="center"><?php echo functddmmmyyyy($row_tr['date']); ?></td>
              <td><a href=../MOM_/uploadmom/<?php echo $row_tr['fileupload']; ?>><?php echo $row_tr['keterangan']; ?></td>
              <td align="center"><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_tr['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
            </tr>
            <?php } while ($row_tr = mysql_fetch_assoc($tr)); ?>
          </table>
        </div>
        
        <div class="TabbedPanelsContent">
          <table border="0" width="624">
            <tr class="tabel_header">
              <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jeniskom['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
              </tr>
            <tr class="tabel_header">
              <td width="30">No.</td>
              <td width="100">Date</td>
              <td width="380">Title</td>
              <td width="78">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td align="center"><?php $n=$n+1; echo $n; ?></td>
              <td align="center"><?php echo functddmmmyyyy($row_kom['date']); ?></td>
              <td><a href=../MOM_/uploadmom/<?php echo $row_kom['fileupload']; ?>><?php echo $row_kom['keterangan']; ?></td>
              <td align="center"><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_kom['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
            </tr>
            <?php } while ($row_kom = mysql_fetch_assoc($kom)); ?>
          </table>
        </div>
        
		<div class="TabbedPanelsContent">
		  <table border="0" width="624">
		    <tr class="tabel_header">
		      <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jenisst['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
		      </tr>
		    <tr class="tabel_header">
		      <td width="30">No.</td>
		      <td width="100">Date</td>
		      <td width="380">Title</td>
		      <td width="50">&nbsp;</td>
		      </tr>
            <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php $o=$o+1; echo $o; ?></td>
                <td align="center"><?php echo functddmmmyyyy($row_st['date']); ?></td>
                <td><a href="../MOM_/uploadmom/<?php echo $row_st['fileupload']; ?>"><?php echo $row_st['keterangan']; ?></td>
                <td align="center"><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_st['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
              </tr>
              <?php } while ($row_st = mysql_fetch_assoc($st)); ?>
          </table>
		</div>
        
        <div class="TabbedPanelsContent">
          <table border="0" width="624">
            <tr class="tabel_header">
              <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=<?php echo $row_jenistm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
              </tr>
            <tr class="tabel_header">
              <td width="30">No.</td>
              <td width="100">Date</td>
              <td width="380">Title</td>
              <td width="50">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td align="center"><?php $p=$p+1; echo $p; ?></td>
              <td align="center"><?php echo functddmmmyyyy($row_tm['date']); ?></td>
              <td><a href=../MOM_/uploadmom/<?php echo $row_tm['fileupload']; ?>><?php echo $row_tm['keterangan']; ?></td>
              <td align="center"><a href="#" onclick="MM_openBrWindow('../editMOM.php?data=<?php echo $row_tm['id']; ?>','','scrollbars=yes,resizable=yes,width=450,height=300')">Edit</a></td>
            </tr>
            <?php } while ($row_tm = mysql_fetch_assoc($tm)); ?>
          </table>
        </div>
      </div>
<p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top" id="font"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="594">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="649" colspan="2" align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>

<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>

</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($cm);
	mysql_free_result($mr);
	mysql_free_result($am);
	mysql_free_result($tr);
	mysql_free_result($kom);
	mysql_free_result($st);
	mysql_free_result($tm);
	mysql_free_result($pm);
	mysql_free_result($gm);
	mysql_free_result($Recordset2);
	mysql_free_result($jeniscm);
	mysql_free_result($jenispm);
	mysql_free_result($jenisgm);
	mysql_free_result($jenismr);
	mysql_free_result($jenisam);
	mysql_free_result($jenistr);
	mysql_free_result($jeniskom);
	mysql_free_result($jenistm);
	mysql_free_result($jenisst);
?>