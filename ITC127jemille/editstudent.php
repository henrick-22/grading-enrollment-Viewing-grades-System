<?php
include("session-checker.php");
require_once "config.php";

// Update an existing student
if (isset($_POST['edit_user'])) {
    // Debugging statement
    error_log("Form submitted");

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

    // Debugging statement
    error_log("Fields validated");

    // Check if student exists
    $check_query = "SELECT * FROM tblstudents WHERE studentnumber = ?";
    if ($stmt = mysqli_prepare($link, $check_query)) {
        mysqli_stmt_bind_param($stmt, "s", $student);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 0) {
            $res = [
                'status' => 422,
                'message' => 'Student does not exist'
            ];
            echo json_encode($res);
            mysqli_stmt_close($stmt);
            return;
        }

        mysqli_stmt_close($stmt);
    } else {
        // Debugging statement
        error_log("Error preparing check SQL statement: " . mysqli_error($link));
        $res = [
            'status' => 500,
            'message' => 'Database error (check query)'
        ];
        echo json_encode($res);
        return;
    }

    // Debugging statement
    error_log("Student exists");

    // Update student
    $query = "UPDATE tblstudents SET password = ?, lastname = ?, firstname = ?, middlename = ?, course = ?, yearlevel = ? WHERE studentnumber = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $password, $lastname, $firstname, $middlename, $course, $year, $student);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            // Log the update student action
            $time = date("H:i:s");
            $action = "Update";
            $module = "Students Management";

            $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_log = mysqli_prepare($link, $log_query);
            mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $student, $createdBy);
            mysqli_stmt_execute($stmt_log);
            mysqli_stmt_close($stmt_log);

            $res = [
                'status' => 200,
                'message' => 'Student updated successfully'
            ];
        } else {
            // Debugging statement
            error_log("Error executing update SQL statement: " . mysqli_error($link));
            $res = [
                'status' => 500,
                'message' => 'Failed to update student (execute)'
            ];
        }
    } else {
        // Debugging statement
        error_log("Error preparing update SQL statement: " . mysqli_error($link));
        $res = [
            'status' => 500,
            'message' => 'Database error (update query)'
        ];
    }

    echo json_encode($res);
    return;
} else {
    // Debugging statement
    error_log("Form not submitted correctly");
}
?>
