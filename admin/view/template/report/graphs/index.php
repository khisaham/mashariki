<?php include_once("header-main.php");?>
  <div class="col-md-1">
    <p>Types of reports</p>
    <a href="index.php" style="color:#e45;">Invoice</a><br>
    <a href="jobs.php">Jobs</a><br>
    <a href="payments.php">Payments</a><br>
    <a href="charts.php">Chart View</a><br>
  </div>
  <div class="col-md-11">
    <?php
$dg = new C_DataGrid("SELECT * FROM invoice", "date", "Invoices");
$dg->enable_advanced_search(true);
$dg->enable_export('EXCEL');
$dg -> display();  
?>
  </div>



</body>
</html>