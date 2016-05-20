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
     $sql = "SELECT id_mmodel, mtrl_model
          FROM m_e_model
          WHERE id_subcatg = '$idSubcatg'
          ORDER BY mtrl_model
     ";
     $getFrameModel = mysql_query($sql, $koneksi) or die ('Query Gagal');
     while ($data = mysql_fetch_array($getFrameModel)){
          echo '<option value="'.$data['id_mmodel'].'">'.$data['mtrl_model'].'</option>';
     }
     exit;   
}
?>