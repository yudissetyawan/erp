<?php
 
include "../../config.php";
 
?>
 
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>S-Curve</title>
 
		<script type="text/javascript" src="../../js/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
				
                text: 'KLO Project - J134',
                x: 0 //center
            },
            subtitle: {
                text: 'Sumber:erp.btubpn.com',
                x: 0
            },
            xAxis: {
                categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6','Week 7', 'Week 8', 'Week 9', 'Week 10', 'Week 11', 'Week 12']
            },
            yAxis: {
                title: {
                    text: 'Weight Factor'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +' Nilai (dalam Persen(%))';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: 0,
                y: 100,
                borderWidth: 0
            },`
            series:             
            [
            <?php //query tiap negara lbih dulu, baru tiap jenis diambil datanya, dijadikan data berjajar berdasar koma
		    $sql   = "SELECT * FROM `pr_jenis` ";
            $query = mysql_query( $sql );
            while( $ret = mysql_fetch_array( $query ) ){
               $nId = $ret['id'];
               $jenis = $ret['jenis']; 
                  $sql_   = "SELECT * FROM `pr_allcumm` WHERE `jenisId`='$nId'";
                  $query_ = mysql_query( $sql_ );
                  $data = "";
                  while( $ret_ = mysql_fetch_array( $query_ ) ){
                     $kel = $ret_['nilai'];s
                     $data = $data . "," . $kel;
                  }
                  $data = substr( $data , 1 , strlen( $data ) );
                  ?>
                  {
                      name: '<?php echo $jenis; ?>',
                      data: [<?php echo $data; ?>]
                  },
                  <?php
 
            }
            ?>
            ]
        });
    });
 
});
		</script>
	</head>
 
	<body>
<script src="../../js/highcharts.js"></script>
<script src="../../js/exporting.js"></script>
 
<div id="container" style="width: 700px; height: 400px; margin: 0 auto"></div>
 
	</body>
</html>