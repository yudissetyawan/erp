<?php require_once('../../Connections/core.php'); ?>
<?php
// jumlah data yang akan ditampilkan per halaman

$dataPerPage = 5;

// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
// sedangkan apabila belum, nomor halamannya 1.

if(isset($_GET['page']))
{
    $noPage = $_GET['page'];
}
else $noPage = 1;

// perhitungan offset

$offset = ($noPage - 1) * $dataPerPage;

// query SQL untuk menampilkan data perhalaman sesuai offset

$query = "SELECT a_crf.idms, dms.idms, dms.inisial_pekerjaan, dms.`date`, dms.fileupload, dms.keterangan
FROM dms, a_crf
WHERE dms.idms=a_crf.idms AND dms.inisial_pekerjaan = 'DI' LIMIT $offset, $dataPerPage";

$result = mysql_query($query) or die('Error');

// menampilkan data 

echo "<table border='1'>";
echo "<tr><td>Date</td><td>Nama File</td></tr>";
while($data = mysql_fetch_array($result))
{
   echo "<tr><td>".$data['date']."</td><td>".$data['fileupload']."</td></tr>";
}

echo "</table>";

// mencari jumlah semua data dalam tabel guestbook

$query   = "SELECT a_crf.idms, dms.idms, dms.inisial_pekerjaan, dms.`date`, dms.fileupload, dms.keterangan
FROM dms, a_crf
WHERE dms.idms=a_crf.idms AND dms.inisial_pekerjaan = 'DI'";
$hasil  = mysql_query($query);
$data     = mysql_fetch_array($hasil);

$jumData = $data['jumData'];

// menentukan jumlah halaman yang muncul berdasarkan jumlah semua data

$jumPage = ceil($jumData/$dataPerPage);

// menampilkan link previous

if ($noPage > 1) echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'>&lt;&lt; Prev</a>";

// memunculkan nomor halaman dan linknya

for($page = 1; $page <= $jumPage; $page++)
{
         if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage))
         {
            if (($showPage == 1) && ($page != 2))  echo "...";
            if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
            if ($page == $noPage) echo " <b>".$page."</b> ";
            else echo " <a href='".$_SERVER['PHP_SELF']."?page=".$page."'>".$page."</a> ";
            $showPage = $page;
         }
}

// menampilkan link next

if ($noPage < $jumPage) echo "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage+1)."'>Next &gt;&gt;</a>";

?>