<?php
require_once "config.php";
include("session-checker.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) { // Check if the flag is set
    $studentnumber = mysqli_real_escape_string($link, $_POST['studentnumber']);
    $code = mysqli_real_escape_string($link, $_POST['cmbcode']);
    $grade = mysqli_real_escape_string($link, $_POST['cmbgrade']);
    $updatedBy = $_SESSION['username'];
    $date = date("Y-m-d");

    // Validate fields
    if (empty($studentnumber) || empty($code) || $grade == 'Select Grade') {
        $res = [
            'status' => 500,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    // Update grade record
    $query = "UPDATE tblgrades SET grade = ?, createdby = ?, datecreated = ? WHERE studentnumber = ? AND code = ?";
    $stmt = mysqli_prepare($link, $query);

    if (!$stmt) {
        $res = [
            'status' => 500,
            'message' => 'Failed to prepare SQL statement: ' . mysqli_error($link)
        ];
        echo json_encode($res);
        return;
    }

    mysqli_stmt_bind_param($stmt, "sssss", $grade, $updatedBy, $date, $studentnumber, $code);

    if (mysqli_stmt_execute($stmt)) {
        // Insert log
        $time = date("H:i:s");
        $action = "Update";
        $module = "Grade Management";
        $performedBy = $_SESSION['username'];

        $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_prepare($link, $log_query);
        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $code, $performedBy);
        mysqli_stmt_execute($stmt_log);
        mysqli_stmt_close($stmt_log);

        $res = [
            'status' => 200,
            'message' => 'Grade updated successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to update grade: ' . mysqli_stmt_error($stmt)
        ];
    }
    mysqli_stmt_close($stmt);

    echo json_encode($res);
}
?>
