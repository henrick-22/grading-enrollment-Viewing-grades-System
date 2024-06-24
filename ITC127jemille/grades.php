<?php
    session_start();
    if(isset($_SESSION['usertype'])) {
        echo "<h1>Welcome, " . $_SESSION['username'] . "</h1>";
        echo "<h4>Account type: " . $_SESSION['usertype'] . "</h4>";
    }
    else {
        header("location: login.php");
        exit; // Ensure that no further PHP code is executed after the redirection
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GRADES MANAGEMENT</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            position: relative;
            overflow: hidden; /* Prevents scrolling issue with pseudo-element */
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('aubg2.jpg') no-repeat center center fixed;
            background-size: cover;
            opacity: 0.7; /* Adjust the opacity value as needed */
            z-index: -1;
        }


        #searchInput {
            width: 50%;
            padding: 5px;
            border-radius: 5px;
            margin: 0 auto;
            margin-left: 15%;
        }

        /* Style for the container box */
        .containers {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            padding: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px; /* Rounded border */
            width: 90%; /* Adjust the width as needed */
            max-width: 1200px; /* Limit the maximum width */
            margin-top: 20px; /* Adjust the margin as needed */
            height: 500px; /* Adjust the height as needed */
            overflow-y: auto; /* Add vertical scroll if content exceeds height */
        }


          ul {
              list-style-type: none;
              margin: 0;
              padding: 0;
              overflow: hidden;
              background-color: #333;
              position: fixed; /* Position the ul fixed at the top */
              width: 100%; /* Make it full width */
              top: 0; /* Align it at the top */
          }

          li {
              float: left;
          }

          /* Style for the right-aligned list items */
          .right {
              float: right;
          }

          li a {
              display: block;
              color: white;
              text-align: center;
              padding: 14px 16px;
              text-decoration: none;
          }

          li a:hover:not(.active) {
              background-color: #111;
          }

        .active {
            background-color: #04AA6D;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: gray;
            width: 100%;
            position: fixed;
            bottom: 0;
            z-index: 1; /* Ensures the footer is above the pseudo-element */
        }
        .button-container {
            margin-bottom: 20px;
        }
        .container {
            margin-top: 50px;
            height: 300px; /* Adjust the height as needed */
            overflow-y: auto; /* Enable vertical scrollbar */
        }

        .nav-button {
    background-color: #333; /* Same color as the navigation bar */
    border: none;
    color: white; 
    padding: 5px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 15px; /* Adjust as needed */
    cursor: pointer;
}

.nav-button:hover {
    background-color: #111; /* Darker color when hovered */
}

/* Search button styles */
#btnsearch {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007bff; /* Button background color */
    color: white; /* Button text color */
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition effect */
}

#btnsearch:hover {
    background-color: #0056b3; /* Button background color on hover */
}
/* Student Information Styles */
.studentinfo {
    background-color: #f8f9fa; /* Background color of the student info container */
    padding: 20px; /* Padding around the student info */
    border-radius: 10px; /* Rounded corners for the student info container */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
    margin-top: 20px; /* Margin on top to create space */
}

.studentinfo table {
    width: 100%; /* Make the table width 100% of its container */
    border-collapse: collapse; /* Collapse borders between table cells */
}

.studentinfo td {
    padding: 8px; /* Padding inside table cells */
}

.studentinfo #left {
    font-weight: bold; /* Make text in left column bold */
    text-align: right; /* Align text in left column to the right */
    padding-right: 10px; /* Add some padding to the right of the left column */
}

.studentinfo #right {
    text-align: left; /* Align text in right column to the left */
}

.studentinfo a {
    text-decoration: none; /* Remove underline from links */
    color: #007bff; /* Set link color */
}

.studentinfo a:hover {
    text-decoration: underline; /* Underline links on hover */
}

    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<ul>
    <?php if($_SESSION['usertype'] !== 'REGISTRAR'): ?>
        <li><a href="Mainpanel.php">Account</a></li>
        <?php endif; ?>
        <li><a href="student.php">Students</a></li>
        <li><a href="subjects.php">Subject</a></li>
        <li><a class="active" href="grades.php">Grades</a></li>
        <li><a href="advising.php">Advising subject</a></li>
        <li><a href="logs.php">Logs</a></li>
        
        <!-- Right-aligned list items -->
        <li class="right"><a href="login.php" id="logout" class="nav-button">Logout</a></li>
        <li class="right">
    <button id="changePasswordButton" class="nav-button changepass" value="<?php echo $_SESSION['username']; ?>">
        Change Password
    </button>
</li>

    </ul>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Prerequisites</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Prerequisites</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>





