<?php
require_once 'PHPExcel/PHPExcel.php';
require_once 'PHPExcel/PHPExcel/IOFactory.php';
require_once("config.php");
require_once("functions.php");

global $db, $DB_NAME;

// Import Devan

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
if ($result = $db->query("SHOW TABLE STATUS FROM " . $DB_NAME . " LIKE 'excel_pick_import'")) {
    $result = (array)$result;
    if ($result["lengths"] !== NULL) {
        echo "Table excel_pick_import already exists" . "<br/>";
    } else {
        $db->query($sql);
        echo "Table excel_pick_import created successfully" . "<br/>";
    }
}

// Create Table Import Pick

// SQL statement to create table
$sql_list = "CREATE TABLE excel_pick_list (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Container VARCHAR(30) NOT NULL,
    Module VARCHAR(30) NOT NULL,
    Part_number VARCHAR(20) NOT NULL,
    Kanban VARCHAR(10) NOT NULL,
    No_box INT(10) UNSIGNED,
    is_complete BOOLEAN
)";

//checking if excel_pick_import table exists in database
if ($result = $db->query("SHOW TABLE STATUS FROM " . $DB_NAME . " LIKE 'excel_pick_list'")) {
    $result = (array)$result;
    if ($result["lengths"] !== NULL) {
        echo "Table excel_pick_list already exists" . "<br/>";
    } else {
        $db->query($sql_list);
        echo "Table excel_pick_list created successfully" . "<br/>";
    }
}

// ==============================================================

if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else {
    $file = '' . $_FILES['file']['name'];
    $kind = $_POST['kind'];
    $result = move_uploaded_file($_FILES['file']['tmp_name'], $file);

    if ($result) {
        //Import Excel to DB
        $excel = new PHPExcel();
        try {
            // load uploaded file
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            if ($kind == "system") {
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

                for (
                    $row = 2;
                    $row <= $total_rows;
                    ++$row
                ) {
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
                            $Qty_Boxes = (int)$row[8];
                            $Stocking_Date = $row[11];
                            $shift = $row[12];
                            $query = "INSERT INTO excel_pick_import(Container, Module, Qty_Boxes, Stocking_Date, shift) VALUES ('" . $Container . "','" . $Module . "','" . $Qty_Boxes . "','" . $Stocking_Date . "','" . $shift . "')";
                            echo $query;

                            if (
                                $db->query($query) === FALSE
                            ) {
                                echo "Error: " . $query . "<br>";
                            }
                        }
                    }
                }
            } else {
                // Pack List

                $sheet_list = $objPHPExcel->getSheet(0);
                $total_rows_list = $sheet_list->getHighestRow();
                $highestColumn_list      = $sheet_list->getHighestColumn();
                $highestColumnIndex_list = PHPExcel_Cell::columnIndexFromString($highestColumn_list);
                $records_list = array();

                $sql_list_delete = "DELETE FROM excel_pick_list";
                if (
                    $db->query($sql_list_delete) === TRUE
                ) {
                    echo "All data deleted successfully";
                } else {
                    echo "Error deleting data: " . $db->error;
                }

                for ($row = 2; $row <= $total_rows_list; ++$row) {
                    for ($col = 0; $col < $highestColumnIndex_list; ++$col) {
                        $cell = $sheet_list->getCellByColumnAndRow($col, $row);
                        $val = $cell->getValue();
                        $records_list[$row][$col] = $val;
                    }
                }

                foreach ($records_list as $index => $row) {
                    if ($index > 0) {
                        if ($row[1] && $row[2] && $row[3] && $row[4] && $row[7]) {
                            $Container = $row[1];
                            $Module = $row[2];
                            $Part_number = $row[3];
                            $Kanban = $row[4];
                            $No_box = (int)$row[7];
                            $query = "INSERT INTO excel_pick_list(Container, Module, Part_number, Kanban, No_box, is_complete) VALUES ('" . $Container . "','" . $Module . "','" . $Part_number . "','" . $Kanban . "','" . $No_box . "', 0)";
                            echo $query;

                            if (
                                $db->query($query) === FALSE
                            ) {
                                echo "Error: pick list - " . $query . "<br>";
                            }
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
