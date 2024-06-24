<?php
header('Content-Type: application/json');
include("session-checker.php");
require_once "config.php";

$subjects = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course'])) {
    $course = mysqli_real_escape_string($link, $_POST['course']);

    // Prepare the SQL statement to fetch all subject codes with the same course
    $sql_subjects = "SELECT code, description, prerequisite1, prerequisite2, prerequisite3 FROM tblsubjects WHERE course = ?";
    if ($stmt_subjects = mysqli_prepare($link, $sql_subjects)) {
        mysqli_stmt_bind_param($stmt_subjects, "s", $course);
        if (mysqli_stmt_execute($stmt_subjects)) {
            $result_subjects = mysqli_stmt_get_result($stmt_subjects);
            while ($row = mysqli_fetch_assoc($result_subjects)) {
                $subjects[] = [
                    'code' => $row['code'],
                    'description' => $row['description'],
                    'prerequisites' => array_filter([$row['prerequisite1'], $row['prerequisite2'], $row['prerequisite3']])
                ];
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

echo json_encode(["subjects" => $subjects]);
?>
