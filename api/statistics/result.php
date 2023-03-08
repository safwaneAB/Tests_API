<?php
require_once '../TestCase/db_connection.php';

try {



    // Prepare SQL statement
    $sql = "SELECT ( SELECT COUNT(*) FROM testcase where PassCount = 1 ) AS 'Passed', ( SELECT COUNT(*) FROM testcase where FailCount = 1 ) AS 'Failed';";
    $result = $conn->query($sql);
    while ($obj = $result->fetch_object()) {
        // Access the properties of the object
        $data = array("Passed" => $obj->Passed, "Failed" => $obj->Failed);
        echo json_encode($data);
    }
} catch (Throwable $th) {
    echo $th;
}
//} else {
//   echo "Please select a video file to upload.";
//}
$conn = null;
