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
$sql = "SELECT value
FROM live
WHERE `timestamp` = (
  SELECT MAX(`timestamp`)
  FROM live
);";
$result = $conn->query($sql);
$row = $result->fetch_all();
$result->free_result();
$conn->close();
echo json_encode($row[0]);
// Check if any rows were returned
?>