<?php
/*database connection info*/
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'itc127 -2024');

/*attempt to connect to MySQL database*/
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($link === false) {
    die("ERROR: Could not connect " . mysqli_connect_error());
}

//timezone
date_default_timezone_set('Asia/Manila');
?>