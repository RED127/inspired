<?php
 // Connect to the database
 $servername = "localhost";
 $username = "root";
 $password = "";
 $db = "spsonlin_pro";
 // Create connection
 $conn = mysqli_connect($servername, $username, $password,$db);
 // Check connection
 if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
 }
 // Execute SQL query to fetch data from the table
 $sql = "SHOW TABLE STATUS FROM spsonlin_pro LIKE 'excel_pick_import'";
 $result = $conn->query($sql);
 // Check if any rows were returned
$latest_updated = mysqli_fetch_array($result);

// get latest updated value from live page
$sql_live = "SELECT value FROM live WHERE timestamp = (SELECT MAX(timestamp) FROM live)";
$result_live = $conn->query($sql_live);
?>