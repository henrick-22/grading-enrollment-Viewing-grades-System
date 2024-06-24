<?php
include("session-checker.php");
require_once "config.php";

if (isset($_GET['username'])) {
    $code = mysqli_real_escape_string($link, $_GET['username']);

    $query = "SELECT * FROM tblsubjects WHERE code=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $code);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $res = [
            'status' => 200,
            'message' => 'Student fetched successfully',
            'data' => $user
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'message' => 'Student not found'
        ];
        echo json_encode($res);
    }

    mysqli_stmt_close($stmt);
    return;
}
?>