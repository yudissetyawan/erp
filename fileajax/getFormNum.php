<?php
	$num=$_GET['num'];
	$i=1;
	echo "<table>";
	do{
		echo "	<tr>
				<td>Material -".$i."</td>
				<td>:</td>
				<td><input type='text' name='materi".$i."' id='materi".$i."' ></td>
				</tr>";
		$i++;
	}while($i<=$num);
	echo "<tr><td></td>
			  <td></td>
			  <td><input type='submit' name='save' id='save' value='Save' /></td>
		  </tr>
		  <table>"; ?>