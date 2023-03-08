<?php

require_once 'db_connection.php';

// Check if video file is uploaded
//if (isset($_FILES['video'])&& $_FILES['video']['error'] == 0) {
try {
    // Get video data
    $video = null;/*file_get_contents($_FILES['video']['tmp_name']);*/

    if (isset($_FILES['video'])) {
        $video_name = $_FILES['video']['name'];
        $video_size = $_FILES['video']['size'];
        $video_type = $_FILES['video']['type'];
    }

    // Prepare SQL statement
    $sql = "INSERT INTO TestCase (Name, FullName, ResultState, TestStatus, Duration, StartTime, EndTime, Message, StackTrace, AssertCount, FailCount, PassCount, SkipCount, InconclusiveCount, HasChildren, Output, TestClassId, video) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE FullName = VALUES(FullName), ResultState = VALUES(ResultState), TestStatus = VALUES(TestStatus), Duration = VALUES(Duration), StartTime = VALUES(StartTime), EndTime = VALUES(EndTime), Message = VALUES(Message), StackTrace = VALUES(StackTrace), AssertCount = VALUES(AssertCount), FailCount = VALUES(FailCount), PassCount = VALUES(PassCount), SkipCount = VALUES(SkipCount), InconclusiveCount = VALUES(InconclusiveCount), HasChildren = VALUES(HasChildren), Output = VALUES(Output), TestClassId = VALUES(TestClassId), video = VALUES(video)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssdssssiiiiiisss", $_POST["Name"], $_POST["FullName"], $_POST["ResultState"], $_POST["TestStatus"], $_POST["Duration"], $_POST["StartTime"], $_POST["EndTime"], $_POST["Message"], $_POST["StackTrace"], $_POST["AssertCount"], $_POST["FailCount"], $_POST["PassCount"], $_POST["SkipCount"], $_POST["InconclusiveCount"], $_POST["HasChildren"], $_POST["Output"], $_POST["TestClassId"], $video);

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
