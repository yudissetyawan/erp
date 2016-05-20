     <?php
    if(isset($_POST[submit1])){
     $direktori = '../qly/uploaditp/'; //Folder penyimpanan file
     $max_size  = 100000000*2; //Ukuran file maximal 10mb
     $nama_file = $_FILES['fileitp']['name']; //Nama file yang akan di Upload
     $file_size = $_FILES['fileitp']['size']; //Ukuran file yang akan di Upload
     $nama_tmp  = $_FILES['fileitp']['tmp_name']; //Nama file sementara
     $upload = $direktori . $nama_file; //Memposisikan direktori penyimpanan dan file
   // Mengecek apakah File yang dipilih ada atau tidak
  	 if( file_exists ($upload)) { 
	echo "<blink>file <strong>$nama_file</strong> sudah ada, Rename File Upload atau upload file lain</blink>";}
	else {
	//Proses akan dimulai apabila File telah dipilih sebelumnya
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
     echo "File ".$nama_file." Gagal di Upload, karena terlalu besar, batas yang ditentukan adalah : ".$max_size." byte.";
    }}}}
    
    ?>  