<!-- Add Grades Modal -->
<div class="modal fade" id="addgrade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Grade</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addgradeform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessage"></div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbcode">
              <option selected>Select Subject Code</option>
            </select>
            <input type="hidden" id="txtstudentnumber" name="studentnumber">
          </div>
          <div class="mb-3">
            <label for="txtdescription" class="form-label">Description</label>
            <input type="text" class="form-control" id="txtdescription" name="description" placeholder="Input your description">
          </div>
          <div class="mb-3">
            <label for="txtrequisite" class="form-label">Prerequisites</label>
            <input type="text" class="form-control" id="txtrequisite" name="requisite" placeholder="Prerequisites">
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbgrades">
              <option selected>Select Grade</option>
              <option value="1.00">1.00</option>
              <option value="1.25">1.25</option>
              <option value="1.50">1.50</option>
              <option value="1.75">1.75</option>
              <option value="2.00">2.00</option>
              <option value="2.25">2.25</option>
              <option value="2.50">2.50</option>
              <option value="2.75">2.75</option>
              <option value="3.00">3.00</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


                    


<!-- Edit Grades Modal -->
<div class="modal fade" id="editgrade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Grade</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editgradeform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageUpdate"></div>
          <div class="mb-3">
            <label for="editusernamess" class="form-label">Subject Code</label>
            <span class="form-control disabled-span" id="editcode_display">Sample Username</span>
            <input type="hidden" class="form-control" id="cmbcodes" name="cmbcode">
            <input type="hidden" id="txtstudentnumbers" name="studentnumber">
          </div>
          <div class="mb-3">
            <label for="txtdescriptionss" class="form-label">Description</label>
            <span class="form-control disabled-span" id="editdescription_display">Sample Username</span>
          </div>
          <div class="mb-3">
            <label for="txtrequisite" class="form-label">Prerequisites</label>
            <span class="form-control disabled-span" id="editrequisite_display">Sample Username</span>
          </div>
          <div class="mb-3">
            <label for="cmbgradess" class="form-label">Grade</label>
            <select class="form-select" id="cmbgrades" name="cmbgrade">
              <option selected>Select Grade</option>
              <option value="1.00">1.00</option>
              <option value="1.25">1.25</option>
              <option value="1.50">1.50</option>
              <option value="1.75">1.75</option>
              <option value="2.00">2.00</option>
              <option value="2.25">2.25</option>
              <option value="2.50">2.50</option>
              <option value="2.75">2.75</option>
              <option value="3.00">3.00</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>








<!-- Change Password Modal -->
<div class="modal fade" id="changepassaccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changepassaccountform">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="CPerrorMessage"></div>
                    <div class="mb-3">
                        <label for="editusername" class="form-label">USERNAME</label>
                        <span class="form-control disabled-span" id="cpusername_display">Sample Username</span>
                        <input type="hidden" id="cpusername" name="txtusername">
                    </div>
                    <div class="mb-3">
                        <label for="cppassword" class="form-label">NEW PASSWORD</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="cppassword" name="txtpassword" placeholder="Input your new password">
                            <button class="btn btn-outline-secondary" type="button" id="passwordVisibilityToggle">Show</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Delete grade Modal -->
<div class="modal fade" id="deletegrade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Grade</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deletestudentform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageDelete"></div>
          <p>Are you sure you want to delete this grade?</p>
          <input type="hidden" class="form-control" id="deletecode" name="deletecode">
          <input type="hidden" id="deletestudentnumber" name="deletestudentnumber">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>









<div class="containers"> <!-- Container box -->

    <!-- Button trigger modal -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input id="searchInput" type="text" name="studentnumber" size="90" placeholder="Search (Student Number)">
        <input id="btnsearch" type="submit" name="btnsearch" alt="image" value="Search">
    </form> 

    <div class="table-con">
        
    <?php
require_once "config.php";

if (isset($_POST['studentnumber'])) {
    $student_number = $_POST['studentnumber'];
    $sql = "SELECT * FROM tblstudents WHERE studentnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $student_number);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['student_info'] = $row;
                displayStudentInfo($row);
                displayGradesTable($link, $student_number);
            } else {
                echo "No student found with the given student number.";
            }
        } else {
            echo "Error executing SQL statement: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing SQL statement: " . mysqli_error($link);
    }
    mysqli_close($link);
}

