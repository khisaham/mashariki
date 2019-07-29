<?php
//include('../../Glimpse/index.php');
require_once("conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mashariki | Reports</title>
</head>
<body>
	<div>
		<p>Invoices Reports</p>
<?php
$dg = new C_DataGrid("SELECT * FROM invoice", "date", "Invoices");
$dg -> display();
?>
</div>

<div>
	<p>Jobs</p>
<?php
$dgol = new C_DataGrid("SELECT * FROM job", "id", "Jobs");
$dgol -> display();
?>
</div>
<div>
	<p>Clients</p>
<?php
$dgclients = new C_DataGrid("SELECT * FROM clients", "id", "clients");
$dgclients -> display();
?>
</div>
</body>
</html>