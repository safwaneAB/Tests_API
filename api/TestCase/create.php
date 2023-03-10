<?php

require_once 'db_connection.php';

// Check if video file is uploaded
//if (isset($_FILES['video'])&& $_FILES['video']['error'] == 0) {
try {
 
    // Prepare SQL statement
    $sql = "INSERT INTO TestCase (Name, ResultState,Message) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE ResultState = VALUES(ResultState), Message = VALUES(Message)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $_POST["Name"], $_POST["ResultState"],$_POST["Message"]);

    // Execute INSERT query
    if (mysqli_stmt_execute($stmt)) {
        echo "Video uploaded successfully.";
    } else {
        echo "Error uploading video: " . mysqli_error($conn);
    }
} catch (Throwable $th) {
    echo $th;
}
//} else {
//   echo "Please select a video file to upload.";
//}
