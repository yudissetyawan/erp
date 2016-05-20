function cek(){ 
	    $.ajax({ 
        url: "cekpesan.php", 
	        cache: false, 
        success: function(msg){ 
	            $("#notifikasi").html(msg); 
	        } 
	    }); 
	    var waktu = setTimeout("cek()",3000); 
	} 