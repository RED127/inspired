<?php
require_once("config.php");
require_once("functions.php");

global $db;
// Execute SQL query to fetch data from the table
$sql = "SELECT value
FROM live
WHERE `timestamp` = (
  SELECT MAX(`timestamp`)
  FROM live
);";
$result = $db->query($sql);
$row = $result->fetch_all();
$result->free_result();
echo json_encode($row[0]);
// Check if any rows were returned
