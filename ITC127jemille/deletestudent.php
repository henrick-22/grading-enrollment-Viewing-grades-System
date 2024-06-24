<?php
include("session-checker.php");
require_once "config.php";

// Delete an existing student
if (isset($_POST['delete_student'])) {
    $student = mysqli_real_escape_string($link, $_POST['deleteusername']); // Correcting the parameter name

    // Delete student from tblstudents
    $query = "DELETE FROM tblstudents WHERE studentnumber = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $student);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        // Log the delete student action
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $action = "Delete";
        $module = "Students Management";
        $createdBy = $_SESSION['username'];

        $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_prepare($link, $log_query);
        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $student, $createdBy);
        mysqli_stmt_execute($stmt_log);
        mysqli_stmt_close($stmt_log);

        $res = [
            'status' => 200,
            'message' => 'Student deleted successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to delete student'
        ];
    }

    echo json_encode($res); 
}
?>
