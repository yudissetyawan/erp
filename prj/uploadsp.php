     <?php
    if(isset($_POST[submit3])){
     $direktori = '../prj/upload/sp'; //Folder penyimpanan file
     $max_size  = 100000000*2; //Ukuran file maximal 10mb
     $nama_file = $_FILES['filesp']['name']; //Nama file yang akan di Upload
     $file_size = $_FILES['filesp']['size']; //Ukuran file yang akan di Upload
     $nama_tmp  = $_FILES['filesp']['tmp_name']; //Nama file sementara
     $upload = $direktori . $nama_file; //Memposisikan direktori penyimpanan dan file
    //Proses akan dimulai apabila File telah dipilih sebelumnya
	if( file_exists ($upload)) { 
	echo "<blink>file <strong>$nama_file</strong> sudah ada, Rename File Upload atau upload file lain</blink>";}
	else {
    if($nama_file == ""){echo "File Gagal di Upload karena anda tidak memilih file apapun!";}
    else{
    //Proses upload file jika ukuran lebih kecil dari yang di tentukan
    if($file_size <= $max_size)
     {
      if(move_uploaded_file($nama_tmp, $upload)){echo "File Berhasil diupload ke Direktori: ".$direktori.$nama_file."";}
      else{echo "File ".$nama_file."  Gagal diupload, karena berbagai macam alasan!";}
     }
    else
    {
     //Jika ukuran file lebih besar dari yang ditentukan
     echo "File ".$nama_file." Gagal di Upload, karena terlalu besar, batas yang ditentukan adalah : ".$max_size." bait.";
    }}}}
    
    ?>  

