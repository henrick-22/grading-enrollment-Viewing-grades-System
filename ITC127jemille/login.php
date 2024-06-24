<?php
    session_start(); // Start the session at the very beginning

    $output = NULL;

    // Check if the form has been submitted
    if(isset($_POST['btnlogin'])){
        // Require config file
        require_once('config.php');

        // Build template for login
        $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ? AND userstatus = 'ACTIVE'";

        // Check if SQL will run successfully
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind data
            mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);

            // Execute SQL statement
            if(mysqli_stmt_execute($stmt)){
                // Get result
                $result = mysqli_stmt_get_result($stmt);

                // Check if result
                if(mysqli_num_rows($result) > 0){
                    // Fetch the result array
                    $accounts = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Create session
                    if($accounts['usertype'] == 'ADMINISTRATOR'){
                        // Start session
                        $_SESSION['username'] = $_POST['txtusername'];
                        $_SESSION['usertype'] = $accounts['usertype']; // Correct variable name to $accounts
                        header("Location: Mainpanel.php");
                        exit();
                    }
                    if($accounts['usertype'] == 'REGISTRAR'){
                        // Start session
                        $_SESSION['username'] = $_POST['txtusername'];
                        $_SESSION['usertype'] = $accounts['usertype']; // Correct variable name to $accounts
                        header("Location: student.php");
                        exit();
                    }
                    if($accounts['usertype'] == 'STUDENT'){
                        // Start session
                        $_SESSION['username'] = $_POST['txtusername'];
                        $_SESSION['usertype'] = $accounts['usertype']; // Correct variable name to $accounts
                        header("Location: gradesstudent.php");
                        exit();
                    }
                } else {
                    $output = 'Login failed: Incorrect details or account is inactive';
                }
            } else {
                $output = 'Error on login statement execution';
            }
        } else {
            $output = 'Error preparing SQL statement';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login Form</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        
    </style>
</head>
<body>
    <div class="login-container">
        <form id="loginForm" method="POST" action="">
            <h2>Login</h2>
            <?php if ($output): ?>
                <div class="error-message">
                    <?php echo $output; ?>
                </div>
            <?php endif; ?>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="txtusername" name="txtusername" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="txtpassword" name="txtpassword" required>
            </div>
            <button type="submit" name="btnlogin">Login</button>
        </form>
    </div>
    <footer>
        &copy; 2024 Your Company. All rights reserved.
    </footer>
</body>
</html>
