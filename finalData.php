<?php
require_once("config.php");
require_once("functions.php");

global $DB_NAME, $tblFinalData;

// sql statement for creation table in database
$sql_table = "CREATE TABLE IF NOT EXISTS " . $tblFinalData . "(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userNm VARCHAR(10) NOT NULL,
    firstID VARCHAR(20) NOT NULL,
    secondID VARCHAR(20) NOT NULL,
    liveTime VARCHAR(10) NOT NULL,
    liveBuild INT(10) UNSIGNED,
    startNm VARCHAR(10) NOT NULL,
    startTime VARCHAR(15) NOT NULL,
    finishNm VARCHAR(10) NOT NULL,
    finishTime VARCHAR(15) NOT NULL
  )";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //checking if final_data table exists in database
  try {
    $db->query($sql_table);
  } catch (Exception $err) {
    echo $err;
  }
  //insert new data into database

  $data = $_POST['data'];
  $currentUser   =    $data["currentUser"];
  $firstID       =    $data["firstID"];
  $secondID      =    $data["secondID"];
  $liveTime      =    $data["liveTime"];
  $liveBuild     =    $data["liveBuild"];
  $startID       =    $data["startInfo"]["userName"];
  $startTime     =    $data["startInfo"]["regTime"];
  $finishID      =    $data["finishInfo"]["userName"];
  $finishTime    =    $data["finishInfo"]["regTime"];

  $sql_select = "SELECT * FROM final_data WHERE  userNm = '" . $currentUser . "' AND firstID = '" . $firstID . "' AND secondID = '" . $secondID . "'";
  $sql_insert = "INSERT INTO final_data(userNm, firstID, secondID, liveTime, liveBuild, startNm, startTime, finishNm, finishTime) VALUES ('$currentUser','$firstID', '$secondID', '$liveTime', '$liveBuild', '$startID', '$startTime', '$finishID', '$finishTime')";
  $sql_update = "UPDATE final_data SET liveTime = '" . $liveTime . "', liveBuild = '" . $liveBuild . "', startNm = '" . $startID . "', startTime = '" . $startTime . "',finishNm = '" . $finishID . "', finishTime = '" . $finishTime . "'  WHERE  userNm = '" . $currentUser . "' AND firstID = '" . $firstID . "' AND secondID = '" . $secondID . "'";

  if ($db->query($sql_select) && mysqli_num_rows($db->query($sql_select)) > 0) {
    if ($result = $db->query($sql_update)) {
      echo "Success";
    } else {
      echo "Failed!";
    }
  } else {
    if ($result = $db->query($sql_insert)) {
      echo "Success";
    } else {
      echo "Failed!";
    }
  }
} else {
  $sql_read = "SELECT * from final_data";
  if ($result = $db->query("SHOW TABLE STATUS FROM spsonlin_pro LIKE 'final_data'")) {
    try {
      $output = array();
      $rr = $db->query($sql_read);
      while ($item = mysqli_fetch_assoc($rr)) {
        $output[] = $item;
      }
      mysqli_free_result($result);
      echo json_encode($output);
    } catch (Exception $err) {
      echo $err;
    }
  }
}
