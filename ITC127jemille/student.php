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
  <title>STUDENTS MANAGEMENT</title>
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
            width: 80%; /* Adjust the width as needed */
            max-width: 1200px; /* Limit the maximum width */
            margin-top: 20px; /* Adjust the margin as needed */
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
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <ul>
    <?php if($_SESSION['usertype'] !== 'REGISTRAR'): ?>
    <li><a href="Mainpanel.php">Account</a></li>
    <?php endif; ?>
    <li><a class="active"  href="student.php">Students</a></li>
    <li><a href="subjects.php">Subject</a></li>
    <li><a href="grades.php">Grades</a></li>
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




<!-- Add student Modal -->
<div class="modal fade" id="addstudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addstudentform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessage"></div>
          <div class="mb-3">
          <label for="formGroupExampleInput2" class="form-label">Student number</label>
            <input type="text" class="form-control" id="txtstudent" name="txtstudent" placeholder="Input your student">
          </div>
          <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">Password</label>
            <input type="text" class="form-control" id="txtpassword" name="txtpassword" placeholder="Input your password">
          </div>
          <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="txtlastname" name="txtlastname" placeholder="Input your Last Name">
          </div>
          <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">First Name</label>
            <input type="text" class="form-control" id="txtfirstname" name="txtfirstname" placeholder="Input your First Name">
          </div>
          <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="txtmiddlename" name="txtmiddlename" placeholder="Input your Middle Name">
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbcourse">
              <option selected>Select Course</option>
                <option value="BSCRIM">Bachelor of Science in Criminology</option>
                <option value="BSA">Bachelor of Science in Accountancy</option>
                <option value="BSCS">Bachelor of Science in Computer Science</option>
                <option value="BSBA">Bachelor of Science in Business Administration</option>
                <option value="BPE">Bachelor of Physical Education</option>
                <option value="BSNURSING">Bachelor of Science in Nursing</option>
                <option value="BAPSY">Bachelor of Arts in Psychology</option>
                <option value="BFGD">Bachelor of Fine Arts in Graphic Design</option>
                <option value="BECE">Bachelor of Engineering in Civil Engineering</option>
                <option value="BSENSCI">Bachelor of Science in Environmental Science</option>
                <option value="BCOMM">Bachelor of Commerce in Marketing</option>
                <option value="BLLB">Bachelor of Laws (LLB)</option>
                <option value="BELED">Bachelor of Education in Elementary Education</option>
                <option value="BMUSIC">Bachelor of Music in Music Performance</option>
                <option value="BARCH">Bachelor of Architecture</option>
                <option value="BHSPH">Bachelor of Health Science in Public Health</option>
            </select>
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbyear">
              <option selected>Select year level</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
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



<!-- Edit Student Modal -->
<div class="modal fade" id="editstudents" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editstudentform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageUpdate"></div>
          <div class="mb-3">
            <label for="txtstudent_display" class="form-label">Student Number</label>
            <input type="text" class="form-control" id="txtstudents" name="txtstudent" placeholder="Input your username" readonly>
          </div>
          <div class="mb-3">
            <label for="txtpassword" class="form-label">Password</label>
            <input type="text" class="form-control" id="txtpasswords" name="txtpassword" placeholder="Input your password">
          </div>
          <div class="mb-3">
            <label for="txtlastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="txtlastnames" name="txtlastname" placeholder="Input your last name">
          </div>
          <div class="mb-3">
            <label for="txtfirstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="txtfirstnames" name="txtfirstname" placeholder="Input your first name">
          </div>
          <div class="mb-3">
            <label for="txtmiddlename" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="txtmiddlenames" name="txtmiddlename" placeholder="Input your middle name">
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" id="cmbcourse" name="cmbcourse">
              <option selected>Select Course</option>
                <option value="BSCRIM">Bachelor of Science in Criminology</option>
                <option value="BSA">Bachelor of Science in Accountancy</option>
                <option value="BSCS">Bachelor of Science in Computer Science</option>
                <option value="BSBA">Bachelor of Science in Business Administration</option>
                <option value="BPE">Bachelor of Physical Education</option>
                <option value="BSNURSING">Bachelor of Science in Nursing</option>
                <option value="BAPSY">Bachelor of Arts in Psychology</option>
                <option value="BFGD">Bachelor of Fine Arts in Graphic Design</option>
                <option value="BECE">Bachelor of Engineering in Civil Engineering</option>
                <option value="BSENSCI">Bachelor of Science in Environmental Science</option>
                <option value="BCOMM">Bachelor of Commerce in Marketing</option>
                <option value="BLLB">Bachelor of Laws (LLB)</option>
                <option value="BELED">Bachelor of Education in Elementary Education</option>
                <option value="BMUSIC">Bachelor of Music in Music Performance</option>
                <option value="BARCH">Bachelor of Architecture</option>
                <option value="BHSPH">Bachelor of Health Science in Public Health</option>
            </select>
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" id="cmbyear" name="cmbyear">
              <option selected>Select year level</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
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



