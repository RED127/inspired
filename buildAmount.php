<?php
require_once("config.php");
require_once("functions.php");

global $db, $DB_NAME, $tblBuildAmount;

// sql statement for creation table in database
$sql_table = "CREATE TABLE IF NOT EXISTS build_amount(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tbl_name VARCHAR(10),
    amount VARCHAR(10),
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
  $amount = $_POST["amount"];
  $date = $_POST["date"];

  $sql_select = "SELECT * FROM build_amount WHERE date = '" . $date . "' AND tbl_name = '" . $tbl . "'";
  $sql_insert = "INSERT INTO build_amount(tbl_name,amount,date) VALUES ('" . $tbl . "', '" . $amount . "', '" . $date . "')";
  $sql_update = "UPDATE build_amount SET amount= " . $amount . " WHERE date = '" . $date . "' AND tbl_name = '" . $tbl . "'";

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
  $sql_read = "SELECT * from build_amount";
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
