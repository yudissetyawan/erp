<?php 
	$kata = "aku ingin begini aku ingin begitu ingin ini ingin itu banyak sekali";
	$kata2 = "semua dapat aku lakukan";
	
	echo substr_count("$kata $kata2", "aku");
	//echo "$kata $kata2";
	
	$n = str_word_count($kata,'ini');
	
	
	
	$n2 = array('satu','dua','dua','lima');
	//echo substr_count($n2, 'satu');
	echo count($n2, 'satu').'<br>';
	$kata3 = "$kata $kata2";
	
	
	//Menghitung jumlah kata.
	$data = "Selalu untukmu dan untuk keluargaku";
	$a   = str_word_count($data, 1);
	$b   = str_word_count($data, 2);
	$c   = str_word_count($data);
	echo "<br><br>Data asli: $data <br>";
	print_r($a);
	echo "<br>";
	print_r ($b);
	echo "<br>Jumlah kata : $c";
?>