<?php //MESSAGE FOR DAYS REMAINING BEFORE EXPIRED!!!
		//if (functyyyymmdd($row_Recordset1['expired_date']) > date("Y-m-d")) {
		
		$idcp = $row_Recordset1['id_certificate'];
		$tagsn = $row_Recordset1['tag_serial_number'];
		$eqpname = $row_Recordset1['name_of_equipment'];
		$expdt = functddmmmyyyy($row_Recordset1['expired_date']);
		
		list($month1, $date1, $year1) = functddmmyyyy($row_Recordset1['expired_date']);
		list($month2, $date2, $year2) = functddmmyyyy2(date("Y-m-d"));
		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);
		$selisih = $jd1 - $jd2;
			
		if (($row_Recordset1['expired_date']) > date("Y-m-d")) {
			
			echo '<font size="1" color="#000">'.$selisih.' days</font>';
			
			if ($selisih <= 30) {
				switch($row_Recordset1['id_category_product']){
					case "1" : $catg="SB";break;
					case "2" : $catg="SP";break;
					case "3" : $catg="SK";break;
					case "4" : $catg="CBR";break;
					case "5" : $catg="SL";break;
					case "6" : $catg="BS";break;
					case "7" : $catg="CB";break;
					case "8" : $catg="WS";break;
					case "9" : $catg="BC";break;
				}
				
				$usrid = $_SESSION['empID'];
				$sqlIdJob = "SELECT id_pekerjaan FROM log_pesan WHERE id_pekerjaan = '$idcp' AND id_inisial = '60'";
				$cmdIdJob = mysql_query($sqlIdJob) or die(mysql_error());
				$nData = mysql_num_rows($cmdIdJob);
			
				$sqlEmp = "SELECT id FROM h_employee WHERE department = 'Quality' OR department = 'PPIC' OR userlevel = 'administrator' OR userlevel = 'branchmanager' OR department = 'Project' AND code='K'";
				$cmdEmp = mysql_query($sqlEmp) or die(mysql_error());
				$rstEmp = mysql_fetch_assoc($cmdEmp);
			
				$msgcnt = "$eqpname with Tag Serial Number : $tagsn will be expired on $expdt";
				
				if ($nData == 0) {
					do {
						$idemp = $rstEmp['id'];
						$sqlMsg = "INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, removable_ntf, ntf_goto)
									VALUES ('60', '$idcp', '$idemp', '$msgcnt', 'UR', '../ppic/editcertificateproduct$catg.php?data=$idcp')";
						$cmdMsg = mysql_query($sqlMsg) or die(mysql_error());
					} while ($rstEmp = mysql_fetch_assoc($cmdEmp));
									
				} else if ($nData != 0) {
					do {
						$idemp = $rstEmp['id'];
						$sqlUpdMsg = "UPDATE log_pesan SET isi = '$msgcnt'
									WHERE id_inisial = '60' AND id_pekerjaan = '$idcp' AND id_empdept = '$idemp'";
						$cmdUpdMsg = mysql_query($sqlUpdMsg) or die(mysql_error());				
					} while ($rstEmp = mysql_fetch_assoc($cmdEmp));
				}
				
				//CEK JIKA ADA KARYAWAN YG BARU DIREGISTER AGAR MENDAPAT NOTIF
				$cmdEmp2 = mysql_query($sqlEmp) or die(mysql_error());
				$rstEmp2 = mysql_fetch_assoc($cmdEmp2);
				do {
					$idemp2 = $rstEmp2['id'];
					$sqlCekKary = "SELECT id_pekerjaan, id_empdept FROM log_pesan WHERE id_empdept = '$idemp2' AND id_pekerjaan = '$idcp'";
					$cmdCekKary = mysql_query($sqlCekKary) or die(mysql_error());
					//$rowCekKary = mysql_fetch_assoc($cmdCekKary);		
					$nCekKary = mysql_num_rows($cmdCekKary);
					if ($nCekKary == 0) {
						$sqlMsg2 = "INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, removable_ntf, ntf_goto)
									VALUES ('60', '$idcp', '$idemp2', '$msgcnt', 'UR', '../ppic/editcertificateproduct$catg.php?data=$idcp')";
						$cmdMsg2 = mysql_query($sqlMsg2) or die(mysql_error());
						/* echo "<script>alert(\"$msgcnt dan $idemp2\");</script>"; */
					}
				} while ($rstEmp2 = mysql_fetch_assoc($cmdEmp2));
				
				
			} else if ($selisih > 30) {
				$sqlDelMsg = "DELETE FROM log_pesan WHERE id_pekerjaan = '$idcp' AND id_inisial = '60'";
				$cmdDelMsg = mysql_query($sqlDelMsg) or die(mysql_error());
				/* echo "<script>parent.window.location.reload(true);</script>"; */
			}
			
		} else if (($row_Recordset1['expired_date']) <= date("Y-m-d")) {
			//echo "-";
			echo '<font size="1" color="#FF0000">'.$selisih.' days</font>';
			$sqlIdJob2 = "SELECT id_pekerjaan FROM log_pesan WHERE id_pekerjaan = '$idcp' AND id_inisial = '60'";
			$cmdIdJob2 = mysql_query($sqlIdJob2) or die(mysql_error());
			$nData2 = mysql_num_rows($cmdIdJob2);
		
			if ($nData2 != 0) {
				$sqlDelMsg2 = "DELETE FROM log_pesan WHERE id_pekerjaan = '$idcp' AND id_inisial = '60'";
				$cmdDelMsg2 = mysql_query($sqlDelMsg2) or die(mysql_error());
			}
		}
		
		//UPDATE STATUS
		if ($row_Recordset1['expired_date'] <= date("Y-m-d") && $row_Recordset1['status'] == '1') {
			$sqlUpdStat = "UPDATE p_certificate_product SET status = '0' WHERE id_certificate = '$idcp'";
			$cmdUpdStat = mysql_query($sqlUpdStat) or die(mysql_error());
		}
		?>
		
