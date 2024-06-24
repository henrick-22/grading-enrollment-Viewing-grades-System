<?php
include("session-checker.php");
require_once "config.php";

// Add a new subject
if (isset($_POST['save_user'])) {
    $code = mysqli_real_escape_string($link, $_POST['txtcode']);
    $description = mysqli_real_escape_string($link, $_POST['txtdescription']);
    $unit = mysqli_real_escape_string($link, $_POST['cmbunit']);
    $course = mysqli_real_escape_string($link, $_POST['cmbcourse']);
    $prerequisite1 = mysqli_real_escape_string($link, $_POST['cmbprequisite1']);
    $prerequisite2 = mysqli_real_escape_string($link, $_POST['cmbprequisite2']);
    $prerequisite3 = mysqli_real_escape_string($link, $_POST['cmbprequisite3']);
    $createdBy = $_SESSION['username'];
    $date = date("Y-m-d"); // Correct date format for SQL

    // Validate fields
    if (empty($code) || empty($description) || $unit == 'Select Unit' || $course == 'Select Course') {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res); 
        return;
    }

    // Check if subject code already exists
    $check_query = "SELECT * FROM tblsubjects WHERE code = ?";
    $stmt = mysqli_prepare($link, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $res = [
            'status' => 422,
            'message' => 'Subject code already exists'
        ];
        echo json_encode($res);
        mysqli_stmt_close($stmt);
        return;
    }
    mysqli_stmt_close($stmt);

    // Insert new subject record
    $query = "INSERT INTO tblsubjects (code, description, unit, course, prerequisite1, prerequisite2, prerequisite3, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "sssssssss", $code, $description, $unit, $course, $prerequisite1, $prerequisite2, $prerequisite3, $createdBy, $date);

    if (mysqli_stmt_execute($stmt)) {
        // Log the add subject action
        $time = date("H:i:s");
        $action = "Create";
        $module = "Subjects Management";

        $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_prepare($link, $log_query);
        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $code, $createdBy);
        mysqli_stmt_execute($stmt_log);
        mysqli_stmt_close($stmt_log);

        $res = [
            'status' => 200,
            'message' => 'Subject added successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to add subject'
        ];
    }
    mysqli_stmt_close($stmt);

    echo json_encode($res);
    return;
}
?>
