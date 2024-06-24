<?php
require_once "config.php";

if (isset($_POST['studentnumber'])) {
    $student_number = $_POST['studentnumber'];
    displayGradesTable($link, $student_number);
}

function displayGradesTable($link, $student_number)
{
    $sql_grades = "SELECT g.code, s.description, s.unit, g.grade, g.createdby, g.datecreated FROM tblgrades g JOIN tblsubjects s ON g.code = s.code WHERE g.studentnumber = ?";
    if ($stmt_grades = mysqli_prepare($link, $sql_grades)) {
        mysqli_stmt_bind_param($stmt_grades, "s", $student_number);
        if (mysqli_stmt_execute($stmt_grades)) {
            $result_grades = mysqli_stmt_get_result($stmt_grades);
            if (mysqli_num_rows($result_grades) > 0) {
                ?>
                <thead class='table-dark'>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Grade</th>
                        <th>Encoded by</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row_grade = mysqli_fetch_assoc($result_grades)) {
                    ?>
                    <tr>
                        <td><?php echo $row_grade['code']; ?></td>
                        <td><?php echo $row_grade['description']; ?></td>
                        <td><?php echo $row_grade['unit']; ?></td>
                        <td><?php echo $row_grade['grade']; ?></td>
                        <td><?php echo $row_grade['createdby']; ?></td>
                        <td><?php echo $row_grade['datecreated']; ?></td>
                        <td>
                            <button type='button' value='<?php echo htmlspecialchars($row_grade['code']); ?>' class='editgrades btn btn-success'>Update</button>
                            <button type='button' value='<?php echo htmlspecialchars($row_grade['code']); ?>' class='delete-grade btn btn-danger'>Delete</button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <?php
            } else {
                echo "<font color='red' align='center'>No records found.</font>";
            }
        } else {
            echo "Error executing SQL statement: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt_grades);
    } else {
        echo "Error preparing SQL statement: " . mysqli_error($link);
    }
}
?>
