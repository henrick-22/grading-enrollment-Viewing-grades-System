<?php
include("session-checker.php");
require_once "config.php";

// Delete an existing user
if (isset($_POST['delete_user'])) {
    $username = mysqli_real_escape_string($link, $_POST['deleteusername']); // Correcting the parameter name

    // Delete account
    $query = "DELETE FROM tblaccounts WHERE username = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);

    if (mysqli_stmt_execute($stmt)) {
        // Log the delete action
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $action = "Delete";
        $module = "Accounts Management";
        $performedBy = $_SESSION['username']; // Assuming the session username is the one performing the action

        $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_prepare($link, $log_query);
        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $username, $performedBy);
        mysqli_stmt_execute($stmt_log);
        mysqli_stmt_close($stmt_log);

        $res = [
            'status' => 200,
            'message' => 'Account deleted successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to delete user'
        ];
    }

    echo json_encode($res);
    mysqli_stmt_close($stmt);
}
?>
