<?php
include("session-checker.php");
require_once "config.php";

// Update an existing subject
if (isset($_POST['edit_user'])) {
    $code = mysqli_real_escape_string($link, $_POST['txtcode']);
    $description = mysqli_real_escape_string($link, $_POST['txtdescription']);
    $unit = mysqli_real_escape_string($link, $_POST['cmbunit']);
    $course = mysqli_real_escape_string($link, $_POST['cmbcourse']);
    $prerequisite1 = mysqli_real_escape_string($link, $_POST['cmbprequisite1']);
    $prerequisite2 = mysqli_real_escape_string($link, $_POST['cmbprequisite2']);
    $prerequisite3 = mysqli_real_escape_string($link, $_POST['cmbprequisite3']);
    $createdBy = $_SESSION['username'];
    $date = date("Y-m-d");

    // Validate fields
    if (empty($code) || empty($description) || $unit == 'Select Unit' || $course == 'Select Course') {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    // Check if subject exists
    $check_query = "SELECT * FROM tblsubjects WHERE code = ?";
    if ($stmt = mysqli_prepare($link, $check_query)) {
        mysqli_stmt_bind_param($stmt, "s", $code);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 0) {
            $res = [
                'status' => 422,
                'message' => 'Subject does not exist'
            ];
            echo json_encode($res);
            mysqli_stmt_close($stmt);
            return;
        }

        mysqli_stmt_close($stmt);
    } else {
        $res = [
            'status' => 500,
            'message' => 'Database error (check query)'
        ];
        echo json_encode($res);
        return;
    }

    // Update subject
    $update_query = "UPDATE tblsubjects SET description = ?, unit = ?, course = ?, prerequisite1 = ?, prerequisite2 = ?, prerequisite3 = ? WHERE code = ?";
    if ($update_stmt = mysqli_prepare($link, $update_query)) {
        mysqli_stmt_bind_param($update_stmt, "sssssss", $description, $unit, $course, $prerequisite1, $prerequisite2, $prerequisite3, $code);

        if (mysqli_stmt_execute($update_stmt)) {
            // Log the update subject action
            $time = date("H:i:s");
            $action = "Update";
            $module = "Subjects Management";

            $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_log = mysqli_prepare($link, $log_query);
            mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $code, $createdBy);
            mysqli_stmt_execute($stmt_log);
            mysqli_stmt_close($stmt_log);

            $res = [
                'status' => 200,
                'message' => 'Subject updated successfully'
            ];
        } else {
            $res = [
                'status' => 500,
                'message' => 'Failed to update subject'
            ];
        }
        mysqli_stmt_close($update_stmt);
    } else {
        $res = [
            'status' => 500,
            'message' => 'Database error (update query)'
        ];
    }

    echo json_encode($res);
    return;
} else {
    $res = [
        'status' => 422,
        'message' => 'Form not submitted correctly'
    ];
    echo json_encode($res);
    return;
}
?>
