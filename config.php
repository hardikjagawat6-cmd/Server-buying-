<?php
// Your real live online database configurations pulled from Aiven console
$db_host = '://aivencloud.com'; 
$db_port = 11491;
$db_user = 'avnadmin';      
$db_pass = 'YOUR_ACTUAL_AIVEN_PASSWORD_HERE'; // Click the eye icon on your Aiven screen to copy this!
$db_name = 'defaultdb';     

// Initialize a secure database connection object parameters
$conn = mysqli_init();

// Disables strict cloud SSL verification checks so it runs flawlessly on basic web hosts
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// Establish connection loop parameters
$success = @mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);

if (!$success) {
    die("❌ Cloud Database Connection Lost: " . mysqli_connect_error());
}
?>
