<?php

require_once("config.php");
require_once("functions.php");

global $db;

// Execute SQL query to fetch data from the table
$sql = "SHOW TABLE STATUS FROM spsonlin_pro LIKE 'excel_pick_import'";
$result = $db->query($sql);
// Check if any rows were returned
$latest_updated = mysqli_fetch_array($result);

// get latest updated value from live page
$sql_live = "SELECT value FROM live WHERE timestamp = (SELECT MAX(timestamp) FROM live)";
$result_live = $db->query($sql_live);
