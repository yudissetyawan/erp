<?php
ini_set('display_errors', 0);
require_once('../../Connections/core.php');
$koneksi = mysql_connect($hostname_core,$username_core,$password_core) or die ('Tidak bisa konek DB');
$konekDB = mysql_select_db($database_core,$koneksi) or die ('DB tidak ada');

//ambil parameter
$idSubcatg = $_POST['idSubcatg'];
 
if ($idSubcatg == '') {
     exit;
} else {
     $sql = "SELECT a.id_item, a.item_code, a.id_mmodel, b.mtrl_model, a.descr_name
          FROM m_master a
		  INNER JOIN m_e_model b ON a.id_mmodel = b.id_mmodel
          WHERE b.id_subcatg = '$idSubcatg'
          ORDER BY descr_name
     ";
     $getFrameModel = mysql_query($sql, $koneksi) or die ('Query Gagal');
	 echo '<option value="">- Choose Name of Item -</option>';
     while ($data = mysql_fetch_array($getFrameModel)){
          echo '<option value="'.$data['id_item'].'">'.$data['mtrl_model'].' ['.$data['descr_name'].']</option>'; // ['.$data['item_code'].'] 
     }
     exit;   
}
?>