function displayStudentInfo($row)
{
    ?>
    <div class='studentinfo'>
        <table>
            <tr>
                <td id='left'>Student Number:</td>
                <td id='right'><?php echo $row['studentnumber']; ?></td>
            </tr>
            <tr>
                <td id='left'>Name:</td>
                <td id='right'><?php echo $row['lastname'] . ", " . $row['firstname'] . " " . $row['middlename']; ?></td>
            </tr>
            <tr>
                <td id='left'>Course:</td>
                <td id='right'><?php echo $row['course']; ?></td>
            </tr>
            <tr>
                <td id='left'>Year Level:</td>
                <td id='right'><?php echo $row['yearlevel']; ?></td>
            </tr>
            <tr>
                <td id='left'>Add Grade:</td>
                <td id='right'>
                <button type="button" class="getcode btn btn-primary" data-bs-toggle="modal" data-bs-target="#addgrade" data-course="<?php echo $row['course']; ?>" data-studentnumber="<?php echo $row['studentnumber']; ?>">Add Grade</button>
                </td>
            </tr>
        </table>
    </div>
    <?php
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
                <div class='container'>
                    <div class='table-responsive'>
                        <table id='myTable' class='table table-striped'>
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
                                            <button type='button' value='<?php echo htmlspecialchars($row_grade['code']); ?>' class='deletegrades btn btn-danger'>Delete</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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


        
    </div>
</div>











<script>
    $(document).ready(function () {
    // Set student number when the modal is opened
    $('#addgrade').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var studentnumber = button.data('studentnumber'); // Extract info from data-* attributes

        var modal = $(this);
        modal.find('#txtstudentnumber').val(studentnumber); // Set the student number in the modal's hidden input
    });

    // Handle add grade form submission
    $('#addgradeform').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("save_user", true);

        // Log form data for debugging
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            type: "POST",
            url: "addgrade.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);  // Log the response for debugging
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);
                } else if (res.status == 200) {
                    $('#errorMessage').addClass('d-none');
                    $('#addgrade').modal('hide');
                    $('#addgradeform')[0].reset();

                    // Trigger search form submission with the student number
                    var studentnumber = $('#txtstudentnumber').val();
                    $('#searchInput').val(studentnumber);
                    $('#btnsearch').click();
                } else if (res.status == 500) {
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                $('#errorMessage').removeClass('d-none');
                $('#errorMessage').text('AJAX error: ' + status + ', ' + error);
            }
        });
    });
});







$(document).on('click', '.editstudent', function () {
    var username = $(this).val();
    

    $.ajax({
        type: "GET",
        url: "getcodegrade.php",
        data: { username: username },
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                
                
                // Set the selected option in the dropdowns
                $('#cmbcode').val(res.data.course);
                
                
                $('#editstudents').modal('show'); 
            } else if (res.status == 500) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);
            }
        }
    });
});








$(document).ready(function () {
    // Handle edit grade form submission
    $('#editgradeform').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("edit_user", true); // Add a flag to identify the request

        $.ajax({
            type: "POST",
            url: "editgrade.php", // Change the URL to the PHP script for updating grades
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);
                } else if (res.status == 200) {
                    $('#errorMessageUpdate').addClass('d-none');
                    $('#editgrade').modal('hide');
                    $('#editgradeform')[0].reset();

                    // Trigger search form submission with the student number
                    var studentnumber = $('#txtstudentnumbers').val();
                    $('#searchInput').val(studentnumber);
                    $('#btnsearch').click();
                } else if (res.status == 500) {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);
                }
            }
        });
    });
});

$(document).on('click', '.editgrades', function () {
    var code = $(this).val();

    $.ajax({
        type: "GET",
        url: "getgrade.php",
        data: { code: code },
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                // Concatenate prerequisites
                var prerequisites = [
                    res.data.prerequisite1,
                    res.data.prerequisite2,
                    res.data.prerequisite3
                ].filter(function(prerequisite) {
                    return prerequisite != null && prerequisite.trim() != "";
                }).join(", ");

                // Update the spans with the data from the response
                $('#editcode_display').text(res.data.code);
                $('#editdescription_display').text(res.data.description);
                $('#editrequisite_display').text(prerequisites); // Concatenated prerequisites
                $('#cmbcodes').val(res.data.code); // Set the value of cmbcodes input
                $('#txtstudentnumbers').val(res.data.studentnumber); // Set the value of txtstudentnumber input
                $('#cmbgrades').val(res.data.grade); // Set the value of cmbgrades select

                $('#editgrade').modal('show');
            } else if (res.status == 500) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);
            }
        }
    });
});





