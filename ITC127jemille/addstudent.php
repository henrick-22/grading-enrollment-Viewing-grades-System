<?php
include("session-checker.php");
require_once "config.php";

// Add a new user
if (isset($_POST['save_user'])) {
    $student = mysqli_real_escape_string($link, $_POST['txtstudent']);
    $password = mysqli_real_escape_string($link, $_POST['txtpassword']);
    $lastname = mysqli_real_escape_string($link, $_POST['txtlastname']);
    $firstname = mysqli_real_escape_string($link, $_POST['txtfirstname']);
    $middlename = mysqli_real_escape_string($link, $_POST['txtmiddlename']);
    $course = mysqli_real_escape_string($link, $_POST['cmbcourse']);
    $year = mysqli_real_escape_string($link, $_POST['cmbyear']);
    $createdBy = $_SESSION['username'];
    $date = date("Y-m-d"); // Correct date format for SQL

    // Validate fields
    if (empty($student) || empty($password) || empty($lastname) || empty($firstname) || empty($middlename) || $course == 'Select Course' || $year == 'Select year level') {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res); 
        return;
    }

    // Check if student number already exists
    $check_query = "SELECT * FROM tblstudents WHERE studentnumber = ?";
    $stmt = mysqli_prepare($link, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $student);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $res = [
            'status' => 422,
            'message' => 'Student number already exists'
        ];
        echo json_encode($res);
        mysqli_stmt_close($stmt);
        return;
    }
    mysqli_stmt_close($stmt);

    // Insert new student record
    $query = "INSERT INTO tblstudents (studentnumber, password, lastname, firstname, middlename, course, yearlevel, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "sssssssss", $student, $password, $lastname, $firstname, $middlename, $course, $year, $createdBy, $date);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        // Insert new account record
        $query = "INSERT INTO tblaccounts (username, password, usertype, userstatus, createdby, datecreated) VALUES (?, ?, 'STUDENT', 'ACTIVE', ?, ?)";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $student, $password, $createdBy, $date);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            // Log the add student action
            $time = date("H:i:s");
            $action = "Add";
            $module = "Students Management";

            $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_log = mysqli_prepare($link, $log_query);
            mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $student, $createdBy);
            mysqli_stmt_execute($stmt_log);
            mysqli_stmt_close($stmt_log);

            $res = [
                'status' => 200,
                'message' => 'Student added successfully'
            ];
        } else {
            $res = [
                'status' => 500,
                'message' => 'Student added but failed to create account'
            ];
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to add student'
        ];
    }

    echo json_encode($res);
    return;
}
?>
