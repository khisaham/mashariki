<?php
require_once("conf.php"); 
$total = $link->query("SELECT count(*) as 'total' FROM job ");
$t_total[] = mysqli_fetch_array($total);
$total_total = $t_total['0']['total'];

$result = $link->query("SELECT jobstatus, count(*) as 'ctb' from job group by jobstatus");


	$jsonData = array();

	// Push the data into the array
        	while($row = mysqli_fetch_array($result)) {
        		//$get_sum = mysqli_fetch_array($link->query("SELECT count(*) FROM job WHERE "))
        		if($row["jobstatus"]==''){
        			$name = "No Status";
        		}
        		else{
        			$name = $row["jobstatus"];
        		}
        		$ctb = str_replace('"', '', $row['ctb']);
$sum = (($ctb/$total_total)*100);
echo $sum."</br>";
           	array_push($jsonData, array(
              	$name, $sum
              	)
           	);
        	}
       echo json_encode($jsonData);
?>