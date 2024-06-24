<?php
include("session-checker.php");
require_once "config.php";

if (isset($_POST['delete_user'])) {
    $code = $_POST['deletecode'];
    $studentnum = $_POST['deletestudentnumber'];

    $sql = "DELETE FROM tblgrades WHERE code = ? AND studentnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $code, $studentnum);
        if (mysqli_stmt_execute($stmt)) {
            // Log deletion action
            $date = date("Y-m-d");
            $time = date("H:i:s");
            $action = "Delete";
            $module = "Grade Management";
            $performedBy = $_SESSION['username'];

            $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_log = mysqli_prepare($link, $log_query);
            mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $code, $performedBy);
            mysqli_stmt_execute($stmt_log);
            mysqli_stmt_close($stmt_log);

            $response = ['status' => 200, 'message' => 'Grade deleted successfully.'];
        } else {
            $response = ['status' => 500, 'message' => 'Error executing SQL statement: ' . mysqli_error($link)];
        }
        mysqli_stmt_close($stmt);
    } else {
        $response = ['status' => 500, 'message' => 'Error preparing SQL statement: ' . mysqli_error($link)];
    }
    mysqli_close($link);

    echo json_encode($response);
}
?>