<!-- Delete Student Modal -->
<div class="modal fade" id="deletestudents" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deletestudentform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageDelete"></div>
          <p>Are you sure you want to delete this student?</p>
          <input type="hidden" id="deleteusername" name="deleteusername">
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
<div class="button-container">
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addstudent">
        ADD STUDENT
    </button>
    <input type="text" id="searchInput" placeholder="Search by student">
</div>

<div class="container">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Student number</th>
                    <th>Last name</th>   
                    <th>First name</th>
                    <th>Middle Name By</th>
                    <th>Course</th>
                    <th>Year level</th>
                    <th>Created by</th>
                    <th>Date created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "config.php";
                $sql = "SELECT * FROM tblstudents";
                if($stmt = mysqli_prepare($link, $sql)) {
                    if(mysqli_stmt_execute($stmt)) {
                        $result = mysqli_stmt_get_result($stmt);
                        while($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['studentnumber']) ?></td>
                                <td><?= htmlspecialchars($row['lastname']) ?></td>
                                <td><?= htmlspecialchars($row['firstname']) ?></td>
                                <td><?= htmlspecialchars($row['middlename']) ?></td>
                                <td><?= htmlspecialchars($row['course']) ?></td>
                                <td><?= htmlspecialchars($row['yearlevel']) ?></td>
                                <td><?= htmlspecialchars($row['createdby']) ?></td>
                                <td><?= htmlspecialchars($row['datecreated']) ?></td>
                                <td>
                                    <button type="button" value="<?= htmlspecialchars($row['studentnumber']) ?>" class="editstudent btn btn-success">Edit</button>
                                    <button type="button" value="<?= htmlspecialchars($row['studentnumber']) ?>" class="deletestudent btn btn-danger">Delete</button> 
                                </td>    
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='9'>Error executing SQL statement</td></tr>";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "<tr><td colspan='9'>Error preparing SQL statement</td></tr>";
                }
                mysqli_close($link);
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>



<script>
    $(document).ready(function () {
        // Handle add account form submission
        $('#addstudentform').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_user", true);

            $.ajax({
                type: "POST",
                url: "addstudent.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                    } else if (res.status == 200) {
                        $('#errorMessage').addClass('d-none');
                        $('#addstudent').modal('hide');
                        $('#addstudentform')[0].reset();

                        // Reload the table
                        $('#myTable').load(location.href + " #myTable > *");
                    } else if (res.status == 500) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                    }
                }
            });
        });
    });


    $(document).on('click', '.editstudent', function () {
    var username = $(this).val();
    

    $.ajax({
        type: "GET",
        url: "getstudent.php",
        data: { username: username },
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                // Update the display elements with the data from the response
                $('#txtstudent_display').text(res.data.studentnumber);  // Update the span text
                $('#txtstudents').val(res.data.studentnumber);  // Set the hidden input value
                $('#txtpasswords').val(res.data.password);
                $('#txtlastnames').val(res.data.lastname);
                $('#txtfirstnames').val(res.data.firstname);
                $('#txtmiddlenames').val(res.data.middlename);
                
                // Set the selected option in the dropdowns
                $('#cmbcourse').val(res.data.course);
                $('#cmbyear').val(res.data.yearlevel);
                
                $('#editstudents').modal('show'); 
            } else if (res.status == 500) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);
            }
        }
    });
});


$(document).ready(function () {
        // Handle add account form submission
        $('#editstudentform').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("edit_user", true);

            $.ajax({
                type: "POST",
                url: "editstudent.php",
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
                        $('#editstudents').modal('hide');
                        $('#editstudentform')[0].reset();

                        // Reload the table
                        $('#myTable').load(location.href + " #myTable > *");
                    } else if (res.status == 500) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);
                    }
                }
            });
        });
    });


    $(document).ready(function () {
    // Handle delete student button click
    $(document).on('click', '.deletestudent', function () {
        var student = $(this).val();
        $('#deleteusername').val(student);
        $('#deletestudents').modal('show');
    });

    // Handle delete student form submission
    $('#deletestudentform').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("delete_student", true);

        $.ajax({
            type: "POST",
            url: "deletestudent.php",
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
                    $('#deletestudents').modal('hide');
                    $('#deletestudentform')[0].reset();

                    // Reload the table
                    $('#myTable').load(location.href + " #myTable > *");
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

    
    <footer>
    &copy; 2024 Your Company. All rights reserved.
</footer>
</body>
</html>
