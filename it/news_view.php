<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bukaka News</title>
<link rel="stylesheet" type="text/css" href="/css/induk.css" />
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
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

<body class="General">

<?php
	if ($_SESSION['userlvl'] == 'administrator') {
		echo'<p><a href="news_data.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-comment"></span>All News</a></p>';
	}

	$where = '';
				if(isset($_GET['txtcari']) && $_GET['txtcari']){
					//$cmbcari = $_GET['cmbcari'];
					$txtcari = $_GET['txtcari'];
					//$where .= " WHERE concat_ws(' ', NonKeywordID, KataNonKunci, ResponNonKunci, UserID) LIKE '%{$_GET['txtcari']}%'";  
					//$where .= " AND $cmbcari LIKE '%$txtcari%'";
					$where .= " AND news_title LIKE '%$txtcari%' OR news_content LIKE '%$txtcari%'";		
				}
				
				//mencari banyak data yang ada dalam tabel
				$sqlCount = "SELECT COUNT(id) FROM i_news".$where;  
				$cmdCount = mysql_query($sqlCount) or die(mysql_error());
				$rsCount = mysql_fetch_array($cmdCount);
					
				$banyakData = $rsCount[0];  
				$page = isset($_GET['page']) ? $_GET['page'] : 1;  
				$limit = 20;  
				$mulai_dari = $limit * ($page - 1);
				//select * from nama_tabel limit 0,10 /*limit mulai_data_ke, banyak_data_yang_ditampilkan*/
				$sql_limit = "SELECT i_news.*, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.department FROM i_news, h_employee WHERE h_employee.id = i_news.issued_by AND i_news.news_active = '1'".$where." ORDER BY news_datetime LIMIT $mulai_dari, $limit";
				
				
				mysql_select_db($database_core, $core);
				$query_rsnews = "SELECT i_news.*, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.department FROM i_news, h_employee WHERE h_employee.id = i_news.issued_by AND i_news.news_active = '1'";
				$rsnews = mysql_query($query_rsnews, $core) or die(mysql_error());
				$row_rsnews = mysql_fetch_assoc($rsnews);
				$totalRows_rsnews = mysql_num_rows($rsnews);

				$hasil = mysql_query($sql_limit) or die(mysql_error());
			
?>

            <form method="get" action="" name="news_view.php">
                <table width="600" class="table" id="celebs" align="center">
                <tr align="right">
                    <td><b>Search</b>&nbsp;
                        <input type="text" name="txtcari" size="25">
						<input type="submit" value="Find" style="cursor:pointer">
                    </td>
                </tr>
                </table>
            </form>
            
<br />

<table width="600" class="table" id="celebs" align="center">
<thead>
  <tr class="tabel_header" height="40">
    <td width="600" colspan="2">BUKAKA NEWS</td>
    </tr>
 </thead>
 <tbody> 
  <?php
  { require_once "../dateformat_funct.php"; }
  
  if ($totalRows_rsnews != 0) {
	  
  do { ?>
    <tr class="tabel_body">
		<td valign="middle">
			<b><?php echo $row_rsnews['news_title']; ?></b>
		</td>
      
      <?php if ($_SESSION['userlvl'] == 'administrator') { ?>
		<td align="right" width="50">
			<a href="news_edit.php?data=<?php echo $row_rsnews['id']; ?>"><img src="../images/icedit.png" width="17" height="17"></a> &nbsp;&nbsp;
            <a href="news_deactivate.php?data=<?php echo $row_rsnews['id']; ?>" onclick="return confirm('Delete News about <?php echo $row_rsnews['news_title']; ?> on <?php echo functddmmmyyyy(substr($row_rsnews['news_datetime'], 0, 10)); ?> <?php echo substr($row_rsnews['news_datetime'], -8); ?> ?')"><img src="../images/icdel.png" width="17" height="17"></a>
		</td>
      <?php } ?>
    </tr>
    
    <tr class="tabel_body">
		<td colspan="2" align="justify">
        	by <i><?php echo $row_rsnews['firstname']; ?> <?php echo $row_rsnews['midlename']; ?> <?php echo $row_rsnews['lastname']; ?></i> at Department <?php echo $row_rsnews['department']; ?>
            <br />
            
            on <?php echo $row_rsnews['day_of_news']; ?>, <?php echo functddmmmyyyy(substr($row_rsnews['news_datetime'], 0, 10)); ?> <?php echo substr($row_rsnews['news_datetime'], -8); ?>
            <br /><br />
            
            <?php
            if (strlen($row_rsnews['news_content']) < 130) {
				echo $row_rsnews['news_content'];
			} else {
				echo substr($row_rsnews['news_content'], 0, 130); ?>
                ... <a href="news_detail.php?data=<?php echo $row_rsnews['id']; ?>"><i>Read more</i></a>
		<?php } ?>
             
            <br /><br />
		</td>
	</tr>
  <?php } while ($row_rsnews = mysql_fetch_assoc($rsnews));
  
  } else {
	echo '<tr class="tabel_body">
		<td valign="middle">
			<b>No news</b>
		</td>
		</tr>';
  } ?>
    
 </tbody>
</table>

<br />
<div align="center">
			<?php
            //membuat pagination  
			$banyakHalaman = ceil($banyakData / $limit);  
			echo 'Page : ';  
			for ($i = 1; $i <= $banyakHalaman; $i++) {  
				if ($page != $i) {
					echo '[<a href="news_view.php?page=' . $i .($where ? '&q='.$txtcari : ''). '">' . $i . '</a>] ';  
				} else {
					echo "[$i] ";
				}  
			}
			?>
</div>

</body>
</html>
<?php
	mysql_free_result($rsnews);
?>