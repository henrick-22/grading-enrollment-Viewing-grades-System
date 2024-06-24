<?php
include("session-checker.php");
require_once "config.php";

// Delete an existing student
if (isset($_POST['delete_user'])) {
    $code = mysqli_real_escape_string($link, $_POST['deleteusername']); // Correcting the parameter name

    // Delete student from tblsubjects
    $query = "DELETE FROM tblsubjects WHERE code = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $code);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        // Log the delete student action
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $action = "Delete";
        $module = "Subject Management";
        $performedBy = $_SESSION['username'];

        $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_prepare($link, $log_query);
        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $code, $performedBy);

        if (mysqli_stmt_execute($stmt_log)) {
            $res = [
                'status' => 200,
                'message' => 'Student deleted successfully'
            ];
        } else {
            $res = [
                'status' => 500,
                'message' => 'Failed to log student deletion'
            ];
        }

        mysqli_stmt_close($stmt_log);
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to delete student'
        ];
    }

    echo json_encode($res); 
}
?>
