<?php
require_once "config.php";

if (isset($_GET['code'])) {
    $code = mysqli_real_escape_string($link, $_GET['code']);

    // Fetch data from tblgrades
    $query_grades = "SELECT * FROM tblgrades WHERE code = ?";
    $stmt_grades = mysqli_prepare($link, $query_grades);

    if ($stmt_grades) {
        mysqli_stmt_bind_param($stmt_grades, "s", $code);
        mysqli_stmt_execute($stmt_grades);
        $result_grades = mysqli_stmt_get_result($stmt_grades);

        if (mysqli_num_rows($result_grades) > 0) {
            $row_grades = mysqli_fetch_assoc($result_grades);

            // Fetch data from tblsubjects for requisite and description
            $query_subjects = "SELECT description, prerequisite1, prerequisite2, prerequisite3 FROM tblsubjects WHERE code = ?";
            $stmt_subjects = mysqli_prepare($link, $query_subjects);

            if ($stmt_subjects) {
                mysqli_stmt_bind_param($stmt_subjects, "s", $code);
                mysqli_stmt_execute($stmt_subjects);
                $result_subjects = mysqli_stmt_get_result($stmt_subjects);

                if (mysqli_num_rows($result_subjects) > 0) {
                    $row_subjects = mysqli_fetch_assoc($result_subjects);

                    // Merge data from both queries
                    $data = array_merge($row_grades, $row_subjects);

                    $res = [
                        'status' => 200,
                        'data' => $data
                    ];
                } else {
                    $res = [
                        'status' => 404,
                        'message' => 'No subject data found'
                    ];
                }

                mysqli_stmt_close($stmt_subjects);
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Failed to prepare SQL statement for subjects: ' . mysqli_error($link)
                ];
            }
        } else {
            $res = [
                'status' => 404,
                'message' => 'No grade data found'
            ];
        }

        mysqli_stmt_close($stmt_grades);
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to prepare SQL statement for grades: ' . mysqli_error($link)
        ];
    }

    echo json_encode($res);
}
?>
