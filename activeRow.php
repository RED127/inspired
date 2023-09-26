<?php
require_once("config.php");
require_once("functions.php");

global $db, $DB_NAME, $tblActiveRow;

// sql statement for creation table in database
$sql_table = "CREATE TABLE IF NOT EXISTS active_row(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tbl_name VARCHAR(10),
    row_id VARCHAR(10),
    DATE VARCHAR(10)
  )";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //checking if final_data table exists in database
  try {
    $db->query($sql_table);
  } catch (Exception $err) {
    echo $err;
  }
  //insert new data into database

  $tbl  = $_POST["table"];
  $row_id = $_POST["row"];
  $date = $_POST["date"];

  $sql_select = "SELECT * FROM active_row WHERE date = '" . $date . "'";
  $sql_insert = "INSERT INTO active_row(tbl_name,row_id,date) VALUES ('" . $tbl . "', '" . $row_id . "', '" . $date . "')";
  $sql_update = "UPDATE active_row SET tbl_name = '" . $tbl . "', row_id= " . $row_id . " WHERE date = '" . $date . "'";

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
  $sql_read = "SELECT * from active_row";
  if ($result = $db->query("SHOW TABLE STATUS FROM " . $DB_NAME . " LIKE 'active_row'")) {
    try {
      $output = array();

      if($rr = $db->query($sql_read))
      {
        while ($item = mysqli_fetch_assoc($rr)) {
          $output[] = $item;
        }
        mysqli_free_result($result);
        echo json_encode($output);
      }
    } catch (Exception $err) {
      echo $err;
    }
  }
}
