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
  <title>SUBJECTS MANAGEMENT</title>
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
        <li><a href="student.php">Students</a></li>
        <li><a class="active" href="#subject">Subject</a></li>
        <li><a  href="grades.php">Grades</a></li>
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





<!-- Add Subject Modal -->
<div class="modal fade" id="addsubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subject</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addsubjectform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessage"></div>
          <div class="mb-3">
            <label for="txtcode" class="form-label">Code</label>
            <input type="text" class="form-control" id="txtcode" name="txtcode" placeholder="Input your student">
          </div>
          <div class="mb-3">
            <label for="txtdescription" class="form-label">Description</label>
            <input type="text" class="form-control" id="txtdescription" name="txtdescription" placeholder="Input your description">
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbunit">
              <option selected>Select Unit</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
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
            <select class="form-select" aria-label="Default select example" name="cmbprequisite1">
                <option selected>Select Prerequisite 1</option>
            </select>
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbprequisite2">
                <option selected>Select Prerequisite 2</option>
            </select>
          </div>    
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbprequisite3">
                <option selected>Select Prerequisite 3</option>
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
                    


<!-- Edit Subject Modal -->
<div class="modal fade" id="editsubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subject</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editsubjectform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageUpdate"></div>
          <div class="mb-3">
          <label for="txtcode_display" class="form-label">txtcodes</label>
            <input type="text" class="form-control" id="txtcode_display" name="txtcode" placeholder="Input your code" readonly>
          </div>
          <div class="mb-3">
            <label for="txtdescription" class="form-label">Description</label>
            <input type="text" class="form-control" id="txtdescriptions" name="txtdescription" placeholder="Input your description">
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" id="cmbunits" name="cmbunit">
              <option selected>Select Unit</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" id="cmbcourses" name="cmbcourse">
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
            <select class="form-select" aria-label="Default select example" id="cmbprequisites1" name="cmbprequisite1">
                <option selected>Select Prerequisite 1</option>
            </select>
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" id="cmbprequisites2" name="cmbprequisite2">
                <option selected>Select Prerequisite 2</option>
            </select>
          </div>    
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" id="cmbprequisites3" name="cmbprequisite3">
                <option selected>Select Prerequisite 3</option>
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



<!-- Delete Subject Modal -->
<div class="modal fade" id="deletesubject" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Subject</h1>
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
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addsubject">
        ADD SUBJECT
    </button>
    <input type="text" id="searchInput" placeholder="Search by student">
</div>

<div class="container">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Code</th>
                    <th>Description</th>   
                    <th>Unit</th>
                    <th>Course</th>
                    <th>Prerequisite 1</th>
                    <th>Prerequisite 2</th>
                    <th>Prerequisite 3</th>
                    <th>Created By</th>
                    <th>Date created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "config.php";
                $sql = "SELECT * FROM tblsubjects";
                if($stmt = mysqli_prepare($link, $sql)) {
                    if(mysqli_stmt_execute($stmt)) {
                        $result = mysqli_stmt_get_result($stmt);
                        while($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['code']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= htmlspecialchars($row['unit']) ?></td>
                                <td><?= htmlspecialchars($row['course']) ?></td>
                                <td><?= htmlspecialchars($row['prerequisite1']) ?></td>
                                <td><?= htmlspecialchars($row['prerequisite2']) ?></td>
                                <td><?= htmlspecialchars($row['prerequisite3']) ?></td>
                                <td><?= htmlspecialchars($row['createdby']) ?></td>
                                <td><?= htmlspecialchars($row['datecreated']) ?></td>
                                <td>
                                    <button type="button" value="<?= htmlspecialchars($row['code']) ?>" class="editsubjects btn btn-success">Edit</button>
                                    <button type="button" value="<?= htmlspecialchars($row['code']) ?>" class="deletesubject btn btn-danger">Delete</button> 
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
        $('#addsubjectform').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_user", true);

            $.ajax({
                type: "POST",
                url: "addsubject.php",
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
                        $('#addsubject').modal('hide');
                        $('#addsubjectform')[0].reset();

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


        $(document).on('click', '.editsubjects', function () {
        var username = $(this).val();

        $.ajax({
            type: "GET",
            url: "getsubject.php",
            data: { username: username },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    alert(res.message);
                } else if (res.status == 200) {
                    // Update the input fields with the data from the response
                    $('#txtcode_display').val(res.data.code);
                    $('#txtdescriptions').val(res.data.description);
                    $('#cmbunits').val(res.data.unit);
                    $('#cmbcourses').val(res.data.course);
                    
                    // Get the values of prerequisites
                    var prerequisite1Value = res.data.prerequisite1;
                    var prerequisite2Value = res.data.prerequisite2;
                    var prerequisite3Value = res.data.prerequisite3;
                    
                    // Set the values of prerequisite select elements
                    $('#cmbprequisites1').val(prerequisite1Value);
                    $('#cmbprequisites2').val(prerequisite2Value);
                    $('#cmbprequisites3').val(prerequisite3Value);
                    
                    $('#editsubject').modal('show'); 
                } else if (res.status == 500) {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message); 
                }
            }
        });
    });



$(document).ready(function () {
        // Handle add account form submission
        $('#editsubjectform').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("edit_user", true);

            $.ajax({
                type: "POST",
                url: "editsubject.php",
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
                        $('#editsubject').modal('hide');
                        $('#editsubjectform')[0].reset();

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
    // Handle delete subject button click
    $(document).on('click', '.deletesubject', function () {
        var subjectCode = $(this).val();
        $('#deleteusername').val(subjectCode);
        $('#deletesubject').modal('show');
    });

    // Handle delete subject form submission
    $('#deletestudentform').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("delete_user", true); // Add delete_user parameter to identify the request

        $.ajax({
            type: "POST",
            url: "deletesubject.php", // Change the URL to the correct file handling the deletion
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
                    $('#deletesubject').modal('hide');
                    $('#deletestudentform')[0].reset();

                    // Reload the table or update UI as needed
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
    $(document).ready(function() {
    $('select[name="cmbcourse"]').change(function() {
        var course = $(this).val();

        // Clear existing options in prerequisite dropdowns and add "None" option
        var noneOption = '<option value="">None</option>';
        $('select[name="cmbprequisite1"], select[name="cmbprequisite2"], select[name="cmbprequisite3"]').html(noneOption);

        if (course) {
            $.ajax({
                url: 'get_prerequisites.php',
                type: 'POST',
                data: { cmbcourse: course },
                success: function(response) {
                    console.log("Response received:", response); // Log the response for debugging
                    if (Array.isArray(response)) {
                        var options = noneOption;

                        response.forEach(function(prerequisite) {
                            options += '<option value="' + prerequisite + '">' + prerequisite + '</option>';
                        });

                        $('select[name="cmbprequisite1"], select[name="cmbprequisite2"], select[name="cmbprequisite3"]').html(options);
                    } else {
                        console.error('Response is not an array:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch prerequisites:', error);
                }
            }); 
        }
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
    
    <footer>
    &copy; 2024 Your Company. All rights reserved.
</footer>
</body>
</html>
