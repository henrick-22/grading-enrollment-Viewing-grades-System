<?php
header('Content-Type: application/json');
include("session-checker.php");
require_once "config.php";

$subject_codes = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cmbcourse'])) {
    $course_id = mysqli_real_escape_string($link, $_POST['cmbcourse']);

    // Prepare the SQL statement to fetch all subject codes with the same course
    $sql_subjects = "SELECT code FROM tblsubjects WHERE course = ?";
    if ($stmt_subjects = mysqli_prepare($link, $sql_subjects)) {
        mysqli_stmt_bind_param($stmt_subjects, "s", $course_id);
        if (mysqli_stmt_execute($stmt_subjects)) {
            $result_subjects = mysqli_stmt_get_result($stmt_subjects);
            while ($row = mysqli_fetch_assoc($result_subjects)) {
                $subject_codes[] = $row['code'];
            }
            mysqli_stmt_close($stmt_subjects);
        } else {
            echo json_encode(["error" => "Error executing the query."]);
            exit;
        }
    } else {
        echo json_encode(["error" => "Error preparing the query."]);
        exit;
    }
} else {
    echo json_encode(["error" => "Invalid request."]);
    exit;
}

echo json_encode($subject_codes);
?>
    