$(document).ready(function () {
    // Handle delete subject button click
    $(document).on('click', '.deletegrades', function () {
        var subjectCode = $(this).val();
        var studentNumber = $('#right').text().trim(); // Get the student number from the <td> with ID 'right'
        $('#deletecode').val(subjectCode); // Set the subject code in the hidden input
        $('#deletestudentnumber').val(studentNumber); // Set the student number in the hidden input
        $('#deletegrade').modal('show'); // Show the delete modal
    });

    // Handle delete subject form submission
    $('#deletestudentform').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("delete_user", true); // Add delete_user parameter to identify the request

        $.ajax({
            type: "POST",
            url: "deletegrades.php", // Change the URL to the correct file handling the deletion
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessageDelete').removeClass('d-none');
                    $('#errorMessageDelete').text(res.message);
                } else if (res.status == 200) {
                    $('#errorMessageDelete').addClass('d-none');
                    $('#deletegrade').modal('hide');
                    $('#deletestudentform')[0].reset();
                    // Trigger search form submission with the student number
                    var studentnumber = $('#deletestudentnumber').val();
                    $('#searchInput').val(studentnumber);
                    $('#btnsearch').click();
                } else if (res.status == 500) {
                    $('#errorMessageDelete').removeClass('d-none');
                    $('#errorMessageDelete').text(res.message);
                }
            }
        });
    });
});









      $(document).on('click', '.changepass', function () {
    var username = $(this).val(); // Retrieve the value of the button

    // Debugging to ensure the value is correctly retrieved
    console.log("Username:", username);

    $.ajax({
        type: "GET",
        url: "getuser.php",
        data: { username: username },
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                // Update the display elements with the data from the response
                $('#cpusername_display').text(res.data.username);  // Update the span text
                $('#cpusername').val(res.data.username);  // Set the hidden input value
                $('#cppassword').val(res.data.password);

                $('#changepassaccount').modal('show'); 
            } else if (res.status == 500) {
                $('#CPerrorMessage').removeClass('d-none');
                $('#CPerrorMessage').text(res.message);
            }
        }
    });
});



$(document).ready(function () {
        // Handle add account form submission
        $('#changepassaccountform').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("edit_user", true);

            $.ajax({
                type: "POST",
                url: "changepass.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#CPerrorMessage').removeClass('d-none');
                        $('#CPerrorMessage').text(res.message);
                    } else if (res.status == 200) {
                        $('#CPerrorMessage').addClass('d-none');
                        $('#changepassaccount').modal('hide');
                        $('#changepassaccountform')[0].reset();

                        // Reload the table
                        $('#myTable').load(location.href + " #myTable > *");
                    } else if (res.status == 500) {
                        $('#CPerrorMessage').removeClass('d-none');
                        $('#CPerrorMessage').text(res.message);
                    }
                }
            });
        });
    });




</script>


<script>
    $(document).ready(function () {
        // Handle search input
        $('#searchInput').on('keyup', function () {
            var searchText = $(this).val().toLowerCase();
            $('#myTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1)
            });
        });
    });
</script>

<script>
  $(document).ready(function() {
    // Function to toggle password visibility
    function togglePasswordVisibility() {
        var passwordInput = $('#cppassword');
        var passwordVisibilityToggle = $('#passwordVisibilityToggle');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            passwordVisibilityToggle.text('Hide');
        } else {
            passwordInput.attr('type', 'password');
            passwordVisibilityToggle.text('Show');  
        }
    }

    // Event listener for password visibility toggle button click
    $('#passwordVisibilityToggle').click(function() {
        togglePasswordVisibility();
    });
});

</script>




<script>
    
</script>




<script>
$(document).ready(function() {
    // Trigger when the modal is opened
    $('#addgrade').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var course = button.data('course'); // Extract course info from data-* attributes

        if (course) {
            $.ajax({
                url: 'gradesfetch.php',
                type: 'POST',
                data: { course: course },
                success: function(response) {
                    console.log("Response received:", response); // Log the response for debugging
                    var subjectDropdown = $('select[name="cmbcode"]');
                    subjectDropdown.empty(); // Clear the existing options
                    subjectDropdown.append('<option selected>Select Subject Code</option>');

                    if (response.error) {
                        console.error('Failed to fetch subject codes:', response.error);
                    } else {
                        if (response.subjects) {
                            // Populate the dropdown with the fetched subject codes
                            $.each(response.subjects, function(index, subject) {
                                subjectDropdown.append('<option value="' + subject.code + '">' + subject.code + '</option>');
                            });

                            // Set up change event to fetch description and prerequisites
                            subjectDropdown.change(function() {
                                var selectedCode = $(this).val();
                                var selectedSubject = response.subjects.find(s => s.code === selectedCode);

                                if (selectedSubject) {
                                    // Update txtdescription with the fetched description
                                    $('#txtdescription').val(selectedSubject.description);

                                    // Update txtrequisite with the fetched prerequisites
                                    $('#txtrequisite').val(selectedSubject.prerequisites.join(', '));
                                }
                            });
                        } else {
                            console.error('No subjects found:', response);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch subject codes:', error);
                }
            });
        }
    });
});


</script>







<script>
    document.addEventListener('DOMContentLoaded', function() {
        var codeElements = document.querySelectorAll('#myTable td:first-child'); // Selecting all td elements in the first column of the table

        codeElements.forEach(function(element) {
            console.log('Code:', element.textContent.trim()); // Logging the text content of each td element
        });
    });
</script>

    <footer>
    &copy; 2024 Your Company. All rights reserved.
</footer>
</body>
</html>
