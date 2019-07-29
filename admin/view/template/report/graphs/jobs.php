<?php include_once("header-main.php");?>
  <div class="col-md-1">
    <p>Types of reports</p>
    <a href="index.php">Invoice</a><br>
    <a href="jobs.php" style="color:#e45;">Jobs</a><br>
    <a href="payments.php">Payments</a><br>
    <a href="charts.php">Chart View</a><br>
  </div>
  <div class="col-md-11">
  <div class="col-md-12" style="height: 67px; background: #fff;">
    <p>Custom fields</p>
    <center>
      <!-- ID<input type="checkbox" name="id" id="id1">&nbsp; &nbsp; MATTERID<input type="checkbox" name="matterid" id="matterid">&nbsp; &nbsp; ASSOCIATE<input type="checkbox" name="associate" id="associate"> -->
      <form action="jobs.php" method="POST">

        <select style="background: #ffc; color:#45ee54; font-size: 22px; font-style: italic; width: 20%; height: 52px; " name="table">
        <?php 
        $sql = "SHOW TABLES FROM mamboleo_mis_database";
        $result = $link->query($sql);

        while ($row = mysqli_fetch_array($result)) {
    //echo "Table: {$row[0]}\n";
    echo "<option>".$row[0]."</option>";
}
echo "</select>";
        ?>
</select> 
       <input type="text" name="query" style="background: #ffc; color:#45ee54; font-size: 22px; font-style: italic; width: 30%; height: 52px; ">
        <input name="submit" type="submit" value="submit">
      </form>

    </center>
  </div>
  <div class="col-md-12">
    &nbsp;
  </div>
  <div class="col-md-12" style="margin-top: 12px;">
    <?php
    $table = 'Jobs';
    $select_transtype = $link->query("SELECT * FROM job");
    if(isset($_POST['submit'])){
      $table = $_POST['table'];

if($_POST['query'] !=''){
  $values = $_POST['query'];
  $query = "SELECT $values FROM $table ";
}
else {
  $query = "SELECT * FROM $table";
}
    }
    else {
     $query = "SELECT * FROM job"; 
    }


$dg = new C_DataGrid($query, "id", $table);
$dg->enable_advanced_search(true);
$dg->enable_export('EXCEL');
$dg -> display();  
?>
  </div>
</div>
</body>
</html>