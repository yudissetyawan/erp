<?php require_once('../../Connections/core.php'); ?>
<?php require_once ('Classes/PHPExcel.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
    $colname_Recordset1 = $_GET['data'];
}

mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_absen_core WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// kalkulasi waktu
function totalTime($in, $out) {
    $IN = new DateTime($in);
    $OUT = new DateTime($out);

    $diff = $IN->diff($OUT);
    return  $diff->d.'days, '.$diff->h.'hours, '.$diff->i.'minutes';
}

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray(
                                                     array(
                                                         'borders' => array(
                                                             'allborders' => array(
                                                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                                                             )
                                                         ),
                                                         'font' => array(
                                                                         'bold' => true
                                                                     )
                                                     )
                                                 );

$objPHPExcel->getActiveSheet()
        ->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()
        ->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()
        ->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()
        ->getColumnDimension('D')->setWidth(25);

$objPHPExcel->getProperties()->setTitle("Absensi-Prototype")
        ->setDescription("prototype document excel");

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'DATE')
        ->setCellValue('B1', 'In Time')
        ->setCellValue('C1', 'Out Time')
        ->setCellValue('D1', 'Total');

$i = 1;
do {
    $i=$i+1;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i , ''.date('Y-m-d', strtotime($row_Recordset1['intime'])))
            ->setCellValue('B'.$i , $row_Recordset1['intime'])
            ->setCellValue('C'.$i , $row_Recordset1['outtime'])
            ->setCellValue('D'.$i , totalTime($row_Recordset1['intime'],$row_Recordset1['outtime']));

    $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D1'.$i)->applyFromArray(
                                                         array(
                                                             'borders' => array(
                                                                 'allborders' => array(
                                                                     'style' => PHPExcel_Style_Border::BORDER_THIN
                                                                 )
                                                             )
                                                         )
                                                     );

} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Data Absensi');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>