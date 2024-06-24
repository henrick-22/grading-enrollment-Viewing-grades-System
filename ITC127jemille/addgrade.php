<?php
include("session-checker.php");
require_once "config.php";

// Log the received POST data for debugging
file_put_contents('php://stderr', print_r($_POST, true));

// Add a new grade
if (isset($_POST['save_user'])) {
    $studentnumber = mysqli_real_escape_string($link, $_POST['studentnumber']);
    $code = mysqli_real_escape_string($link, $_POST['cmbcode']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $requisite = mysqli_real_escape_string($link, $_POST['requisite']);
    $grade = mysqli_real_escape_string($link, $_POST['cmbgrades']);
    $createdBy = $_SESSION['username'];
    $date = date("Y-m-d");

    // Validate fields
    if ($code == 'Select Subject Code' || empty($description) || $grade == 'Select Grade') {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    // Check if the requisite courses have grades
    if (!empty($requisite)) {
        $requisites = explode(',', $requisite);
        foreach ($requisites as $req) {
            $req = trim($req);
            $prereqQuery = "SELECT grade FROM tblgrades WHERE studentnumber = ? AND code = ? AND grade IS NOT NULL AND grade != ''";
            $prereqStmt = mysqli_prepare($link, $prereqQuery);

            if (!$prereqStmt) {
                $res = [
                    'status' => 500,
                    'message' => 'Failed to prepare SQL statement for checking prerequisite: ' . mysqli_error($link)
                ];
                echo json_encode($res);
                return;
            }

            mysqli_stmt_bind_param($prereqStmt, "ss", $studentnumber, $req);
            mysqli_stmt_execute($prereqStmt);
            mysqli_stmt_store_result($prereqStmt);

            if (mysqli_stmt_num_rows($prereqStmt) == 0) {
                $res = [
                    'status' => 500,
                    'message' => 'Prerequisite grade not found for the requisite: ' . $req
                ];
                echo json_encode($res);
                mysqli_stmt_close($prereqStmt);
                return;
            }

            mysqli_stmt_close($prereqStmt);
        }
    }

    // Check if the grade record already exists
    $checkQuery = "SELECT * FROM tblgrades WHERE studentnumber = ? AND code = ?";
    $checkStmt = mysqli_prepare($link, $checkQuery);

    if (!$checkStmt) {
        $res = [
            'status' => 500,
            'message' => 'Failed to prepare SQL statement for checking existing record: ' . mysqli_error($link)
        ];
        echo json_encode($res);
        return;
    }

    mysqli_stmt_bind_param($checkStmt, "ss", $studentnumber, $code);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        $res = [
            'status' => 500,
            'message' => 'Grade for this subject code already exists for the student'
        ];
        echo json_encode($res);
        mysqli_stmt_close($checkStmt);
        return;
    }

    mysqli_stmt_close($checkStmt);

    // Insert new grade record
    $query = "INSERT INTO tblgrades (studentnumber, code, grade, createdby, datecreated) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);

    if (!$stmt) {
        $res = [
            'status' => 500,
            'message' => 'Failed to prepare SQL statement: ' . mysqli_error($link)
        ];
        echo json_encode($res);
        return;
    }

    mysqli_stmt_bind_param($stmt, "sssss", $studentnumber, $code, $grade, $createdBy, $date);

    if (mysqli_stmt_execute($stmt)) {
        // Insert log
        $time = date("H:i:s");
        $action = "Add";
        $module = "Grade Management";
        $performedBy = $_SESSION['username'];

        $log_query = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_prepare($link, $log_query);
        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $code, $performedBy);
        mysqli_stmt_execute($stmt_log);
        mysqli_stmt_close($stmt_log);

        $res = [
            'status' => 200,
            'message' => 'Grade added successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to add grade: ' . mysqli_stmt_error($stmt)
        ];
    }
    mysqli_stmt_close($stmt);

    echo json_encode($res);
    return;
}
?>
