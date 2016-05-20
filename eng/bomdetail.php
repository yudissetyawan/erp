<html> 
<head> 
<script> 
	var idrow = 2; 
	 
	function tambah(){ 
	    var x=document.getElementById('datatable').insertRow(idrow); 
	    var td1=x.insertCell(0); 
	    var td2=x.insertCell(1); 
	    var td3=x.insertCell(2); 
	    var td4=x.insertCell(3); 
		var td5=x.insertCell(4); 
	    var td6=x.insertCell(5); 
	    var td7=x.insertCell(6); 
	    var td8=x.insertCell(7); 
		var td9=x.insertCell(8); 
	    var td10=x.insertCell(9); 
	    var td11=x.insertCell(10); 
	    var td12=x.insertCell(11); 
	    td1.innerHTML="<input type='text' name='id[]'>"; 
	    td2.innerHTML="<input type ='text' name='description[]'>"; 
	    td3.innerHTML="<input type ='text' name='spec[]'>"; 
	    td4.innerHTML="<input type ='text' name='thickness[]'>"; 
		td5.innerHTML="<input type='text' name='width[]'>"; 
	    td6.innerHTML="<input type ='text' name='length[]'>"; 
	    td7.innerHTML="<input type ='text' name='unit[]'>"; 
	    td8.innerHTML="<input type ='text' name='unitweight[]'>"; 
		td9.innerHTML="<input type='text' name='qty[]'>"; 
	    td10.innerHTML="<input type ='text' name='paintarea[]'>"; 
	    td11.innerHTML="<input type ='text' name='remarks[]'>"; 
	    td12.innerHTML="<input type ='text' name='headercorebom[]'>"; 
	    idrow++; 
	} 
	 
	function hapus(){ 
	    if(idrow>2){ 
	        var x=document.getElementById('datatable').deleteRow(idrow-1); 
	        idrow--; 
	    } 
	} 
	</script>
	<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head> 
<body> 
	<form action=../prosesdatabom.php method=post> 
	<table id=datatable border=0> 
	  <td width="40" rowspan="2" class="tabel_header">No.</td>
              <td width="261" rowspan="2" class="tabel_header">Description</td>
              <td colspan="4" class="tabel_header">Size</td>
              <td width="39" rowspan="2" class="tabel_header"><span class="judul">Unit</span></td>
              <td width="61" rowspan="2" class="tabel_header"><span class="judul">Weight (Kg)</span></td>
              <td width="67" rowspan="2" class="tabel_header"><span class="judul">Quantity</span></td>
              <td width="78" rowspan="2" class="tabel_header"><span class="judul">Total Weights (Kg)</span></td>
              <td width="64" rowspan="2" class="tabel_header"><span class="judul">Total Lengths (Kg)</span></td>
              <td width="73" rowspan="2" class="tabel_header"><span class="judul">Paint Area</span></td>
              <td width="71" rowspan="2" class="tabel_header"><span class="judul">Total Paint Area</span></td>
              <td width="67" rowspan="2" class="tabel_header">Remarks</td>
              <td width="33" rowspan="2" class="tabel_header">&nbsp;</td>
              </tr>
            <tr class="General">
              <td width="215" class="tabel_header">Spesification</td>
              <td width="56" class="tabel_header">Thickness (mm)</td>
              <td width="36" class="tabel_header">Width (mm)</td>
              <td width="50" class="tabel_header">Length (mm)</td>
              </tr>
	</tr> 
	<tr> 
     <?php $n=$n+1; ?>
	<td><input type ='text' value="<?php echo $n ;?>"></td> 
	<td><input type ='text' name='description[]'></td> 
	<td><input type='text' name='spec[]'></td>  
	<td><input type ='text' name='thickness[]' /></td> 
    <td><input type='text' name='width[]'></td> 
	<td><input type ='text' name='length[]'></td> 
	<td><input type='text' name='unit[]'></td>  
	<td><input type ='text' name='unitweight[]' /></td> 
    <td><input type='text' name='qty[]'></td> 
	<td><input type ='text' name='paintarea[]'></td> 
	<td><input type='text' name='remark[]'></td>  
	
	</tr> 
	</table> 
	<input type=button value=tambah onclick=tambah()> 
	<input type=button value=delete onclick=hapus()> 
	<br> 
	<input type=submit> 
</form> 
</body>
	</html> 

