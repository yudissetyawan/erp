<?php
ini_set('display_errors',0);
require_once('../../Connections/core.php');
$koneksi = mysql_connect($hostname_core,$username_core,$password_core) or die ('Tidak bisa konek DB');
$konekDB = mysql_select_db($database_core,$koneksi) or die ('DB tidak ada');

//ambil parameter
$idMCatg = $_POST['idMCatg'];
 
if($idMCatg == ''){
     exit;
}else{
     $sql = "SELECT id_msubcatg, msubcatg_descr, msubcatg_code
          FROM m_master_subcatg
          WHERE id_mcatg = '$idMCatg' AND subcatg_stat = '1'
          ORDER BY msubcatg_descr
     ";
     $getsubmcatg = mysql_query($sql,$koneksi) or die ('Query Gagal');
	 echo '<option value="">- Choose Subcategory -</option>';
     while($data = mysql_fetch_array($getsubmcatg)){
          echo '<option value="'.$data['id_msubcatg'].'">'.$data['msubcatg_descr'].'</option>';
     }
     exit;  
}
?>