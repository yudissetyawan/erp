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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO h_training (kategori, jenis_training, `date`, exp_date, no_certificate, provider, remark) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['jenis_training'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['exp_date'], "text"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['remark'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_jenis_training ORDER BY jenis_training ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_jenis_training ORDER BY jenis_training ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<script type="text/javascript">
function loadData(type,parentId){
  // berikan kondisi sedang loading data ketika proses pengambilan data
  $('#loading').text('Loading '+type.replace('_','/')+' data...');
     $.post('load_data.php', // request ke file load_data.php
	{data_type: type, parent_id: parentId},
	function(data){
	  if(data.error == undefined){ // jika respon error tidak terdefinisi maka pengambilan data sukses 
		 $('#combobox_'+type).empty(); // kosongkan dahulu combobox yang ingin diisi datanya
		 $('#combobox_'+type).append('<option>-Pilih data-</option>'); // buat pilihan awal pada combobox
		 for(var x=0;x<data.length;x++){
			// berikut adalah cara singkat untuk menambahkan element option pada tag <select>
		 	$('#combobox_'+type).append($('<option></option>').val(data[x].id).text(data[x].nama));
		 }
		 $('#loading').text(''); // hilangkan text loading
	  }else{
		 alert(data.error); // jika ada respon error tampilkan alert
	  }
	},'json' // format respon yang diterima langsung di convert menjadi JSON 
     );      
  }
  $(function(){
   // pertama kali halaman di-load, maka ambil seluruh data pulau 
   loadData('pulau',0); 
   // fungsi yang dipanggil ketika isi dari combobox pulau dipilih 
   $('#combobox_pulau').change( 
		function(){
			// apabila nilai pilihan tidak kosong, load data propinsi
			if($('#combobox_pulau option:selected').val() != '')
				loadData('propinsi',$('#combobox_pulau option:selected').val());
		}
   );
   // fungsi yang dipanggil ketika isi dari combobox propinsi dipilih 
   $('#combobox_propinsi').change(
		function(){
			// apabila nilai pilihan tidak kosong, load data kabupaten/kota
			if($('#combobox_propinsi option:selected').val() != '')
				loadData('kabupaten_kota',$('#combobox_propinsi option:selected').val());
		}
   );
  });
 </script>
<link href="../css/induk.css" rel="stylesheet" type="text/css">
<?php
header("Refresh: 5; url=inputtrainingdetail.php");
?>
<?php {include "../date.php";}?>
          <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="627" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td width="113" class="General"><strong>Training</strong></td>
                <td width="6">&nbsp;</td>
                <td width="212" class="General"><input name="id_datapribadi2" type="text" class="hidentext" id="id_datapribadi2" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
                <td width="109" class="General">&nbsp;</td>
                <td width="12" class="General">&nbsp;</td>
                <td width="234" class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kategori Training</td>
                <td>:</td>
                <td class="General"><input type="radio" name="kategori" id="radio" value="1" />
                  Management Training</td>
                <td class="General">No. Sertifikat</td>
                <td>:</td>
                <td><input type="text" name="no_certificate" id="no_certificate" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="General"><input type="radio" name="kategori" id="radio2" value="2" />                  
                Skill Training</td>
                <td class="General">Penyelenggara</td>
                <td>:</td>
                <td><input name="provider" type="text" class="huruf_besar" id="provider" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Training</td>
                <td>:</td>
                <td class="General"><select name="jenis_training" id="jenis_training">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Recordset2['jenis_training']?>"><?php echo $row_Recordset2['jenis_training']?></option>
                  <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                </select>                  <?php {include "popup.html";}?></td>
                <td class="General">Klasifikasi</td>
                <td>:</td>
                <td><select name="klasifikasi" id="klasifikasi">
                  <option value="Basic">Basic</option>
                  <option value="Advance">Advance</option>
                  <option value="Inspector">Inspector</option>
                  <option value="Migas A">Migas A</option>
                  <option value="Migas B">Migas B</option>
                  <option value="Migas C">Migas C</option>
                  <option value="Depnaker III">Depnaker III</option>
                  <option value="Depnaker II">Depnaker II</option>
                  <option value="Depnaker I">Depnaker I</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Tanggal Training</td>
                <td>:</td>
                <td><input type="text" name="date" id="tanggal4" /></td>
                <td class="General">Remark</td>
                <td>:</td>
                <td><textarea name="remark" id="remark" cols="25" rows="3"></textarea></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku</td>
                <td>:</td>
                <td><input type="text" name="exp_date" id="exp_date" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form2">
          </form>
          <p>&nbsp;</p>
        <?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset1);
?>
