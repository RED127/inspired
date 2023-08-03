<?php
require_once("config.php");
require_once("functions.php");

global $db, $DB_NAME, $tblFinalData;

// sql statement for creation table in database
$sql_table = "CREATE TABLE IF NOT EXISTS " . $tblFinalData . "(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    container VARCHAR(10),
    module VARCHAR(10),
    userNm VARCHAR(10),
    firstID VARCHAR(20),
    secondID VARCHAR(20),
    count VARCHAR(20),
    liveTime VARCHAR(100),
    liveBuild INT(10) UNSIGNED,
    startNm VARCHAR(10),
    startTime VARCHAR(15),
    finishNm VARCHAR(10),
    finishTime VARCHAR(15),
    complete Boolean
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
  $cont          =    $data["cont"];
  $mod           =    $data["mod"];
  $currentUser   =    $data["currentUser"];
  $firstID       =    $data["firstID"];
  $secondID      =    $data["secondID"];
  $count         =    (int)$data["count"];
  $liveTime      =    $data["liveTime"];
  $liveBuild     =    (int)$data["liveBuild"];
  $startID       =    $data["startInfo"]["userName"];
  $startTime     =    $data["startInfo"]["regTime"];
  $finishID      =    $data["finishInfo"]["userName"];
  $finishTime    =    $data["finishInfo"]["regTime"];
  $complete    =      (int)$data["complete"];

  $sql_select = "SELECT * FROM final_data WHERE firstID = '" . $firstID . "'";
  $sql_insert = "INSERT INTO final_data(container, module, userNm, firstID, secondID, count, liveTime, liveBuild, startNm, startTime, finishNm, finishTime,complete) VALUES ('" . $cont . "', '" . $mod . "', '" . $currentUser . "','" . $firstID . "', '" . $secondID . "', '" . $count . "', '" . $liveTime . "', '" . $liveBuild . "', '" . $startID . "', '" . $startTime . "', '" . $finishID . "', '" . $finishTime . "','" . $complete . "')";
  $sql_update = "UPDATE final_data SET userNm = '" . $currentUser . "', count= " . $count . ", liveTime = '" . $liveTime . "', liveBuild = '" . $liveBuild . "', startNm = '" . $startID . "', startTime = '" . $startTime . "',finishNm = '" . $finishID . "', finishTime = '" . $finishTime . "', complete = '" . $complete . "' WHERE firstID = '" . $firstID . "'";

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
  if ($result = $db->query("SHOW TABLE STATUS FROM " . $DB_NAME . " LIKE 'final_data'")) {
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
