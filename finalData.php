<?php
  require_once("config.php");
  require_once("functions.php");

  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "spsonlin_pro";
  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $db);

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // sql statement for creation table in database
  $sql_table = "CREATE TABLE final_data(
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

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //checking if final_data table exists in database
    if ($result = mysqli_query($conn, "SHOW TABLE STATUS FROM spsonlin_pro LIKE 'final_data'")){
      try {
        if (mysqli_num_rows($result) > 0) {
          echo "Table final_data already exists"."<br/>";
        } else {
          mysqli_query($conn, $sql_table);
          echo "Table final_data created successfully"."<br/>";
        }
      }catch (Exception $err) {
        echo $err;
      }
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

    $sql_insert = "INSERT INTO final_data(userNm, firstID, secondID, liveTime, liveBuild, startNm, startTime, finishNm, finishTime) VALUES ('$currentUser','$firstID', '$secondID', '$liveTime', '$liveBuild', '$startID', '$startTime', '$finishID', '$finishTime')";

    if ($result = mysqli_query($conn, $sql_insert)){
     echo "Success";
    } else {
      echo "Failed!";
    }
  } else {
    $sql_read = "SELECT * from final_data";
    if ($result = mysqli_query($conn, "SHOW TABLE STATUS FROM spsonlin_pro LIKE 'final_data'")){
      try {
        $output = array();
          $rr = $conn->query($sql_read);
          while ($item = mysqli_fetch_assoc($rr)) {
            $output[] = $item;
          }
          mysqli_free_result($result);
          echo json_encode($output);
      }catch (Exception $err) {
        echo $err;
      }
    }
  }
?>