<?php
/*
		if (($row_Recordset1['expired_date']) > date("Y-m-d")) {
			list($month1, $date1, $year1) = functddmmyyyy($row_Recordset1['expired_date']);
			list($month2, $date2, $year2) = functddmmyyyy2(date("Y-m-d"));
			$jd1 = GregorianToJD($month1, $date1, $year1);
			$jd2 = GregorianToJD($month2, $date2, $year2);
			$selisih = $jd1 - $jd2;
			echo "$selisih days";
		
		} else { echo "-"; }
		
			$tagsn = $row_Recordset1['tag_serial_number'];
			$eqpname = $row_Recordset1['name_of_equipment'];
			$expdt = functddmmmyyyy($row_Recordset1['expired_date']);
			if ($selisih <= 30) {
				$sqlIdJob = "SELECT id_pekerjaan FROM log_pesan WHERE id_pekerjaan = '$tagsn'";
				$cmdIdJob = mysql_query($sqlIdJob) or die(mysql_error());
				$nData = mysql_num_rows($cmdIdJob);
		
				if ($nData == 0) {
					$sqlEmp = "SELECT id FROM h_employee WHERE department = 'Quality' OR department = 'PPIC' OR userlevel = 'administrator' OR userlevel = 'branchmanager'";
					//$sqlEmp = "SELECT id FROM h_employee WHERE userlevel = 'branchmanager'";
					$cmdEmp = mysql_query($sqlEmp) or die(mysql_error());
					$rstEmp = mysql_fetch_assoc($cmdEmp);
			
					$msgcnt = "$eqpname with Tag Serial Number : $tagsn will be expired on $expdt";
					do {
						$idemp = $rstEmp['id'];
						$sqlMsg = "INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi)
									VALUES ('60', '$tagsn', '$idemp', '$msgcnt')";
						$cmdMsg = mysql_query($sqlMsg) or die(mysql_error());
					} while ($rstEmp = mysql_fetch_assoc($cmdEmp));
				}
			} else if ($selisih > 30) {
				$sqlDelMsg = "DELETE FROM log_pesan WHERE id_pekerjaan = '$tagsn'";
				$cmdDelMsg = mysql_query($sqlDelMsg) or die(mysql_error());
			}
*/
?>