<?php
// Uses environment variables online, falls back to your mobile values locally
$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: 'root';
$db_name = getenv('DB_NAME') ?: 'yt_notes_hosting';

$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    $conn = @new mysqli('localhost', 'root', 'root', $db_name);
    if ($conn->connect_error) { die("❌ Connection Error"); }
}
?>
