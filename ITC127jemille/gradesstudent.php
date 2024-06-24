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

        <li><a class="active" href="gradesstudent.php">Grades</a></li>
        <li><a href="advisingstudent.php">Advising subject</a></li>
        <li><a href="logsstudent.php">Logs</a></li>
            
        <!-- Right-aligned list items -->
        <li class="right"><a href="login.php" id="logout" class="nav-button">Logout</a></li>
        <li class="right">
    <button id="changePasswordButton" class="nav-button changepass" value="<?php echo $_SESSION['username']; ?>">
        Change Password
    </button>
</li>

    </ul>






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





<div class="containers"> <!-- Container box -->
    <div class="table-con">
        <?php 
        require_once "config.php";
        $student_number = $_SESSION['username'];
        $sql_grades = "SELECT * FROM tblgrades WHERE studentnumber = ?";
        if($stmt_grades = mysqli_prepare($link, $sql_grades)){
            mysqli_stmt_bind_param($stmt_grades, "s", $student_number);
            if(mysqli_stmt_execute($stmt_grades)){
                $result_grades = mysqli_stmt_get_result($stmt_grades);
                if(mysqli_num_rows($result_grades) > 0){
        ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_grade = mysqli_fetch_assoc($result_grades)){
                                    $subject_code = $row_grade['code'];
                                    $sql_subject = "SELECT description, unit FROM tblsubjects WHERE code = ?";
                                    if($stmt_subject = mysqli_prepare($link, $sql_subject)){
                                        mysqli_stmt_bind_param($stmt_subject, "s", $subject_code);
                                        if(mysqli_stmt_execute($stmt_subject)){
                                            $result_subject = mysqli_stmt_get_result($stmt_subject);
                                            if(mysqli_num_rows($result_subject) > 0){
                                                $row_subject = mysqli_fetch_assoc($result_subject);
                                                ?>
                                                <tr>
                                                    <td><?php echo $subject_code; ?></td>
                                                    <td><?php echo $row_subject['description']; ?></td>
                                                    <td><?php echo $row_subject['unit']; ?></td>
                                                    <td><?php echo $row_grade['grade']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "Error executing query: " . mysqli_error($link);
                                        }
                                        mysqli_stmt_close($stmt_subject);
                                    } else {
                                        echo "Error preparing statement: " . mysqli_error($link);
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                    echo "<p style='text-align: center;'>No subjects found.</p>";
                }
            }
        }
        ?>
    </div>
</div>












<script>
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












    <footer>
    &copy; 2024 Your Company. All rights reserved.
</footer>
</body>
</html>
