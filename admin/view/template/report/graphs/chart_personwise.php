<!DOCTYPE html>
<?php
require_once("conf.php"); 
$total = $link->query("SELECT count(*) as 'total' FROM job ");
$t_total[] = mysqli_fetch_array($total);
$total_total = $t_total['0']['total'];

$result = $link->query("SELECT distinct jobassignment, count(*)as 'ctb' from job group by jobassignment");


	$jsonData = array();

	// Push the data into the array
        	while($row = mysqli_fetch_array($result)) {
        		//$get_sum = mysqli_fetch_array($link->query("SELECT count(*) FROM job WHERE "))
        		if($row["jobassignment"]==''){
        			$name = "No Name";
        		}
        		else{
        			$name = $row["jobassignment"];
        		}
        		$ctb = str_replace('"', '', $row['ctb']);
$sum = (($ctb/$total_total)*100);
//echo $sum."</br>";
           	array_push($jsonData, array(
              	$name, $sum
              	)
           	);
        	}
       //echo json_encode($jsonData);
?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
	<title>Charts</title>
</head>
<body>
<div class="col-sm-8" id="container2">

</div>
<script>
	jQuery(document).ready(function() {
$('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: '<b>Pie chart of Jobs Personwise<br><a href="charts.php">View Status Wise</a></b>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
				showInLegend: true
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: <?php echo json_encode($jsonData);?>
        }]
    });
    });
</script>

</body>
</html>