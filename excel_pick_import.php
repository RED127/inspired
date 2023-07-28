<?php
require_once 'PHPExcel/PHPExcel.php';
require_once 'PHPExcel/PHPExcel/IOFactory.php';
require_once("config.php");
require_once("functions.php");

global $db;

// SQL statement to create table
$sql = "CREATE TABLE excel_pick_import (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Container VARCHAR(30) NOT NULL,
    Module VARCHAR(30) NOT NULL,
    Qty_Boxes INT(10) UNSIGNED,
    Stocking_Date DATE,
    shift VARCHAR(10)
)";

//checking if excel_pick_import table exists in database
if ($result = $db->query("SHOW TABLE STATUS FROM spsonlin_pro LIKE 'excel_pick_import'")) {
    $result = (array)$result;
    if ($result["lengths"] !== NULL) {
        echo "Table excel_pick_import already exists" . "<br/>";
    } else {
        $db->query($sql);
        echo "Table excel_pick_import created successfully" . "<br/>";
    }
}

// Execute SQL statement
// if (mysqli_query($conn, $sql)) {
//     echo "Table excel_pick_import created successfully";
// } else {
//     echo "Error creating table: " . mysqli_error($conn);
// }

if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else {
    $file = '' . $_FILES['file']['name'];
    $result = move_uploaded_file($_FILES['file']['tmp_name'], $file);

    if ($result) {
        //Import Excel to DB
        $excel = new PHPExcel();
        try {
            // load uploaded file
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $sheet = $objPHPExcel->getSheet(0);
            $total_rows = $sheet->getHighestRow();
            $highestColumn      = $sheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $records = array();

            $sql = "DELETE FROM excel_pick_import";
            if ($db->query($sql) === TRUE) {
                echo "All data deleted successfully";
            } else {
                echo "Error deleting data: " . $db->error;
            }

            for ($row = 2; $row <= $total_rows; ++$row) {
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $sheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    $records[$row][$col] = $val;
                }
            }

            foreach ($records as $index => $row) {
                if ($index > 0) {
                    if ($row[5] && $row[6] && $row[8] && $row[11] && $row[12]) {
                        $Container = $row[5];
                        var_dump($Container);
                        $Module = $row[6];
                        $Qty_Boxes = $row[8];
                        $Stocking_Date = $row[11];
                        $shift = $row[12];
                        $query = "INSERT INTO excel_pick_import(Container, Module, Qty_Boxes, Stocking_Date, shift) VALUES ('" . $Container . "','" . $Module . "','" . $Qty_Boxes . "','" . $Stocking_Date . "','" . $shift . "')";
                        echo $query;

                        if ($db->query($query) === FALSE) {
                            echo "Error: " . $query . "<br>";
                        }
                    }
                }
            }
            echo 'Success';
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
    }
}
