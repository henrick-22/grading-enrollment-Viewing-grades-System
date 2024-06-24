<?php
include("session-checker.php");
require_once "config.php";

// Update an existing user
if (isset($_POST['edit_user'])) {
    // Debugging statement
    error_log("Form submitted");

    $username = mysqli_real_escape_string($link, $_POST['txtusername']);
    $password = mysqli_real_escape_string($link, $_POST['txtpassword']);


    // Validate fields
    if (empty($username) || empty($password)) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    // Debugging statement
    error_log("Fields validated");

    // Check if username exists
    $check_query = "SELECT * FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $check_query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 0) {
            $res = [
                'status' => 422,
                'message' => 'Username does not exist'
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
    error_log("Username exists");

    // Update account
    $query = "UPDATE tblaccounts SET password = ? WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $password, $username);

        if (mysqli_stmt_execute($stmt)) {
            $res = [
                'status' => 200,
                'message' => 'Account updated successfully'
            ];
        } else {
            // Debugging statement
            error_log("Error executing update SQL statement: " . mysqli_error($link));
            $res = [
                'status' => 500,
                'message' => 'Failed to update user (execute)'
            ];
        }
        mysqli_stmt_close($stmt);
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
